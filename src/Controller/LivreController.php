<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use App\Entity\Livre;
use App\Entity\Category;
use App\Entity\Emprunteur;
use App\Form\AddLivreType;
use App\Form\EmprunterType;
use App\Form\SortByType;
use App\Form\SortByTitleType;
use App\Repository\CategoryRepository;
use App\Repository\LivreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class LivreController extends AbstractController
{

  /**
   * @Route("", name="livre")
   */
  public function home()
  {
      return $this->render('home.html.twig');
  }

    /**
     * @Route("/livre/{id}", name="app_getLivre")
     */
    public function getLivre($id)
    {
        $repository = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $repository->findOneBy(array('id' => $id));
        if(!$livre) {
          throw $this->createNotFoundException("Ce livre n'existe pas");
        }
        return $this->render('livre/singleLivre.html.twig', [
            'id' => $id, 'livre' => $livre
        ]);
    }

    /**
     * @Route("/ajout/livre", name="app_addLivre")
     * @IsGranted("ROLE_BIBLIOTHECAIRE")
     */
    public function addLivre(Request $request): Response
    {
      //On instance l'objet//
      $livre = new Livre();
      //On crée le form et on fait passer le nom du form::class pour qu'il hydrate l'objet qu'on a instancié avant//
      $form = $this->createForm(AddLivreType::class, $livre);
      $form->handleRequest($request);

      //Vérification du formulaire (rempli + validation)//
      if ($form->isSubmitted() && $form->isValid())
     {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($livre);
        $entityManager->flush();
        return $this->redirectToRoute('livre');
      }
      //Sinon on crée une vue pour afficher le form//
        return $this->render('livre/addLivre.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("livre/{id}/emprunt", name="app_emprunt")
     */
    public function emprunterLivre($id, Request $request):Response
    {
        //Création du formulaire
        $form = $this->createForm(EmprunterType::class);
        //Permet de récuperer les informations du formulaire lors de la soumission
        $form->handleRequest($request);

        //Vérification
        if ($form->isSubmitted() && $form->isValid())
        {
          //Je récupère les données de mon formulaire avec le getData
          $data = $form->getData();
          //J'instancie le Repo avec Doctrine
          $repository = $this->getDoctrine()->getRepository(Emprunteur::class);
          //Je fais une recherche du numero de l'emprunteur avec celui entrée dans le formulaire
          $emprunteur = $repository->findOneBy([ 'numero' => $data['emprunteur'] ]);
          //J'instancie le Repo de Livre avec Doctrine afin de récuperer le livre selon l'ID
          $livre =  $this->getDoctrine()->getRepository(Livre::class)->find($id);
          //On verifie si l'emprunteur existe
          if($emprunteur) {
            //J'hydrate Livre avec un nouvelle emprunteur
            $livre->setEmprunteur($emprunteur);
            //J'appelle mon Manager pour l'enregistrement en BDD
            $entityManager = $this->getDoctrine()->getManager();
            //Je prépare la requête
            $entityManager->persist($livre);
            //Je l'éxecute
            $entityManager->flush();

            return $this->redirectToRoute('app_getLivre', ['id' => $id]);
          }

        }

        return $this->render('livre/ajoutEmprunteur.html.twig', [
          'id' => $id, 'form' => $form->createView()
        ]);
    }

    /**
    * @Route("livre/{id}/rendre", name="app_rendre")
    */

    public function rendreLivre($id){

      $livre =  $this->getDoctrine()->getRepository(Livre::class)->find($id);

      if($livre->setStatus(0)) {

        $livre->setEmprunteur(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($livre);
        $entityManager->flush();

        return $this->redirectToRoute('app_getLivre', ['id' => $id]);
      }

    }


    /**
    * @Route("/livres", name="livre_index", methods={"GET","POST"})
    */
    public function trieLivre(LivreRepository $LivreRepository, Request $request): Response
   {
       
      //Formulaire Trie
       
       $form = $this->createForm(SortByType::class);
       $form->handleRequest($request);


       if ($form->isSubmitted() && $form->isValid()) {
         $trieCategorie = $form->getData()['name'];
         $livres = $LivreRepository->getCategorywithLivre($trieCategorie);
        }
       else {
         $livres = $LivreRepository->findAll();
       }

        //Formulaire de Recherche

        $form2 = $this->createForm(SortByTitleType::class);
        $form2->handleRequest($request);

        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'form' => $form->createView(),
            'form2' => $form2->createView()
         ]);

    }
}

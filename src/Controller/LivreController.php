<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;
use App\Entity\Livre;
use App\Entity\Category;
use App\Form\AddLivreType;
use App\Repository\CategoryRepository;


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
     * @Route("/livres", name="app_livres")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Livre::class);
        $livres = $repository->getCategorywithLivre();

        return $this->render('livre/index.html.twig', [
            'livres' => $livres
        ]);
    }

    /**
     * @Route("/livre/{id}", name="app_getLivre{id}", methods={"GET"})
     */
    public function getLivre($id)
    {
        $repository = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $repository->findOneBy(array('id' => $id));

        return $this->render('livre/singleLivre.html.twig', [
            'id' => $id, 'livre' => $livre
        ]);
    }

    /**
     * @Route("/ajout/livre", name="app_addLivre")
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
     * @Route("/livre/emprunt/{id}", name="app_emprunt{id}")
     */
    public function emprunterLivre($id)
    {

        return $this->render('livre/emprunterLivre.html.twig', [
          'id' => $id
        ]);

    }
}

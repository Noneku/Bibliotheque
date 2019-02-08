<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Reponse;
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
     * @Route("/livre/{id}", name="app_getLivre{id}")
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
    public function addLivre(Request $request): Reponse
    {

      $livre = new Livre();
      $form = $this->createForm(AddLivreType::class, $livre);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
     {
        $livre = $this->getDoctrine()->getManager();
        $livre->persist($livre);
        $livre->flush();
        return $this->redirectToRoute('livre/index.html.twig');
      }
        return $this->render('livre/singleLivre.html.twig', [
            'livre' => $livre, 'form' => $form->createview(),
        ]);
    }
}

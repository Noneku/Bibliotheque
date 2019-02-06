<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Livre;

class LivreController extends AbstractController
{

    /**
     * @Route("", name="livre")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $repository->findAll();
        return $this->render('livre/index.html.twig', [
            'livres' => $livre
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
    public function formAdd()
    {
      $livre = new Livre();

      $form = $this->createFormBuilder($livre)
                  ->add('titre', TextType::class, ['label' => 'Titre'])
                  ->add('auteur', TextType::class, ['label' => 'Auteur'])
                  ->add('resume', TextareaType::class, ['label' => 'Resumé'])
                  ->add('status', ChoiceType::class, ['choices' => ['En stock' => 1 , 'Pas en stock' => 0]])
                  ->add('Envoyer', SubmitType::class, ['attr' => ['label' => 'Envoyer']])
                  ->getForm();

        return $this->render('livre/addLivre.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}

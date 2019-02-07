<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
     * @Route("/livre/add", name="app_addLivre")
    */    
    public function formAdd(Request $request)
    {
        $livre = new Livre();
        $livre->setLivre('Write a blog post');
        $livre->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($livre)
            ->add('livre', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Livre'])
            ->getForm();

        return $this->render('livre/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

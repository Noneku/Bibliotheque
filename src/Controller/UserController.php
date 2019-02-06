<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Emprunteur;
class UserController extends AbstractController
{
    /**
     * @Route("/emprunteurs", name="app_emprunteur")
     */
    public function getEmprunteurs()
    {
        $repository = $this->getDoctrine()->getRepository(Emprunteur::class);
        $emprunteurs = $repository->findAll();   
        return $this->render('emprunteur/index.html.twig', [
            'emprunteurs' => $emprunteurs
        ]);
    }

    /**
     * @Route("/emprunteur/{id}", name="app_getEmprunteur{id}")
     */

    public function getEmprunteur($id)
    {   
        $repository = $this->getDoctrine()->getRepository(Emprunteur::class);
        $emprunteur = $repository->findOneBy(array('id' => $id));   
        return $this->render('emprunteur/singleUser.html.twig', [
            'id' => $id, 'emprunteur' => $emprunteur
        ]);
    }
}

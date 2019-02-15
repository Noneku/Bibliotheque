<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Emprunteur;
use App\Repository\UserRepository;
use App\Entity\User;
class EmprunteurController extends AbstractController
{
    /**
     * @Route("/emprunteurs", name="app_emprunteurs")
     */
    public function getEmprunteurs()
    {
        $user = $this->getUser();
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $bibliothecaires = $userRepository->getBibliothequeWithUser($user->getBibliotheque());
        $repository = $this->getDoctrine()->getRepository(Emprunteur::class);
        $emprunteurs = $repository->findAll();
        return $this->render('emprunteur/index.html.twig', [
            'emprunteurs' => $emprunteurs, 'bibliothecaires' => $bibliothecaires
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

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user{id}", name="app_getUser{id}")
     */
    public function getUser($id)
    {
        $repository = $this->getDoctrine()->getRepository(Emprunteur::class);
        $emprunteur = $repository->findOneBy(array('id' => $id));

        return $this->render('user/singleUser.html.twig', [
            'id' => $id, 'Emprunteur' => $emprunteur
        ]);
    }
}

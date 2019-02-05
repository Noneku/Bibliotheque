<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/livre{id}", name="app_getLivre{id}")
     */
    public function getLivre($id)
    {   
        $repository = $this->getDoctrine()->getRepository(Livre::class);
        $livre = $repository->findOneBy(array('id' => $id));   
        return $this->render('livre/singleLivre.html.twig', [
            'id' => $id, 'livre' => $livre
        ]);
    }
}

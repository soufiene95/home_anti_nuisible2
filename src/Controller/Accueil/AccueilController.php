<?php

namespace App\Controller\Accueil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil_accueil_index')]
    public function index(): Response
    {
        return $this->render('accueil/accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
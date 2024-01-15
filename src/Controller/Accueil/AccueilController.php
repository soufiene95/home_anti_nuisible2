<?php

namespace App\Controller\Accueil;

use App\Repository\PrestationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil_index', methods:['GET', 'POST'])]
    public function index(PrestationsRepository $prestationsRepository): Response
    {
        $prestations = $prestationsRepository->findAll();
        //dd($prestations);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'prestations' => $prestations,
        ]);
    }
}

<?php

namespace App\Controller\Formulaire;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormulaireController extends AbstractController
{
    #[Route('/formulaire/formulaire', name: 'app_formulaire_formulaire')]
    public function index(): Response
    {
        return $this->render('formulaire/formulaire/index.html.twig', [
            'controller_name' => 'FormulaireController',
        ]);
    }
}

<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/user/home', name: 'app_user_home', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('user/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

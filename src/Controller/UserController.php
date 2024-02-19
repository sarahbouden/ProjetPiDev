<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('base-back.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/index', name: 'ammm')]
    public function hello(): Response
    {
        return $this->render('base-front.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}

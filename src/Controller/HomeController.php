<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [

        ]);
    }

    #[Route('/l', name: 'app_logout', methods: ['GET'])]
    public function dex(): Response
    {

        return $this->render('home/index.html.twig', [

        ]);
    }
}
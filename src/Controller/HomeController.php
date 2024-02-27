<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(SerieRepository $serieRepository): Response
    {

        $array_series = $serieRepository->findAll();

        return $this->render('page/home/home.html.twig', [
            'array_series' => $array_series,
            'controller_name' => 'HomeController',
        ]);
    }
}

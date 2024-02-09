<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    #[Route('/mostrarSerie/{id}', name: 'mostrar_serie')]
    public function index(SerieRepository $serieRepository, int $id): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException(
                '404 Not found ' //TODO: redirigir a página de error
            );
        }

        return $this->render('serie/views/showSerie.html.twig', [
            'nombre_serie' => $serie->getNombre(),
            'poster_serie' => $serie->getPosterSrc()
        ]);
    }
}

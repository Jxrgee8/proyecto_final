<?php

namespace App\Controller;

use App\Repository\GeneroRepository;
use App\Repository\PlataformaRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    #[Route('/mostrarSeries', name: 'mostrar_series')]
    public function mostrarSeries(SerieRepository $serieRepository): Response
    {
        $array_series = $serieRepository->findAll();

        if (!$array_series) {
            throw $this->createNotFoundException(
                '404 Not found' // TODO: redirigir a página de error
            );
        }

        return $this->render('serie/views/showAllSeries.html.twig', [
            'array_series' => $array_series
        ]);
    }

    #[Route('/mostrarSerie/{id}', name: 'mostrar_serie')]
    public function mostrarSerie(SerieRepository $serieRepository, int $id): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException(
                '404 Not found' // TODO: redirigir a página de error
            );
        }

        return $this->render('serie/views/showSerie.html.twig', [
            'id_serie' => $serie->getId(),
            'nombre_serie' => $serie->getNombre(),
            'poster_serie' => $serie->getPosterSrc()
        ]);
    }

    #[Route('/mostrarSeries/{genero}')]
    public function mostrarSeriesPorGenero(GeneroRepository $generoRepository, string $genero): Response
    {
        $genero = $generoRepository->buscarGenero($genero);
        $genero_string = $genero->getNombre();
        
        if (!$genero) {
            throw $this->createNotFoundException((
                '404 Not Found' // TODO: redirigir a página de error
            ));
        }

        $array_series = $genero->getSerie();

        return $this->render('serie/views/showAllSeriesGenero.html.twig', [
            'array_series' => $array_series,
            'genero' => $genero_string
        ]);
    }

    #[Route('/mostrarSeries/{plataforma}')]
    public function mostrarSeriesPorPlataforma(PlataformaRepository $plataformaRepository, string $plataforma): Response
    {
        $plataforma = $plataformaRepository->buscarPlataforma($plataforma);
        $plataforma_string = $plataforma->getNombre();
        
        if (!$plataforma) {
            throw $this->createNotFoundException((
                '404 Not Found' // TODO: redirigir a página de error
            ));
        }

        $array_series = $plataforma->getSerie();

        return $this->render('serie/views/showAllSeriesPLataforma.html.twig', [
            'array_series' => $array_series,
            'plataforma' => $plataforma_string
        ]);
    }

}

<?php

namespace App\Controller;

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
            'nombre_serie' => $serie->getNombre(),
            'poster_serie' => $serie->getPosterSrc()
        ]);
    }

    #[Route('/mostrarSeries/{genero}')]
    public function mostrarSeriesPorGenero(SerieRepository $serieRepository, string $genero): Response
    {
        $array_series = $serieRepository->buscarPorGenero($genero);

        /*
        $tareas = $tareaRepository->findTareasMayorPrioridad($pri); // Objetos

        $tareas_string = "";

        // Procesar objetos:    
        foreach($tareas as $tarea) {
            $tareas_string = $tareas_string." >".$tarea->getNombre()." (Objeto)";
        }
        
        return new Response('Las tareas seleccionadas son: ' . $tareas_string);
        */

        if (!$array_series) {
            throw $this->createNotFoundException((
                '404 Not Found' // TODO: redirigir a página de error
            ));
        }

        return $this->render('serie/views/showAllSeriesGenero.html.twig', [
            'array_series' => $array_series,
            'genero' => $genero
        ]);
    }

}

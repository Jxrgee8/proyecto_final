<?php

namespace App\Controller;

use App\Repository\GeneroRepository;
use App\Repository\ListaRepository;
use App\Repository\PlataformaRepository;
use App\Repository\SerieRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class SerieController extends AbstractController
{
    #[Route('/mostrarSerie/id={id}', name: 'mostrar_serie_id')]
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

    #[Route('/buscarSerie/genre={genero}', name: 'buscar_serie_genero')]
    public function buscarSeriePorGenero(GeneroRepository $generoRepository, string $genero): Response
    {
        $genero_buscar = new UnicodeString($genero);
        $genero_lower = ($genero_buscar)->lower();
        $genero = $generoRepository->buscarGenero($genero_lower);
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

    #[Route('/buscarSerie/plat={plataforma}', name: 'buscar_serie_plataforma')]
    public function buscarSeriePorPlataforma(PlataformaRepository $plataformaRepository, string $plataforma): Response
    {
        $plataforma_buscar = new UnicodeString($plataforma);
        $plataforma_lower = ($plataforma_buscar)->lower();
        $plataforma = $plataformaRepository->buscarPlataforma($plataforma_lower);
        $plataforma_string = $plataforma->getNombre();
        
        if (!$plataforma) {
            throw $this->createNotFoundException((
                '404 Not Found' // TODO: redirigir a página de error
            ));
        }

        $array_series = $plataforma->getSerie();

        return $this->render('serie/views/showAllSeriesPlataforma.html.twig', [
            'array_series' => $array_series,
            'plataforma' => $plataforma_string
        ]);
    }

    #[Route('/empezarSerie/id={id}', name: 'empezar_serie')]
    public function empezarSerie(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, int $id): Response
    {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);
        $array_series = $listaUsuario->getSerie();

        return $this->render('serie/views/showAllSeriesPorVer.html.twig', [
            'array_series' => $array_series
        ]);
    }
}

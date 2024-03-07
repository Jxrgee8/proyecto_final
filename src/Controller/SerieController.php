<?php

namespace App\Controller;

use App\Repository\GeneroRepository;
use App\Repository\ListaRepository;
use App\Repository\SerieRepository;
use App\Repository\StreamingRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\UnicodeString;

class SerieController extends AbstractController
{
    /** ######### MÉTODOS DE SERIES: ######### */

    /**
     * Método que buscará una serie a través de su id y devolverá la página de dicha serie.
     * id: id de la serie
     */
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

    /**
     * Método que mostrará todas las series disponibles.
     */
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

    /**
     * Método que mostrará todas las series de un género específico.
     * Se usará en el apartado de búsqueda.
     * genero: genero de la serie
     */
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

    /**
     * Método que mostrará todas las series de una plataforma de streaming específica.
     * Se usará en el apartado de búsqueda.
     * streaming: plataforma de streaming de la serie
     */
    #[Route('/buscarSerie/stream={streaming}', name: 'buscar_serie_streaming')]
    public function buscarSeriePorStreaming(StreamingRepository $streamingRepository, string $streaming): Response
    {
        $streaming_buscar = new UnicodeString($streaming);
        $streaming_lower = ($streaming_buscar)->lower();
        $streaming = $streamingRepository->buscarStreaming($streaming_lower);
        $streaming_string = $streaming->getNombre();
        
        if (!$streaming) {
            throw $this->createNotFoundException((
                '404 Not Found' // TODO: redirigir a página de error
            ));
        }

        $array_series = $streaming->getSerie();

        return $this->render('serie/views/showAllSeriesStreaming.html.twig', [
            'array_series' => $array_series,
            'streaming' => $streaming_string
        ]);
    }


    /** ######### MÉTODOS DE PERFIL: ######### */


    /**
     * Método que mostrará la página de perfil del usuario actual. Por defecto mostrará el listado de las series que está viendo.
     */
    #[Route('/perfil', name: 'perfil')]
    public function perfil(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository) {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

        $array_series = $listaUsuario->getSerieListas();

        return $this->render('page/perfil/perfil.html.twig', [
            'array_series' => $array_series
        ]);
    }

    /**
     * Método que permitirá navegar entre las distintas listas del usuario (que aparecen en el perfil).
     * Dependiendo de la lista seleccionada por el usuario se mostrarán unas series u otras.
     * tipo_lista: tipo de lista a mostrar (series_viendo | series_por_ver | series_vistas | series_favoritas)
     */
    #[Route('/perfil/{tipo_lista}', name: 'perfil_browse_lista')]
    public function seriesPorVer(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, string $tipo_lista): Response
    {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        $array_series = "";
        $listaUsuario = "";

        if ($tipo_lista == "series_viendo") {
            $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);
            $array_series = $listaUsuario->getSerieListas();
        }

        if ($tipo_lista == "series_por_ver") {
            $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);
            $array_series = $listaUsuario->getSerieListas();
        }

        if ($tipo_lista == "series_vistas") {
            $listaUsuario = $listaRepository->listaSeriesVistas($currentUserID);
            $array_series = $listaUsuario->getSerieListas();
        }

        if ($tipo_lista == "series_favoritas") {
            $listaUsuario = $listaRepository->listaSeriesFavoitas($currentUserID);
            $array_series = $listaUsuario->getSerieListas();
        }

        return $this->render('page/perfil/perfilListas.html.twig', [
            'array_series' => $array_series
        ]);
    }


    /** ######### MÉTODOS DE LISTA DE SEGUIMIENTO: ######### */

    /**
     * Método que muestra la página de lista de seguimiento, donde se encuentran todas las series de la lista series_por_ver
     */
    #[Route('/seguimiento', name: 'seguimiento')]
    public function seguimiento(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository) {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);

        $array_series = $listaUsuario->getSerieListas();

        return $this->render('page/seguimiento/seguimiento.html.twig', [
            'array_series' => $array_series
        ]);
    }
}

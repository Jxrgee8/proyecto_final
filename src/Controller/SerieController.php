<?php

namespace App\Controller;

use App\Repository\GeneroRepository;
use App\Repository\ListaRepository;
use App\Repository\SerieListaRepository;
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

        $array_temporada = $serie->getTemporadas();

        $capitulos = "";

        foreach ($array_temporada as $temporada) {
            $capitulos = count($temporada->getCapitulo());
        }

        return $this->render('serie/views/showSerie.html.twig', [
            'id_serie' => $serie->getId(),
            'nombre_serie' => $serie->getNombre(),
            'poster_serie' => $serie->getPosterSrc(),
            'streaming_serie' => $serie->getStreamings(),
            'genero_serie' => $serie->getGenero(),
            'director_serie' => $serie->getDirector(),
            'sinopsis_serie' => $serie->getSinopsis(),
            'temporada_serie' => $serie->getTemporadas(),
            'capitulos' => $capitulos
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
    public function perfil(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieListaRepository $serieListaRepository, SerieRepository $serieRepository) {
        // Obtener el ID del usuario conectado:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Buscar la lista "serie_viendo" del usuario conectado: 
        $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

        // Obtener el ID de dicha lista ("series_viendo"):
        $currentListaID = $listaUsuario->getId(); 

        // Obtener un array con todas las series de la lista con el ID anterior (SerieLista):
        $series_lista = $serieListaRepository->getSerieIdFromLista($currentListaID);

        $array_id_series = [];

        foreach ($series_lista as $id_serie) {
            $array_id_series[] = $id_serie['serie_id'];
        }

        $array_series = [];

        foreach ($array_id_series as $id_serie) {
            $array_series[] = $serieRepository->find($id_serie);
        }

        return $this->render('page/perfil/perfil.html.twig', [
            'array_series' => $array_series
        ]);
    }

    private function statsPerfil(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository) {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Ids de listas a buscar:
        $lista_vistas = $listaRepository->listaSeriesVistas($currentUserID);
        $lista_por_ver = $listaRepository->listaSeriesPorVer($currentUserID);
        $lista_favoritas = $listaRepository->listaSeriesFavoitas($currentUserID);

        // Array Series en cada Lista
        $series_vistas = $serieListaRepository->getSerieIdFromLista($lista_vistas->getId());;
        $series_por_ver = $serieListaRepository->getSerieIdFromLista($lista_por_ver->getId());
        $series_favoritas = $serieListaRepository->getSerieIdFromLista($lista_favoritas->getId());

        // Guardar número de series en cada lista:
        $array_series_vistas = []; 
        $array_series_por_ver = []; 
        $array_series_favoritas = []; 

        //VISTAS:
            foreach ($series_vistas as $id_serie_vista) {
                $array_series_vistas[] = $id_serie_vista['serie_id'];
            }

        //POR VER:
            foreach ($series_por_ver as $id_serie_por_ver) {
                $array_series_por_ver[] = $id_serie_por_ver['serie_id'];
            }

        //FAVORITAS:
            foreach ($series_favoritas as $id_serie_favorita) {
                $array_series_favoritas[] = $id_serie_favorita['serie_id'];
            }      

        // Contador de series para el perfil:
        $num_por_ver = count($array_series_por_ver);
        $num_vistas = count($array_series_vistas);
        $num_favoritas = count($array_series_favoritas);

        $array_stats = [$num_vistas, $num_por_ver, $num_favoritas];

        return $array_stats;
    }

    /**
     * Método que permitirá navegar entre las distintas listas del usuario (que aparecen en el perfil).
     * Dependiendo de la lista seleccionada por el usuario se mostrarán unas series u otras.
     * tipo_lista: tipo de lista a mostrar (series_viendo | series_por_ver | series_vistas | series_favoritas)
     * Se usará la misma funcionalidad que en el método /perfil
     */
    #[Route('/perfil/{tipo_lista}', name: 'perfil_browse_lista')]
    public function seriesPorVer(UsuarioRepository $usuarioRepository, string $tipo_lista, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository): Response
    {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        $nombre_usuario = $currentUser->getUsername(); //nombre del usuario
        $array_series = [];
        
        $array_stats = $this->statsPerfil($usuarioRepository, $listaRepository, $serieRepository, $serieListaRepository);

        // Dependiendo de la lista activa se pasará la una clase para subrayar el título de dicha lista:
        $activo_viendo = "";
        $activo_por_ver = "";
        $activo_vistas = "";
        $activo_favoritas = "";

        // Obtener SERIES VIENDO:
        if ($tipo_lista == "series_viendo") {
            // Se selecciona el tipo de lista a buscar ("series_viendo"):
            $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

            // Obtener el ID de dicha lista ("series_viendo"):
            $currentListaID = $listaUsuario->getId(); 

            // Obtener un array con todas las series de la lista con el ID obtenido antes (SerieLista):
            $series_lista = $serieListaRepository->getSerieIdFromLista($currentListaID);

            // Se guardan los ids de las series obtenidas en un array seleccionando esa clave-valor (array['serie_id']):
            $array_id_series = [];
            foreach ($series_lista as $id_serie) {
                $array_id_series[] = $id_serie['serie_id'];
            }

            // Se busca en "serieRepository" las series con los ids obtenidos antes y se guardan todas las series en un array de objetos (Serie[id, nombre, ...]):
            foreach ($array_id_series as $id_serie) {
                $array_series[] = $serieRepository->find($id_serie);
            }

            $activo_viendo = "activo_s_viendo";
        }

        // Obtener SERIES POR VER:
        if ($tipo_lista == "series_por_ver") {
            // Se selecciona el tipo de lista a buscar ("series_por_ver"):
            $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);

            // Obtener el ID de dicha lista ("series_por_ver"):
            $currentListaID = $listaUsuario->getId(); 

            // Obtener un array con todas las series de la lista con el ID obtenido antes (SerieLista):
            $series_lista = $serieListaRepository->getSerieIdFromLista($currentListaID);

            // Se guardan los ids de las series obtenidas en un array seleccionando esa clave-valor (array['serie_id']):
            $array_id_series = [];
            foreach ($series_lista as $id_serie) {
                $array_id_series[] = $id_serie['serie_id'];
            }

            // Se busca en "serieRepository" las series con los ids obtenidos antes y se guardan todas las series en un array de objetos (Serie[id, nombre, ...]):
            foreach ($array_id_series as $id_serie) {
                $array_series[] = $serieRepository->find($id_serie);
            }
            
            $activo_por_ver = "activo_s_por_ver";
        }

        // Obtener SERIES VISTAS:
        if ($tipo_lista == "series_vistas") {
            // Se selecciona el tipo de lista a buscar ("series_vistas"):
            $listaUsuario = $listaRepository->listaSeriesVistas($currentUserID);

            // Obtener el ID de dicha lista ("series_vistas"):
            $currentListaID = $listaUsuario->getId(); 

            // Obtener un array con todas las series de la lista con el ID obtenido antes (SerieLista):
            $series_lista = $serieListaRepository->getSerieIdFromLista($currentListaID);

            // Se guardan los ids de las series obtenidas en un array seleccionando esa clave-valor (array['serie_id']):
            $array_id_series = [];
            foreach ($series_lista as $id_serie) {
                $array_id_series[] = $id_serie['serie_id'];
            }

            // Se busca en "serieRepository" las series con los ids obtenidos antes y se guardan todas las series en un array de objetos (Serie[id, nombre, ...]):
            foreach ($array_id_series as $id_serie) {
                $array_series[] = $serieRepository->find($id_serie);
            }

            $activo_vistas = "activo_s_vistas";
        }

        // Obtener SERIES FAVORITAS:
        if ($tipo_lista == "series_favoritas") {
            // Se selecciona el tipo de lista a buscar ("series_favoritas"):
            $listaUsuario = $listaRepository->listaSeriesFavoitas($currentUserID);

            // Obtener el ID de dicha lista ("series_favoritas"):
            $currentListaID = $listaUsuario->getId(); 

            // Obtener un array con todas las series de la lista con el ID obtenido antes (SerieLista):
            $series_lista = $serieListaRepository->getSerieIdFromLista($currentListaID);

            // Se guardan los ids de las series obtenidas en un array seleccionando esa clave-valor (array['serie_id']):
            $array_id_series = [];
            foreach ($series_lista as $id_serie) {
                $array_id_series[] = $id_serie['serie_id'];
            }

            // Se busca en "serieRepository" las series con los ids obtenidos antes y se guardan todas las series en un array de objetos (Serie[id, nombre, ...]):
            foreach ($array_id_series as $id_serie) {
                $array_series[] = $serieRepository->find($id_serie);
            }        

            $activo_favoritas = "activo_s_favoritas";
        }

        return $this->render('page/perfil/perfilListas.html.twig', [
            'nombre_usuario' => $nombre_usuario,
            'array_series' => $array_series,
            'stats' => $array_stats,
            'activo_s_viendo' => $activo_viendo,
            'activo_s_por_ver' => $activo_por_ver,
            'activo_s_vistas' => $activo_vistas,
            'activo_s_favoritas' => $activo_favoritas,
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

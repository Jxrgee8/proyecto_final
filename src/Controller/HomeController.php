<?php

namespace App\Controller;

use App\Repository\ListaRepository;
use App\Repository\SerieListaRepository;
use App\Repository\SerieRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository): Response
    {
        // Recoger Usuario actual:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener Listas viendo y por ver
        $listaUsuarioViendo = $listaRepository->listaSeriesViendo($currentUserID);
        $listaUsuarioPorVer = $listaRepository->listaSeriesPorVer($currentUserID);

        // Devolver error 404 si no se encuentra la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuarioViendo || !$listaUsuarioPorVer) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Obtener ID de las listas:
        $currentListaViendoID = $listaUsuarioViendo->getId();
        $currentListaPorVerID = $listaUsuarioPorVer->getId(); 

        // Obtener un array con todas las series de la lista con los ID obtenidos antes (SerieLista):
        $series_lista_viendo = $serieListaRepository->getSerieIdFromLista($currentListaViendoID);
        $series_lista_por_ver = $serieListaRepository->getSerieIdFromLista($currentListaPorVerID);

        // Se guardan los ids de las series obtenidas en un array seleccionando esa clave-valor (array['serie_id']):
        $array_id_series_viendo = [];
        foreach ($series_lista_viendo as $id_serie) {
            $array_id_series_viendo[] = $id_serie['serie_id'];
        }

        $array_id_series_por_ver = [];
        foreach ($series_lista_por_ver as $id_serie) {
            $array_id_series_por_ver[] = $id_serie['serie_id'];
        }

        // Se busca en "serieRepository" las series con los ids obtenidos antes y se guardan todas las series en un array de objetos (Serie[id, nombre, ...]):
        foreach ($array_id_series_viendo as $id_serie) {
            $array_series_viendo[] = $serieRepository->find($id_serie);
        }  
        
        foreach ($array_id_series_por_ver as $id_serie) {
            $array_series_por_ver[] = $serieRepository->find($id_serie);
        }    

        return $this->render('page/home/home.html.twig', [
            'array_series_viendo' => $array_series_viendo,
            'array_series_por_ver' => $array_series_por_ver,
        ]);
    }
}

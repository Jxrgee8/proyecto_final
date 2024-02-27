<?php

namespace App\Controller;

use App\Repository\ListaRepository;
use App\Repository\SerieRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListaController extends AbstractController
{
    // TODO: En las series que estén en series_por_ver añadir botón empezar serie. (<a href="path('add_lista_viendo')"></a>)
    #[Route('/addListaViendo/id={id}', name: 'add_lista_viendo')]
    public function empezarSerie(UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, int $id): Response
    {
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

        $serie = $serieRepository->find($id);
        $listaUsuario->addSerie($serie);

        return new Response('Añadida serie: '.$serie->getNombre());
    }
}

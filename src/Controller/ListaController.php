<?php

namespace App\Controller;

use App\Entity\SerieLista;
use App\Repository\ListaRepository;
use App\Repository\SerieListaRepository;
use App\Repository\SerieRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListaController extends AbstractController
{
    #[Route('/addListaViendo/id={id}', name: 'add_lista_viendo')]
    public function empezarSerie(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_viendo):
        $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Si no existe se crea la relación (Se añade la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    #[Route('/addListaVistas/id={id}', name: 'add_lista_vista')]
    public function serieVista(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_vistas):
        $listaUsuario = $listaRepository->listaSeriesVistas($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Si no existe se crea la relación (Se añade la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    #[Route('/addListaPorVer/id={id}', name: 'add_lista_por_ver')]
    public function addSeguimiento(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_por_ver):
        $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Si no existe se crea la relación (Se añade la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    #[Route('/addListaFavoritas/id={id}', name: 'add_lista_favorita')]
    public function marcarFavorita(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_favoritas):
        $listaUsuario = $listaRepository->listaSeriesFavoritas($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Si no existe se crea la relación (Se añade la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    /**
     * Método que permitirá eliminar serie de la lista a la que pertenecen según se encuentren en está vista dentro del perfil.
     * Para encontrar la vista de la lista en la que se encuentran se utilizará el nombre de la clase del contenedor.
     */
    #[Route('/removeSerieLista/id={id}&lista={tipo_lista}', name: 'remove_serie_lista')]
    public function eliminarSerie(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id, string $tipo_lista): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // ID de la serie a eliminar
        $serie = $serieRepository->find($id);
        // ID de la lista a eliminar
        $lista = 0;

        // Obtener la lista de usuario donde se encuentra la serie a eliminar:
        if ($tipo_lista == "viendo-container") {
            $lista = $listaRepository->listaSeriesViendo($currentUserID);
        } else if ($tipo_lista == "por-ver-container") {
            $lista = $listaRepository->listaSeriesPorVer($currentUserID);
        } else if ($tipo_lista == "visto-container") {
            $lista = $listaRepository->listaSeriesVistas($currentUserID);
        } else if ($tipo_lista == "favorito-container") {
            $lista = $listaRepository->listaSeriesFavoritas($currentUserID);
        } else {
            throw $this->createNotFoundException(
                '404 Not found' // TODO: redirigir a página de error
            );
        }

        // ID de la SerieLista a eliminar:
        $idSerieLista = "S".$serie->getId()."L".$lista->getId();

        // Se busca la SerieLista en el repository:
        $serieLista = $serieListaRepository->find($idSerieLista);

        if (!$serieLista) {
            throw $this->createNotFoundException(
                '404 Not found' // TODO: redirigir a página de error
            );
        } 

        $entityManager->remove($serieLista);
        $entityManager->flush();
            
        return $this->redirectToRoute('perfil');
    }
}

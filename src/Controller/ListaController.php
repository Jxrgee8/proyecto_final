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
    /** ##############################################
     *  ######### MÉTODOS DE VISTA DE SERIE: #########
     *  ############################################## */

     /**
      * Método para añadir una serie a la lista "series_viendo" al hacer click sobre "Empezar Serie" 
      */
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

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Se recogen los datos de la lista series_por_ver.
        // Si la serie existe dentro de esta lista se eliminará, funcionando como un cambio de estado (por_ver --> viendo)
        $listaUsuario_delete = $listaRepository->listaSeriesPorVer($currentUserID);
        $id_delete = "S".$serie->getId()."L".$listaUsuario_delete->getId();
        $serieListaID_delete = $serieListaRepository->find($id_delete);

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

        if ($serieListaID_delete != null) {
            $serieLista_delete = $entityManager->find(SerieLista::class, $serieListaID_delete);
            $entityManager->remove($serieLista_delete);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    /**
     * Método que permitirá añadir o eliminar una serie de "series_vistas" según su estado.
     * Si la serie NO ESTÁ marcada como vista (icono de ojo vacío) se AÑADIRÁ a la lista al hacer click sobre dicho icono.
     * Si la serie ESTÁ marcada como vista (icono de ojo relleno) se ELIMINARÁ de la lista al hacer click sobre dicho icono.
     */
    #[Route('/editListaVistas/id={id}', name: 'edit_lista_vista')]
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

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // (if) Si no existe se crea la relación (Se añade la serie a la lista):
        // (else) Si ya existe se elimina la relación (Se elimina la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        } else {
            $serieLista = $entityManager->find(SerieLista::class, $serieListaID);
            $entityManager->remove($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    /**
     * Método que permitirá añadir o eliminar una serie de "series_por_ver" según su estado.
     * Si la serie NO ESTÁ marcada como por_ver (icono de marcador vacío) se AÑADIRÁ a la lista al hacer click sobre dicho icono.
     * Si la serie ESTÁ marcada como por_ver (icono de marcador relleno) se ELIMINARÁ de la lista al hacer click sobre dicho icono.
     */
    #[Route('/editListaPorVer/id={id}', name: 'edit_lista_por_ver')]
    public function serieSeguimiento(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_por_ver):
        $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // (if) Si no existe se crea la relación (Se añade la serie a la lista):
        // (else) Si ya existe se elimina la relación (Se elimina la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        } else {
            $serieLista = $entityManager->find(SerieLista::class, $serieListaID);
            $entityManager->remove($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }

    /**
     * Método que permitirá añadir o eliminar una serie de "series_favoritas" según su estado.
     * Si la serie NO ESTÁ marcada como favorita (icono de corazón vacío) se AÑADIRÁ a la lista al hacer click sobre dicho icono.
     * Si la serie ESTÁ marcada como favorita (icono de corazón relleno) se ELIMINARÁ de la lista al hacer click sobre dicho icono.
     */
    #[Route('/editListaFavoritas/id={id}', name: 'edit_lista_favorita')]
    public function serieFavorita(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_favoritas):
        $listaUsuario = $listaRepository->listaSeriesFavoritas($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // (if) Si no existe se crea la relación (Se añade la serie a la lista):
        // (else) Si ya existe se elimina la relación (Se elimina la serie a la lista):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $entityManager->flush();
        } else {
            $serieLista = $entityManager->find(SerieLista::class, $serieListaID);
            $entityManager->remove($serieLista);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('mostrar_serie_id', ['id' => $serie->getId()]);
    }



    /** ########################################################
     *  ######### MÉTODOS DE VISTA DE LISTAS (PERFIL): #########
     *  ######################################################## */

    /**
     * Método que permitirá eliminar serie de la lista a la que pertenecen según se encuentren en está vista dentro del perfil.
     * Al hacer click sobre el icono de la papelera de cada serie se eliminará de la lista.
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

        if (!$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

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
            return $this->render('security/errors/404-error.html.twig');
        }

        // ID de la SerieLista a eliminar:
        $idSerieLista = "S".$serie->getId()."L".$lista->getId();

        // Se busca la SerieLista en el repository:
        $serieLista = $serieListaRepository->find($idSerieLista);

        if (!$serieLista) {
            return $this->render('security/errors/404-error.html.twig');
        } 

        $entityManager->remove($serieLista);
        $entityManager->flush();
            
        return $this->redirectToRoute('perfil');
    }



    /** ################################################
     *  ######### MÉTODOS DE PÁGINAS EXTERNAS: #########
     *  ################################################ */

    /**
     * Método para empezar serie desde "Seguimiento" al hacer click en el botón de "Empezar Serie" individual para cada serie:
     */
    #[Route('/addListaViendoS/id={id}', name: 'add_lista_viendo_s')]
    public function empezarSerieSeguimiento(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_viendo):
        $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Se recogen los datos de la lista series_por_ver.
        $listaUsuario_delete = $listaRepository->listaSeriesPorVer($currentUserID);
        $id_delete = "S".$serie->getId()."L".$listaUsuario_delete->getId();
        $serieListaID_delete = $serieListaRepository->find($id_delete);

        // Si no existe se crea la relación (Se añade la serie a la lista series_viendo) y se elimina de la lista previa (series_por_ver):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $serieLista_delete = $entityManager->find(SerieLista::class, $serieListaID_delete);
            $entityManager->remove($serieLista_delete);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('seguimiento');
    }

    /**
     * Método para empezar serie desde "Home" al hacer click en el botón "Empezar Serie" individual para cada serie:
     */
    #[Route('/addListaViendoH/id={id}', name: 'add_lista_viendo_h')]
    public function empezarSerieHome(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_viendo):
        $listaUsuario = $listaRepository->listaSeriesViendo($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

        // Se crea el id de SerieLista y se busca si ya existe:
        $id = "S".$serie->getId()."L".$listaUsuario->getId();
        $serieListaID = $serieListaRepository->find($id);

        // Se recogen los datos de la lista en la que estaba la serie (serie_por_ver) para eliminarla de esta:
        $listaUsuario_delete = $listaRepository->listaSeriesPorVer($currentUserID);
        $id_delete = "S".$serie->getId()."L".$listaUsuario_delete->getId();
        $serieListaID_delete = $serieListaRepository->find($id_delete);

        // Si no existe se crea la relación (Se añade la serie a la lista series_viendo) y se elimina de la lista previa (series_por_ver):
        if (null === $serieListaID) {
            $serieLista = new SerieLista();
            $serieLista->setSerie($serie);
            $serieLista->setLista($listaUsuario);
            $serieLista->setFechaAgregado(new \DateTime());
            $serieLista->setId($id);
            $entityManager->persist($serieLista);
            $serieLista_delete = $entityManager->find(SerieLista::class, $serieListaID_delete);
            $entityManager->remove($serieLista_delete);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('home');
    }

    /**
     * Método para añadir serie a seguimiento desde "Destacados" al hacer click sobre el botón "Añadir a Seguimiento" individual para cada serie:
     */
    #[Route('/addListaPorVerD/id={id}', name: 'add_lista_por_ver_d')]
    public function addSeguimientoDestacados(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ListaRepository $listaRepository, SerieRepository $serieRepository, SerieListaRepository $serieListaRepository, int $id): Response
    {
        // Obtener usuario:
        $user = $this->getUser();
        $currentUser = $usuarioRepository->getUserID($user->getUserIdentifier());
        $currentUserID = $currentUser->getId();

        // Obtener lista del usuario a manejar (series_por_ver):
        $listaUsuario = $listaRepository->listaSeriesPorVer($currentUserID);

        // Obtener serie seleccionada:
        $serie = $serieRepository->find($id);

        // Devolver error 404 si no se encuentra la serie o la lista (Usuarios admin, manager o sin logear)
        if (!$listaUsuario || !$serie) {
            return $this->render('security/errors/404-error.html.twig');
        }

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
            
        return $this->redirectToRoute('destacados');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Método para cambiar la ruta por defecto de symfony.
     * Hará un logout de la sesión activa (si hay alguna) y redirigirá al login.
     */
    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_logout');
    }

    /**
     * Método para hacer login.
     * Usará un Token CSRF junto al controlador "LoginFormAuthenticator" para validar al usuario.
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Método para cerrar sesión. 
     * Redirigirá a login tras cerrarla.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Método para mostrar una página de acceso denegado cuando un usuario no tenga el rol necesario para acceder a alguna parte de la página.
     * Permitirá volver a la página de inicio y cerrar sesión.
     */
    #[Route(path: '/accessDenied', name: 'access_denied')]
    public function accessDenied(AuthenticationUtils $authenticationUtils): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/accessDenied.html.twig', ['last_username' => $lastUsername]);

    }

}

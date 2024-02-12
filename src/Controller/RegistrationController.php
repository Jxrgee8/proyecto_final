<?php

namespace App\Controller;

use App\Entity\Lista;
use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /** Función de registrode usuario */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setUsername($form->get('username')->getData());
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();
            
            $usuario = $usuarioRepository->find($user->getId());

            // ?: CREAR ID FORMADO POR [ÚLTIMO ID + 1 (CONSULTA BBDD EN ListaRepository)] + [ID DEL USUARIO ($usuario)]
            $lista1 = new Lista();
            $lista2 = new Lista();
            $lista3 = new Lista();
            $lista4 = new Lista();

            $lista1->setTipoLista('series_viendo');
            $lista1->setUsuario($usuario);
            $entityManager->persist($lista1);

            $lista2->setTipoLista('series_por_ver');
            $lista2->setUsuario($usuario);
            $entityManager->persist($lista2);

            $lista3->setTipoLista('series_vistas');
            $lista3->setUsuario($usuario);
            $entityManager->persist($lista3);

            $lista4->setTipoLista('series_favoritas');
            $lista4->setUsuario($usuario);
            $entityManager->persist($lista4);

            $entityManager->flush();
            
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /** Función para crear una cuenta admin */
    /*#[Route('/crear_admin', name: 'register_admin')]
    public function registerAdmin(EntityManagerInterface $entityManager): Response
    {
        $user = new Usuario();
        $user->setRoles(['ROLE_ADMIN']);
        
        $entityManager->persist($user);
        $entityManager->flush();
        // do anything else you need here, like send an email
        
        return new Response('Admin creado');
    }*/
}

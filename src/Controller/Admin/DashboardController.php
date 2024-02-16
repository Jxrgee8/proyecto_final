<?php

namespace App\Controller\Admin;

use App\Entity\Capitulo;
use App\Entity\Genero;
use App\Entity\Plataforma;
use App\Entity\Serie;
use App\Entity\Temporada;
use App\Entity\Usuario;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Proyecto Final');
    }

    public function configureMenuItems(): iterable
   {
       yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
       yield MenuItem::section('Usuarios');
       yield MenuItem::linkToCrud('Usuario', 'fa fa-user', Usuario::class);
       yield MenuItem::section('Series');
       yield MenuItem::linkToCrud('Serie', 'fa fa-tv', Serie::class);
       yield MenuItem::linkToCrud('Temporada', 'fa fa-th-list', Temporada::class);
       yield MenuItem::linkToCrud('Capitulo', 'fa fa-eye', Capitulo::class);
       yield MenuItem::section('Información de Serie');
       yield MenuItem::linkToCrud('Género', 'fa fa-tags', Genero::class);
       yield MenuItem::linkToCrud('Plataforma', 'fa fa-play-circle-o', Plataforma::class);
   }

}

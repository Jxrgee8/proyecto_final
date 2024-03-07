<?php

namespace App\Controller\Admin;

use App\Entity\Genero;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GeneroCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Genero::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $genero = new Genero();
        $genero->setFechaCreacion(new \DateTime());

        return $genero;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            DateField::new('fecha_creacion')->hideOnForm()
        ];
    }
}

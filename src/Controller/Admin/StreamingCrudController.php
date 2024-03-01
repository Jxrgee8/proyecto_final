<?php

namespace App\Controller\Admin;

use App\Entity\Streaming;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StreamingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Streaming::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            TextField::new('icono_src')->setHelp("img/icons/streaming-icon.svg")->setLabel("Icono de Plataforma"),
            DateField::new('fecha_creacion')
        ];
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Plataforma;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlataformaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plataforma::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
        ];
    }
}

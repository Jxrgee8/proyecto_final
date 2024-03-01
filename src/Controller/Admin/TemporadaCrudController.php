<?php

namespace App\Controller\Admin;

use App\Entity\Temporada;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class TemporadaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Temporada::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            NumberField::new('numero_temp')->setLabel('Número de Temporada'),
            AssociationField::new('Serie'),
            DateField::new('fecha_creacion')
        ];
    }
}

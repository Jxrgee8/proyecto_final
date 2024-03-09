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

    public function createEntity(string $entityFqcn)
    {
        $temporada = new Temporada();
        $temporada->setFechaCreacion(new \DateTime());

        return $temporada;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('Serie'),
            NumberField::new('numero_temp')->setLabel('Número de Temporada'),
            NumberField::new('capitulos'),
            DateField::new('fecha_creacion')->hideOnForm()
        ];
    }
}

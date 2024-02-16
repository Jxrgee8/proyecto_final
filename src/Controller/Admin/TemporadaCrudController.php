<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use App\Entity\Temporada;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

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
            AssociationField::new('Serie')->autocomplete(),
        ];
    }
}

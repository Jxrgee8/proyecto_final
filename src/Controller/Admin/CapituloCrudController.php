<?php

namespace App\Controller\Admin;

use App\Entity\Capitulo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class CapituloCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Capitulo::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $capitulo = new Capitulo();
        $capitulo->setFechaCreacion(new \DateTime());

        return $capitulo;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            NumberField::new('numero_cap')->setLabel('Número de Capítulo'),
            AssociationField::new('Temporada'),
            ChoiceField::new('es_ultimo')->setChoices([
                'Último de Temporada' => 0,
                'Último de Serie' => 1,
            ])->setHelp('? - Vacío para "null"'),  
            DateField::new('fecha_creacion')->hideOnForm()
        ];
    }
}

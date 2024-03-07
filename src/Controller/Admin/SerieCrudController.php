<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SerieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serie::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $serie = new Serie();
        $serie->setFechaCreacion(new \DateTime());

        return $serie;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            NumberField::new('fecha_lanzamiento'),
            TextareaField::new('sinopsis'),
            TextField::new('poster_src')->setHelp("img/posters/SERIE_POSTER.jpg")->setLabel("Póster de Serie"),
            AssociationField::new('genero')->setFormTypeOptions(['multiple' => true])->setFormTypeOption('by_reference', false)->onlyOnForms(),
            ArrayField::new('genero')->hideOnForm(),
            AssociationField::new('streamings')->setFormTypeOptions(['multiple' => true])->setFormTypeOption('by_reference', false)->onlyOnForms(),
            ArrayField::new('streamings')->hideOnForm(),
            AssociationField::new('director')->setFormTypeOptions(['multiple' => true])->setFormTypeOption('by_reference', false)->onlyOnForms(),
            ArrayField::new('director')->hideOnForm(),
            DateField::new('fecha_creacion')->hideOnForm()
        ];
    }
}

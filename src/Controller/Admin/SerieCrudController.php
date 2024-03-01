<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SerieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            NumberField::new('fecha_lanzamiento'),
            TextEditorField::new('sinopsis'),
            TextField::new('poster_src')->setHelp("img/posters/SERIE_POSTER.jpg")->setLabel("Póster de Serie"),
            AssociationField::new('genero')->setFormTypeOptions(['multiple' => true])->setFormTypeOption('by_reference', false),
            ArrayField::new('genero')->hideOnForm(),
            AssociationField::new('streamings')->setFormTypeOptions(['multiple' => true])->setFormTypeOption('by_reference', false),
            ArrayField::new('streamings')->hideOnForm(),
            DateTimeField::new('fecha_creacion')
        ];
    }
}

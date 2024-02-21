<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UsuarioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Usuario::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('username'),
            TextField::new('password')->setFormType(RepeatedType::class)->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Contraseña',
                    'hash_property_path' => 'password',
                ],
                'second_options' => ['label' => '(Confirmar contraseña)'],
                'mapped' => false,
            ])->setRequired($pageName === Crud::PAGE_NEW)->onlyOnForms(),
            ChoiceField::new('roles')->setChoices([
                'Rol de Admin' => 'ROLE_ADMIN',
                'Rol de Manager' => 'ROLE_MANAGER',
            ])->allowMultipleChoices()->onlyOnForms(),
            ChoiceField::new('roles')->setChoices([
                'Rol de Admin' => 'ROLE_ADMIN',
                'Rol de Manager' => 'ROLE_MANAGER',
                'Rol de Usuario' => 'ROLE_USER'
            ])->onlyOnIndex()
        ];
    }
}

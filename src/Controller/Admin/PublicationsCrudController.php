<?php

namespace App\Controller\Admin;

use App\Entity\Publications;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PublicationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Publications::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Publications')
            ->setEntityLabelInSingular('Publication')
            ->setSearchFields(['titre', 'contenu', 'author', 'createdAt'])
            ->setDefaultSort(['createdAt' => 'DESC'], ['titre' => 'ASC']);
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('titre');
        yield SlugField::new('slug')->setTargetFieldName('titre')->hideOnIndex();
        yield TextEditorField::new('contenu');
        yield TextField::new('featuredText')->hideOnIndex();
        yield AssociationField::new('categorie');
        yield BooleanField::new('isActive')->hideOnForm();
        yield BooleanField::new('isPublished')->hideOnForm();
        yield TextField::new('author')->onlyOnDetail();
        yield BooleanField::new('favoris')->hideOnForm();
        yield DateTimeField::new('createdAt')->onlyOnDetail();
        yield DateTimeField::new('publishedAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}
<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield SlugField::new('slug')->setTargetFieldName('title');
        yield TextEditorField::new('content');
        yield DateTimeField::new('createdAt')->setLabel('Créé le')->hideOnForm();
        yield DateTimeField::new('updatedAt')->setLabel('Mis à jour le')->hideOnForm();
        yield AssociationField::new('image')->setLabel('Image');
        yield TextField::new('featured_text')->setLabel('Texte en vedette');
        yield AssociationField::new('category')->setLabel('Catégorie');
        
    }
    
}


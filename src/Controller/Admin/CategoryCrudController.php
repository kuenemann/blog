<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
       
         yield  TextField::new('name');
         yield  SlugField::new('slug')->setTargetFieldName('name');
         yield  ColorField::new('color');
         yield ImageField::new('image')
                ->setBasePath('/images')
                ->setUploadDir('public/images')
                ->setUploadedFileNamePattern('[name].[extension]')
                ->setRequired(false);

        
    }
}

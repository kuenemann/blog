<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{mode}', name: 'category_mode')]
    #[Route('/category/{slug}/{mode}', name: 'category_mode_with_slug')]
    public function show(string $mode, string $slug = 'default'): Response
    {
        $template = $this->getTemplate($mode);

        return $this->render($template, [
            'categorySlug' => $slug,
        ]);
    }

    private function getTemplate(string $mode): string
    {
        switch ($mode) {
            case 'html':
                return 'category/categorie_html.html.twig';
            case 'css':
                return 'category/categorie_css.html.twig';
            case 'symfony':
                return 'category/categorie_symfony.html.twig';
            default:
                throw $this->createNotFoundException('Template not found');
        }
    }
}

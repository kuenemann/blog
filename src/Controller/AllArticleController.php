<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllArticleController extends AbstractController
{
    #[Route('/all/article/{slug}', name: 'app_all_article', defaults: ['mode' => 'default'])]
    public function showAllArticles( string $slug, EntityManagerInterface $entityManagerInterface): Response
    {
        $template = $this->getTemplate($slug);

        $articlesRepository = $entityManagerInterface->getRepository(Article::class);
        $articles = $articlesRepository->createQueryBuilder('a')
            ->join('a.category', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getResult();

        return $this->render($template, [
            'categorySlug' => $slug,
            'articles' => $articles,
        ]);
    }

  private function getTemplate(string $slug): string
{
    switch ($slug) {
        case 'html':
            return 'allcategory/categorie_html.html.twig';
        case 'css':
            return 'allcategory/categorie_css.html.twig';
        case 'symfony':
            return 'allcategory/categorie_symfony.html.twig';
        default:
            throw $this->createNotFoundException('Template not found');
    }
}

}

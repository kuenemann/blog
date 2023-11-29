<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Security;

class ArticleController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article, Request $request): Response
    {
        // Vérifiez si l'article existe
        if (!$article) {
            // Redirigez vers la page d'accueil si l'article n'existe pas
            return $this->redirectToRoute('app_accueil');
        }

        // Créez un nouveau commentaire lié à l'article
        $comment = new Comment();
        $comment->setArticle($article);

        // Définissez la date de mise à jour (à supprimer si la date n'est pas nécessaire ici)
        $comment->setCreatedAt(new DateTimeImmutable());

        // Créez le formulaire de commentaire
        $commentForm = $this->createForm(CommentType::class, $comment);

        // Gérez la soumission du formulaire
        
        $commentForm->handleRequest($request);

        // Vérifiez si le formulaire a été soumis et est valide
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Vérifiez si l'utilisateur est connecté avant d'ajouter le commentaire
            if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                // L'utilisateur est connecté, enregistrez le commentaire dans la base de données
                $comment->setUser($this->getUser()); // Associez l'utilisateur au commentaire
                $this->entityManager->persist($comment);
                $this->entityManager->flush();

                // Rafraîchissez la page pour afficher le nouveau commentaire
                return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()]);
            } else {
                // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
                return $this->redirectToRoute('app_login');
            }
        }

        // Si le formulaire n'est pas valide ou n'a pas été soumis, affichez la page normalement
        return $this->render('article/afficher.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}

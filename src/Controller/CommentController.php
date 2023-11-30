<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;



class CommentController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/create-comment', name: 'create_comment', methods: ['POST'])]
    public function createComment(Request $request): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // L'utilisateur est connecté, autorisez la création du commentaire

            // Récupérez l'utilisateur actuel
            $user = $this->getUser();

            // Exemple de création d'un nouveau commentaire avec le contenu du formulaire
            $newComment = new Comment();
            $newComment->setContent($request->request->get('comment_form')['content']);
            $newComment->setCreatedAt(new \DateTimeImmutable());
            $newComment->setUser($user);

            // Enregistrez le commentaire dans la base de données
            $this->entityManager->persist($newComment);
            $this->entityManager->flush();

            // Utilisez dump ou dd pour afficher des informations dans la console Symfony
            dump('Commentaire créé et persisté avec succès!');

            // Redirigez l'utilisateur vers la page des commentaires
            return $this->redirectToRoute('app_comment');
        } else {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            // Vous pouvez personnaliser la route de redirection en fonction de vos besoins
            return $this->redirectToRoute('app_login');
        }
    }


    #[Route('/comment-page/{articleId}', name: 'app_comment', methods: ['GET'])]
    public function commentPage(CommentRepository $commentRepository, int $articleId): Response
    {
        // Récupérez l'article depuis la base de données
        $article = $this->entityManager->getRepository(Article::class)->find($articleId);

        // Récupérez les commentaires depuis la base de données
        $comments = $commentRepository->findAll();

        // Chargez manuellement les détails de l'utilisateur pour chaque commentaire
        foreach ($comments as $comment) {
            // Récupérez l'utilisateur associé à ce commentaire
            $user = $this->entityManager->getRepository(User::class)->find($comment->getUser()->getId());

            // Associez l'utilisateur au commentaire
            $comment->setUser($user);
        }

        // Render the comment page template and pass the article and comments to it
        return $this->render('comment/comment_page.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }
    #[Route('/comment/delete/{id}', name: 'delete_comment', methods: ['DELETE'])]
    public function deleteComment(Comment $comment): JsonResponse
    {
        // Assurez-vous que l'utilisateur est autorisé à supprimer le commentaire, si nécessaire

        // Supprimez le commentaire de la base de données
        $this->entityManager->remove($comment);
        $this->entityManager->flush();

        // Réponse JSON pour indiquer que la suppression a réussi
        return $this->json(['message' => 'Commentaire supprimé avec succès'], JsonResponse::HTTP_OK);
    }
}

    
    


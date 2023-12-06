<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user/{id}/edit', name: 'user_edit')]
    public function edit(Request $request, User $user): Response
    {   
        // Vérification d'accès au tableau de bord ici
        if (!$this->isGranted('ROLE_ADMIN') && $this->getUser() !== $user) {
            throw new AccessDeniedException('Accès non autorisé');
        }
    
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getGdpr() === null) {
                $user->setGdpr(new \DateTime());
            }
    
            $this->entityManager->flush();
    
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }
    
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}



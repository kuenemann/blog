<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    // Ajoutez ces déclarations de dump pour déboguer
    dump($user->getGdpr()); // Avant la soumission du formulaire

    if ($form->isSubmitted() && $form->isValid()) {
        if ($user->getGdpr() === null) {
            $user->setGdpr(new \DateTime());
        }

        // Ajoutez ces déclarations de dump pour déboguer
        dump($user->getGdpr()); // Après la soumission du formulaire

        $this->entityManager->flush();

        // Ajoutez ces déclarations de dump pour déboguer
        dump($user->getGdpr()); // Après la mise à jour dans la base de données

        return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
    }

    return $this->render('user/edit.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
    }

}




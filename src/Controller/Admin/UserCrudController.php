<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('email'),
            TextField::new('first_name'),
            TextField::new('last_name'),
            BooleanField::new('is_blocked', 'Bloqué'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::new('block', 'Bloquer')->linkToCrudAction('block'))
            ->add(Crud::PAGE_INDEX, Action::new('unblock', 'Débloquer')->linkToCrudAction('unblock'));
    }

    public function block(AdminContext $context): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $context->getEntity()->getInstance();
        $user->setIsBlocked(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'Le compte a été bloqué avec succès.');

        return $this->redirectToRoute('admin', ['crudController' => 'UserCrud']);
    }

    public function unblock(AdminContext $context): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $context->getEntity()->getInstance();
        $user->setIsBlocked(false);
        $this->entityManager->flush();

        $this->addFlash('success', 'Le compte a été débloqué avec succès.');

        return $this->redirectToRoute('admin', ['crudController' => 'UserCrud']);
    }
}

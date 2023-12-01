<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'required' => true, 
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Votre Bio',
                'required' => true,  
            ])
            // Si le champ n'est pas obligatoire
            ;

        // Ajoutez d'autres champs en fonction de vos besoins
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // configure the form to bind to the User class
            'data_class' => 'App\Entity\User',
        ]);
    }
}

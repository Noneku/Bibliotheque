<?php

namespace App\Form;

use App\Entity\Livre; 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;  
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddLivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                  ->add('titre', TextType::class, ['label' => 'Titre'])
                  ->add('auteur', TextType::class, ['label' => 'Auteur'])
                  ->add('resume', TextareaType::class, ['label' => 'Resumé'])
                  ->add('status', ChoiceType::class, ['choices' => ['En stock' => 1 , 'Pas en stock' => 0]])
                  ->add('Envoyer', SubmitType::class, ['attr' => ['label' => 'Envoyer']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}

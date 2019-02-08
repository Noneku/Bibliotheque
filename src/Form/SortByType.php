<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

class SortByType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder
           ->add('name', EntityType::class,[
             'class' => Category::class,
             'choice_label' => 'name',
             'choice_value' => 'id'
            ])
             ->add('submit', SubmitType::class,
             ['attr' => ['label' => 'Rechercher']])
       ;
   }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}

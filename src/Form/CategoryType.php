<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('color', ColorType::class)
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    // Configuration de la classe pour tout le formulaire
    //méthode configureOptions est utilisé pour configurer les paramètres glocaux du formulaire
    //$resolver est un objet fourni par Symfony
    public function configureOptions(OptionsResolver $resolver): void
    {
        // avec setDefaults on défini les valeurs par défaut pour les options du formulaire
        // on lui donne un tableau avec les options par défaut du form
        $resolver->setDefaults([
            'data_class' => Category::class
        ]);
    }

}

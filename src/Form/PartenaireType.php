<?php

namespace App\Form;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\DateTime;



class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomP',TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom Partenaire',
                ]
            ])
            ->add('TypeP',TextType::class, [
                'attr' => [
                    'placeholder' => 'Type Partenaire',
                ]
            ])
            ->add('DescriptionP',TextAreaType::class, [
                'attr' => [
                    'placeholder' => 'Description Partenaire',
                ]
            ])
            ->add('PhotoURL',FileType::class, [
                'label' => 'Select your Picture' ,
                'data_class' => null,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}

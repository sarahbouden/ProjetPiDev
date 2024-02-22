<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Partenaire;
use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use DateTime;




class Offre1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomOffre',TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de Offre',
                ]
            ])
            ->add('DescriptionOffre',TextAreaType::class, [
                'attr' => [
                    'placeholder' => 'Description Offre',
                ]
            ])
            ->add('DateExp',DateType::class,[
                'widget' =>'single_text',
                'html5'=>true,
                'attr'=>['min'=>(new DateTime())->format('Y-m-d')],
            ])
            ->add('Partenaire', EntityType::class, [
                'class' => Partenaire::class,
                'choice_label' => 'NomP', 
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
            'data_class' => Offre::class,
        ]);
    }
}

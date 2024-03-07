<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\Recompense;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecompenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomRecp', TextType::class, [
                'label' => 'Nom de la récompense',
                'attr' => [
                    'placeholder' => 'Veuillez saisir le nom de la récompense',
                ],
                'invalid_message' => 'Veuillez saisir  le nom de la récompense de la publication.',
            
            ])
            ->add('Niveau', TextType::class, [
                'label' => 'Niveau',
                'attr' => [
                    'placeholder' => 'Veuillez saisir le niveau',
                ],
                'invalid_message' => 'Veuillez saisir le niveau de la publication.', 
            ])
            ->add('DescriptionRecp', TextType::class, [
                'label' => 'Description de la récompense',
                'attr' => [
                    'placeholder' => 'Veuillez saisir la description de la récompense',
                ],
                'invalid_message' => 'Veuillez saisir la description de la récompense  de la publication.',
            ]);
            /*->add('Sauvegarder', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => [
                    'novalidate' => 'false',
                ]
            ]);*/
   
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recompense::class,
        ]);
    }
}
<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image', FileType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold'],
            'label' => 'Image',
            'mapped' => false,
            'required' => false,
            'data_class' => null,
            'constraints' => [
                new File([
                    'mimeTypes' => [
                        'image/webp',
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Le site accepte uniquement les fichiers WEBP, PNG et JPG',
                    ])
                ],
        ])
        ->add('nom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('marque',TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('prix', NumberType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('description', TextareaType::class, ['attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('categorie', ChoiceType::class, [
            'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold'],
            'choices'  => [
                'Extérieur' => 'Extérieur',
                'Intérieur' => 'Intérieur',
                'Décoration' => 'Décoration',
            ],
        ])
        ->add('scategorie', ChoiceType::class, [ //scatégorie n'est pas forcéme,nt lié à catégorie mais je ne peux tranféré ceci en tant que entité en raison du manque de temp,je le ferai ensuite lors d'une mise à jour
            'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold'],
            'choices'  => [
                'Filaire' => 'Filaire',
                'Piscines Spas' => 'Piscines Spas',
                'Laveur' => 'Laveur',
                'Bureau' => 'Bureau',
            ],
        ])
        ->add('envoyer', SubmitType::class, ['attr' => ['class'=> 'btn bg-primary text-white m-4' ], 'row_attr' => ['class' => 'text-center'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

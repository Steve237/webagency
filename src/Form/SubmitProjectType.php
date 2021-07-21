<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SubmitProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [

            "label" => false,

            "attr" => [

                "class" => "form-control input-width",

                "placeholder" => "Veuillez entrer votre nom",
                "require" => true
            ]
        ])


        ->add('email', EmailType::class, [

            "label" => false,

            "attr" => [

                "class" => "form-control input-width",
                "placeholder" => "Veuillez entrer votre adresse email",
                "require" => true
            ]
        ])


        ->add('message', TextareaType::class, [

            "label" => false,

            "attr" => [

                "class" => "form-control input-width",
                "placeholder" => "Veuillez nous décrire votre projet",
                "cols" => 30,
                "rows" => 10,
                "require" => true
            ]
        ])

        ->add('tel', TelType::class, [

            "label" => false,

            "attr" => [

                "class" => "form-control input-width",
                "placeholder" => "Veuillez entrer votre numéro de téléphone",
                "require" => true
            ]
        ])


        ->add('society', TextType::class, [

            "label" => false,

            "attr" => [

                "class" => "form-control input-width",
                "placeholder" => "Veuillez entrer le nom de votre société",
                "require" => true
            ]
        ])

    ;
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UpdateProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [

                "attr" => [

                    "class" => "form-control",

                    "placeholder" => "Entrez le nom du projet"

                ], 

                "label" => false,

                "required" => true,
                
            ])
            
            ->add('client', TextType::class, [

                "attr" => [

                    "class" => "form-control",

                    "placeholder" => "Pour quelle société le projet a été réalisé?"

                ], 

                "label" => false,

                "required" => true
            ])
            
            ->add('duration', TextType::class, [

                "attr" => [

                    "class" => "form-control",
                    "placeholder" => "Combien de temps a duré le projet? (facultatif)"

                ], 

                "label" => false,

                "required" => false
            ])
            
            ->add('url', UrlType::class, [

                "attr" => [

                    "class" => "form-control",
                    "placeholder" => "Entrez l'url vers l'application (facultatif)"

                ],
                
                "label" => false,

                "required" => false
            ])
            
            
            ->add('description', TextareaType::class, [


                "attr" => [

                    "class" => "form-control",
                    "placeholder" => "Description détaillée du projet",

                ], 

                "label" => false,

                "required" => true

            ])


            ->add('shortdescription', TextareaType::class, [


                "attr" => [

                    "class" => "form-control",
                    "placeholder" => "Résumé du projet"

                ], 

                "label" => false,

                "required" => true

            ])


            ->add('image', FileType::class, [

                "label" => false,

                "attr" => [

                    "class" => "form-control",
                    "accept" => "img/jpg, image/png, image/jpeg",

                ], 

                "required" => false,

                "mapped" => false,

            ])
            
            ->add('videolink',  UrlType::class, [

                "attr" => [

                    "class" => "form-control",
                    "placeholder" => "Video youtube du projet (faculatif)"

                ],
                
                "label" => false,

                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}

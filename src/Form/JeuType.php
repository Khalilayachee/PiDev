<?php

namespace App\Form;

use App\Entity\Categorie;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Choice;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_jeu', null, ['constraints' => [
            new Assert\NotBlank(), // Le champ ne doit pas être vide
            // Ajoutez d'autres contraintes si nécessaire
        ],
    ])
            ->add('description_jeu')
            ->add('date_de_sortie', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'constraints' => [
                    new Assert\NotBlank(), // Le champ ne doit pas être vide
                ],
            ])
         /*  ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Horreur ' => 'Horreur ',
                    'RPG (Role-Playing Game)' => 'RPG (Role-Playing Game)',
                    'Action ' => 'Action ',
                    'Aventure  ' => 'Aventure  ',
                ],
            ])                                                           */
            ->add('Categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom_categorie',   
                'multiple' => false,
                'expanded' => false
              ])
            ->add('images', FileType::class, [
                'label' => 'Fichier',
                'required' => false, // Facultatif, si le téléchargement de fichier n'est pas obligatoire
                'mapped' => true, // Si vous ne stockez pas directement le fichier dans l'entité Post
                'attr' => ['accept' => '.jpg,.jpeg,.png,.gif'] // Spécifiez les types de fichiers acceptés
            ])
            
            ->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

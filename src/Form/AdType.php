<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Veuillez saisir un titre"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse Web", "Veuillez saisir l'adresse web (automatique)", [
                'required' => false
            ]))
            ->add('introdution', TextType::class, $this->getConfiguration("Introduction", "Saisissez une introduction rapide"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description", "Saisissez une description détaillée"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Image", "Url de l'image principale"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambres", "Nombre de chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Veuillez saisir un prix pour une nuit"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EntrepriseType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom')
                ->add('imageFile', VichImageType::class, [
                    'label' => false,
                    'required' => false,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => true,
                    'asset_helper' => true,
                ])
                ->add('contact')
                ->add('adresse')
                ->add('api_message')
                ->add('message_1')
                ->add('message_2')
                ->add('message_3')
                ->add('message_4')
                ->add('message_5')
                ->add('livraison_uniquement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }

}

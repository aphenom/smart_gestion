<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('imageFile', VichImageType::class, [
                    'label' => false,
                    'required' => false,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => true,
                    'asset_helper' => true,
                ])
                ->add('nom')
                ->add('pu_vente')
                ->add('pu_achat')
                ->add('seuil_approvisionnement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}

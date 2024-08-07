<?php

namespace App\Form;

use App\Entity\CommandeArticle;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeArticleExterneType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('quantite')
                ->add('remise')
                ->add('article', ArticleExterneType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CommandeArticle::class,
        ]);
    }

}

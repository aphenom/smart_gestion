<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/* use Symfony\Component\Form\Extension\Core\Type\CollectionType;
 */

class ComptableType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('montant_recu')
                ->add('date_montant', DateType::class, array(
                    'widget' => 'single_text',
                    'html5' => true,
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }

}

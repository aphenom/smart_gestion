<?php

namespace App\Form;

use App\Entity\AutreTransaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AutreTransactionType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('type_transaction', ChoiceType::class, array(
                    'choices' => array(
                        'ENTREE' => 'entree',
                        'SORTIE' => 'sortie',
                    ),
                    'placeholder' => 'Choisir le type de transaction',
                    'required' => true,))
                ->add('montant')
                ->add('objet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => AutreTransaction::class,
        ]);
    }

}

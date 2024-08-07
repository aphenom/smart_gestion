<?php

namespace App\Form;

use App\Entity\Agent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class AgentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom')
                ->add('prenom')
                ->add('contact', TelType::class, array(
                    'required' => false,))
                ->add('type_piece', ChoiceType::class, array(
                    'choices' =>
                    array
                        (
                        'Veuillez sélèctionner un type' => '',
                        'CNI' => 'cni',
                        'Récépissé' => 'recepisse',
                        'Attestation' => 'attestation',
                        'Passeport' => 'passeport',
                        'Carte séjour' => 'carte_sejour',
                    ),
                    'multiple' => false,
                ))
                ->add('numero_piece')
                ->add('user', UserAgentType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }

}

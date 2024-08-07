<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('text_password', HiddenType::class)
                ->add('username', TextType::class, [
                        //'attr' => ['readonly' => 'readonly'],
                ])
                ->add('roles', ChoiceType::class, array(
                    'choices' =>
                    array
                        (
                        'Commercial' => 'ROLE_COM',
                        'Logisticien' => 'ROLE_LOG',
                        'Livraison' => 'ROLE_LIV',
                        'Comptable' => 'ROLE_FIN',
                        'Administrateur' => 'ROLE_ADMIN',
                    ),
                    'multiple' => true,
                ))
                ->add('password')
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('contact', TelType::class, array(
                    'required' => false,))
                ->add('entreprise', EntityType::class, array(
                    'class' => Entreprise::class,
                    'query_builder' => function (EntityRepository $e) {
                        return $e->createQueryBuilder('e')
                                ->where('e.etat_val = true')
                                ->andWhere('e.etat_del = false')
                                ->addOrderBy('e.nom', 'ASC')
                        ;
                    },
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisissez une entreprise au cas où il interviendrait que dans celle-ci',
                    'required' => false,
                    'attr' => ['data-select' => 'true'],
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}

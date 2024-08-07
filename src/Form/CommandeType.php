<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/* use Symfony\Component\Form\Extension\Core\Type\CollectionType;
 */

class CommandeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('type_commande', ChoiceType::class, array(
                    'choices' => array(
                        'RESEAUX SOCIAUX' => 'reseaux sociaux',
                        'JUMIA' => 'jumia',
                        'LOCALE' => 'locale',
                        'SERVICE LIVRAISON' => 'service livraison',
                    ),
                    'placeholder' => 'Choisir le type de commande',
                    'required' => true,))
                ->add('nom_client')
                ->add('numero_client')
                ->add('lieu_livraison')
                ->add('frais_livraison')
                ->add('date_livraison_souhaite', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'html5' => true,
                    'required' => false,
                ))
                ->add('commentaire')
        /*
         * Rappel :
         * * - 1er argument : nom du champ, ici « categories », car c'est le nom de l'attribut
         * * - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
         * * - 3e argument : tableau d'options du champ
         */
        /* ->add('commandeArticles', CollectionType::class, array(
          'entry_type' => CommandeArticleType::class,
          'allow_add' => true,
          'allow_delete' => true,
          'by_reference' => false,
          )) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }

}

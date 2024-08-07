<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Agent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/* use Symfony\Component\Form\Extension\Core\Type\CollectionType;
 */

class StepsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('commentaire', TextType::class, array(
                    'required' => false,
                ))
                ->add('etat_val', HiddenType::class)
                ->add('etat_del', HiddenType::class)
                ->add('etat_relance', HiddenType::class)
                ->add('etat_lancement', HiddenType::class)
                ->add('etat_livraison', HiddenType::class)
                ->add('etat_livraison_agent', HiddenType::class)
                ->add('etat_livraison_val', HiddenType::class)
                ->add('etat_comptabilite', HiddenType::class)
                ->add('type_etat', HiddenType::class)
                ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                    $user = $event->getData()->getUserAdd();
                    $event->getForm()->add('agent_livreur', EntityType::class, array(
                    'class' => Agent::class,
                    'query_builder' => function (EntityRepository $a) use ($user) {
                        return $a->createQueryBuilder('a')
                                ->where('a.etat_val = true')
                                ->andWhere('a.etat_del = false')
                                                                    ->andWhere('a.entreprise = :entreprise')
                                    ->setParameter('entreprise', $user->getEntreprise())
                                ->addOrderBy('a.nom', 'ASC')
                        ;
                    },
                    'choice_label' => 'displayName',
                    'placeholder' => 'Choisissez un agent pour la livraison',
                    'required' => true,
                    'attr' => ['data-select' => 'true'],
                ));
                })

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

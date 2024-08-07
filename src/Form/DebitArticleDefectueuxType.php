<?php

namespace App\Form;

use App\Entity\DebitArticle;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DebitArticleDefectueuxType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                    $user = $event->getData()->getUserAdd();
                    $event->getForm()->add('article', EntityType::class, array(
                        'class' => Article::class,
                        'query_builder' => function (EntityRepository $a) use ($user) {
                            return $a->createQueryBuilder('a')
                                    ->where('a.etat_val = true')
                                    ->andWhere('a.etat_del = false')
                                    ->andWhere('a.etat_proprio = true')
                                    ->andWhere('a.entreprise = :entreprise')
                                    ->setParameter('entreprise', $user->getEntreprise())
                                    ->addOrderBy('a.nom', 'ASC')
                            ;
                        },
                        'choice_label' => 'displayName',
                        'placeholder' => 'Choisissez un article',
                        'required' => true,
                        'attr' => ['data-select' => 'true'],
                    ));
                })
                ->add('ref_article')
                ->add('objet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => DebitArticle::class,
        ]);
    }

}

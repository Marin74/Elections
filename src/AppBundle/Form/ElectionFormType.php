<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ElectionFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',	TextType::class)
            ->add('type',	EntityType::class, array(
                'class'                     => 'AppBundle:ElectionType',
                'choice_label'              => 'name',
                'multiple'                  => false,
                'placeholder'               => 'election_type',
                'attr'                      => ['class' => 'form-control',],
                'query_builder'             => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('u')->orderBy('u.name', 'ASC');
                },
            ))
            ->add('rounds',	CollectionType::class, array(
            		// each entry in the array will be an "email" field
            		'entry_type'   => ElectionRoundFormType::class,
            		//'allow_add'    => true,
            	))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Election'
        ));
    }
}

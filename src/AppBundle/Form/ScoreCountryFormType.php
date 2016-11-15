<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ScoreCountryFormType extends AbstractType
{
	public $election_id;
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$this->election_id = $options["election_id"];
    	
        $builder
            ->add('voices',		IntegerType::class)
            ->add('candidacy',	EntityType::class, array(
                'class'                     => 'AppBundle:Candidacy',
                'choice_label'              => 'name',
                'multiple'                  => false,
                'placeholder'               => 'candidacy',
                'attr'                      => ['class' => 'form-control',],
                'query_builder'             => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('s')
					->innerJoin("s.round", "r", "WITH", "r = s.round")
                    ->where("r.election = :election")
                    ->orderBy('s.candidate', 'ASC')
                    ->setParameter("election", $this->election_id);
                },
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ScoreCountry',
        	'election_id' => null,
        ));
    }
}

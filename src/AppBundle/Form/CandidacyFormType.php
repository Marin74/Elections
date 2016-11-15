<?php

namespace AppBundle\Form;

use AppBundle\Entity\Candidate;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Election;

class CandidacyFormType extends AbstractType
{
	public $electionId;
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$this->electionId = $options["election_id"];
    	
        $builder
            ->add('candidate',	EntityType::class, array(
                'class'                     => 'AppBundle:Candidate',
                'choice_label'              => 'reverseName',
                'multiple'                  => false,
                'placeholder'               => 'candidate',
                'attr'                      => ['class' => 'form-control',],
                'query_builder'             => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('u')->orderBy('u.lastname', 'ASC');
                },
            ))
            ->add('nuance',		EntityType::class, array(
                'class'                     => 'AppBundle:Nuance',
                'choice_label'              => 'name',
                'multiple'                  => false,
                'placeholder'               => 'nuance',
                'attr'                      => ['class' => 'form-control',],
                'query_builder'             => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('u')->orderBy('u.name', 'ASC');
                },
            ))
            ->add('round',		EntityType::class, array(
                'class'                     => 'AppBundle:ElectionRound',
                'choice_label'              => 'roundNumber',
                'multiple'                  => false,
                'placeholder'               => 'round',
                'attr'                      => ['class' => 'form-control',],
                'query_builder'             => function(EntityRepository $repository) {
                    //return $repository->createQueryBuilder('u')->orderBy('u.roundNumber', 'ASC');
                    
                    return $repository->createQueryBuilder('u')
                    ->where("u.election = :election")
                    ->orderBy('u.roundNumber', 'ASC')
                    ->setParameter("election", $this->electionId);
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
            'data_class' => 'AppBundle\Entity\Candidacy',
        	'election_id' => null,
        ));
    }
}

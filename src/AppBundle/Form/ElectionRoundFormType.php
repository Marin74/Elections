<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElectionRoundFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$timeZoneDisplayed = 'Europe/Paris';
    	
        $builder
            ->add('date',	DateType::class, array('widget' => 'single_text', 'view_timezone' => $timeZoneDisplayed, 'format' => 'dd-MM-yyyy', 'attr' => [
                    'class' => 'form-control input-inline form_datetime',
                ]))
            ->add('roundNumber',	IntegerType::class)
            ->add('resultCountry',	ResultCountryFormType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ElectionRound'
        ));
    }
}

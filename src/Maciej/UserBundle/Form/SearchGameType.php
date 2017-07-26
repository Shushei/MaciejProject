<?php

namespace Maciej\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchGameType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('searchTitle', TextType::class, array(
                    'required' => false,
                    'label' => "Title"
                ))
                ->add('searchCompany', EntityType::class, array(
                    'class' => 'MaciejStudyBundle:Company',
                    'choice_label' => 'company',
                    
                    'required' => false
                ))
                ->add('minDate', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text'
                ))
                ->add('maxDate', DateType::class, array(
                    'required' => false,
                    'widget' => 'single_text'
        ));
    }

}

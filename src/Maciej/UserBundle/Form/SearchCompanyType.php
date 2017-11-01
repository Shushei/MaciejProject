<?php

namespace Maciej\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchCompanyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('searchCompany', TextType::class, array(
                    'required' => false,
                    'label' => "Company"
                ))

                ->add('minDate', DateType::class, array(
                    'required' => false
                ))
                ->add('maxDate', DateType::class, array(
                    'required' => false
        ));
    }

}
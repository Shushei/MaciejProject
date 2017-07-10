<?php

namespace Maciej\MaciejBundle\Form;

use Maciej\MaciejBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CompanyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('company', TextType::class, array(
        'required' => true,
        ))
        ->add('founded', DateType::class, array(        ))
        ->add('ownername', TextType::class, array(        ))
        ->add('ownersurname', TextType::class, array(        ))
        ->add('clogo', FileType::class);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Company::class,
            'emtpy_data' => function (FormInterface $form) {
                return new Company($form->get('Company')->getData());
            },
        ));
    }

}

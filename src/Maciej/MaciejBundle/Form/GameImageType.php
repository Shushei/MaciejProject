<?php
namespace Maciej\MaciejBundle\Form;

use Maciej\MaciejBundle\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GameImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', EntityType::class, array(
                    'class' => 'MaciejStudyBundle:Game',
                    'choice_label' => 'title'))
                ->add('gameimage', FileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'emtpy_data' => function (FormInterface $form) {
                return new GameImage($form->get('game')->getData());
            },
        ));
    }

}
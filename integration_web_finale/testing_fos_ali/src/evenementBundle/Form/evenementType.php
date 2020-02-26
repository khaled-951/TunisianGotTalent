<?php

namespace evenementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class evenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
                ->add('datedebut')
                ->add('datefin')
                ->add('description')
                ->add('typedetalent',ChoiceType::class,array('choices'=>array(
                    'Musique'=>'Musique',
                    'BeatBox'=>'BeatBox',
                    'Comédie'=>'Comédie',
                    'Dance'=>'Dance',
                    'magique'=>'magique',
                    'peinture'=>'peinture',
                    'theatre'=>'theatre'
                )))
                ->add('cout')
            ->add('nbparticipant')
            ->add('file')

            ->add('valider',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'evenementBundle\Entity\evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementbundle_evenement';
    }


}

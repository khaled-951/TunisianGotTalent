<?php

namespace SponsorsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class PackType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('position',ChoiceType::class, array(
            'choices' => array(
                'Left' => 'Left',
                'Right' => 'Right',
                'Center' => 'Center',
            )
        ))->add('ad',
            FileType::class,['required' => false,])->add('displaydate')->add('discarddate')->add('price')->add('idsp',EntityType::class,
            ['class'=>'SponsorsBundle\Entity\Sponsor',
                'choice_label'=>'namesp',
                'multiple'=>false,
                'expanded'=>false
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SponsorsBundle\Entity\Pack'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sponsorsbundle_pack';
    }


}

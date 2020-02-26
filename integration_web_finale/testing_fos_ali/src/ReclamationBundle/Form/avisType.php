<?php

namespace ReclamationBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class avisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //->add('note', ChoiceType::class, [
        //            'choices' => [
        //                'Note' => [
        //                    '1' => '1',
        //                    '2' => '2',
        //                    '3' => '3',
        //                    '4' => '4',
        //                    '5' => '5',
        //                ],
        //            ],
        //        ])

        $builder->add('note',RatingType::class,[
            'stars' => 5,
        ])->add('description',TextareaType::class)->add('Envoyer', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ReclamationBundle\Entity\avis'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'reclamationbundle_avis';
    }


}

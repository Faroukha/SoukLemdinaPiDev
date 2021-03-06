<?php

namespace EvenementBundle\Form;

use Doctrine\DBAL\Types\FloatType;
use EvenementBundle\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('description',TextareaType::class)
            ->add('datedebut',DateType::class,array(
                'widget' => 'single_text'
            ))
            ->add('datefin',DateType::class,array(
                'widget' => 'single_text',

            ))

            ->add('lieu',TextType::class)

            ->add('photo', FileType::class, array('attr' => array('class' => 'form-control file'),'data_class' => null,'label'=>'Photo'))
            ->add('nbMax',NumberType::class)

            ->add('categorie',ChoiceType::class,array(
                'choices'=>array(
                    'Foire'=>'Foire',
                    'Formation'=>'Formation',
                    'Conférence '=>'Conférence',
                )
            ))
        ;
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Event::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'evenementtbundle_event';
    }


}

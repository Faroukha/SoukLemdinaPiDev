<?php

namespace ProduitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', \blackknight467\StarRatingBundle\Form\RatingType::class);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProduitBundle\Entity\Avis'
        ));
    }



    public function getBlockPrefix()
    {
        return 'produitbundle_rating';
    }
}
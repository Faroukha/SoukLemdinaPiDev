<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 09/04/2018
 * Time: 16:12
 */

namespace ProduitBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ratingType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', \blackknight467\StarRatingBundle\Form\RatingType::class, ['stars'=>5, 'label'=>'Notez Nous' ])
            ->add('avis')
            ->add('Enregistrer', SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Rate'
        ));
    }



    public function getBlockPrefix()
    {
        return 'ff';
    }


}

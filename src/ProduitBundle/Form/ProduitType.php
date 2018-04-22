<?php
/**
 * Created by PhpStorm.
 * User: jskka
 * Date: 05/04/2018
 * Time: 19:02
 */

namespace ProduitBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ProduitType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('prix')
            ->add('description',TextareaType::class)
            ->add('categorie',TextareaType::class)
            ->add('quantite')
            ->add('image',FileType::class)
            ->add('Ajouter',SubmitType::class);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Produit'
        ));
    }



    public function getBlockPrefix()
    {
        return 'Produitbundle_produit';
    }

}
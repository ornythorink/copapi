<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedCSVType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idStoreApi')
            ->add('source')
            ->add('locale')
            ->add('feed')
            ->add('flagbatched')
            ->add('active')
            ->add('broken')
            ->add('sitename')
            ->add('siteslug')
            ->add('siteurl')
            ->add('logostore')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FeedCSV',
             'csrf_protection'   => false,
        ));
    }
}

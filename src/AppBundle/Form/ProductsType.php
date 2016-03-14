<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_api')
            ->add('name')
            ->add('price')
            ->add('currency')
            ->add('siteId')
            ->add('logostore')
            ->add('promo')
            ->add('status')
            ->add('brand')
            ->add('image')
            ->add('sourceId')
            ->add('sourceType')
            ->add('program')
            ->add('actif')
            ->add('locale')
            ->add('categoryMerchant')
            ->add('softdeleted')
            ->add('createdAt', 'datetime')
            ->add('updateAt', 'datetime')
            ->add('description')
            ->add('url')
            ->add('short_url')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Products',
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'products';
    }
}

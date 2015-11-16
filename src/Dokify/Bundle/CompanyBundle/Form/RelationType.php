<?php

namespace Dokify\Bundle\CompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('relationGroup')
            ->add('company')
            ->add('role')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dokify\Bundle\CompanyBundle\Entity\Relation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dokify_bundle_companybundle_relation';
    }
}

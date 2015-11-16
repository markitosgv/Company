<?php

/*
 * This file is part of the Patrimonio Intranet package.
 *
 * (c) Gesdinet. Marcos Gómez Vilches <marcos@gesdinet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dokify\Bundle\AdminCompanyBundle\Form\Company;

use Doctrine\ORM\EntityRepository;
use Dokify\Bundle\CompanyBundle\Model\RoleTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', 'text')
            ->add('save', 'submit', array(
                'label' => 'Add new Company'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dokify\Bundle\CompanyBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dokify_bundle_companybundle_company';
    }
}

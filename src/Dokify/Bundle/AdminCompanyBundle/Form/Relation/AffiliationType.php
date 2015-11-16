<?php

/*
 * This file is part of the Patrimonio Intranet package.
 *
 * (c) Gesdinet. Marcos Gómez Vilches <marcos@gesdinet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dokify\Bundle\AdminCompanyBundle\Form\Relation;

use Doctrine\ORM\EntityRepository;
use Dokify\Bundle\CompanyBundle\Model\RoleTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AffiliationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('save', 'submit', array(
                'label' => 'Create Affiliation'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dokify_bundle_companybundle_affiliation';
    }
}

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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AffiliationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('role', 'entity', array(
                'class' => 'DokifyCompanyBundle:Role',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.key = :role')
                        ->setParameter(':role', RoleTypes::ROLE_AFFILIATED);
                },
            ))
            ->add('save', 'submit', array(
                'label' => 'Add Client'
            ));

        $builder->add('tags', 'collection', array('type' => new AffiliationType()));
    }

    public function getName()
    {
        return 'task2';
    }
}
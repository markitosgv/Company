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

class RelationType extends AbstractType
{
    private $company;
    private $role;

    function __construct($company, $role)
    {
        $this->company = $company;
        $this->role = $role;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $this->company;
        $role = $this->role;
        $inverseRole = ($role === RoleTypes::ROLE_CLIENT) ? RoleTypes::ROLE_SUPPLIER : RoleTypes::ROLE_CLIENT;

        $builder
            ->add('company', 'entity', array(
                'class' => 'DokifyCompanyBundle:Company',
                'query_builder' => function (EntityRepository $er) use ($company, $inverseRole) {

                    $sq = $er->createQueryBuilder('r');

                    $sq->select("rg.id")->from('DokifyCompanyBundle:Relation', 're');
                    $sq->innerJoin('re.relationGroup', 'rg');
                    $sq->innerJoin('re.role', 'ro');

                    $sq->where('re.company = :company');
                    $sq->setParameter(':company', $company);

                    $sq->andWhere('ro.key = :role');
                    $sq->setParameter(':role', $inverseRole);

                    $qb = $er->createQueryBuilder('r');

                    $qb->select("c.id")->from('DokifyCompanyBundle:Relation', 're');
                    $qb->innerJoin('re.company', 'c');
                    $qb->innerJoin('re.role', 'ro');

                    $qb->where('re.company != :company');
                    $qb->andWhere('re.relationGroup IN (:relations)');
                    $qb->setParameter(':company', $company);
                    $qb->setParameter(':relations', $sq->getQuery()->getScalarResult());

                    $b = $er->createQueryBuilder('c');
                    $b->where('c.id NOT IN (:companies)');
                    $b->andWhere('c.id != (:company)');
                    $b->setParameter(':companies', $qb->getQuery()->getScalarResult() ? $qb->getQuery()->getScalarResult() : '');
                    $b->setParameter(':company', $company);

                    return $b;
                },
            ))
            ->add('role', 'entity', array(
                'class' => 'DokifyCompanyBundle:Role',
                'query_builder' => function (EntityRepository $er) use ($role) {
                    return $er->createQueryBuilder('r')
                        ->where('r.key = :role')
                        ->setParameter(':role', $role);
                },
            ))
            ->add('save', 'submit', array(
                'label' => 'Add Client'
            ));
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

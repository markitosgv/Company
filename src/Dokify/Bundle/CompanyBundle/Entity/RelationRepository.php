<?php

namespace Dokify\Bundle\CompanyBundle\Entity;
use Dokify\Bundle\CompanyBundle\Model\RoleTypes;

/**
 * Class RelationRepository
 *
 * @package Dokify\Bundle\CompanyBundle\Entity
 */
class RelationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCompanyRelations($company, $role = null, $orderBy = null, $sortBy = null)
    {
        $sq = $this->getEntityManager()->createQueryBuilder();

        $sq->select("rg.id")->from('DokifyCompanyBundle:Relation', 're');
        $sq->innerJoin('re.relationGroup', 'rg');
        $sq->innerJoin('re.role', 'ro');

        $sq->where('re.company = :company');
        $sq->setParameter(':company', $company);

        if (null !== $role) {
            $sq->andWhere('ro.key = :role');
            $sq->setParameter(':role', $role->getKey());
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select("c, re, ro")->from('DokifyCompanyBundle:Relation', 're');
        $qb->innerJoin('re.company', 'c');
        $qb->innerJoin('re.role', 'ro');

        $qb->where('re.company != :company');
        $qb->andWhere('re.relationGroup IN (:relations)');
        $qb->setParameter(':company', $company);
        $qb->setParameter(':relations', $sq->getQuery()->getScalarResult() ? $sq->getQuery()->getScalarResult() : '');

        if (null !== $orderBy && null !== $sortBy) {
            $qb->orderBy('re.' . $orderBy, $sortBy);
        }

        return $qb->getQuery()->getResult();
    }

    public function getCompanyClientsSuppliers($company, $companies)
    {
        $sq = $this->getEntityManager()->createQueryBuilder();

        $sq->select("rg.id")->from('DokifyCompanyBundle:Relation', 're');
        $sq->innerJoin('re.relationGroup', 'rg');
        $sq->innerJoin('re.role', 'ro');

        $sq->where('re.company = :company');
        $sq->setParameter(':company', $company);

        $sq->andWhere('ro.key = :role OR ro.key = :role2');
        $sq->setParameter(':role', RoleTypes::ROLE_CLIENT);
        $sq->setParameter(':role2', RoleTypes::ROLE_SUPPLIER);

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select("c, re, ro")->from('DokifyCompanyBundle:Relation', 're');
        $qb->innerJoin('re.company', 'c');
        $qb->innerJoin('re.role', 'ro');

        $qb->where('re.company != :company');
        $qb->andWhere('re.relationGroup IN (:relations)');
        $qb->andWhere('re.company NOT IN (:companies)');
        $qb->setParameter(':company', $company);
        $qb->setParameter(':relations', $sq->getQuery()->getScalarResult() ? $sq->getQuery()->getScalarResult() : '');
        $qb->setParameter(':companies', $companies);
        $qb->groupBy("c.id");

        return $qb->getQuery()->getResult();
    }
}

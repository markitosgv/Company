<?php

namespace Dokify\Bundle\CompanyBundle\Entity;

/**
 * Class RelationRepository
 *
 * @package Dokify\Bundle\CompanyBundle\Entity
 */
class RelationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCompanyRelations($company, $role = null)
    {
        $sq = $this->getEntityManager()->createQueryBuilder();

        $sq->select("re.relation")->from('DokifyCompanyBundle:Relation', 're');

        $sq->where('re.company = :company');
        $sq->setParameter(':company', $company);

        if (null !== $role) {
            $sq->andWhere('re.role = :role');
            $sq->setParameter(':role', $role);
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select("c, re, ro")->from('DokifyCompanyBundle:Relation', 're');
        $qb->innerJoin('re.company', 'c');
        $qb->innerJoin('re.role', 'ro');

        $qb->where('re.company != :company');
        $qb->andWhere('re.relation IN (:relations)');
        $qb->setParameter(':company', $company);
        $qb->setParameter(':relations', $sq->getQuery()->getScalarResult());

        return $qb->getQuery()->getResult();
    }
}

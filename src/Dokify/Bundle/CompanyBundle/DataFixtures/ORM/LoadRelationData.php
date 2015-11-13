<?php

namespace Dokify\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Relation;

class LoadRelationData extends AbstractFixture implements OrderedFixtureInterface
{
    private $companyRelations = array(
        1 => array(
            1 => "role-supplier",
            2 => "role-supplier",
            3 => "role-client",
            4 => "role-affiliated",
            6 => "role-affiliated",
            7 => "role-supplier",
        ),
        2 => array(
            1 => "role-client",
            3 => "role-supplier",
            4 => "role-affiliated",
            5 => "role-supplier",
            6 => "role-affiliated",
        ),
        3 => array(
            2 => "role-client",
            4 => "role-affiliated",
        ),
        4 => array(
            5 => "role-client",
            4 => "role-affiliated",
            6 => "role-affiliated",
        ),
        5 => array(
            7 => "role-client",
        ),
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->companyRelations as $companyId => $relations) {
            foreach ($relations as $relation => $role) {
                $company = $this->getReference('company-'.$companyId);
                $role = $this->getReference($role);

                $relation = new Relation($relation, $company, $role);
                $manager->persist($relation);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
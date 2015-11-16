<?php

namespace Dokify\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\RelationGroup;

class LoadRelationGroupData extends AbstractFixture implements OrderedFixtureInterface
{

    private $groups = array(
        1 => "Company 1 -> Company 2",
        2 => "Company 1 -> Company 3",
        3 => "Company 2 -> Company 1",
        4 => "Company 3 -> Company 1 -> Company 2 -> Company 4",
        5 => "Company 2 -> Company 4",
        6 => "Company 4 -> Company 2 -> Company 1",
        7 => "Company 1 -> Company 5",
    );

    public function load(ObjectManager $om)
    {
        foreach ($this->groups as $key => $name) {;

            $relationGroup = new RelationGroup();
            $relationGroup->setName($name);
            $om->persist($relationGroup);

            $this->addReference('relationgroup-'.$key, $relationGroup);
        }

        $om->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
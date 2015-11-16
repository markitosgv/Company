<?php

namespace Dokify\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{

    private $roles = array(
        "SUP" => "Supplier",
        "CLI" => "Client",
        "AFF" => "Affiliated",
    );

    public function load(ObjectManager $om)
    {
        foreach ($this->roles as $key => $name) {
            $role = new Role();
            $role->setKey($key);
            $role->setName($name);
            $om->persist($role);

            $this->addReference('role-'.strtolower($name), $role);
        }

        $om->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
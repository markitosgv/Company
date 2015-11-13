<?php

namespace Dokify\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    private $roles = array(
        "Supplier",
        "Client",
        "Affiliated",
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->roles as $name) {
            $role = new Role($name);
            $manager->persist($role);

            $this->addReference('role-'.strtolower($name), $role);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
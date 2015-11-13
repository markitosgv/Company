<?php

namespace Dokify\Bundle\CompanyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Company;

class LoadCompanyData extends AbstractFixture implements OrderedFixtureInterface
{
    private $companies = array(
        1 => "Company 1",
        2 => "Company 2",
        3 => "Company 3",
        4 => "Company 4",
        5 => "Company 5",
    );

    public function load(ObjectManager $manager)
    {
        foreach ($this->companies as $key => $name) {
            $company = new Company($name);
            $manager->persist($company);

            $this->addReference('company-'.$key, $company);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
<?php

namespace Dokify\Bundle\CompanyBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Role;

class CompanyManager
{
    protected $objectManager;
    protected $class;
    protected $repository;

    /**
     * Constructor.
     *
     * @param ObjectManager $om
     * @param string $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * Creates a company instance
     *
     * @return Company
     */
    public function create()
    {
        $class = $this->getClass();
        $company = new $class();

        return $company;
    }

    /**
     * Get all companies
     *
     * @param $id
     *
     * @return Company
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all companies
     *
     * @return Company[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Persist company
     *
     * @param Company   $company
     * @param bool|true $andFlush
     */
    public function save(Company $company, $andFlush = true)
    {
        $this->objectManager->persist($company);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * Remove company
     *
     * @param Company   $company
     * @param bool|true $andFlush
     */
    public function remove(Company $company, $andFlush = true)
    {
        $this->objectManager->remove($company);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * Returns the Company fully qualified class name.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
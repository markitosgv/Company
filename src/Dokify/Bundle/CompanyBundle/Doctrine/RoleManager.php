<?php

namespace Dokify\Bundle\CompanyBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Role;

class RoleManager
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
     * @param $relation
     * @param Company $company
     * @param Role $role
     *
     * @return Company
     */
    public function create($relation, Company $company, Role $role)
    {
        $class = $this->getClass();
        $company = new $class($relation, $company, $role);

        return $company;
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
     * Get company relations
     *
     * @param Company  $company
     * @param int|null $role
     *
     * @return mixed
     */
    public function getRelations($company, $role = null)
    {
        return $this->repository->getRelations($company, $role);
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
<?php

namespace Dokify\Bundle\CompanyBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
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
     * Creates a role instance
     *
     * @return Role
     */
    public function create()
    {
        $class = $this->getClass();
        $role = new $class();

        return $role;
    }

    /**
     * Get all companies
     *
     * @return Role[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Persist role
     *
     * @param Role      $role
     * @param bool|true $andFlush
     */
    public function save(Role $role, $andFlush = true)
    {
        $this->objectManager->persist($role);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * Get a Role
     *
     * @param $role
     *
     * @return Role
     */
    public function get($role)
    {
        return $this->repository->findOneBy(array('key' => $role));
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
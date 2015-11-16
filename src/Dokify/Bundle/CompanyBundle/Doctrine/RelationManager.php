<?php

namespace Dokify\Bundle\CompanyBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\AdminCompanyBundle\Form\Relation\RelationType;
use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Relation;
use Dokify\Bundle\CompanyBundle\Entity\Role;
use Dokify\Bundle\CompanyBundle\Model\RoleTypes;

class RelationManager
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
     * Creates a relation instance
     *
     * @return Relation
     */
    public function create($relationGroup)
    {
        $class = $this->getClass();
        $relation = new $class($relationGroup);

        return $relation;
    }

    /**
     * Get company relations by company
     *
     * @param Company     $company
     * @param Role|null   $role
     * @param string|null $orderBy
     * @param string|null $sortBy
     *
     * @return mixed
     */
    public function getCompanyRelations($company, $role = null, $orderBy = null, $sortBy = null)
    {
        return $this->repository->getCompanyRelations($company, $role, $orderBy, $sortBy);
    }

    /**
     * Get company relations by company
     *
     * @param Company     $company
     *
     * @return mixed
     */
    public function getCompanyClientsSuppliers($company, $companies)
    {
        return $this->repository->getCompanyClientsSuppliers($company, $companies);
    }

    /**
     * Persist relation
     *
     * @param Company  $company
     * @param Relation $relation
     * @param Role     $role
     * @param bool|true $andFlush
     */
    public function save(Company $company, Relation $relation, Role $role, $andFlush = true)
    {
        $sideRelation = $this->create($relation->getRelationGroup());
        $sideRelation->setCompany($company);
        $sideRelation->setRole($role);

        $this->objectManager->persist($sideRelation);
        $this->objectManager->persist($relation);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * Persist affiliation relation
     *
     * @param Relation $relation
     * @param bool|true $andFlush
     */
    public function saveAffiliation(Relation $relation, $andFlush = true)
    {
        $this->objectManager->persist($relation);

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
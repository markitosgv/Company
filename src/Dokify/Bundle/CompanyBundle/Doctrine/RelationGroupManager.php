<?php

namespace Dokify\Bundle\CompanyBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Dokify\Bundle\CompanyBundle\Entity\Relation;
use Dokify\Bundle\CompanyBundle\Entity\RelationGroup;
use Dokify\Bundle\CompanyBundle\Entity\Role;

class RelationGroupManager
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
     * Creates a relation group instance
     *
     * @return RelationGroup
     */
    public function create()
    {
        $class = $this->getClass();
        $relationGroup = new $class();

        return $relationGroup;
    }

    /**
     * Remove company
     *
     * @param RelationGroup $relationGroup
     * @param bool|true     $andFlush
     */
    public function remove(RelationGroup $relationGroup, $andFlush = true)
    {
        $this->objectManager->remove($relationGroup);

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
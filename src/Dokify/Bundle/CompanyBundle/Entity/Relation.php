<?php

namespace Dokify\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relations", uniqueConstraints={@ORM\UniqueConstraint(name="relation_company", columns={"relation_group_id", "company_id"})})
 * @ORM\Entity(repositoryClass="RelationRepository")
 */
class Relation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="RelationGroup", cascade={"persist"})
     * @ORM\JoinColumn(name="relation_group_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $relationGroup;

    /**
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    private $role;

    public function __construct($relationGroup)
    {
        $this->relationGroup = $relationGroup;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set relationGroup
     *
     * @param \Dokify\Bundle\CompanyBundle\Entity\RelationGroup $relationGroup
     *
     * @return Relation
     */
    public function setRelationGroup(\Dokify\Bundle\CompanyBundle\Entity\RelationGroup $relationGroup)
    {
        $this->relationGroup = $relationGroup;

        return $this;
    }

    /**
     * Get relationGroup
     *
     * @return \Dokify\Bundle\CompanyBundle\Entity\RelationGroup
     */
    public function getRelationGroup()
    {
        return $this->relationGroup;
    }

    /**
     * Set company
     *
     * @param \Dokify\Bundle\CompanyBundle\Entity\Company $company
     *
     * @return Relation
     */
    public function setCompany(\Dokify\Bundle\CompanyBundle\Entity\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Dokify\Bundle\CompanyBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set role
     *
     * @param \Dokify\Bundle\CompanyBundle\Entity\Role $role
     *
     * @return Relation
     */
    public function setRole(\Dokify\Bundle\CompanyBundle\Entity\Role $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Dokify\Bundle\CompanyBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }
}

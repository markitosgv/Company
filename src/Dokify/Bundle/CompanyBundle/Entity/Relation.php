<?php

namespace Dokify\Bundle\CompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relations", uniqueConstraints={@ORM\UniqueConstraint(name="relation_company", columns={"relation", "company_id"})})
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
     * @var integer
     *
     * @ORM\Column(name="relation", type="integer", nullable=false)
     */
    private $relation;

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

    public function __construct($relation, Company $company, Role $role)
    {
        $this->relation = $relation;
        $this->company = $company;
        $this->role = $role;
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
     * Set relation
     *
     * @param integer $relation
     *
     * @return Relation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * Get relation
     *
     * @return integer
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set company
     *
     * @param Company $company
     *
     * @return Relation
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set role
     *
     * @param Role $role
     *
     * @return Relation
     */
    public function setRole(Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}

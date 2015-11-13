<?php

namespace Dokify\Bundle\CompanyBundle\Controller;

use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Role;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CompanyController extends Controller
{
    /**
     * @Route("/companies/{company}/{role}", name="companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Company $company = null, Role $role = null)
    {
        $companyManager = $this->get('dokify.companybundle.company_manager');
        $companies = $companyManager->findAll();

        $relations = null;
        $roles = null;
        if (null !== $company) {
            $relationManager = $this->get('dokify.companybundle.relation_manager');
            $roleManager = $this->get('dokify.companybundle.role_manager');

            $relations = $relationManager->getCompanyRelations($company, $role);
            $roles = $roleManager->findAll();
        }

        return $this->render('DokifyCompanyBundle:Company:index.html.twig', array(
            'companies' => $companies,
            'relations' => $relations,
            'roles' => $roles,
        ));
    }
}
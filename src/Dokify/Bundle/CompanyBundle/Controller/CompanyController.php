<?php

namespace Dokify\Bundle\CompanyBundle\Controller;

use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Role;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{

    /**
     * @Route("/", name="companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $companyManager = $this->get('dokify.companybundle.company_manager');
        $companies = $companyManager->findAll();

        return $this->render('DokifyCompanyBundle:Company:index.html.twig', array(
            'companies' => $companies,
        ));
    }

    /**
     * @param Company $company
     * @param Role    $role
     * @param Request $request
     *
     * @Route("/companies/relations/{company}/{role}", name="companies_related", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function relationsAction(Company $company, Role $role = null, Request $request)
    {
        $orderBy = ($request->get('orderBy')) ? $request->get('orderBy') : 'company';
        $sortBy = ($request->get('sortBy')) ? $request->get('sortBy') : 'ASC';

        $relationManager = $this->get('dokify.companybundle.relation_manager');
        $roleManager = $this->get('dokify.companybundle.role_manager');

        $relations = $relationManager->getCompanyRelations($company, $role, $orderBy, $sortBy);
        $roles = $roleManager->findAll();

        $html = $this->renderView('DokifyCompanyBundle:Relations:relations.html.twig', array(
            'relations' => $relations,
            'roles' => $roles,
            'role' => $role,
            'orderBy' => $orderBy,
            'sortBy' => $sortBy,
            'company' => $company,
        ));

        return new JsonResponse($html);
    }
}
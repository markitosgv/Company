<?php

namespace Dokify\Bundle\AdminCompanyBundle\Controller;

use Dokify\Bundle\AdminCompanyBundle\Form\Relation\AffiliationType;
use Dokify\Bundle\AdminCompanyBundle\Form\Relation\RelationType;
use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Relation;
use Dokify\Bundle\CompanyBundle\Entity\RelationGroup;
use Dokify\Bundle\CompanyBundle\Model\RoleTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AffiliationController extends Controller
{

    /**
     * @Route("/affiliations/new", name="admin_new_affiliations_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAffiliationAction(Request $request)
    {
        $companyManager = $this->get('dokify.companybundle.company_manager');
        $companies = $companyManager->findAll();

        $form = $this->createForm(new AffiliationType());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $companies = $request->request->get("data");
            $name = $request->request->get("name");
            $companies = explode(",", $companies);

            $relationGroupManager = $this->get('dokify.companybundle.relation_group_manager');
            $relationGroup = $relationGroupManager->create();
            $relationGroup->setName($name);

            try {
                foreach ($companies as $company) {
                    $company = $companyManager->get($company);

                    $relationManager = $this->get('dokify.companybundle.relation_manager');
                    $relation = $relationManager->create($relationGroup);

                    $roleManager = $this->get('dokify.companybundle.role_manager');
                    $role = $roleManager->get(RoleTypes::ROLE_AFFILIATED);

                    $relation->setCompany($company);
                    $relation->setRelationGroup($relationGroup);
                    $relation->setRole($role);

                    $relationManager->saveAffiliation($relation);
                }
            } catch (\Exception $e) {
                die("Affiliation exists!");
            }

            return $this->redirectToRoute('admin_companies');
        }

        return $this->render('DokifyAdminCompanyBundle:Relation:newaffiliation.html.twig', array(
            'form' => $form->createView(),
            'companies' => $companies,
        ));
    }

    /**
     * @Route("/affiliations/{company}", name="admin_affiliation_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function affiliationsAction(Company $company)
    {
        $relationManager = $this->get('dokify.companybundle.relation_manager');
        $relations = $relationManager->getCompanyRelations($company, RoleTypes::ROLE_AFFILIATED);

        return $this->render('DokifyAdminCompanyBundle:Company:affiliations.html.twig', array(
            'relations' => $relations,
            'company' => $company,
        ));
    }

    /**
     * @Route("/affiliations/related/{company}", name="admin_related_affiliations_companies", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRelatedAction(Company $company, Request $request)
    {
        $relationManager = $this->get('dokify.companybundle.relation_manager');

        $companies = $request->request->get("data");
        $companies = explode(",", $companies);
        $relations = $relationManager->getCompanyClientsSuppliers($company, $companies);
        $html = $this->renderView('DokifyAdminCompanyBundle:Relation:listbox.html.twig', array(
            'relations' => $relations,
        ));

        return new JsonResponse($html);
    }

    /**
     * @Route("/affiliations/delete/{company}/{relationGroup}", name="admin_delete_affiliation_companies")
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAffiliationAction(Company $company, RelationGroup $relationGroup)
    {
        $relationGroupManager = $this->get('dokify.companybundle.relation_group_manager');
        $relationGroupManager->remove($relationGroup);

        return $this->redirectToRoute('admin_affiliation_companies', array(
            'company' => $company->getId(),
        ));
    }

}
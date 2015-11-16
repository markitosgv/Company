<?php

namespace Dokify\Bundle\AdminCompanyBundle\Controller;

use Dokify\Bundle\AdminCompanyBundle\Form\Relation\RelationType;
use Dokify\Bundle\CompanyBundle\Entity\Company;
use Dokify\Bundle\CompanyBundle\Entity\Relation;
use Dokify\Bundle\CompanyBundle\Entity\RelationGroup;
use Dokify\Bundle\CompanyBundle\Model\RoleTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{

    /**
     * @Route("/clients/{company}", name="admin_client_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function clientsAction(Company $company)
    {
        $relationManager = $this->get('dokify.companybundle.relation_manager');
        $relations = $relationManager->getCompanyRelations($company, RoleTypes::ROLE_SUPPLIER);

        return $this->render('DokifyAdminCompanyBundle:Company:clients.html.twig', array(
            'relations' => $relations,
            'company' => $company,
        ));
    }

    /**
     * @Route("/clients/new/{company}", name="admin_new_client_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newClientAction(Company $company, Request $request)
    {
        $relationGroup = new RelationGroup();
        $relation = new Relation($relationGroup);
        $form = $this->createForm(new RelationType($company, RoleTypes::ROLE_CLIENT), $relation);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $relationManager = $this->get('dokify.companybundle.relation_manager');
            $roleManager = $this->get('dokify.companybundle.role_manager');
            $role = $roleManager->get(RoleTypes::ROLE_SUPPLIER);
            $relationGroup->setName($company->getName()." -> ".$relation->getCompany()->getName());
            $relationManager->save($company, $relation, $role);

            return $this->redirectToRoute('admin_client_companies', array(
                'company' => $company->getId(),
            ));
        }

        return $this->render('DokifyAdminCompanyBundle:Relation:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/clients/delete/{company}/{relationGroup}", name="admin_delete_client_companies")
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteClientAction(Company $company, RelationGroup $relationGroup)
    {
        $relationGroupManager = $this->get('dokify.companybundle.relation_group_manager');
        $relationGroupManager->remove($relationGroup);

        return $this->redirectToRoute('admin_client_companies', array(
            'company' => $company->getId(),
        ));
    }

}
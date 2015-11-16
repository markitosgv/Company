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

class SupplierController extends Controller
{

    /**
     * @Route("/suppliers/{company}", name="admin_supplier_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function suppliersAction(Company $company)
    {
        $relationManager = $this->get('dokify.companybundle.relation_manager');
        $roleManager = $this->get('dokify.companybundle.role_manager');
        $role = $roleManager->get(RoleTypes::ROLE_CLIENT);
        $relations = $relationManager->getCompanyRelations($company, $role);

        return $this->render('DokifyAdminCompanyBundle:Company:suppliers.html.twig', array(
            'relations' => $relations,
            'company' => $company,
        ));
    }

    /**
     * @Route("/suppliers/new/{company}", name="admin_new_supplier_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newSupplierAction(Company $company, Request $request)
    {
        $relationGroup = new RelationGroup();
        $relation = new Relation($relationGroup);
        $form = $this->createForm(new RelationType($company, RoleTypes::ROLE_SUPPLIER), $relation);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $relationManager = $this->get('dokify.companybundle.relation_manager');
            $roleManager = $this->get('dokify.companybundle.role_manager');
            $role = $roleManager->get(RoleTypes::ROLE_CLIENT);
            $relationGroup->setName($company->getName()." -> ".$relation->getCompany()->getName());
            $relationManager->save($company, $relation, $role);

            return $this->redirectToRoute('admin_supplier_companies', array(
                'company' => $company->getId(),
            ));
        }

        return $this->render('DokifyAdminCompanyBundle:Relation:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/suppliers/delete/{company}/{relationGroup}", name="admin_delete_supplier_companies")
     * @Method("DELETE")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteSupplierAction(Company $company, RelationGroup $relationGroup)
    {
        $relationGroupManager = $this->get('dokify.companybundle.relation_group_manager');
        $relationGroupManager->remove($relationGroup);

        return $this->redirectToRoute('admin_supplier_companies', array(
            'company' => $company->getId(),
        ));
    }
}
<?php

namespace Dokify\Bundle\AdminCompanyBundle\Controller;

use Dokify\Bundle\AdminCompanyBundle\Form\Company\CompanyType;
use Dokify\Bundle\AdminCompanyBundle\Form\Generic\DeleteType;
use Dokify\Bundle\CompanyBundle\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{

    /**
     * @Route("/", name="admin_companies")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $companyManager = $this->get('dokify.companybundle.company_manager');
        $companies = $companyManager->findAll();

        return $this->render('DokifyAdminCompanyBundle:Company:index.html.twig', array(
            'companies' => $companies,
        ));
    }

    /**
     * @Route("/company/new", name="admin_new_company")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newCompanyAction(Request $request)
    {
        $companyManager = $this->get('dokify.companybundle.company_manager');
        $company = $companyManager->create();
        $form = $this->createForm(new CompanyType(), $company);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $companyManager->save($company);

            return $this->redirectToRoute('admin_companies');
        }

        return $this->render('DokifyAdminCompanyBundle:Company:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
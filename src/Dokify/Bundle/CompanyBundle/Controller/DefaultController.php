<?php

namespace Dokify\Bundle\CompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DokifyCompanyBundle:Default:index.html.twig', array('name' => $name));
    }
}

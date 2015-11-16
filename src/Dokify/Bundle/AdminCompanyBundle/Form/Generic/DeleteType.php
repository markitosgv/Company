<?php

namespace Dokify\Bundle\AdminCompanyBundle\Form\Generic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteType extends AbstractType
{

    protected $route;

    public function __construct($route = null)
    {
        $this->route = $route;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delete', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'btn btn-danger btn-xs',
                )
            ))
            ->setMethod('DELETE')
            ->setAction($this->route);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'delete';
    }
}
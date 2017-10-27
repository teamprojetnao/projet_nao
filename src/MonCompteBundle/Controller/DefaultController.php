<?php

namespace MonCompteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/mon-compte", name="mon-compte")
     */
    public function indexAction()
    {
        return $this->render('MonCompteBundle:Default:index.html.twig');
    }
}

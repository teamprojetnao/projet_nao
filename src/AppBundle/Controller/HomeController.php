<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/",name="homepage")
     */
    public function indexAction()
    {
        return $this->render(':Home:index.html.twig');

    }

    /**
     * @Route("/card",name="searchpage")
     */
    public function cardAction()
    {
        return $this->render(':Home:card.html.twig');
    }

}

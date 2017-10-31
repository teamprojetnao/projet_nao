<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonCompteController extends Controller
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function adminAction()
    {
        return $this->render(':Admin:index.html.twig');
    }

    /**
     * @Route("/observation", name="observationpage")
     * @Security("has_role('ROLE_USER')")
     */
    public function  observationAction(){

        return $this->render(':MonCompte:observation.html.twig');
    }
}
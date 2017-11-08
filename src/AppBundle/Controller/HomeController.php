<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/completion", name="ajax_search")
     */

    public function completionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('term');
        $aves =  $em->getRepository('AppBundle:Aves')->findAvesByString($requestString);

        return new Response(json_encode($aves));
    }

    /**
     * @Route("/card",name="searchpage")
     */
    public function cardAction()
    {
        return $this->render(':Home:card.html.twig');
    }

}

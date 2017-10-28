<?php

namespace AppBundle\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LoginController extends Controller
{
    /**
     * @Route("/login",name="login")
     */
    public function indexAction()
    {
        return $this->render(':Auth:login.html.twig');

    }


}

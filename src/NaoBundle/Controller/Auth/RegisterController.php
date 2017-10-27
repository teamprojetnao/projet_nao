<?php

namespace NaoBundle\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegisterController extends Controller
{
    /**
     * @Route("/register",name="register")
     */
    public function indexAction()
    {
        return $this->render('NaoBundle:Auth:register.html.twig');

    }
    // replace this example code with whatever you need

}

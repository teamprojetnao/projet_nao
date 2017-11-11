<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse($aves);
    }

    /**
     * @Route("/card",name="searchpage")
     */
    public function cardAction()
    {
        return $this->render(':Home:card.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contact", name="contact_page")
     */
    public function contactAction(Request $request)
    {
        $contact=new Contact;
        $form =$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $message = (new Swift_Message('Contact from NAO'))
                ->setFrom($contact->getEmail())
                ->setTo($this->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/contact.html.twig',
                        array('contact' => $contact)
                    ),
                    'text/html'
                )

            ;

            $this->get('mailer')->send($message);


            return $this->render(':Home:confirmation.html.twig');
        }
        return $this-> render(':Home:contact.html.twig', array(
            'form' => $form->createView()));
    }

}

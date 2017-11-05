<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 29/10/2017
 * Time: 12:10
 */

namespace AppBundle\Controller;


use AppBundle\Entity\New_password;
use AppBundle\Entity\Password_registration;
use AppBundle\Entity\User;
use AppBundle\Form\New_passwordType;
use AppBundle\Form\Password_registrationType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Swift_Message;

class SecurityController extends Controller
{
    /**
     * @Route("/login",name="login")
     */
    public function loginAction(Request $request)
    {

        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        /*   if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
               return $this->redirectToRoute('homepage');
           }*/

        if ($this->get('security.authorization_checker')
                ->isGranted('ROLE_ADMIN') === true
        ) {
            return $this->redirectToRoute('admin_home');
        }

        $user = new User;
        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $plainPassword = $user->getPassword();
            $encoded = $this->get('security.password_encoder')->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }


        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render(':Security:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(), 'form' => $form->createView(),
        ));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/password",name="password_page")
     */
    public function passwordAction(Request $request)
    {
        $new_password = new New_password();
        $form = $this->createForm(New_passwordType::class, $new_password);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:User');
            if ($user = $repository->findOneBy(array('email' => $new_password->getEmail()))) {


                $user->setToken(base64_encode(random_bytes(10)));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $message = (new Swift_Message('Votre demande de nouveau mot de passe'))
                    ->setFrom($this->getParameter('mailer_user'))
                    ->setTo($new_password->getEmail())
                    ->setBody(
                        $this->renderView(

                            'Emails/new_password.html.twig',
                            array('user' => $user)

                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);


                return $this->redirectToRoute('new_password_confirmation_page');
            }
            $this->get('session')->getFlashBag()->add('info', "Email incorrect");
        }
        return $this->render(':Security:new_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new_password_confirmation",name="new_password_confirmation_page")
     */
    public function new_password_confirmationAction()
    {
        return $this->render(':Security:new_password_confirmation.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/register",name="passwordregistration_page")
     *
     */
    public function password_registrationAction(Request $request)
    {
        $key = $request->query->get('key');


        $password_registration = new Password_registration();
        $form = $this->createForm(Password_registrationType::class, $password_registration);
        $form->handleRequest($request);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $user = $repository->findOneBy(array('email' => $password_registration->getEmail()));
        if ($form->isSubmitted() && $form->isValid()) {

            $encoded = $this->get('security.password_encoder')->encodePassword($password_registration, $password_registration->getPassword());
            $user->setPassword($encoded);
            $user->setToken("");
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('passwordchanged_page');
        }


        return $this->render(':Security:password_registration.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/passwordchanged",name="passwordchanged_page")
     */
    public function password_registration_confirmationAction()
    {
        return $this->render(':Security:password_registration_confirmation.html.twig');
    }
}
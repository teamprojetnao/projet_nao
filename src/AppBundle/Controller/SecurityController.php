<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 29/10/2017
 * Time: 12:10
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
                ->isGranted('ROLE_ADMIN') === true) {
            return $this->redirectToRoute('admin_home');
        }

        $user=new User;
        $form   = $this->get('form.factory')->create(UserType::class, $user);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
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
            'error' => $authenticationUtils->getLastAuthenticationError(),'form'=> $form->createView(),
        ));
    }

    /**
     * @Route("/register",name="register")
     */
    public function registerAction()
    {
        return $this->render(':Security:register.html.twig');

    }

    /**
     * @Route("/inscription",name="inscription")
     * @Method("POST")
     */
    public function connexionAction(Request $request)
    {

        $doctrinemanager = $this->getDoctrine()->getManager();
        $data = $request->request->all();

        $user = new User();
        $user->setNom($data['name']);
        $user->setEmail($data['email']);
        $plainPassword = $data['password'];
        $passwordEncoder = $this->get('security.password_encoder');

        $encoded = $passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $doctrinemanager->persist($user);
        $doctrinemanager->flush();

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Votre compte a été bien crée');
        return $this->redirectToRoute('homepage');


    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction()
    {
        return $this->redirectToRoute('homepage');
    }
}
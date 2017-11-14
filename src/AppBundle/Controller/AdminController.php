<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 09/11/2017
 * Time: 09:45
 */

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function adminAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $nbNaturalists=$repository->countNaturalists();
        $nbUsers=$repository->countUsers();
        $nbIsNaturalistRequired=$repository->countIsNaturalistRequired();


        $observations=$this->getDoctrine()->getManager()->getRepository('AppBundle:Observation')->findBy(
            array('isValidate'=>'1')
        );
        $nbObservations =count($observations);

        $requiredObservations=$this->getDoctrine()->getManager()->getRepository('AppBundle:Observation')->findBy(
        array('isValidate'=>'0')
    );
        $nbRequiredObservations =count($requiredObservations);

        return $this->render(':Admin:index.html.twig', array(
            'nbNaturalists' => $nbNaturalists,
            'nbUsers' => $nbUsers,
            'nbIsNaturalistRequired' => $nbIsNaturalistRequired,
            'nbObservations' => $nbObservations,
            'nbRequiredObservations' => $nbRequiredObservations
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user", name="admin_user")
     */
    public function userAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $listUsers = $repository->findUsers();



        return $this->render(':Admin:user.html.twig', array('listUsers' => $listUsers));
    }

    /**
     * @Route("/naturalist", name="admin_naturalist")
     */
    public function naturalistAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $listUsers = $repository->findNaturalists();

        return $this->render(':Admin:naturalist.html.twig', array('listUsers' => $listUsers));
    }

    /**
     * @param Request $request
     * @param User $user
     * @Route("/refuse-user/{id}", name="admin_refuse_user")
     */
    public function refuseUserAction(Request $request, User $user)
    {
        $em = $this->get('doctrine')->getManager();
        $csrfToken = $request->request->get('_csrf_token');


        $user->setIsNaturalistRequired('0');


        $em->persist($user);
        $em->flush();
        $request->getSession()->getFlashbag()->add('info, la demande de compte naturaliste a bien été refusée');
        return $this->redirectToRoute('admin_validate_list');
    }

    /**
     * @param Request $request
     * @param User $user
     * @Route("/validate-user/{id}", name="admin_validate_user")
     */
    public function validateUserAction(Request $request, User $user)
    {
        $em = $this->get('doctrine')->getManager();
        $csrfToken = $request->request->get('_csrf_token');


        $user->setIsNaturalistRequired('0');
        $user->setRoles(array('ROLE_NATURALIST'));

        $em->persist($user);
        $em->flush();
        $request->getSession()->getFlashbag()->add('info', 'la demande de compte naturaliste a bien été refusée');
        return $this->redirectToRoute('admin_validate_list');
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/validate-list", name="admin_validate_list")
     */
    public  function validateListAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $listUsers = $repository->FindBy(
            array('isNaturalistRequired' => '1')
        );




        return $this->render(':Admin:validate.html.twig', array('listUsers' => $listUsers

        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/observation-list", name="observation_list")
     */
    public function observationListAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation');

        $listObservations = $repository->FindBy(
            array('isValidate' => '1')
        );


        return $this->render(':Admin:observations.html.twig', array('listObservations' => $listObservations,


        ));
    }

        /**
         * @return \Symfony\Component\HttpFoundation\Response
         * @Route("/observation-required-list", name="observation_required_list")
         */
        public function observationRequiredListAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Observation');

        $listObservations = $repository->FindBy(
            array('isValidate' => '0')
        );




        return $this->render(':Admin:observations.html.twig', array('listObservations' => $listObservations,


        ));

    }


}
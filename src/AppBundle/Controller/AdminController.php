<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 09/11/2017
 * Time: 09:45
 */

namespace AppBundle\Controller;


use AppBundle\AppBundle;
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
    public function adminAction()
    {
        return $this->render(':Admin:index.html.twig');
    }

    /**
     * @Route("/user", name="admin_user")

     */
    public function userAction()
    {
        $repository=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $listUsers=$repository->FindBy(
            array('roles'=>'ROLE_USER')
        );
        return $this->render(':Admin:user.html.twig', array('listUsers'=>$listUsers));
    }

    /**
     * @Route("/naturalist", name="admin_naturalist")

     */
    public function naturalistAction()
    {
        $repository=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $listUsers=$repository->FindBy(
            array('roles'=>'ROLE_NATURALIST')
        );
        return $this->render(':Admin:naturalist.html.twig', array('listUsers'=>$listUsers));
    }

    /**
     * @Route("/validate", name="admin_validate")

     */
    public function validateAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');
        $listUsers = $repository->FindBy(
            array('isNaturalistRequired' => '1')
        );
        return $this->render(':Admin:validate.html.twig', array('listUsers' => $listUsers));
    }


        public function isNaturalistAction(Request $request, $id)
        {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:Advert')->find($id);

            if (null === $user) {
                throw new NotFoundHttpException("l'user" . $id . "n'existe pas");
            }

            $form = $this->createForm('form.factory');
            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid())
            {$user->setIsNaturalistRequired='0';
            $user->setRoles="ROLE_NATURALIST";
                $em->persist($user);
                $em->flush();
                $request->getSession()->getFlashbag()->add('info, le compte naturaliste a bien été validé');
                return $this->redirectToRoute('admin_home');
            }
            return $this->render('AppBundle:validate.html.twig', array(
                'user' => $user,
                'form'   => $form->createView(),
            ));

        }
}
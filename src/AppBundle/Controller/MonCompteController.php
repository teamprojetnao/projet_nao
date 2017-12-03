<?php


namespace AppBundle\Controller;


use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Observation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MonCompteController extends Controller
{


    /**
     * @Route("/observation", name="observationpage")
     * @Security("has_role('ROLE_USER')")
     */

    public function  observationAction(){
        $espece_not_exist = false;
        return $this->render(':MonCompte:observation.html.twig',[
            'espece_not_exist' => $espece_not_exist,
            'old_value' => []
        ]);

    }

    /**
     * @Route("/mon-compte", name="mon-compte")
     * @Security("has_role('ROLE_USER')")
     */
    public function monCompteAction()
    {

        $em = $this->getDoctrine()->getManager();

        /**
         * Les Requêtes pour les particuliers
         */

        //On recupere les observations de l'user à partir de son id
        $observations = $em->getRepository('AppBundle:Observation')
            ->getObervationByUserId($this->getUser()->getId());

        //Les reservations en attentes
        $observationsEnAttentes = $em->getRepository('AppBundle:Observation')
            ->getObervationEnAttenteByUserId($this->getUser()->getId());

        //Les reservations refusés
        $mesObervationRefuser = $em->getRepository('AppBundle:Observation')
            ->getObervationRefuserByUserId($this->getUser()->getId());


        //Les dernières observations
        $lastObservations = $em->getRepository('AppBundle:Observation')
            ->getLastObservation();

        /**
         * Les Requêtes pour les fonctionnalités de compte naturaliste
         */

        //Les observation à valider
        $observations_a_valider = $em->getRepository('AppBundle:Observation')
            ->getObservationAvalider();

        //Les observation validé par le naturaliste
        $valideObservations = $em->getRepository('AppBundle:Observation')
            ->getObservationValiderByUserId($this->getUser()->getId());

        //Les observation refusé par le naturaliste
        $refuseObservations = $em->getRepository('AppBundle:Observation')
            ->getObservationRefuserByUserId($this->getUser()->getId());


        return $this->render(':MonCompte:index.html.twig',
            ['observations' => $observations,
                'observationsEnAttentes' => $observationsEnAttentes,
                'mesObervationRefuser' => $mesObervationRefuser,
                'observations_a_valider' => $observations_a_valider,
                'lastObservations' => $lastObservations,
                'valideObservations' => $valideObservations,
                'refuseObservations' => $refuseObservations,
            ]);
    }

    /**
     * @Route("/valider-obs/{observation}", name="valider-observation")
     * @ParamConverter("observation", class="AppBundle:Observation")
     * @Security("has_role('ROLE_USER')")
     */
    public function validerObservationAction(Observation $observation)
    {
        $em = $this->getDoctrine()->getManager();
        $observation->setIsValidate(1);
        $observation->setValiderPar($this->getUser());
        $em->persist($observation);
        $em->flush();
        return $this->redirectToRoute('mon-compte');
    }

    /**
     * @Route("/refuser-obs/{observation}", name="refuser-observation")
     * @ParamConverter("observation", class="AppBundle:Observation")
     * @Security("has_role('ROLE_USER')")
     */
    public function refuserObservationAction(Observation $observation)
    {
        $em = $this->getDoctrine()->getManager();
        $observation->setRefuserPar($this->getUser());
        $observation->setIsValidate(2);
        $em->persist($observation);
        $em->flush();
        return $this->redirectToRoute('mon-compte');
    }

    /**
     * @Route("/modifier-compte/{user}", name="nao.modifier.compte")
     * @ParamConverter("user", class="AppBundle:User")
     * @Method("POST")
     */
    public function modifierCompteAction(User $user, Request $request)
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        //Si l'action de l'utilisateur est modifié
        if (isset($data['modifier'])) {
            $user->setEmail($data['email']);
            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);
            $date_de_naissance = new \DateTime($data["date_de_naissance"]);
            $user->setBirthdate($date_de_naissance);
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()
                ->add('success', 'Votre compte a bien été modifié');
            return $this->redirect($this->generateUrl('mon-compte'));
        }
        //Si non,  l'action de l'utilisateur est supprimer son compte
        else {

            $allObservationUsers = $em->getRepository('AppBundle:Observation')
                ->getAllObervationByUserId($user->getId());

            $user_to_remove = $em->getRepository('AppBundle:User')->find($user->getId());

            if ($allObservationUsers != null) {
                foreach ($allObservationUsers as $allObservationUser) {
                    $em->remove($allObservationUser);
                    $em->flush();
                }
            }

            $user = $this->get('security.token_storage');
            $user->setToken(null);

            $em->remove($user_to_remove);
            $em->flush();

           /* $request->getSession()->getFlashBag()
                ->add('success', 'Votre compte a bien été supprimé');*/
            return $this->redirect($this->generateUrl('homepage'));
        }
    }


}
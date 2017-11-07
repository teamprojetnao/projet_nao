<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Observation;

class MonCompteController extends Controller
{
    /**
     * @Route("/admin", name="admin_home")
     * @Security("has_role('ROLE_ADMIN')")
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

    /**
     * @Route("/mon-compte", name="mon-compte")
     * @Security("has_role('ROLE_USER')")
     */
    public function monCompteAction()
    {

        $em = $this->getDoctrine()->getManager();


        //On recupere les observations de l'user à partir de son id
        $observations = $em->getRepository('AppBundle:Observation')
            ->getObervationByUserId($this->getUser()->getId());
        $nombre = count($observations);

        //Dernier observation
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Observation');
        $query = $repository->createQueryBuilder('o')
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(2)
            ->getQuery();
        $lastObservations = $query->getResult();

        return $this->render(':MonCompte:index.html.twig',
            ['observations' => $observations,
                'lastObservations' => $lastObservations,
                'nombre' => $nombre]);
    }
}
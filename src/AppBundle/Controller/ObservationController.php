<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ObservationController extends Controller
{
    /**
     * @Route("/saveObservation", name="save-observation")
     */
    public function saveObservationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Aves')
        ;
        $data = $request->request->all();
        $date = new \DateTime($data['date_obs']);
        if($request->getMethod() === 'POST') {
            $dataObservation = $repository->findAves($data['nom_especes']);
            if (null === $dataObservation) {
                throw new NotFoundHttpException("cette espèce n'existe pas");
            } else {
                $observation = new Observation();
                $observation->setNomEspece($data['nom_especes']);
                $observation->setNbIndividus($data['nb_especes']);
                $observation->setDateObservation($date);
                $observation->setLatitude($data['latitude']);
                $observation->setLongitude($data['longitude']);
                $observation->setUser($this->getUser());


            $file = $request->files->get('fichier');
            $upload_service = $this->get('file_uploader_service');
            if(null != $data['file_mobile']){
                $fileName = $upload_service->base64Converter($data['file_mobile'] ,$upload_service->getTargetPath());
                $observation->setPhoto($fileName);
            }
            if(null != $file){
                $fileName = $upload_service->upload($file);
                $observation->setPhoto($fileName);
            }


                $em->persist($observation);
                $em->flush();
            }
        }
        $request->getSession()->getFlashBag()
            ->add('success', 'Votre observation a été bien enregistrée');
        return $this->redirect($this->generateUrl('observationpage'));
    }

}

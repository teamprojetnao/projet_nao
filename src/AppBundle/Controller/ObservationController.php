<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    /**
     * @Route("/saveObservation", name="save-observation")
     */
    public function saveObservationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->all();
        $date = new \DateTime($data['date_obs']);
        if($request->getMethod() === 'POST'){
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
            }else{
                $fileName = $upload_service->upload($file);
            }
            $observation->setPhoto($fileName);

            $em->persist($observation);
            $em->flush();
        }
        $request->getSession()->getFlashBag()
            ->add('success', 'Votre observation a été bien enregistrée');
        return $this->redirect($this->generateUrl('observationpage'));
    }

}

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
    protected function getErrorForm($errors){
        foreach ($errors as $error){
            $error_validation[$error->getPropertyPath()] = $error->getMessage();
        }
        return $error_validation;
    }

    /**
     * @Route("/saveObservation", name="save-observation")
     */
    public function saveObservationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $validator = $this->get('validator');
        $data = $request->request->all();
        $is_exist_espece = $em->getRepository('AppBundle:Aves')->findAves($data['nom_especes']);
        $date_observation = new \DateTime($data['date_obs']);
        $observation = new Observation();
        $observation->setNomEspece($data['nom_especes']);
        $observation->setNbIndividus($data['nb_especes']);
        $observation->setDateObservation($date_observation);
        $observation->setLatitude($data['latitude']);
        $observation->setLongitude($data['longitude']);
        $observation->setUser($this->getUser());
        
        $errors = $validator->validate($observation);
       /* dump(count($errors));
        dump(count($is_exist_espece));
        die();*/

        if($request->getMethod() === 'POST' && count($errors) > 0 && count($is_exist_espece )==0) {
            if( count($errors) > 0) {

                $error_observation = $this->getErrorForm($errors);

            }else{
                $error_observation = [];

            }
            if( count($is_exist_espece) > 0) {
                $espece_not_exist = false;
            }else{
                $espece_not_exist = true;
            }

            return $this->render(':MonCompte:observation.html.twig',[
                'error_observation' => $error_observation,
                'espece_not_exist' => $espece_not_exist,
                'old_value' => $data
            ]);


        }else if ($request->getMethod() === 'POST' && (count($errors) == 0 &&  count($is_exist_espece)==1)){



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

            //Si l'utilisateur est un naturaliste on valide son observation automatiquement
            if ($this->getUser()->getRoles()[0] == "ROLE_NATURALIST") {
                $observation->setIsValidate(1);
            }

            $em->persist($observation);
            $em->flush();


            return $this->redirect($this->generateUrl('observationpage'));
        }
    }
}

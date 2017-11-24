<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationRepository")
 */
class Observation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="nom_espece", type="string", nullable=false)
     */
    private $nomEspece;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     */
    private $validerPar;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     */
    private $refuserPar;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_individus", type="integer", nullable=true)
     */
    private $nbIndividus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_observation", type="datetime", nullable=true)
     */
    private $dateObservation;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=150, nullable=true)
     */
    private $photo;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_validate", type="boolean", nullable=true)
     */
    private $isValidate=0;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    

    /**
     * Set nomEspece
     *
     * @param string $nomEspece
     *
     * @return Observation
     */
    public function setNomEspece($nomEspece)
    {
        $this->nomEspece = $nomEspece;

        return $this;
    }

    /**
     * Get nomEspece
     *
     * @return string
     */
    public function getNomEspece()
    {
        return $this->nomEspece;
    }

    /**
     * Set nbIndividus
     *
     * @param integer $nbIndividus
     *
     * @return Observation
     */
    public function setNbIndividus($nbIndividus)
    {
        $this->nbIndividus = $nbIndividus;

        return $this;
    }

    /**
     * Get nbIndividus
     *
     * @return integer
     */
    public function getNbIndividus()
    {
        return $this->nbIndividus;
    }

    /**
     * Set dateObservation
     *
     * @param \DateTime $dateObservation
     *
     * @return Observation
     */
    public function setDateObservation($dateObservation)
    {
        $this->dateObservation = $dateObservation;

        return $this;
    }

    /**
     * Get dateObservation
     *
     * @return \DateTime
     */
    public function getDateObservation()
    {
        return $this->dateObservation;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Observation
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }



    /**
     * Set isValidate
     *
     * @param boolean $isValidate
     *
     * @return Observation
     */
    public function setIsValidate($isValidate)
    {
        $this->isValidate = $isValidate;

        return $this;
    }

    /**
     * Get isValidate
     *
     * @return boolean
     */
    public function getIsValidate()
    {
        return $this->isValidate;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Observation
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set validerPar
     *
     * @param \AppBundle\Entity\User $validerPar
     *
     * @return Observation
     */
    public function setValiderPar(\AppBundle\Entity\User $validerPar = null)
    {
        $this->validerPar = $validerPar;

        return $this;
    }

    /**
     * Get validerPar
     *
     * @return \AppBundle\Entity\User
     */
    public function getValiderPar()
    {
        return $this->validerPar;
    }

    /**
     * Set refuserPar
     *
     * @param \AppBundle\Entity\User $refuserPar
     *
     * @return Observation
     */
    public function setRefuserPar(\AppBundle\Entity\User $refuserPar = null)
    {
        $this->refuserPar = $refuserPar;

        return $this;
    }

    /**
     * Get refuserPar
     *
     * @return \AppBundle\Entity\User
     */
    public function getRefuserPar()
    {
        return $this->refuserPar;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * Aves
 *
 * @ORM\Table(name="aves", indexes={@Index(columns={"nomscientifique"}), @Index(columns={"nomvernaculaire"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AvesRepository")
 */
class Aves
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomscientifique", type="string")
     */
    private $nomscientifique;

    /**
     * @var string
     *
     * @ORM\Column(name="nomvernaculaire", type="string", nullable=true)
     */
    private $nomvernaculaire;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomscientifique
     *
     * @param string $nomscientifique
     *
     * @return Aves
     */
    public function setNomscientifique($nomscientifique)
    {
        $this->nomscientifique = $nomscientifique;

        return $this;
    }

    /**
     * Get nomscientifique
     *
     * @return string
     */
    public function getNomscientifique()
    {
        return $this->nomscientifique;
    }

    /**
     * Set nomvernaculaire
     *
     * @param string $nomvernaculaire
     *
     * @return Aves
     */
    public function setNomvernaculaire($nomvernaculaire)
    {
        $this->nomvernaculaire = $nomvernaculaire;

        return $this;
    }

    /**
     * Get nomvernaculaire
     *
     * @return string
     */
    public function getNomvernaculaire()
    {
        return $this->nomvernaculaire;
    }
}


<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Password_registration
 *
 * @ORM\Table(name="password_registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Password_registrationRepository")
 */
class Password_registration
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordconfirmed", type="string", length=255)
     */
    private $passwordconfirmed;


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
     * Set email
     *
     * @param string $email
     *
     * @return Password_registration
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Password_registration
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set passwordconfirmed
     *
     * @param string $passwordconfirmed
     *
     * @return Password_registration
     */
    public function setPasswordconfirmed($passwordconfirmed)
    {
        $this->passwordconfirmed = $passwordconfirmed;

        return $this;
    }

    /**
     * Get passwordconfirmed
     *
     * @return string
     */
    public function getPasswordconfirmed()
    {
        return $this->passwordconfirmed;
    }
}


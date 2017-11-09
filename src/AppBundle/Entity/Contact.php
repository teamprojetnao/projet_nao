<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 31/08/2017
 * Time: 11:55
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\Email(
     *     message = "L'email {{ value }} n'est pas valide.",
     *     checkMX = true
     *     )
     */
    private $email;

    /**
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
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
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="id")
     * @ORM\JoinColumn(name="userenvoyer", referencedColumnName="id")
     */
    private $userenvoyer;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="id")
     * @ORM\JoinColumn(name="userreceive", referencedColumnName="id")
     */
    private $userreceive;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Objet", inversedBy="id")
     * @ORM\JoinColumn(name="objetenvoyer", referencedColumnName="id")
     */
    private $objetenvoyer;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Objet", inversedBy="id")
     * @ORM\JoinColumn(name="objetreceive", referencedColumnName="id")
     */
    private $objetreceive;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserenvoyer()
    {
        return $this->userenvoyer;
    }

    /**
     * @param mixed $userenvoyer
     */
    public function setUserenvoyer($userenvoyer)
    {
        $this->userenvoyer = $userenvoyer;
    }

    /**
     * @return mixed
     */
    public function getUserreceive()
    {
        return $this->userreceive;
    }

    /**
     * @param mixed $userreceive
     */
    public function setUserreceive($userreceive)
    {
        $this->userreceive = $userreceive;
    }

    /**
     * @return mixed
     */
    public function getObjetreceive()
    {
        return $this->objetreceive;
    }

    /**
     * @param mixed $objetreceive
     */
    public function setObjetreceive($objetreceive)
    {
        $this->objetreceive = $objetreceive;
    }

    /**
     * @return mixed
     */
    public function getObjetenvoyer()
    {
        return $this->objetenvoyer;
    }

    /**
     * @param mixed $objetenvoyer
     */
    public function setObjetenvoyer($objetenvoyer)
    {
        $this->objetenvoyer = $objetenvoyer;
    }



}


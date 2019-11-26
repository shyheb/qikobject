<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Objet
 *
 * @ORM\Table(name="objet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjetRepository")
 */
class Objet
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categorie", inversedBy="id")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     */
    private $categorie;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="gouvernorat", type="string", length=255)
     */
    private $gouvernorat;

    /**
     * @var string
     *
     * @ORM\Column(name="cond", type="text", length=255)
     */
    private $cond;

    /**
     * @var float
     *
     * @ORM\Column(name="recompense_optionnelle", type="integer" ,nullable=True)
     */
    private $recompenseOptionnelle;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="objet")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;



    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\media",cascade={"persist"})
     * @ORM\JoinColumn(name="images", referencedColumnName="id")
     */
    private $images;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\media",cascade={"persist"})
     * @ORM\JoinColumn(name="image2", referencedColumnName="id",nullable=True)
     */
    private $image2;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\media",cascade={"persist"})
     * @ORM\JoinColumn(name="image3", referencedColumnName="id",nullable=True)
     */
    private $image3;

    /**
     * @return mixed
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * @param mixed $image2
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
    }

    /**
     * @return mixed
     */
    public function getImage3()
    {
        return $this->image3;
    }

    /**
     * @param mixed $image3
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;
    }




    /**
     * @return mixed
     */
    public function getUserDemande()
    {
        return $this->userDemande;
    }

    /**
     * @param mixed $userDemande
     */
    public function setUserDemande($userDemande)
    {
        $this->userDemande = $userDemande;
    }

    /**
     * @return string
     */
    public function getTypeDemande()
    {
        return $this->typeDemande;
    }

    /**
     * @param string $typeDemande
     */
    public function setTypeDemande($typeDemande)
    {
        $this->typeDemande = $typeDemande;
    }




    /**
     * Set images
     *
     * @param \AppBundle\Entity\Media $images
     *
     * @return Objet
     */
    public function setImages(\AppBundle\Entity\Media $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \AppBundle\Entity\Media
     */
    public function getImages()
    {
        return $this->images;
    }





    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTrouver()
    {
        return $this->trouver;
    }

    /**
     * @param mixed $trouver
     */
    public function setTrouver($trouver)
    {
        $this->trouver = $trouver;
    }




    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }


    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * @param string $emplacement
     */
    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;
    }

    /**
     * @return string
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }

    /**
     * @param string $gouvernorat
     */
    public function setGouvernorat($gouvernorat)
    {
        $this->gouvernorat = $gouvernorat;
    }



    /**
     * @return string
     */
    public function getCond()
    {
        return $this->cond;
    }

    /**
     * @param string $cond
     */
    public function setCond($cond)
    {
        $this->cond = $cond;
    }

    /**
     * @return float
     */
    public function getRecompenseOptionnelle()
    {
        return $this->recompenseOptionnelle;
    }

    /**
     * @param float $recompenseOptionnelle
     */
    public function setRecompenseOptionnelle($recompenseOptionnelle)
    {
        $this->recompenseOptionnelle = $recompenseOptionnelle;
    }





    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}


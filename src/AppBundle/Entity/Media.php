<?php
/**
 * Created by PhpStorm.
 * User: shyheb
 * Date: 09/05/2017
 * Time: 13:17
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */

class media
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at",type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->updateAt = new \DateTime();
    }

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $path;



    public $file;


    public function getUploadRootDir()
    {
        return __dir__.'/../../../web/uploads';
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getAssetPath()
    {
        return 'uploads/'.$this->path;
    }



    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
        $this->oldFile = $this->getPath();
        $this->updateAt = new \DateTime();

    /*
            $finfo = new \finfo();

        $fileMimeType = $finfo->file($this->getPath() . $this->getFile(), FILEINFO_MIME_TYPE);

        if (!($fileMimeType == "image/png" or $fileMimeType == "image/jpg" or $fileMimeType == "image/jpeg")) {
            die('Erreur Format Image ');
        }

    */



        if (null !== $this->file)
            $this->path = sha1(uniqid(mt_rand(),true)).'.'.$this->file->guessExtension();

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null !== $this->file) {
            $this->file->move($this->getUploadRootDir(),$this->path);
            unset($this->file);

            if ($this->oldFile != null) unlink($this->tempFile);
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFile)) unlink($this->tempFile);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getFile(){
        return $this->file;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Media
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}

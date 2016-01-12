<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Comparison
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="file", fileNameProperty="first_file_name")
     * 
     * @var File
     */
    private $first_file;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $first_file_name;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="file", fileNameProperty="second_file_name")
     * 
     * @var File
     */
    private $second_file;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $second_file_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    private $percentage;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $first_file
     */
    public function setFirstFile(File $first_file = null)
    {
        $this->first_file = $first_file;

        if ($first_file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getFirstFile()
    {
        return $this->first_file;
    }

    /**
     * @param string $first_file_name
     */
    public function setFirstFileName($first_file_name)
    {
        $this->first_file_name = $first_file_name;
    }

    /**
     * @return string
     */
    public function getFirstFileName()
    {
        return $this->first_file_name;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $second_file
     */
    public function setSecondFile(File $second_file = null)
    {
        $this->second_file = $second_file;

        if ($second_file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getSecondFile()
    {
        return $this->second_file;
    }

    /**
     * @param string $second_file_name
     */
    public function setSecondFileName($second_file_name)
    {
        $this->second_file_name = $second_file_name;
    }

    /**
     * @return string
     */
    public function getSecondFileName()
    {
        return $this->second_file_name;
    }

    /**
     * @param int $percentage
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }
}
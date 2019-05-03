<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient
{
    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_birth;

    /**
     * Modelisation de la relation : Un patient a plusieurs rendez-vous
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="patient")
     */
    private $appointments;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getUserid(): ?string
    {
        return $this->user_id;
    }

    public function setUserid($userid): self
    {
        $this->user_id = $userid;
        return $this;
    }
    
    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 */
class Doctor
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
     * @ORM\Column(type="string", length=40)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $profession;

    /**
     * Modelisation de la relation : Un docteur a plusieurs rendez-vous
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="doctor")
    */
    private $appointments;

    public function getUserid(): ?string
    {
        return $this->user_id;
    }

    public function setUserid($userid): self
    {
        $this->user_id = $userid;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }
}

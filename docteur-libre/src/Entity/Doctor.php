<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoctorRepository")
 */
class Doctor extends User
{
    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

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

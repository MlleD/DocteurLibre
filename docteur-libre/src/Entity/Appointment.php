<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentRepository")
*/

class Appointment
{
    public function __construct($patient, $doctor)
    {
        $this->patient = $patient;
        $this->doctor = $doctor;
    }

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="appointments")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     */
    private $patient;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Doctor")
     * @ORM\JoinColumn(name="doctor_id", referencedColumnName="id")
     */
    private $doctor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $appointment_time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appointment_reason;

    public function getPatient(): ?int
    {
        return $this->patient;
    }

    public function getDoctor(): ?int
    {
        return $this->doctor;
    }

    public function getAppointmentTime(): ?\DateTimeInterface
    {
        return $this->appointment_time;
    }

    public function setAppointmentTime(\DateTimeInterface $appointment_time): self
    {
        $this->appointment_time = $appointment_time;

        return $this;
    }

    public function getAppointmentReason(): ?string
    {
        return $this->appointment_reason;
    }

    public function setAppointmentReason(string $appointment_reason): self
    {
        $this->appointment_reason = $appointment_reason;

        return $this;
    }
}

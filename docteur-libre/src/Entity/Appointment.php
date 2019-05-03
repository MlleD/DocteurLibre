<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppointmentRepository")
*/

class Appointment
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="appointments")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     */
    private $patient;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Doctor", inversedBy="appointments")
     * @ORM\JoinColumn(name="doctor_id", referencedColumnName="id")
     */
    private $doctor;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string",length=19)
     */
    private $appointment_time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appointment_reason;

    public function setPatient($patient): self 
    {
        $this->patient = $patient;
        
        return $this;
    }

    public function setDoctor($doctor): self
    {
        $this->doctor = $doctor;
        
        return $this;
    }

    public function getPatient(): ?int
    {
        return $this->patient;
    }

    public function getDoctor(): ?int
    {
        return $this->doctor;
    }

    public function getAppointmentTime(): ?string
    {
        return $this->appointment_time;
    }

    public function setAppointmentTime(\DateTimeInterface $appointment_time): self
    {
        $this->appointment_time = $appointment_time->format('Y-m-d H:i:s');

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

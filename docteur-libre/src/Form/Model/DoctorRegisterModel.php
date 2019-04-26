<?php

namespace App\Form\Model;

use App\Entity\Doctor;
use App\Form\Model\UserRegisterModel;

class DoctorRegisterModel extends UserRegisterModel
{
    /**
     * @Assert\Valid()
     */
    private $doctor;

    public function getDoctor()
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor = null)
    {
        $this->doctor = $doctor;
    }
}
<?php

namespace App\Form\Model;

use App\Entity\Patient;
use App\Form\Model\UserRegisterModel;

class PatientRegisterModel extends UserRegisterModel
{
    
    /**
     * @Assert\Valid()
     */
    private $patient;

    public function getPatient()
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient = null)
    {
        $this->patient = $patient;
    }
}
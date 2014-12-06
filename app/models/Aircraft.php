<?php

class Aircraft extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $faa_registration_number;

    /**
     *
     * @var string
     */
    public $aircraft_type;

    /**
     *
     * @var integer
     */
    public $manufacture_year;

    /**
     *
     * @var integer
     */
    public $seating_capacity;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("");
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'faa_registration_number' => 'faa_registration_number', 
            'aircraft_type' => 'aircraft_type', 
            'manufacture_year' => 'manufacture_year', 
            'seating_capacity' => 'seating_capacity'
        );
    }

}

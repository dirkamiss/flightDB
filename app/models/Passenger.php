<?php

class Passenger extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $birthdate;

    /**
     *
     * @var string
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $phone_number;

    /**
     *
     * @var string
     */
    public $booked_flight;

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
            'name' => 'name', 
            'birthdate' => 'birthdate', 
            'gender' => 'gender', 
            'phone_number' => 'phone_number', 
            'booked_flight' => 'booked_flight'
        );
    }

}

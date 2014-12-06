<?php

namespace flightDB\Models;
use Phalcon\Mvc\Model;

class Flight extends Model
{

    /**
     *
     * @var integer
     */
    public $flight_number;

    /**
     *
     * @var string
     */
    public $aircraft_used;

    /**
     *
     * @var string
     */
    public $departure_city;

    /**
     *
     * @var string
     */
    public $destination_city;

    /**
     *
     * @var integer
     */
    public $departure_time;

    /**
     *
     * @var integer
     */
    public $arrival_time;

    /**
     *
     * @var string
     */
    public $airfare;

    /**
     *
     * @var string
     */
    public $mileage;

    /**
     *
     * @var integer
     */
    public $number_of_booked_passengers;

    /**
     *
     * @var integer
     */
    public $pilot;

    /**
     *
     * @var integer
     */
    public $copilot;

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
            'flight_number' => 'flight_number', 
            'aircraft_used' => 'aircraft_used', 
            'departure_city' => 'departure_city', 
            'destination_city' => 'destination_city', 
            'departure_time' => 'departure_time', 
            'arrival_time' => 'arrival_time', 
            'airfare' => 'airfare', 
            'mileage' => 'mileage', 
            'number_of_booked_passengers' => 'number_of_booked_passengers', 
            'pilot' => 'pilot', 
            'co-pilot' => 'copilot'
        );
    }

}

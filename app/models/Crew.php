<?php

namespace flightDB\Models;
use Phalcon\Mvc\Model;

class Crew extends Model
{

    /**
     *
     * @var integer
     */
    public $crew_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $salary;

    /**
     *
     * @var string
     */
    public $position;

    /**
     *
     * @var integer
     */
    public $seniority;

    /**
     *
     * @var integer
     */
    public $flying_hours;

    /**
     *
     * @var integer
     */
    public $supervisor;

    /**
     *
     * @var string
     */
    public $aircrafts_certified_to_fly;

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
            'crew_id' => 'crew_id', 
            'name' => 'name', 
            'salary' => 'salary', 
            'position' => 'position', 
            'seniority' => 'seniority', 
            'flying_hours' => 'flying_hours', 
            'supervisor' => 'supervisor', 
            'aircrafts_certified_to_fly' => 'aircrafts_certified_to_fly'
        );
    }

}

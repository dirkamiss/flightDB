<?php

namespace flightDB\Models;
use Phalcon\Mvc\Model;

class Maintenance extends Model
{

    /**
     *
     * @var string
     */
    public $log_number;

    /**
     *
     * @var string
     */
    public $aircraft;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var string
     */
    public $job;

    /**
     *
     * @var string
     */
    public $next;

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
            'log_number' => 'log_number', 
            'aircraft' => 'aircraft', 
            'date' => 'date', 
            'job' => 'job', 
            'next' => 'next'
        );
    }

}

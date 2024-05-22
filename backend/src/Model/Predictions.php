<?php

namespace App\Model;

class Predictions implements \Iterator, \Countable, \JsonSerializable
{
    private $predictions = [];
    private $position = 0;
    private $city;
    private $date;

    public function __construct(string $city, string $date)
    {
        $this->city = $city;
        $this->date = $date;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function addPrediction(Prediction $prediction)
    {
        return $this->predictions[] = $prediction;
    }

    public function rewind() 
    {
        $this->position = 0;
    }

    public function current() 
    {
        return $this->predictions[$this->position];
    }

    public function key() 
    {
        return $this->position;
    }

    public function next() 
    {
        ++$this->position;
    }

    public function valid() 
    {
        return isset($this->predictions[$this->position]);
    }

    public function count() 
    { 
        return count($this->predictions); 
    }

    public function  jsonSerialize()
    {
        return $this->predictions;
    }
}

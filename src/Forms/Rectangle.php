<?php
namespace CleanCode\Forms;

class Rectangle implements Area
{
    private $sideA;
    private $sideB;
    public function __construct($sideA, $sideB)
    {
        $this->sideA = $sideA;
        $this->sideB = $sideB;
    }
    public function getSize()
    {
      return $this->sideA * $this->sideB;
    }
}
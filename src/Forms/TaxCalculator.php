<?php
namespace CleanCode\Forms\TaxCalculator;

class TaxCalculator
{
    public function getTax($price)
    {
        return $price * 0.19;
    }
}
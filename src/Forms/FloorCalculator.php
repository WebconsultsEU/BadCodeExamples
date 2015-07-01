<?php
namespace CleanCode\Forms;

class FloorCalculator
{
    const PRICE_PER_SQUAREMETER = 2;
    public function getPriceForArea(Area $area)
    {

        return $area->getSize() * self::PRICE_PER_SQUAREMETER ;
    }

    public function getPriceForAreaWithTax(Area $area, TaxCalculator $taxCalculator)
    {
        $priceWithoutTax = $this->getPriceForArea($area);
        $tax = $taxCalculator->getTax($priceWithoutTax);
        return $tax + $priceWithoutTax;
    }
}

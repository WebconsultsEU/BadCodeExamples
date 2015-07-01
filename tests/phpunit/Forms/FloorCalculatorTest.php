<?php
namespace CleanCode\Test\Forms;

use \CleanCode\Forms\FloorCalculator;
use \CleanCode\Forms\Rectangle;

class FloorCalculatorTest extends \PHPUnit_Framework_TestCase
{

    public function testCalculatePrice()
    {
        $calculator = new FloorCalculator();
        $area = new Rectangle(3,4);
        $this->assertEquals(24, $calculator->getPriceForArea($area, 'standard'), 'Preis für einfaches Parkett 12m² = 24');
    }

    public function testCalculatePriceForOneSM()
    {
        $calculator = new FloorCalculator();
        $area = new Rectangle(1,1);
        $this->assertEquals(2, $calculator->getPriceForArea($area, 'standard'), 'Preis für einfaches Parkett 1m² = 2');
    }

    public function testGetPriceInclusiveTax()
    {
        $calculator = new FloorCalculator();
        $area = new Rectangle(1,1);
        $taxCalculator = new TaxCalculator('de');
        $this->assertEquals(2.38, $calculator->getPriceForAreaWithTax($area, $taxCalculator));

    }
    
}
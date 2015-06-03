<?php
namespace CleanCode\Test\Forms;

use \CleanCode\Forms\Rectangle;

class RectangleTest extends \PHPUnit_Framework_TestCase
{

    public function testObjectCreation()
    {
        $testObject = new \CleanCode\Forms\Rectangle(1,2);
        $this->assertEquals('CleanCode\Forms\Rectangle', get_class($testObject), 'Rectangle');
    }

    public function testGetParkettPrice()
    {
        $superCalc = new Rectangle(1,3);
        $dingens = $superCalc->getParkettPreis(3,6, 'normal');
        $this->assertEquals('der preis betraegt 85.4658', $dingens, 'Rectangle');


    }

    
}
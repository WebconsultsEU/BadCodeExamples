<?php
namespace CleanCode\SolidExamples;

require_once(__DIR__.'/../../../src/SolidExamples/DependencyInversion.php');


class DependencyInversionTest  extends \PHPUnit_Framework_TestCase{

    /**
     * @return Basket
     */
    public function getBasketObject() {
        $di = new DiContainer();
        $factory = new BasketFactory($di);
        $basket = $factory->getBasket();
        return $basket;
    }

    public function testInitObject() {
        $basket = $this->getBasketObject();
        $this->assertInstanceOf('\CleanCode\SolidExamples\Basket', $basket);
    }
    public function testGetBasketEmpty() {
        $basket = $this->getBasketObject();
        $this->assertEquals(array(), $basket->getBasket());
    }
    public function testAddBasket() {
        $basket = $this->getBasketObject();
        $basket->addBasket('Hosen',3);
        $basketItems = $basket->getBasket();
        $this->assertContains(["name" => 'Hosen',"amount" => 3], $basketItems);
    }
    public function testGetPrice() {
        $basket = $this->getBasketObject();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(90, $basket->getTotalPrice());
    }

    public function testGetPriceTax() {
        $basket = $this->getBasketObject();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(107.1, $basket->getTotalPriceWithTax());
    }

    public function testGetPriceTaxHolland() {
        $basket = $this->getBasketObject();
        $basket->setTaxCalculator(new TaxCalculatorNetherlands());
        $basket->taxFlag = 'nl';
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(108.9, $basket->getTotalPriceWithTax());
    }

    public function testGetTaxAmount() {
        $basket = $this->getBasketObject();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $this->assertEquals(11.4, $basket->getTaxAmount());
    }




}
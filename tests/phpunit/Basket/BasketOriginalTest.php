<?php
/**
 * Created by PhpStorm.
 * User: Webconsults
 * Date: 17.06.2015
 * Time: 09:55
 */

namespace CleanCode\Basket;


class BasketOriginalTest  extends \PHPUnit_Framework_TestCase{

    public function testInitObject() {
        $basket = new BasketOriginal();
        $this->assertInstanceOf('\CleanCode\Basket\BasketOriginal', $basket);
    }
    public function testGetBasketEmpty() {
        $basket = new BasketOriginal();
        $this->assertEquals(array(), $basket->getBasket());
    }
    public function testAddBasket() {
        $basket = new BasketOriginal();
        $basket->addBasket('Hosen',3);
        $basketItems = $basket->getBasket();
        $this->assertContains(["name" => 'Hosen',"count" => 3, 'price' => 0], $basketItems);
    }
    public function testGetPrice() {
        $basket = new BasketOriginal();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(90, $basket->getPrice());
    }

    public function testGetPriceTax() {
        $basket = new BasketOriginal();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(107.1, $basket->getPrice(true));
    }

    public function testGetPriceTaxHolland() {
        $basket = new BasketOriginal();
        $basket->tflag = 'nl';
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(108.9, $basket->getPrice('nl'));
    }

    public function testGetTaxAmount() {
        $basket = new BasketOriginal();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $this->assertEquals(11.4, $basket->getTaxAmount());
    }




}
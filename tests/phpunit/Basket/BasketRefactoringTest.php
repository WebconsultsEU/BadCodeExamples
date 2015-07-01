<?php
/**
 * Created by PhpStorm.
 * User: Webconsults
 * Date: 17.06.2015
 * Time: 09:55
 */

namespace CleanCode\Basket;


class BasketRefactoringTest  extends \PHPUnit_Framework_TestCase{

    public function testInitObject() {
        $basket = new BasketRefactoring();
        $this->assertInstanceOf('\CleanCode\Basket\BasketRefactoring', $basket);
    }
    public function testGetBasketEmpty() {
        $basket = new BasketRefactoring();
        $this->assertEquals(array(), $basket->getBasket());
    }
    public function testAddBasket() {
        $basket = new BasketRefactoring();
        $basket->addBasket('Hosen',3);
        $basketItems = $basket->getBasket();
        $this->assertContains(["name" => 'Hosen',"count" => 3, 'price' => 0], $basketItems);
    }
    public function testGetPrice() {
        $basket = new BasketRefactoring();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(90, $basket->getTotalBasketPriceSum());
    }

    public function testGetPriceTax() {
        $basket = new BasketRefactoring();
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(107.1, $basket->getTotalBasketPriceSum(true));
    }

    public function testGetPriceTaxHolland() {
        $basket = new BasketRefactoring();
        $basket->taxFlag = 'nl';
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $basket->addBasket('Socken', 6);
        $this->assertEquals(108.9, $basket->getTotalBasketPriceSum('nl'));
    }

    public function testGetTaxAmount() {
        $basket = new BasketRefactoring();
        $basket->taxFlag = true;
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $this->assertEquals(11.4, $basket->getTaxAmount(), 'returns tax only for given basket');
    }
    public function testGetTaxAmountForFalseTaxFlag() {
        $basket = new BasketRefactoring();
        $basket->taxFlag = false;
        $basket->addBasket('Hosen', 3);
        $basket->addBasket('Jacken', 2);
        $this->assertEquals(0, $basket->getTaxAmount(), 'returns tax only if taxflag false');
    }





}
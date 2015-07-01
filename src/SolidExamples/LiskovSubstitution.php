<?php
namespace CleanCode\SolidExamples;

class Basket
{
    public function getBasket()
    {
        return $this->items;
    }
    /** more code here  */
}
class StrangeBasket extends Basket
{

    public function getBasket()
    {
        $items = parent::getBasket();
        /** additional stuff here */
        $this->doSomeUnexpectedCalculations($items);
        $this->initPayment($items);
        return $items;
    }
}

class ExpectedBasket extends Basket
{
    public function getBasket()
    {
        /** other code doing exactly same stuff here */
    }
}
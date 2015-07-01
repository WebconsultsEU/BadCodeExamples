<?php
namespace CleanCode\SolidExamples;

class Basket
{
    public function getBasket()
    {
        return $this->items;
    }
}
class SuperBasket extends Basket
{

    public function getBasket()
    {
        throw new \Exception('not implemented anymore');
    }
}

class LoggingBasket extends Basket
{
    /** additional code here */
    public function getBasket()
    {
        write_log('get price called');
        return parent::getBasket();
    }
}
class SavableBasket extends Basket
{
    /** additional code here */
   public function save()
   {
       $this->storage->save($this->items);
   }
}
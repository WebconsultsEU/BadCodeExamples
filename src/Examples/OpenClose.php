<?php
Class Basket {
    public function getBasket() {
        return $this->items;
    }
}
class SuperBasket extends Basket {

    public function getBasket() {
        throw new \Exception('not implemented anymore');
    }
}

class LoggingBasket extends Basket {
    public function getBasket() {
        parent::getBasket();
        write_log('get price called');
    }
}
class SavableBasket extends Basket {
   public function save() {
       $storage->save($this->items);
   }
}
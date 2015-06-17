<?php
Class Basket {
    public function getBasket() {
        return $this->items;
    }
}
class ObjectBasket extends Basket {

    public function getBasket() {
        $items = array('total_price' => $this->getPrice(), 'items' =>[]);
        foreach($this->items as $item) {
            $items['items'][] = new ItemObject($item['name'], $item['amount']);
        }
        $this->initPayment();
        return $items;
    }
}

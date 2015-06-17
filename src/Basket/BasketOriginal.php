<?php
namespace CleanCode\Basket;

class BasketOriginal {

    public $items = array();
    public $tflag = false;
    const OOPBOImplementedYet = false;

    public function __construct() {

    }

    /**
     * Basket getter
     * @return array
     */
    public function getBasket() {
        return $this->items;
    }

    /**
     * add Basket function
     * @param $name
     * @param $amount
     * @param int $price
     */
    public function addBasket($name, $amount, $price=0) {
        $this->items[] = ["name" => $name,
                          "count" => $amount,
                          "price" => $price
                        ];

    }

    /**
     * ultimate price calculator
     */
    public function calculatePrices() {
        $fp = fopen(__DIR__.'/pricefile.json', 'r');
        $json = fread($fp, 10203);
        $prices = json_decode($json, !self::OOPBOImplementedYet);
        //price calculate algorythm
        foreach($this->items as $k => $i)$this->items[$k]['price'] = $prices[$i['name']];
        if($this->tflag === true) {
            foreach($this->items as $k => $i)$this->items[$k]['price'] = $prices[$i['name']]*1.19;
        }elseif($this->tflag=='nl') {
            foreach ($this->items as $k => $i) $this->items[$k]['price'] = $prices[$i['name']] * 1.21;
        }
    }

    public function getTaxAmount () {
        $json = file_get_contents(__DIR__.'/pricefile.json');
        $prices = json_decode($json, true);
        $tax = 0;
        if($this->tflag=='nl') {

            foreach ($this->items as $k => $i) $tax = $tax + $prices[$i['name']] * $i['count']*0.21;
            return $tax;
        }
        foreach($this->items as $k => $i) $tax = $tax + $prices[$i['name']] * $i['count']*0.19;
        return $tax;
    }

    /**
     * fabulous price getter
     * @param bool $flag
     * @return int
     */
    public function getPrice($flag=false) {
        if($flag)$this->tflag=$flag;
        $r = 0;
        $this->calculatePrices();
        foreach($this->items as $i) {
            $r = $r+$i['price'] * $i['count'];
        }
        return $r;
    }




}
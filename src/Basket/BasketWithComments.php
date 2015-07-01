<?php
namespace CleanCode\Basket;

//warum heisst das so?
class BasketOriginal
{

    public $items = array();
    //tax object
    public $taxFlag = false;
    // versteht keine sau
    //konstanten ganz oben wenn überhaupt sinnvoll
    const OOPBOImplementedYet = false;

    //toter konstruktor wird nicht benötigt
    public function __construct() {

    }

    /**
     *  // kommentar sagt nix neues redundanter funktionsname
     * Basket getter
     * // hilft ein bischen weiter
     * @return array
     */
    // getBasketItems wäre beschreibender
    public function getBasket() {
        return $this->items;
    }

    /**
     * add Basket function
     * @param $name
     * @param $amount
     * @param int $price
     */
    //funktionsname leicht falsch verstehbar.
    //bessere Benamung wäre zb addItemt addItemToBasket
    //$price wird in calculatePrices überschrieben bevor er benutzt wurde
    public function addBasket($name, $amount, $price=0) {
        //objekte wären besser weil fehleranfällig
        // two names per concept amount und count für menge
        $this->items[] = ["name" => $name,
                          "count" => $amount,
                          "price" => $price
                        ];
    }

    /**
     * ultimate price calculator
     */
    //kaum sinnvoller kommentar
    /**
     * Price Calculations Methods
     * Reads prices from JSON file and set them for items in basket
     * with right tax flag
     * true for default/germany
     * and taxFlag 'nl' for nl
     */
    //verstösst gegen Solid  (Single Responsibility) Prinzipien weil ändertsich wenn preise sich ändern oder die mehrwertsteuer eines Landes
    public function calculatePrices() {
        //zugriff auf das dateisystem, hätte man von aussen reingeben können
        $fp = fopen(__DIR__.'/pricefile.json', 'r');
        $json = fread($fp, 10203);
        $prices = json_decode($json, !self::OOPBOImplementedYet);
        //fp wird nicht geschlossen

        //price calculate algorythm
        //teilweise wird zweimal wird über this items iteriert
        //schlechte formatierung
        //Don´t repeat yourself - don´t copy and pase
        foreach ($this->items as $key => $item) {
            $this->items[$key]['price'] = $prices[$item['name']];
        }
        //variable einmal boolsch und einmal mit iso code
        if($this->taxFlag === true) {
            //magic number
            //+ wiederholung
            foreach($this->items as $k => $i)$this->items[$k]['price'] = $prices[$i['name']] * 1.19;
        }elseif($this->taxFlag=='nl') {
            foreach ($this->items as $k => $i) $this->items[$k]['price'] = $prices[$i['name']] * 1.21;
        }
    }
    // nicht eindeutige benamung - text amount von was
    //besser wäre getTotalTaxAmount
    //kein docblock mit return - coding standard
    public function getTaxAmount () {
        //file zugriff von aussen
        // DRY code duplizierung bzw zwei Unterschiedliche Methoden um das gleiche zu tun
        $json = file_get_contents(__DIR__.'/pricefile.json');
        $prices = json_decode($json, true);
        $tax = 0;
        if($this->taxFlag == 'nl') {
            //Code duplizierung
            //magic numbers
            foreach ($this->items as $k => $i) $tax = $tax + $prices[$i['name']] * $i['count']*0.21;
            return $tax;
        }
        //code duplizierung
        //inconsistente handlung des text flags
        //code formatierung for schleife -schlecht für code coverage auf zeilenbasis
        foreach($this->items as $k => $i) $tax = $tax + $prices[$i['name']] * $i['count']*0.19;
        return $tax;
    }

    /**
     * fabulous price getter
     * @param bool $flag
     * @return int
     */
    //nicht eindeutig - getTotalPrice
    //tax flag mysteriös
    public function getPrice($flag=false) {
        if($flag)$this->taxFlag=$flag;
        //result oder totalSum/Price wäre besser
        $r = 0;
        $this->calculatePrices();
        //holt den preis von allen items
        foreach($this->items as $i) {
            $r = $r+$i['price'] * $i['count'];
        }
        return $r;
    }




}
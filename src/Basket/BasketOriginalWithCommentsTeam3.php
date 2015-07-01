<?php
namespace CleanCode\Basket;


//klasse tut mehr als sie vermeintlich tun sollte
//man könnte andere dinge raus separieren
//extra klasse für Tax
//Artikel als eigenes Item
class BasketOriginal
{
    public $items = array();
    public $taxFlag = false;
    
    //weiss keiner was es ist, programmierer hatte merkwürdige gedanken
    const OOPBOImplementedYet = false;

    //leerer constructor ergibt keinen sinn
    public function __construct() {

    }

    /**
     *  
     * Basket getter //kommentar hilft nichts
     * @return array
     */
    //name stimmt nicht ganz gut besser wäre getBasketItems oder getItems
    public function getBasket() {
        return $this->items;
    }

    /**
     * add Basket function // keine zusätzliche info
     * @param $name
     * @param $amount
     * @param int $price
     */
    //price mit 0 im constructor merkwürdig
    //benamung unzutreffend besser wäre addItemToBasket
    //später mit items objects als übergabe
    public function addBasket($name, $amount, $price=0) { 
        $this->items[] = ["name" => $name,
                          "count" => $amount,
                          "price" => $price
                        ];
    }

    /**
     * ultimate holy price calculation function   //kommentar mit sinnloser information
     */
    public function calculatePrices() {
        //zugriff aufs dateisystem, verletzung SLA Prinzip
        //besser wäre kapseln in anderer Klasse
        $fp = fopen(__DIR__.'/pricefile.json', 'r');
        $json = fread($fp, 10203);
        //bedeutung der konstante unklar
        $prices = json_decode($json, !self::OOPBOImplementedYet);

        //fast duplicated code mit dem unteren
        foreach ($this->items as $key => $item) {
            $this->items[$key]['price'] = $prices[$item['name']];
        }
        //tax flag mal als bool mal als country code
        //hart codeirte magic numbers
        if($this->taxFlag === true) {
            foreach($this->items as $k => $i){
            $this->items[$k]['price'] = $prices[$i['name']] * 1.19;}                
        }elseif($this->taxFlag=='nl') {
            //duplicated code unterschiedlich implementiert
            foreach ($this->items as $k => $i):
                $this->items[$k]['price'] = $prices[$i['name']] * 1.21;
            endforeach;
        }
    }
    public function getTaxAmount () {
        //gleiche sachen sollten gleich erledigt werden, hier einmal fopen, einmal file_get_contents
        //duplicated code
        $json = file_get_contents(__DIR__.'/pricefile.json');
        $prices = json_decode($json, true);
        $tax = 0;

        if($this->taxFlag == 'nl') {
            //magic numbers
            //duplicated code
            //lesbarkeit der zeile schlecht
            foreach ($this->items as $k => $i) $tax = $tax + $prices[$i['name']] * $i['count']*0.21;
            return $tax;
        }

        foreach($this->items as $k => $i) $tax = $tax + $prices[$i['name']] * $i['count']*0.19;
        return $tax;
    }
    //kommentar ist veraltet
    /**
     * fabulous price getter  //zusätzliche informationen
     * @param int $flag //kommentar passt nicht zum code int ist falsch
     * @return int //könnte auch kommawerte enthalten
     */    
    public function getPrice($flag=false) {
        //setzt tax flag des gesamtopbjektes
        if($flag)$this->taxFlag=$flag;
        $r = 0;
        //kalkulieren der preise im getter
        $this->calculatePrices();        
        foreach($this->items as $i) {
            $r = $r+$i['price'] * $i['count'];
        }
        return $r;
    }

}
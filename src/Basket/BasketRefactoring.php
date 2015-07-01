<?php
namespace CleanCode\Basket;


//klasse tut mehr als sie vermeintlich tun sollte
//man könnte andere dinge raus separieren
//extra klasse für Tax
//Artikel als eigenes Item
class BasketRefactoring
{
    public $items = array();
    public $taxFlag = false;

    /**
     *
     * Basket getter //kommentar hilft nichts
     * @return array
     */
    //name stimmt nicht ganz gut besser wäre getBasketItems oder getItems
    public function getBasket()
    {
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
    public function addBasket($name, $amount, $price = 0)
    {
        $this->items[] = ["name" => $name,
            "count" => $amount,
            "price" => $price
        ];
    }


    public function getTaxAmount()
    {
        $prices = $this->getAllPrices();
        $taxTotal = 0;
        $vatOnlyFactor = $this->getVatFactor();
        foreach ($this->items as $k => $i) {
            $taxTotal += $prices[$i['name']] * $i['count'] * $vatOnlyFactor;
        }
        return $taxTotal;
    }
    //kommentar ist veraltet
    /**
     * fabulous price getter  //zusätzliche informationen
     * @param int $flag //kommentar passt nicht zum code int ist falsch
     * @return int //könnte auch kommawerte enthalten
     */
    public function getTotalBasketPriceSum($flag = false)
    {
        //setzt tax flag des gesamtopbjektes
        if ($flag) $this->taxFlag = $flag;
        $result = 0;
        $prices = $this->getAllPrices();
        $vatAddingFactor = $this->getVatFactor()+1;
        foreach ($this->items as $key => $item) {
           $result += $prices[$item['name']] *$item['count'] * $vatAddingFactor;
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function getAllPrices()
    {
        //zugriff aufs dateisystem, verletzung SLA Prinzip
        //besser wäre kapseln in anderer Klasse
        $fp = fopen(__DIR__ . '/pricefile.json', 'r');
        $json = fread($fp, 10203);
        //bedeutung der konstante unklar
        $prices = json_decode($json, true);
        return $prices;
    }

    /**
     * @return float|int
     */
    public function getVatFactor()
    {
        $vatFactor = 0;

        if ($this->taxFlag === true) {
            $vatFactor = 0.19;
            return $vatFactor;
        } elseif ($this->taxFlag == 'nl') {
            $vatFactor = 0.21;
            return $vatFactor;
        } elseif ($this->taxFlag == 'dk') {
            $vatFactor = 0.25;
            return $vatFactor;
        } elseif ($this->taxFlag == 'at') {
            $vatFactor = 0.20;
            return $vatFactor;
        }
        return $vatFactor;
    }

}
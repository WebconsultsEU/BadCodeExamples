<?php
class Basket
{
   public function getPrices() {
       $priceFinder = new PriceFinder($priceFileReader);
       if($this->country='de') {
           $taxCalculator = new TaxCalculatorGermany();
       }
   }
}

class BasketFactory {

    public $DI;

    public static function getBasket() {
        $basket = new IndependentBasket();
        $priceFinder = $this->DI->get('PriceFinder');
        $basket->setPriceFinder($priceFinder);
        $taxCalculator = $this->DI->get('TaxCalculator');
        $basket->setTaxCalculator($taxCalculator);
        return $basket;
    }
}


class IndependentBasket {
    public function setPriceFinder(PriceFinderInterface $priceFinder){
        $this->setPriceFinder = $priceFinder;
    }
    public function setTaxCalculator(TaxCalculator $taxCalculator){
        $this->setTaxCalculator = $taxCalculator;
    }
}

class PriceFileReader {
    public function readPriceFile($priceFile) {
        $fp = fopen($priceFile, 'r');
        $json = fread($fp, 10203);
        $prices = json_decode($json, !self::OOPBOImplementedYet);
    }
}
class PriceFinder {
    public function getPrice($articleName) {
        $reader = new PriceFileReader();
        $prices = $reader->readPriceFile(__DIR__ . '/pricefile.json');
        return $prices['articleName'];
    }
}
class TaxCalculatorGermany {
    const taxRateInPercent = 19;
    public function addVat($nettoPrice) {
        $totalPrice = $nettoPrice * (1+self::taxRateInPercent/100);
    }

}
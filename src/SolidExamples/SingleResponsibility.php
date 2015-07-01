<?php
namespace CleanCode\SolidExamples;

class Basket
{
    /** other old class code here */
    public function calculatePrices()
    {
        $fp = fopen(__DIR__ . '/pricefile.json', 'r');
        $json = fread($fp, 10203);
        $prices = json_decode($json, !self::OOPBOImplementedYet);
        //price calculate algorythm
        foreach ($this->items as $k => $i) {
            $this->items[$k]['price'] = $prices[$i['name']];
        }
        if ($this->tflag) {
            foreach ($this->items as $k => $i) {
                $this->items[$k]['price'] = $prices[$i['name']] * 1.19;
            }
        } elseif ($this->tflag == 'nl') {
            foreach ($this->items as $k => $i) {
                $this->items[$k]['price'] = $prices[$i['name']] * 1.21;
            }
        }
    }
}
class PriceFileReader
{
    /**
     * Reads Prices from JSON file and returns array
     * @param $priceFile
     * @return array
     */
    public function readPriceFile($priceFile)
    {
        $fp = fopen($priceFile, 'r');
        $json = fread($fp, 10203);
        $prices = json_decode($json, true);
        return $prices;
    }
}
class PriceFinder
{
    public function getPrice($articleName) {
        $reader = new PriceFileReader();
        $prices = $reader->readPriceFile(__DIR__ . '/pricefile.json');
        return $prices['articleName'];
    }
}
class TaxCalculatorGermany
{
    const taxRateInPercent = 19;
    public function addVat($nettoPrice)
    {
        $totalPrice = $nettoPrice * (1+self::taxRateInPercent/100);
        return $totalPrice;
    }

}
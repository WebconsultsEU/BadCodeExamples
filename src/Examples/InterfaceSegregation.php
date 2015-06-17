<?php
interface UltimateBasket {
    public function getBasket();
    public function addBasket();
    public function getAllArticlePrices();
}

interface PriceFileReader {
    public function getPrice($articleName);
    public function getAllArticlePrices();
    public function getFileContent();
}

interface PriceFinder {
    public function getPrice($articleName);
}

class Basket  {

    public function calculatePrices() {
        $reader->getPrice();
    }
    public function addBasket() {
        // we do real stuff here
    }
    public function getBasket() {
        // we do something
    }
    public function getAllArticlePrices() {
        throw new Exception('will implement later');
    }
}





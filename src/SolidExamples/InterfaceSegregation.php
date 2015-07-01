<?php
namespace CleanCode\SolidExamples;

interface UltimateBasketInterface
{
    public function getBasket();
    public function addBasket();
    public function getAllArticlePrices();
}

interface PriceFileReader
{
    public function getPrice($articleName);
    public function getAllArticlePrices();
    public function getFileContent();
}

interface PriceFinder
{
    public function getPrice($articleName);
}

class UltimateBasket implements UltimateBasketInterface, PriceFinder
{
    public function addBasket()
    {
        /* real code placed here */
    }
    public function getBasket()
    {
        /* real code placed here */
    }

    public function getAllArticlePrices()
    {
        throw new Exception('will implement later');
    }
    public function getPrice($articleName)
    {
        //@todo implement this maybe if you have time between xmas and new year
        throw new Exception('dummy func will implement later');
    }
}

interface TinyPriceFileReader
{
    public function getArticlesFromFileContent();
}





<?php
namespace CleanCode\SolidExamples;

interface Basket
{
    public function getTotalPrice();
}
class OldDependentBasket implements Basket
{
     public function getTotalPrice()
     {
        $priceFileReader = new PriceFileReader();
        $priceFinder = new PriceFinder($priceFileReader);
        if ($this->country='de') {
            $taxCalculator = new TaxCalculatorGermany();
        }
           /** additional code */
     }

}

class IndependentBasket extends RefactoredBasket  implements Basket
{
    protected $priceFinder;
    protected $taxCalculator;

    public function setPriceFinder(PriceFinderInterface $priceFinder)
    {
        $this->priceFinder = $priceFinder;
    }
    public function setTaxCalculator(TaxCalculator $taxCalculator)
    {
        $this->taxCalculator = $taxCalculator;
    }
}

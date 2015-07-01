<?php
namespace CleanCode\SolidExamples;

class RefactoredBasket
{
    protected $priceFinder;
    protected $taxCalculator;
    
    public $items = array();
    
    public function setPriceFinder(PriceFinderInterface $priceFinder)
    {
        $this->priceFinder = $priceFinder;
    }
    public function setTaxCalculator(TaxCalculator $taxCalculator)
    {
        $this->taxCalculator = $taxCalculator;
    }

    /**
     * @return TaxCalculator
     */
    public function getTaxCalculator()
    {
        return $this->taxCalculator;
    }
    /**
     * @return PriceFinderInterface
     */
    public function getPriceFinder()
    {
        return $this->priceFinder;
    }

    public function getBasket()
    {
        return $this->items;
    }
    public function addBasket($name, $amount)
    {
        $this->items[] = ["name" => $name,
            "amount" => $amount
        ];
    }

    public function calculatePrices()
    {
        foreach ($this->items as $key => $item) {
            $articleName = $item['name'];
            $this->items[$key]['price'] = $this->getPriceFinder()->getPrice($articleName);
        }
    }

    public function getTaxAmount()
    {
        $this->calculatePrices();
        $taxCalculator = $this->getTaxCalculator();
        $totalTax = 0;
        foreach ($this->items as $k => $item) {
            $totalTax = $totalTax + $taxCalculator->getVat($item['price'] * $item['amount']);
        }
        return $totalTax;
    }

    public function getTotalPrice()
    {
        $this->calculatePrices();
        $totalPrice = 0;
        foreach ($this->items as $key => $item) {
            $totalPrice = $totalPrice + $item['price'] * $item['amount'];
        }
        return $totalPrice;
    }

    public function getTotalPriceWithTax()
    {
        return $this->getTotalPrice() + $this->getTaxAmount();
    }
}

/**
 * Example DI Container, modern ones are a lot more complicated and not Singleton;
 * Class DiContainer
 * @package CleanCode\SolidExamples
 */
class DiContainer
{
    private $config = false;
    public function __construct()
    {
        //originally this would be done by config.
        $this->config = array(
            "TaxCalculator" => new TaxCalculatorGermany(),
            "PriceFinder" => new PriceFinderFile()
        );
    }

    public function get($dependencyIdentifier)
    {
        return $this->config[$dependencyIdentifier];
    }
}

class BasketFactory
{
    public $di;
    public function __construct(DiContainer $di)
    {
        $this->di = $di;
    }

    public function getBasket()
    {
        $basket = new IndependentBasket($this->di);
        $priceFinder = $this->di->get('PriceFinder');
        $basket->setPriceFinder($priceFinder);
        $taxCalculator = $this->di->get('TaxCalculator');
        $basket->setTaxCalculator($taxCalculator);
        return $basket;
    }
}


class PriceFileReader
{
    public function getPricesFromFile($priceFile)
    {
        $fp = fopen($priceFile, 'r');
        $json = fread($fp, 10203);
        $prices = json_decode($json, true);
        return $prices;
    }
}

interface PriceFinderInterface
{
    public function getPrice($articleName);
}

class PriceFinderFile implements PriceFinderInterface
{
    public function getPrice($articleName)
    {
        $reader = new PriceFileReader();
        $prices = $reader->getPricesFromFile(__DIR__ . '/pricefile.json');
        return $prices[$articleName];
    }
}

interface TaxCalculator
{
    public function addVat($nettoPrice);
    public function getVat($nettoPrice);
}

class TaxCalculatorGermany implements TaxCalculator
{
    const taxRateInPercent = 19;
    public function addVat($nettoPrice)
    {
        $totalPrice = $nettoPrice * (1+self::taxRateInPercent/100);
        return $totalPrice;
    }
    public function getVat($nettoPrice)
    {
        $tax = $nettoPrice * (self::taxRateInPercent/100);
        return $tax;
    }
}

class TaxCalculatorNetherlands extends TaxCalculatorGermany
{
    const taxRateInPercent = 21;
    public function addVat($nettoPrice)
    {
        $totalPrice = $nettoPrice * (1+self::taxRateInPercent/100);
        return $totalPrice;
    }
    public function getVat($nettoPrice)
    {
        $tax = $nettoPrice * (self::taxRateInPercent/100);
        return $tax;
    }
}
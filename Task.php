<?php

class Country
{
    protected string $name;
    public array $cities = [];
    public function __construct(string $name, array $cities )
    {
        $this->name = $name;
        $this->cities = $cities;
    }
    public function getName(): string {
        return $this->name;
    }
    public function SummaryPopulation() : int {
        $population = 0;
        foreach ($this->cities as $city ) {
            $population += $city->NumberOfPeople();
        }
        return $population;
    }
    
}

class City
{
    protected string $name;
    protected int $population;
    public array $cityTransport  = [];

    public function __construct(string $name, int $population)
    {
        $this->name = $name;
        $this->population = $population;
    }
    public function getName(): string {
        return $this->name;
    }
    public function NumberOfPeople(): int
    {
        return $this->population;
    }


    public function CityTransportProfit() : float {
        $sum = 0;
        foreach ($this->cityTransport as $transport ) {
            $sum += $transport->FullLoadProfit();
        }
        return $sum;
    }

}

abstract class TransportForPeople
{
    protected float $speed;
    protected int $capacity;
    
    public function __construct(int $capacity, float $speed)
    {
        $this->capacity = $capacity;
        $this->speed = $speed;
    }

    abstract function FullLoadProfit();
}

class Taxi extends TransportForPeople
{
    protected float $tripCost;
    public function __construct(int $capacity, float $speed, float $tripCost)
    {
        parent::__construct($capacity, $speed);
        $this->tripCost = $tripCost;
    }
    public function FullLoadProfit() : float
    {
        return $this->capacity * $this->tripCost * 0.5;
    }
}

class Bus extends TransportForPeople
{
    protected float $ticketPrice;
    protected string $track;
    
    public function __construct(int $capacity, float $speed, float $ticketPrice, string $track)
    {
        parent::__construct($capacity, $speed);
        $this->ticketPrice = $ticketPrice;
        $this->track = $track;
    }
    public function FullLoadProfit() : float
    {
        return $this->capacity * $this->ticketPrice;
    }
}
class CarSharing extends TransportForPeople
{
    protected float $tripTime;
    protected float $timePrice;
    
    public function __construct(int $capacity, float $speed, float $tripTime, float $timePrice)
    {
        parent::__construct($capacity, $speed);
        $this->tripTime = $tripTime;
        $this->timePrice = $timePrice;
    }
    public function FullLoadProfit() : float
    {
        return $this->tripTime * $this->timePrice;
    }
}
$city = new City('London', 4000);
$city2 = new City('Birmingham', 5040);
$country = new Country('England', [$city, $city2]);


$taxi1 = new Taxi(4, 70, 500);
$taxi2 = new Taxi(4, 70, 600);
$bus1 = new Bus(30, 60, 50, 'F100');
$bus2 = new Bus(25, 60, 50, 'F150');
$carshare1 = new CarSharing(4, 80, 20, 20);
$carshare2 = new CarSharing(4, 80, 20, 20);

$country = new Country('England', [$city, $city2]);

$city->cityTransport[] = $taxi1;
$city->cityTransport[] = $taxi2;
$city->cityTransport[] = $bus1;
$city->cityTransport[] = $bus2;
$city->cityTransport[] = $carshare1;
$city->cityTransport[] = $carshare2;

echo "Суммарная численность страны - " . $country->getName() . " - " . $country->SummaryPopulation() . PHP_EOL;
echo "Суммарная прибыль от городского транспорта в городе " . $city->getName() . " - " . $city->CityTransportProfit();

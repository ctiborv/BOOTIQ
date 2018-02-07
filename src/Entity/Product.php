<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $price;    
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;    
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $watchdog_activated;    
    

    
    public function getId() {
        return $this->id;
    }

    
    public function getColumn($column) {
        
        return $this->$column;
    }
    
        public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getWatchdog_activated() {
        return $this->watchdog_activated;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setWatchdog_activated($watchdog_activated) {
        $this->watchdog_activated = $watchdog_activated;
    }    
    
}

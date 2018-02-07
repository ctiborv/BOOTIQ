<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WatchdogRuleRepository")
 */
class WatchdogRule
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
    private $changed_column_name;  
    
     /**
      * < znamená pokud je položka menší než changed_column_value
      * - znamená zmenšení položky 
      * Z znamená jakákoliv změna
      * + znamená zvětšení položky
      * > znamená pokud je položka větší než changed_column_value
      * = znamená pokud je položka rovno changed_column_value
     * @ORM\Column(type="string", length=1)
     */
    private $changed_column_operation;  
    
     /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $changed_column_value;  
    
    public function getChanged_column_name() {
        return $this->changed_column_name;
    }

    public function getChanged_column_operation() {
        return $this->changed_column_operation;
    }

    public function getChanged_column_value() {
        return $this->changed_column_value;
    }

    public function setChanged_column_name($changed_column_name) {
        $this->changed_column_name = $changed_column_name;
    }

    public function setChanged_column_operation($changed_column_operation) {
        $this->changed_column_operation = $changed_column_operation;
    }

    public function setChanged_column_value($changed_column_value) {
        $this->changed_column_value = $changed_column_value;
    }

    public function getId() {
        return $this->id;
    }


    
}

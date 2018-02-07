<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WatchdogRepository")
 */
class Watchdog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_product;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_rule;

    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $changed_column_name;        


    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $old_value;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $new_value;
    

    
    
    public function getChanged_column_name() {
        return $this->changed_column_name;
    }

    public function getOld_value() {
        return $this->old_value;
    }

    public function getNew_value() {
        return $this->new_value;
    }

    public function setChanged_column_name($changed_column_name) {
        $this->changed_column_name = $changed_column_name;
    }

    public function setOld_value($old_value) {
        $this->old_value = $old_value;
    }

    public function setNew_value($new_value) {
        $this->new_value = $new_value;
    }

    public function setId_product($id_product) {
        $this->id_product = $id_product;
    }

        public function getId() {
        return $this->id;
    }

    public function setId_rule($id_rule) {
        $this->id_rule = $id_rule;
    }


    public function getId_product() {
        return $this->id_product;
    }

    public function getId_rule() {
        return $this->id_rule;
    }


    
    
}

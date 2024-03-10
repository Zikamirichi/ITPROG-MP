<?php
// Reference: https://www.w3schools.com/php/php_oop_constructor.asp 
//            https://stackoverflow.com/questions/14350803/how-to-use-a-php-class-from-another-file

class Order {

    public string $ordID;
    public int $quantity;
    public string $itemID;

    public function __construct($order) { // Constructor for Class

        $this-> ordID = $order;
    }

    public function getOrderID() { // Getters for Order Variables

        return $this-> ordID;
    }

    public function getQuantity() {

        return $this-> quantity;
    }

    public function getItemID() {

        return $this-> itemID;
    }

    public function setOrder($count, $item) {

        $this->quantity = $count;
        $this->itemID = $item;
    }

}

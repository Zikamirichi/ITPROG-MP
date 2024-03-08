<?php
// Reference: https://www.w3schools.com/php/php_oop_constructor.asp 
//            https://stackoverflow.com/questions/14350803/how-to-use-a-php-class-from-another-file

class Item {

    public int $itemID;
    public int $quantity;
    public string $category;

    public function __construct($id, $num) { // Constructor for Class

        $this-> itemID = $id;
        $this-> quantity = $num;
        $this-> setCategory($id);
    }

    public function getID() { // Getters for Item Variables

        return $this-> itemID;
    }

    public function getQuantity() {

        return $this-> quantity;
    }

    public function getCategory() {

        return $this-> category;
    }

    public function incrementQuantity($num) { // Increments by 1, to be used in buttons
        
        $this-> quantity = $num + 1;
    }

    public function decrementQuantity($num) {
        
        $this-> quantity = $num - 1;
    }

    public function setCategory($id) { // Automatically sets the category to mains
                                        // sides, drinks based on id number
        $digit = intval($id / 100); // Gets an integer single digit number

        switch ($digit) { // Test the digit computed against three cases.

            case '1':
                $this-> category = 'mains';
                break;
            case '2':
                $this-> category = 'sides';
                break;
            case '3':
                $this-> category = 'drinks';
                break;
            default:
                $this-> category = 'mains';
        }
    }
}

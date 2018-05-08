<?php

    class Device {
        public $name;
        public $prices;

        function __construct($name, $prices) {
            $this->name = $name;
            $this->prices = $prices;
        }
    
        function getName() {
            return $this->name;
        }
        function setName($name) {
            $this->name = $name;
        }
    
        function getPrices() {
            return $this->prices;
        }
        function setPrices($prices) {
            $this->prices = $prices;
        }
    }

?>
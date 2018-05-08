<?php

class Log {
    public $date;
    public $data;

    public function __construct() {
        $this->date = "";
        $this->data = [];
    }

    function getDate() {
        return $this->date;
    }
    function setDate($date) {
        $this->date = $date;
    }

    function getData() {
        return $this->data;
    }
    function setData($data) {
        $this->data = $data;
    }
}

?>
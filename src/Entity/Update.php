<?php

namespace App\Entity;

class Update{
    protected $device;

    public function getDevice(){
        return $this->device;
    }
    public function setDevice($device){
        $this->device = $device;
    }
}

?>
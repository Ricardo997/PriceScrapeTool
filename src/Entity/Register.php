<?php
namespace App\Entity;

class Register{

    protected $firstName;
    protected $lastName;
    protected $mail;
    protected $password;

    public function getFirstName(){
        return $this->firstName;
    }
    public function setFirstName($firstName){
        $this->mail = $firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function setLastName($lastName){
        $this->mail = $lastName;
    }
    public function getMail(){
        return $this->mail;
    }
    public function setMail($mail){
        $this->mail = $mail;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }

}
?>
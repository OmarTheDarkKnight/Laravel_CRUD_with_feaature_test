<?php

namespace App\Models;

class User{

    public  $first_name;
    public $another_name;
    public  function setName($firstName){

        $this->first_name = $firstName;


    }

    public function getName(){

        return $this->first_name;
    }



}

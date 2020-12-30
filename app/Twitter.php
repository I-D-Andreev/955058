<?php

namespace App;

class Twitter {
    private $key;
    public function __construct(){
        $key = "h66137231";
    }

    public function tweet(){
        return "Hello world111";
    }
}
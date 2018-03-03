<?php

error_reporting(E_ALL);

class A {

    public function __get($name = '') {
        return $name;
    }

}

///////////////////////////////////

$x = new A();

echo $x->super_puper;


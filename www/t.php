<?php

function f($n){
    
    echo $n . '---';
    
    if($n<=0){
        return 0;
    }
    return $n + f((int)($n/2));
}

echo f(4);
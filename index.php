<?php
include "Smath.php";

try{
    $smath = new Smath();

    echo $smath->exec("x²+6x+3");
    echo $smath->exec("(x-1)*(x+1)");
    echo $smath->exec("(x+2)*(x+2");
}catch(Exception $e){
    echo $e;
}
?>
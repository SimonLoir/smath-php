<?php
class Smath
{
    private $index = 0;
    private $byIndexes = [];
    private $byIndexes2 = [];

    public function exec($expression){
        if(strpos($expression, "(") === false){
            return $this->exec_and_sort($expression);
        }else{
            if($this->verify($expression)){
                //return $this->parseExp($expression);
            }else{
                return "Erreur de syntaxe";
            }
        }
    }

    private function exec_and_sort($expression){
        return "parser error";
    }
    /**
     * This method verfifies if the number of '(' is equal to the number of ')'
     * @param exp the expression that has to be verified
     */
    private function verify($exp){
        $o_count = 0;
        $c_count = 0;

        for ($i = 0; $i < strlen($exp); $i++) {
            $char = $exp[$i];
            if ($char == "(") {
                $o_count++;

            } else if ($char == ")") {
                $c_count++;
            }
        }

        if ($o_count == $c_count) {
            return true;
        } else {
            return false;
        }
    }
}

?>
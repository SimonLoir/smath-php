<?php
/**
 * @author Simon Loir 
 * @copyright 2017 Simon Loir
 * @license MIT
 * @package Smath
 */
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
                return $this->parseExp($expression);
            }else{
                return "Erreur de syntaxe";
            }
        }
    }
    /**
     * This function parses a mathematiocal expression and returns an array
     * @param expression the expression that has to be parsed by the metod
     */
    private function exec_and_sort($expression){
        

        
        //return "test";
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

    /**
     * This function parses an expression that contains parenthesis.
     * @param exp the expression that has to be parsed.
     */
    private function parseExp($exp){
        if ($exp[0] == "(") {
            $exp = "1*" . $exp;
        }

        $inside = "";
        $level = 0;
        for ($i = 0; $i < strlen($exp); $i++) {
            $char = $exp[$i];
            if ($char == "(") {
                $level++;
                if ($level == 1) {
                    $inside = "";
                } else {
                    $inside += "(";
                }
            } else if ($char == ")") {
                $level--;
                if ($level == 0) {
                    $this->index++;
                    $index = $this->index;
                    $this->byIndexes["$" + $index] = $this->exec($inside);
                    $this->byIndexes2["$" + $index] = $this->stringify($this->exec($inside));
                    $exp = str_replace('(' + $inside + ')', "$" + $index, $exp);
                } else {
                    $inside += ")";
                }
            } else {
                $inside += $char;
            }

        }

        var_dump($exp);

        return $this->exec($exp);
    }

    public function stringify ($array) {
        $text = "";

        $keys = array_keys($array);
        $new_keys = [];

        for ($i = 0; $i < sizeof($keys); $i++) {
            $element = $keys[$i];
            if ($element == "~") {

            } else {
                if (strpos($element, "x") == 0) {

                    if ($element == "x") {
                        array_push($new_keys,"1");
                    } else {
                        array_push($new_keys, str_replace("x^", "", $element));
                    }

                } else {
                    //console.log('Unknown error while parsing');
                }
            }

        }

        ksort($new_keys);
        
        $new_keys = array_reverse($new_keys);
        
        $keys = [];

        for ($i = 0; $i < sizeof($new_keys); $i++) {
            $key = $new_keys[$i];
            if ($key == "1") {
                array_push($keys, "x");
            } else {
                array_push($keys, 'x^' + $key);
            }
        }

        for ($i = 0; $i < sizeof($keys); $i++) {
            $element = $keys[i];
            if ($element == "~") {

            } else {
                if ($array[$element] != 1) {
                    $e = $array[$element] . "" . $element;

                } else {
                    $e = $element;
                }

                $text .= $e . "+";
            }

        }

        if (isset($array["~"])) {
            $text .= $array["~"];
        }

        $text = str_replace('x^2+', "x²+", $text);
        $text = str_replace('x^3+', "x³+", $text);
        $text = str_replace('+-', "-", $text);
        $text = str_replace('--', "+", $text);

        if (strlen($text)!=0 && $text[strlen($text) - 1] == "+") {
            $text .= "end";
            $text = str_replace('+end', "", $text);
        }

        if ($text == "x^2") {
            $text = "x²";
        }

        if ($text == "x^3") {
            $text = "x³";
        }

        if (isset($array["over"])) {
            $text = "(" . $text . ")/(" + $this->stringify($array["over"]) . ")";
        }

        return $text;
    }
}

?>
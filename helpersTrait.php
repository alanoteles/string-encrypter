<?php


trait helpersTrait
{
    /**
     * @param  String  $input    String to be checked
     * @return string
     * @throws Exception
     */
    private function checkAscii($input){

        $errors = [];
        $string = $this->splitchars($input);

        for ($x = 0; $x < count($string); $x++){

            if(ord($string[$x]) < 32 || ord($string[$x]) > 126){
                $errors[] = $string[$x];
            }

        }

        if(!empty($errors)){
            throw new Exception("The following characters are not allowed : " . implode(", ", $errors));
        }

        return $input;
    }



    private function calcPrimes($num){

        $primes = [];

        for($x = 0; count($primes) < $num; $x++){

            if($this->isPrime($x)){
                $primes[] = $x;
            }
        }

        return end($primes);
    }

    /**
     * @param  int  $num Number to be tested
     * @return boolean
     */
    private function isPrime($num) {

        if($num == 1)
            return false;

        if($num == 2)
            return true;

        if($num % 2 == 0) {
            return false;
        }

        $ceil = ceil(sqrt($num));

        for($i = 3; $i <= $ceil; $i += 2) {
            if($num % $i == 0)
                return false;
        }

        return true;
    }


    /**
     * @param  string  $str String to be splitted to array, including blank spaces.
     * @return array
     */
    private function splitchars($str){

        $arr = [];
        for($x = 0; $x < strlen($str); $x++){
            $arr[] = substr($str, $x, 1);
        }
        return $arr;
    }
}
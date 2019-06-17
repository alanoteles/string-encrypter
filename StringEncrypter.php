<?php

include('helpersTrait.php');


/**
 * 
 * The only valid input and output characters for all variables are from SPACE (character 32) 
 * through to TILDE (character 126). 
 * 
 * @author Alano Teles <alanoteles@gmail.com>
 * @param  String  $input    String to be encrypted/decrypted
 * @param  String  $key      Key value to be used on encryption/decryption
 * @return void
 * @throws InvalidArgumentException when $input are not using allowed ASCII chars.
 * @throws InvalidArgumentException when $key are not using allowed ASCII chars or is empty.
 */
class StringEncrypter
{

    use helpersTrait;

    private $inputData, $key;

    public function __construct(string $input, string $key)
    {
        $this->setInputData($input);
        $this->setKey($key);
    }


    
    public function setInputData($input){
        try{
            $this->inputData = $this->checkAscii($input);

        }catch (Exception $e){
            printf("\n" . 'Input string ERROR : ' . $e->getMessage() . "\n");
            die;
        }
    }



    public function setKey($key){
        try{
            $this->key = $this->checkAscii($key);

        }catch (Exception $e){
            printf("\n" . 'Encrypt/Decrypt key ERROR : ' . $e->getMessage() . "\n");
            die;
        }

    }



    /**
     * @param  string  $input String to be encrypted. Blank spaces are accepted.
     * @return string  String encrypted
     */
    public function encrypt(){

        $string      = $this->splitchars($this->inputData);
        $key         = $this->splitchars($this->key);
        $keyCounter  = 0;
        $codedString = "";


        for ($x = 0; $x < count($string); $x++){

            $n         = $x + ord($key[$keyCounter]);
            $primesResult   = $this->calcPrimes($n) + $x + ord($string[$x]);

            while($primesResult > 126){
                $primesResult = $primesResult - 95;
            }

            $codedString .= chr($primesResult);

            $keyCounter++;

            if($keyCounter > (count($key)-1)){
                $keyCounter = 0;
            }
        }

        return $codedString;

    }



    /**
     * @param  string  $input String to be decrypted. Blank spaces included.
     * @return string  String decrypted
     */
    public function decrypt(){
      
        $string      = $this->splitchars($this->inputData);
        $key         = $this->splitchars($this->key);
        
        $keyCounter  = 0;
        $codedString = "";
        $stringPos   = 0;

        for ($x = 0; $x < count($string); $x++){

            $n         = $x + ord($key[$keyCounter]);
            $primesResult   = $this->calcPrimes($n) + $x;

            $originalSum = ord($string[$x]);
            while($originalSum < ($primesResult + 32)){
                $originalSum += 95;
            }

            $charCode = chr($originalSum - $primesResult);
            $codedString .= $charCode;

            $keyCounter++;

            if($keyCounter > (count($key)-1)){
                $keyCounter = 0;
            }

        }

        return $codedString;

    }


}


// Ask user data to be encrypted
echo "Type the input string :\n";
fscanf(STDIN, "%[^\n]s", $textToEncrypt);

// Ask user the key to encrypt/decrypt data
echo "Type the encryption/decryption key :\n";
fscanf(STDIN, "%[^\n]s", $encryptionKey);

// Encrypts the informed string
$encryptObj = new StringEncrypter($textToEncrypt, $encryptionKey);
echo "Encrypted string : " . $encryptObj->encrypt() . "\n";

// Decrypts the encrypted string
$decryptObj = new StringEncrypter($encryptObj->encrypt(), $encryptionKey);
echo "Decrypted string : " . $decryptObj->decrypt() . "\n";

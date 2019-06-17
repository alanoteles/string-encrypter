## String encrypter/decrypter class

Class to encrypt and decrypt strings, including blank spaces.

To run it on command line, simply type ```php StringEncrypter.php``` 

You'll be asked to enter a string to be encrypted and a key to be used on encryption. The same key must be used to decrypt.

To instantiate on your code, just call :



````
$obj = new StringEncrypter($textToEncrypt, $encryptionKey);

$toEncrypt = $obj->encrypt();

$toEncrypt = $obj->decrypt();
````

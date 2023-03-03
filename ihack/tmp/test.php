<?php
use Nullix\CryptoJsAes\CryptoJsAes;
require 'vendor/autoload.php';



// decrypt
$code='test';
$password = "8eac4ee0790850314134f837b47dfd56";
$encrypted = @CryptoJsAes::encrypt($code,$password);
$decrypted = @CryptoJsAes::decrypt($encrypted, $password);

echo "Encrypted: " . $encrypted . "\n";
echo "Decrypted: " . print_r($decrypted, true) . "\n";
?>


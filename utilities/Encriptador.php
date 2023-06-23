<?php
/**
 * Clase para encriptar y desencriptar las contraseñas
 */
const SUBS_ALPHABET = "TZJCMFHQNDVROLYPUGXSWKBEIA";
class Encriptador{


    // Función de encriptación con método AES-128-ECB
    function encrypt($text){
        return openssl_encrypt($text, "AES-256-ECB", SUBS_ALPHABET);
    }

    // Función de des-encriptación con método AES-128-ECB
    function decrypt($text){
        return openssl_decrypt($text, "AES-256-ECB", SUBS_ALPHABET);
    }
}
?>


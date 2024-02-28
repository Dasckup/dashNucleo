<?php

namespace App\Http\Middleware;


class Cryptography{

    static public function decrypt($data){
        try {
            if(!$data||$data==null||$data=="") return false;
            $key = "988bac6ce7c9cdfbbffafe10";
            $iv = substr($data, 0, 16);
            $encrypted = substr($data, 16);
            $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
            return $decrypted;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function makePassword($tamanho) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $senha = '';
        $caracteresLength = strlen($caracteres);
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= $caracteres[rand(0, $caracteresLength - 1)];
        }
        return $senha;
    }

    public function encrypt($data){
        try {
            $iv = $this->makePassword(16);
            $key = "988bac6ce7c9cdfbbffafe10";
            $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
            $encryptedBase64 = $encrypted;
            $result = $iv . $encryptedBase64;

            return $result;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}

<?php

namespace App\Http\Middleware;


class Cryptography{

    static public function decrypt($data){
        try {
            $key = "988bac6ce7c9cdfbbffafe10";
            $iv = substr($data, 0, 16);
            $encrypted = substr($data, 16);
            $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
            return $decrypted;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}



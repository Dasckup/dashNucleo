<?php
namespace App\Http\Middleware;

class ZapBoss{

    private $receiver;
    private $message;

    public function to($receiver){
        $this->receiver = $receiver;
    }

    public function message($message){
        $this->message = $message;
    }

    public function send(){

        $curl = curl_init();

        curl_setopt_array($curl,
            array(
                CURLOPT_URL => 'https://app.zapboss24.com/api/create-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                'appkey' => 'f0a3c6ed-e236-4cb5-a5f6-e8e6e30422d7',
                'authkey' => 'jTjUo490I771cli5Ao79nmxXcbxWLZ3wN9GGFuJLa8tIogcOWg',
                'to' => $this->receiver,
                'message' => $this->message,
                'sandbox' => 'false'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}

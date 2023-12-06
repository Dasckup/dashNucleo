<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\ClientsFromAutoSave;
use App\Models\Events;
use App\Models\EventsGroups;
use App\Models\EventsIntentionSubmition;
use App\Models\RequestClientsStatus;
use App\Models\RequestsClients;
use App\Models\RequestsClientsDocuments;
use Illuminate\Http\Request;
use App\Http\Middleware\Cryptography;
use App\Http\Middleware\ZapBoss;
use App\Models\Alog;
use App\Models\EventsLog;
use App\Models\EventsLogMessageSended;
use App\Models\EventsLogUpdates;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index(){

        $eventsInProgress = Events::where('active', true)->with('groups')->get();
        $eventsInBlocked = Events::where('active', false)->with('groups')->get();

        return view('pages.events._index', [
            'eventsInProgress' => $eventsInProgress,
            'eventsInBlocked' => $eventsInBlocked
        ]);
    }

    public function store(Request $request){
        try{
            $eventGroups = EventsGroups::where('id', $request->to)->get();

            if(!$eventGroups){
                throw new \Exception('Grupo não encontrado');
            }

            $getDate = date('Y-m-d H:i:s', strtotime('+'.$request->send_on_date_amount.' '.$request->send_on_date));

            if($request->send_on_date==="hours"&&$request->comercial_time==="on"){
                $getDate = $this->jump_junkDays($request, $getDate);
            }elseif($request->send_on_date==="days"&&$request->only_bussines_days==="on"){
                $getDate = $this->jump_NotBusinessDay($getDate);
            }


            if($request->on_time_to_send==="on"&&$request->time_to_send){
                $getDate = date('Y-m-d', strtotime($getDate)) .' '. $request->time_to_send;
            }

            $event = new Events();
            $event->to = $request->to;
            $event->message = $request->message;
            $event->infinit = $request->infinit_mode==="on"?true:false;
            $event->active = true;
            $event->limit = $request->limit;
            $event->on = $getDate;
            $event->on_date = $request->send_on_date;
            $event->on_date_amount = $request->send_on_date_amount;
            $event->only_bussines_days = $request->only_bussines_days==="on"?true:false;
            $event->comercial_time = $request->comercial_time==="on"?true:false;

            if($request->on_time_to_send==="on"&&$request->time_to_send){
                $event->default_time = $request->time_to_send;
            }

            $event->save();

            if(($request->only_contact_returned||$request->only_not_contacted)&&$request->to=="2"){
                $eventGroupIntention = new EventsIntentionSubmition();
                $eventGroupIntention->events = $event->id;
                $eventGroupIntention->only_not_contact_returned = $request->only_contact_returned==="on"?true:false;
                $eventGroupIntention->only_intention_not_contacted = $request->only_not_contacted==="on"?true:false;
                $eventGroupIntention->only_send_per_level = $request->send_per_return_level==="on"?true:false;
                $eventGroupIntention->save();
            }

            $eventLog = new EventsLog();
            $eventLog->events = $event->id;
            $eventLog->message = 'Evento criado';
            $eventLog->success = true;
            $eventLog->save();

            return response()->json([
                'error' => false,
                'event' => $event->id,
                'message' => 'Evento criado com sucesso'
            ]);

        }catch (\Exception $e){
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }

    }

    private function obterFeriados() {
        $url = "https://date.nager.at/api/v3/publicholidays/" . date('Y') . "/BR";
        $feriados = json_decode(file_get_contents($url), true);
        return array_column($feriados, 'date');
    }

    private function jump_junkDays($request, $getDate){

        $dataAtual = date('Y-m-d H:i:s', strtotime($getDate));
        $feriados = $this->obterFeriados();

        while (in_array(date('Y-m-d', strtotime($dataAtual)), $feriados)) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 days'));
            $diaDaSemana = date('N', strtotime($dataAtual));

            if ($diaDaSemana == 6) {
                $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +2 days'));
            } elseif ($diaDaSemana == 7) {
                $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 day'));
            }

            $dataAtual = date('Y-m-d' , strtotime($dataAtual)) .' '. $request->horario_comercial_de ;
        }

        $diaDaSemana = date('N', strtotime($dataAtual));

        if ($diaDaSemana == 6) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +2 days'));
        } elseif ($diaDaSemana == 7) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 day'));
        }


        $dataAtualMais20Min = date('Y-m-d H:i:s', strtotime($dataAtual));
        $dataInicial = date('Y-m-d', strtotime($dataAtual)) . $request->horario_comercial_de;
        $dataFinal = date('Y-m-d', strtotime($dataAtual)) . $request->horario_comercial_ate;


        $horarioInicio = strtotime($dataInicial);
        $horarioFim = strtotime($dataFinal);
        $dataTimestamp = strtotime($dataAtual);

        if ($dataTimestamp < $horarioInicio || $dataTimestamp > $horarioFim) {
                if($dataTimestamp > $horarioFim){
                    $dataAtual = date('Y-m-d', strtotime($dataAtual . ' +1 day'));
                }else if($dataTimestamp < $horarioInicio){
                    $dataAtual = date('Y-m-d', strtotime($dataAtual));
                }

                while (in_array($dataAtual, $feriados)) {
                    $dataAtual = date('Y-m-d', strtotime($dataAtual . ' +1 day'));
                }

                $diaDaSemana = date('N', strtotime($dataAtual));

                if ($diaDaSemana == 6) {
                    $dataAtual = date('Y-m-d', strtotime($dataAtual . ' +2 days'));
                } elseif ($diaDaSemana == 7) {
                    $dataAtual = date('Y-m-d', strtotime($dataAtual . ' +1 day'));
                }

            $dataAtual = date('Y-m-d', strtotime($dataAtual)) .' '. $request->horario_comercial_de.':00' ;
        }else{
            $dataAtual = $dataAtualMais20Min;
        }

        return $dataAtual;
    }

    private function jump_NotBusinessDay($dataAtual){
        $feriados = $this->obterFeriados();

        while (in_array(date('Y-m-d', strtotime($dataAtual)), $feriados)) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 days'));
            $diaDaSemana = date('N', strtotime($dataAtual));

            if ($diaDaSemana == 6) {
                $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +2 days'));
            } elseif ($diaDaSemana == 7) {
                $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 day'));
            }

            $dataAtual = date('Y-m-d 12:00' , strtotime($dataAtual));
        }

        $diaDaSemana = date('N', strtotime($dataAtual));

        if ($diaDaSemana == 6) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +2 days'));
        } elseif ($diaDaSemana == 7) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 day'));
        }

        return date('Y-m-d 12:00:00' , strtotime($dataAtual));
    }

    public function submit(){


        $events = Events::
        whereBetween('on', [date('Y-m-d H:i:s', strtotime('-10 minutes')), date('Y-m-d H:i:s')])->
        where('active', true)->
        with('intentions')->
        with('events_business_hours')->
        get();

        $clientsList = [];

        foreach ($events as $event){
            try{
                if($event->limit&&!$event->infinit){
                    $event->limit = $event->limit - 1;
                    if($event->limit == 0){
                        $event->active = false;

                        $eventLog = new EventsLog();
                        $eventLog->events = $event->id;
                        $eventLog->message = 'Evento finalizado por limite de envios';
                        $eventLog->success = true;
                        $eventLog->save();
                    }
                }
                $getDate = date('Y-m-d H:i:s', strtotime('+'.$event->on_date_amount.' '.$event->on_date));

                if($event->on_date==="hours"&&$event->events_business_hours){
                    $getDate = $this->jump_junkDays(json_decode(json_encode([
                        "horario_comercial_de" => $event->events_business_hours->from,
                        "horario_comercial_ate" => $event->events_business_hours->to
                    ])), $getDate);
                }elseif($event->send_on_date==="days"&&$event->only_bussines_days){
                    $getDate = $this->jump_NotBusinessDay($getDate);

                    if($event->default_time){
                        $getDate = date('Y-m-d', strtotime($getDate)) .' '. $event->default_time;
                    }
                }

                $event->on = $getDate;
                $event->save();


                $clients = $this->getGroups($event);

                if(count($clients) == 0){
                    $eventLog = new EventsLog();
                    $eventLog->events = $event->id;
                    $eventLog->message = 'Nada a enviar';
                    $eventLog->success = true;
                    $eventLog->save();
                    continue;
                }else{
                    $eventLog = new EventsLog();
                    $eventLog->events = $event->id;
                    $eventLog->message = 'Evento enviado para ['.count($clients).'] clientes';
                    $eventLog->success = true;
                    $eventLog->save();

                    foreach($clients as $clientData){
                        $updateLog = new EventsLogMessageSended();
                        $updateLog->events = $event->id;
                        $updateLog->log = $eventLog->id;
                        $updateLog->name = $clientData['name'];
                        $updateLog->cellphone = $clientData['cellphone'];
                        $updateLog->message = $clientData['message'];
                        $updateLog->save();
                    }

                }
                array_push($clientsList, $clients);

            }catch(\Exception $e){
                $eventLog = new EventsLog();
                $eventLog->events = $event->id;
                $eventLog->message = 'Algo deu errado: '.$e->getMessage();
                $eventLog->success = false;
                $eventLog->save();
            }
        }

        $mergedArray = [];

        foreach ($clientsList as $subArray) {
            $mergedArray = array_merge_recursive($mergedArray, $subArray);
        }


        if(count($mergedArray) == 0){
            return response()->json([
                'success' => true,
                'message' => 'Nenhum evento encontrado'
            ]);
        }

        $curlHandles = [];
        $mh = curl_multi_init();


        foreach ($mergedArray as $clientData) {



            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://app.zapboss24.com/api/create-message',
                CURLOPT_RETURNTRANSFER => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'appkey' => 'f0a3c6ed-e236-4cb5-a5f6-e8e6e30422d7',
                    'authkey' => 'jTjUo490I771cli5Ao79nmxXcbxWLZ3wN9GGFuJLa8tIogcOWg',
                    'to' => $clientData['cellphone'],
                    'message' => $clientData['message'],
                    'sandbox' => 'false'
                )
            ));
            curl_multi_add_handle($mh, $curl);
            $curlHandles[] = $curl;
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        foreach ($curlHandles as $curl) {
            curl_multi_remove_handle($mh, $curl);
            curl_close($curl);
        }
        curl_multi_close($mh);

        return response()->json([
            'success' => true,
            'message' => 'Eventos enviados para processamento em segundo plano.'
        ]);
    }

    private function setValueSendTo($data,$message){
        $phoneNumber = preg_replace('/[^\d]/', '', $data->cellphone);
        $ddi = preg_replace('/[^\d]/', '', $data->ddi);
        $ddi = ltrim($ddi, '+');
        $name = explode(' ', $data->name)[0];

        if (!mb_check_encoding($name, 'UTF-8') && mb_check_encoding($name, 'ISO-8859-1')) {
            $name = mb_convert_encoding($name, 'UTF-8', 'ISO-8859-1');
        }

        $lowercaseName = mb_strtolower($name, 'UTF-8');
        $capitalizedName = ucwords($lowercaseName);

        $message = str_replace('{name}', $capitalizedName, $message);

        return [
            'message' => $message,
            'cellphone' => $ddi . $phoneNumber
        ];
    }

    public function getGroups($event){
        $sendTo = array();

        switch($event->to){
            case 1:
                $intentions = ClientsFromAutoSave::get();
                $clients = RequestsClients::get();
                if(isset($clients)){
                    foreach ($clients as $client) {
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->cellphone)){
                            continue;
                        }
                        array_push($sendTo, $this->setValueSendTo($client, $event->message));
                    }
                }
                if(isset($intentions)){
                    foreach ($intentions as $intention) {
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $intention->cellphone)||trim($intention->name)==""){
                            continue;
                        }
                        array_push($sendTo, $this->setValueSendTo($intention, $event->message));
                    }
                }
                return $sendTo;
            break;
            case 2:
                $intentions = ClientsFromAutoSave::where('status', 'intention')->with('contacts')->get();
                $eventsIntentionConfig = $event->intentions;
                if(isset($intentions)){
                    foreach($intentions as $key => $intention){
                        if($eventsIntentionConfig->only_not_contact_returned){
                            if($intention->returned){
                                continue;
                            }
                        }
                        if($eventsIntentionConfig->only_intention_not_contacted){
                            if($intention->contacts->count() > 0){
                                continue;
                            }
                        }

                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $intention->cellphone)||trim($intention->name)==""){
                            continue;
                        }

                        array_push($sendTo, $this->setValueSendTo($intention, $event->message));
                    }
                }
                return $sendTo;
            break;
            case 3:
                $clients = RequestClientsStatus::where('status', 'pendente')->with('clients')->get();
                if(isset($clients)){
                    foreach($clients as $key => $client){
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->clients->cellphone)){
                            continue;
                        }

                        array_push($sendTo, $this->setValueSendTo($client->clients, $event->message));
                    }
                }

                return $sendTo;
            break;
            case 4:
                $clients = RequestClientsStatus::where('status', 'atendido')->with('clients')->get();
                if(isset($clients)){
                    foreach($clients as $key => $client){
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->clients->cellphone)){
                            continue;
                        }

                        array_push($sendTo, $this->setValueSendTo($client->clients, $event->message));
                    }
                }

                return $sendTo;
            break;
            case 5:
                $clients = RequestClientsStatus::where('status', 'pago')->with('clients')->get();
                if(isset($clients)){
                    foreach($clients as $key => $client){
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->clients->cellphone)){
                            continue;
                        }

                        array_push($sendTo, $this->setValueSendTo($client->clients, $event->message));
                    }
                }

                return $sendTo;
            break;
            case 6:
                $clients = RequestClientsStatus::where('status', 'cancelado')->with('clients')->get();
                if(isset($clients)){
                    foreach($clients as $key => $client){
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->clients->cellphone)){
                            continue;
                        }

                        array_push($sendTo, $this->setValueSendTo($client->clients, $event->message));
                    }
                }

                return $sendTo;
            break;
            case 7:
                $clients = RequestsClientsDocuments::with('clients')->get();
                if(isset($clients)){
                    foreach($clients as $key => $client){
                        if(!preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->clients->cellphone)){
                            continue;
                        }

                        $birthday = Cryptography::decrypt($client->birthday);
                        if(date('d/m', strtotime($birthday)) != date('d/m')){
                            continue;
                        }

                        $cellphonesInSendTo = array_column($sendTo, 'cellphone');
                        $objClient = $this->setValueSendTo($client->clients, $event->message);

                        if (!in_array($objClient['cellphone'], $cellphonesInSendTo)) {
                            array_push($sendTo, $objClient);
                        }
                    }
                }
                return $sendTo;
            break;
        }
    }

    public function stop($event){
        if(!Auth::user()){
            return redirect()->back();
        }

        $event = Events::where('id', $event)->first();
        $event->active = false;
        $event->on = null;
        $event->save();

        $updateLog = new EventsLogUpdates();
        $updateLog->events = $event->id;
        $updateLog->user = Auth::user()->id;
        $updateLog->message = 'Evento parado por [#'.Auth::user()->id.' '.Auth::user()->name.']';
        $updateLog->save();

        return redirect()->back();
    }

    public function start($event){
        if(!Auth::user()){
            return redirect()->back();
        }

        $event = Events::where('id', $event)->first();
        $getDate = date('Y-m-d H:i:s', strtotime('+'.$event->on_date_amount.' '.$event->on_date));

        if($event->on_date==="hours"&&$event->events_business_hours){
            $getDate = $this->jump_junkDays(json_decode(json_encode([
                "horario_comercial_de" => $event->events_business_hours->from,
                "horario_comercial_ate" => $event->events_business_hours->to
            ])), $getDate);
        }elseif($event->send_on_date==="days"&&$event->only_bussines_days){
            $getDate = $this->jump_NotBusinessDay($getDate);
        }

        $event->on = $getDate;
        $event->active = true;
        $event->save();

        $updateLog = new EventsLogUpdates();
        $updateLog->events = $event->id;
        $updateLog->user = Auth::user()->id;
        $updateLog->message = 'Evento retomado por [#'.Auth::user()->id.' '.Auth::user()->name.']';
        $updateLog->save();

        return redirect()->back();
    }

    public function show($event){
        $event = Events::where('id', $event)->with('groups')->with('log')->with('log_updates')->first();

        return view('pages.events.show.index', [
            'event' => $event
        ]);
    }


    public function update(Request $request , $event){

        try{

            $event = Events::where('id', $event)->first();

            if(!$event){
                throw new \Exception('Evento não encontrado');
            }

            if($event->message !== $request->message){
                $serverLog = new Alog();
                $serverLog->user = Auth::user()->id;
                $serverLog->message = 'Mensagem do evento '.$event->id.' foi alterada por [#'.Auth::user()->id.' '.Auth::user()->name.']';
                $serverLog->ip = $_SERVER['REMOTE_ADDR'];
                $serverLog->save();

                $updateLog = new EventsLogUpdates();
                $updateLog->events = $event->id;
                $updateLog->user = Auth::user()->id;
                $updateLog->message = 'Mensagem foi alterada por [#'.Auth::user()->id.' '.Auth::user()->name.']';
                $updateLog->save();

                $event->message = $request->message;
            }

            $event->infinit = $request->infinit_mode==="on"?true:false;
            $event->limit = $request->limit;
            $event->on_date = $request->send_on_date;
            $event->on_date_amount = $request->send_on_date_amount;
            $event->only_bussines_days = $request->only_bussines_days==="on"?true:false;
            $event->comercial_time = $request->comercial_time==="on"?true:false;

            if(($request->only_contact_returned||$request->only_not_contacted)&&$event->to==2){
                $eventGroupIntention = EventsIntentionSubmition::where("event" , $event->id)->first();
                $eventGroupIntention->only_not_contact_returned = $request->only_contact_returned==="on"?true:false;
                $eventGroupIntention->only_intention_not_contacted = $request->only_not_contacted==="on"?true:false;
                $eventGroupIntention->only_send_per_level = $request->send_per_return_level==="on"?true:false;
                $eventGroupIntention->save();
            }

            $event->save();

            return redirect()->back()->with('success', 'Evento atualizado com sucesso');

        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Algo deu errado');
        }

    }
}



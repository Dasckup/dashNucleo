<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Cryptography;
use App\Models\Alog;
use App\Models\RequestClientsStatus;
use App\Models\RequestsClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ZapBoss;
use App\Models\ClientsFromAutoSave;
use App\Models\ContactClientsFromAutoSave;
use App\Models\User;

class ClientsController extends Controller
{
    public function index(){
        $clients = RequestsClients::with("submission")->with("status")->orderBy("created_at","DESC")->get();

        return view('pages.client.index', [
            "clients" => $clients
        ]);
    }

    public function update($id,$status){
        if(!Auth::check() || !Auth::user()["id"])
                return redirect()->route("login.index");

        $client = RequestClientsStatus::where("client", $id)->first();

        if(!$client){
            return redirect()->route("client.index");
        }

        switch ($status){
            case "pendente":
                $status = [
                    "status" => "pendente",
                    "bs" => "warning"
                ];
            break;
            case "cancelado":
                $status = [
                    "status" => "cancelado",
                    "bs" => "danger"
                ];
            break;
            case "pago":
                $status = [
                    "status" => "pago",
                    "bs" => "success"
                ];
            break;
            default:
                $status = [
                    "status" => "atendido",
                    "bs" => "info"
                ];
            break;
        }

        $saveInLog = new Alog();
        $saveInLog->user = Auth::user()["id"];
        $saveInLog->message = "Alterou o status do cliente [#".$id."] de: ".$client->status." para: ".$status["status"];
        $saveInLog->ip = $_SERVER['REMOTE_ADDR'];
        $saveInLog->save();

        $client->status = $status["status"];
        $client->bs = $status["bs"];
        $client->save();

        return redirect()->back();
    }

    public function updateStatus(Request $request){
        $user = User::where('id', $request["user"])->first();
        $client = RequestClientsStatus::where("client", $request["id"])->first();
        $status = $request["status"];


        if(!$client){
            return redirect()->route("client.index");
        }

        switch ($status){
            case "pendente":
                $status = [
                    "status" => "pendente",
                    "bs" => "warning"
                ];
            break;
            case "cancelado":
                $status = [
                    "status" => "cancelado",
                    "bs" => "danger"
                ];
            break;
            case "pago":
                $status = [
                    "status" => "pago",
                    "bs" => "success"
                ];
            break;
            default:
                $status = [
                    "status" => "atendido",
                    "bs" => "info"
                ];
            break;
        }

        $saveInLog = new Alog();
        $saveInLog->user = $user->id;
        $saveInLog->message = "Alterou o status do cliente [#".$client->id."] de: ".$client->status." para: ".$status["status"];
        $saveInLog->ip = $_SERVER['REMOTE_ADDR'];
        $saveInLog->save();

        $client->status = $status["status"];
        $client->bs = $status["bs"];
        $client->save();

        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }

    public function show($id){
        if(!Auth::user()){
            return redirect()->route("login.index");
        }

        $client = RequestsClients::where("id", $id)->with("material")->with("submission")->with("address")->with("status")->first();

        if(!$client){
            return redirect()->route("client.index")->withErrors(["error" => "Cliente não econtrado e/ou desativado"]);
        }

        return view('pages.client.show', [
            "client" => $client
        ]);
    }


    public function index_pendente(){
        $clients = RequestClientsStatus::where("status", "pendente")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Pendentes",
                "bg" => "warning"
            ]
        ]);
    }

    public function index_atendido(){
        $clients = RequestClientsStatus::where("status", "atendido")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Atendidas",
                "bg" => "info"
            ]
        ]);
    }

    public function index_pagas(){
        $clients = RequestClientsStatus::where("status", "pago")->with("clients")->orderBy("created_at","DESC")->get();
        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Pagas",
                "bg" => "success"
            ]
        ]);
    }

    public function index_cancelados(){
        $clients = RequestClientsStatus::where("status", "cancelado")->with("clients")->orderBy("created_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "Canceladas",
                "bg" => "danger"
            ]
        ]);
    }
    public function send_message_to_client(){
        return view('pages.client.whatsapp.index');
    }
    public function send_message_to_client_api(Request $request){
        $zapboss = new ZapBoss();
        $zapboss->to($request->to);
        $zapboss->message($request->message);

        $response = $zapboss->send();
        return redirect()->back();
    }

    public function sendMessageToNewClient(){
            $clientes = ClientsFromAutoSave::
                        with("contacts")
                        ->whereBetween('contact_on', [date('Y-m-d H:i:s', strtotime('-2 minutes')), date('Y-m-d H:i:s')])
                        ->get();

        if(count($clientes)>0){
            foreach($clientes as $client){
                if(count($client->contacts)==0){
                    $name = ucwords(strtolower(explode(' ',$client->name)[0]));
                    $numeroLimpo = preg_replace('/\D/', '', $client->ddi.' '.$client->cellphone);

                    $message = "Boa tarde, $name!
                    Somos da *Revista Científica Multidisciplinar Núcleo Do Conhecimento*, percebemos que você iniciou uma submissão de artigo científico mas não finalizou, você deseja publicar um artigo científico?";

                    $zapboss = new ZapBoss();
                    $zapboss->to($numeroLimpo);
                    $zapboss->message($message);
                    $response = $zapboss->send();

                    $dateContact = $this->validaDataContato(date('Y-m-d H:i:s'));

                    $clientsSaved = new ContactClientsFromAutoSave();
                    $clientsSaved->user = 5;
                    $clientsSaved->client = $client->id;
                    $clientsSaved->type = 5;
                    $clientsSaved->observation = "Mensagem enviada automaticamente pelo sistema";
                    $clientsSaved->date = date("Y-m-dTH:i");
                    $clientsSaved->save();

                    $client->bot_count = $client->bot_count + 1;
                }
            }
        }
    }


    public function sendMessageToNewClientSecondTime(){
        $inicioDoisDiasAtras = date('Y-m-d 00:00:00', strtotime('-2 days'));
        $fimDoisDiasAtras = date('Y-m-d 23:59:59', strtotime('-2 days'));

        $clientes = ClientsFromAutoSave::
              with("contacts")
            ->where('bot_count', 2)
            ->where('status', 'intention')
            ->where('returned', false)
            ->whereBetween('contact_on', [$inicioDoisDiasAtras, $fimDoisDiasAtras])
            ->get();

        if(count($clientes)>0){
            foreach($clientes as $client){
                if(count($client->contacts)==0){
                    $name = ucwords(strtolower(explode(' ',$client->name)[0]));
                    $numeroLimpo = preg_replace('/\D/', '', $client->ddi.' '.$client->cellphone);

                    $message = $this->getMessage($name, $client->bot_count);

                    $zapboss = new ZapBoss();
                    $zapboss->to($numeroLimpo);
                    $zapboss->message($message);
                    $response = $zapboss->send();
                    $dateContact = $this->validaDataContato(date('Y-m-d H:i:s'));

                    $clientsSaved = new ContactClientsFromAutoSave();
                    $clientsSaved->user = 5;
                    $clientsSaved->client = $client->id;
                    $clientsSaved->type = 5;
                    $clientsSaved->observation = "Mensagem enviada automaticamente pelo sistema pela segunda vez";
                    $clientsSaved->date = date("Y-m-dTH:i");
                    $clientsSaved->save();

                    $client->bot_count = $client->bot_count + 1;
                }
            }
        }
    }

    private function getMessage($name, $contact){
        switch($contact){
            case 1:
                return "Boa tarde, $name!
Somos da *Revista Científica Multidisciplinar Núcleo Do Conhecimento*, percebemos que você iniciou uma submissão de artigo científico mas não finalizou, você deseja publicar um artigo científico?";
            case 2:
                return "Boa tarde, $name!
Somos da *Revista Científica Multidisciplinar Núcleo Do Conhecimento*, percebemos que você iniciou uma submissão de artigo científico mas não finalizou, você deseja publicar um artigo científico?";
            case 3:
                return "Preciso de um posicionamento $name ainda tem interesse na publicação?";
            case 4:
                return "$name preciso de um retorno, ou seu ticket será encerrado";
            case 5:
                return "$name?";
            case 6:
                return "Esse é o penultimo contato, vamos seguir com sua publicação?";
            case 7:
                return "$name, estou encerrando o seu ticket dado a ausencia de resposta ";
            default:
                return "Boa tarde, $name!
Somos da *Revista Científica Multidisciplinar Núcleo Do Conhecimento*, percebemos que você iniciou uma submissão de artigo científico mas não finalizou, você deseja publicar um artigo científico?";
        }
    }




    private function obterFeriados() {
        $url = "https://date.nager.at/api/v3/publicholidays/" . date('Y') . "/BR";
        $feriados = json_decode(file_get_contents($url), true);
        return array_column($feriados, 'date');
    }

    private function validaDataContato($data) {
        $dataAtual = $data;
        $minutoAtual = date('i', strtotime($dataAtual));
        $feriados = $this->obterFeriados();

        while (in_array($dataAtual, $feriados)) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 day'));
        }

        $diaDaSemana = date('N', strtotime($dataAtual));

        if ($diaDaSemana == 6) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +2 days'));
        } elseif ($diaDaSemana == 7) {
            $dataAtual = date('Y-m-d H:i:s', strtotime($dataAtual . ' +1 day'));
        }

        $dataAtualMais20Min = date('Y-m-d H:i:s', strtotime($dataAtual . ' +20 minutes'));
        $dataInicial = date('Y-m-d', strtotime($dataAtual)) . ' 09:00';
        $dataFinal = date('Y-m-d', strtotime($dataAtual)) . ' 18:00';


        $horarioInicio = strtotime($dataInicial);
        $horarioFim = strtotime($dataFinal);
        $dataMais20MinTimestamp = strtotime($dataAtualMais20Min);

        if ($dataMais20MinTimestamp < $horarioInicio || $dataMais20MinTimestamp > $horarioFim) {

                if($dataMais20MinTimestamp > $horarioFim){
                    $dataAtual = date('Y-m-d', strtotime($dataAtual . ' +1 day'));
                }else if($dataMais20MinTimestamp < $horarioInicio){
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

            $minute = date('i', strtotime($data.' +20 minutes'));
            $dataAtual = date('Y-m-d', strtotime($dataAtual)) . ' 09:'.$minute ;
        }else{
            $dataAtual = $dataAtualMais20Min;
        }

        return $dataAtual;
    }

}

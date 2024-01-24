<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AwsS3;
use App\Http\Middleware\Cryptography;
use App\Models\Alog;
use App\Models\RequestClientsStatus;
use App\Models\RequestsClients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ZapBoss;
use App\Models\ClientsFromAutoSave;
use App\Models\ContactClientsFromAutoSave;
use App\Models\Products;
use App\Models\ProductsPrice;
use App\Models\RequestsClientsFiles;
use App\Models\RequestsClientsMaterial;
use App\Models\RequestsClientsNotes;
use App\Models\RequestsClientsSubmission;
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

        $statusData = [
            'pendente' => [
                'color' => 'warning',
                'title' => 'pendente',
            ],
            'atendidos' => [
                'color' => 'info',
                'title' => 'atendido',
            ],
            'pago' => [
                'color' => 'success',
                'title' => 'pago',
            ],
            'cancelados' => [
                'color' => 'danger',
                'title' => 'cancelado',
            ],
            'pagamento_pendentes' => [
                'color' => 'pink',
                'title' => 'pagamento_pendente',
            ],
            'cancelados' => [
                'color' => 'gray',
                'title' => 'cancelado',
            ],
        ];

        $statusKey = 'pendente';
        if (array_key_exists($statusKey, $statusData)) {
            $status = [
                'status' => $statusKey,
                'bs' => $statusData[$statusKey]['color'],
            ];
        } else {
            $status = [
                'status' => 'pendente',
                'bs' => 'warning',
            ];
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
        $client = RequestClientsStatus::where("article", $request["id"])->first();
        $status = $request["status"];


        if(!$client){
            return redirect()->route("client.index");
        }


        $statusData = [
            'pendente' => [
                'color' => 'warning',
                'title' => 'pendente',
            ],
            'aceito' => [
                'color' => 'info',
                'title' => 'aceito',
            ],
            'pago' => [
                'color' => 'success',
                'title' => 'pago',
            ],
            'recusado' => [
                'color' => 'danger',
                'title' => 'recusado',
            ],
            'pagamento_pendente' => [
                'color' => 'pink',
                'title' => 'pagamento pendente',
            ],
            'cancelado' => [
                'color' => 'gray',
                'title' => 'cancelado',
            ],
            'atendido' => [
                'color' => 'primary',
                'title' => 'atendido',
            ],
            'pendencias' => [
                'color' => 'red-light',
                'title' => 'pendências',
            ],
        ];



        $statusKey = $status;
        if (array_key_exists($statusKey, $statusData)) {
            $status = [
                'status' => $statusData[$statusKey]['title'],
                'bs' => $statusData[$statusKey]['color'],
            ];
        } else {
            $status = [
                'status' => 'pendente',
                'bs' => 'warning',
            ];
        }

        $saveInLog = new Alog();
        $saveInLog->user = $user->id;
        $saveInLog->message = "Alterou o status da submissão [#".$client->article."] de: ".$client->status." para: ".$status["status"];
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

        $material = RequestsClientsMaterial::where("id", $id)->with("file_all_version")->with("notes")->with("clients")->first();

        if(!$material){
            return redirect()->route("client.index")->withErrors(["error" => "Cliente não econtrado e/ou desativado"]);
        }

        return view('pages.client.show', [
            "material" => $material,
            "client" => $material->clients
        ]);
    }




    public function uploadMaterial(Request $request, $id){

        try{
            $client = RequestsClients::where("id", $id)->first();

            if(!$client){
                throw new \Exception("Cliente não encontrado");
            }

            $user = User::where("id", $request['user'])->first();

            $awsS3 = new AwsS3();
            $url = $awsS3->publish($request['name'].".".$request['type'], $request['file']);

            $lastFile = RequestsClientsFiles::where("clients", $client->id)->orderBy("created_at", "DESC")->first();

            $material = new RequestsClientsFiles();
            $material->user = $user->id;
            $material->article = $request['article'];
            $material->clients = $client->id;
            $material->url_material = $url;
            $material->extension = $request['type'];
            $material->size_material = $request['size'];
            $material->version = $lastFile ? $lastFile->version + 1 : 0;
            $material->label = $request['name'].".".$request['type'];
            $material->save();

            $awsS3 = new AwsS3();
            $url = $awsS3->getFile($material->url_material);

            return response()->json([
                'success' => true,
                'name' => $material->label,
                'user_name' => $user->name,
                'url' => $url
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }




    public function index_pendente(){
        $clients = RequestClientsStatus::where("status", "pendente")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "pendentes",
                "bg" => "warning"
            ]
        ]);
    }


    public function index_aceitos(){
        $clients = RequestClientsStatus::where("status", "aceito")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "aceitas",
                "bg" => "info"
            ]
        ]);
    }

    public function index_atendidos(){
        $clients = RequestClientsStatus::where("status", "atendido")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "em atendimento",
                "bg" => "primary"
            ]
        ]);
    }


    public function index_pagas(){
        $clients = RequestClientsStatus::where("status", "pago")->with("material")->orderBy("updated_at","DESC")->get();


        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "pagas",
                "bg" => "success"
            ]
        ]);
    }


    public function index_recusados(){
        $clients = RequestClientsStatus::where("status", "recusado")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "recusadas",
                "bg" => "danger"
            ]
        ]);
    }


    public function index_pagamento_pendentes(){
        $clients = RequestClientsStatus::where("status", "pagamento pendente")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "com pagamento pendente",
                "bg" => "pink"
            ]
        ]);
    }



    public function index_cancelados(){
        $clients = RequestClientsStatus::where("status", "cancelado")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "canceladas",
                "bg" => "gray"
            ]
        ]);
    }

    public function index_pendencias(){
        $clients = RequestClientsStatus::where("status", "pendencias")->with("material")->orderBy("updated_at","DESC")->get();

        return view('pages.client.index' , [
            "data" => $clients,
            "status" => [
                "title" => "com Pendencias",
                "bg" => "red-light"
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




    public function getAllSubmissions(){
        try{
            $routsStatus = [
                'pendente',
                'aceito',
                'atendido',
                'pago',
                'recusado',
                'pagamento pendente',
                'cancelado',
                'pendencias'
            ];

            $data = [];

            foreach ($routsStatus as $status) {
                $count = RequestClientsStatus::where('status', $status)->count();
                $data[$status] = $count;
            }

            $data['intention'] = ClientsFromAutoSave::count();
            $data['products'] = Products::count();
            $data['users'] = User::count();

            return response()->json([
                'success' => true,
                'submissions' => $data
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
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



    public function consult_term(Request $request){

        $client = RequestsClientsMaterial::where("id", $request["id"])->with('submission')->with('clients')->first();

        if(!$client){
            return response()->json([
                'success' => false,
            ]);
        }

        if(!$client->submission->term_publication_title){
            return response()->json([
                'success' => true,
                'client' => [
                    'name' => $client->clients->name,
                    'term' => false,
                ]
            ]);
        }else{
            return response()->json([
                'success' => true,
                'client' => [
                    'name' => $client->clients->name,
                    'term' => true,
                ]
            ]);
        }
    }

    public function updateSubmissionTerm(Request $request){

        try{

            $client = RequestsClientsMaterial::where("id", $request["id"])->first();
            //$user = User::where('id', $request["user"])->first();

            if(!$client){
                throw new \Exception("Cliente não encontrado");
            }

            $product = $this->getProduct($request["term"], $request["currency"]);

            $submission = RequestsClientsSubmission::where("client", $client->client)->first();
            $submission->term_publication_title = $product["title"]; // Linha do erro
            $submission->term_publication_price = $product["price"];
            $submission->save();

            $status = $request["status"];

            $statusData = [
                'pendente' => [
                    'color' => 'warning',
                    'title' => 'pendente',
                ],
                'aceito' => [
                    'color' => 'info',
                    'title' => 'aceito',
                ],
                'pago' => [
                    'color' => 'success',
                    'title' => 'pago',
                ],
                'recusado' => [
                    'color' => 'danger',
                    'title' => 'recusado',
                ],
                'pagamento_pendente' => [
                    'color' => 'pink',
                    'title' => 'pagamento pendente',
                ],
                'cancelado' => [
                    'color' => 'gray',
                    'title' => 'cancelado',
                ],
                'atendido' => [
                    'color' => 'primary',
                    'title' => 'atendido',
                ],
                'pendencias' => [
                    'color' => 'red-light',
                    'title' => 'pendências',
                ]
            ];


            $statusKey = $status;
            if (array_key_exists($statusKey, $statusData)) {
                $status = [
                    'status' => $statusData[$statusKey]['title'],
                    'bs' => $statusData[$statusKey]['color'],
                ];
            } else {
                $status = [
                    'status' => 'pendente',
                    'bs' => 'warning',
                ];
            }

            $client = RequestClientsStatus::where("article", $client->id)->first();
            $client->status = $status["status"];
            $client->bs = $status["bs"];
            $client->save();

            return response()->json([
                'success' => true,
                'status' => $status["status"]
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]
            ]);
        }

    }

    private function getProduct($id, $currency = "BRL"){
        $product = Products::where("id", $id)->first();
        $currency = ProductsPrice::where("product", $product->id)->where("currency", $currency)->first();

        return [
            "title" => $product->title ?? NULL,
            "price" => $currency->price." ".$currency->currency ?? NULL,
        ];
    }

    public function store_note(Request $request, $id){

        try{
            $article = RequestsClientsMaterial::where("id", $id)->first();
            $user = User::where('id', $request["user"])->first();

            if(!$article || !$user){
                throw new \Exception("Cliente não encontrado");
            }

            $note = new RequestsClientsNotes();
            $note->client = $article->client;
            $note->user = $user->id;
            $note->article = $article->id;
            $note->message = $request["message"];
            $note->save();

            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name,
                    'cover' => $user->cover
                ],
                'message' => $request["message"],
                'time' => date('d/m/Y \á\s H:i')
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }

    }
}

<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\RequestsClients;
use Exception;
use Illuminate\Http\Request;
use App\Http\Middleware\AwsS3;
use App\Http\Middleware\Cryptography as Cryptography;
use App\Models\RequestClientsStatus;
use App\Models\RequestsClientsAddress;
use App\Models\RequestsClientsArticleFiles;
use App\Models\RequestsClientsDescription;
use App\Models\RequestsClientsDocuments;
use App\Models\RequestsClientsFiles;
use App\Models\RequestsClientsMaterial;
use App\Models\RequestsClientsNotes;
use App\Models\RequestsClientsSubmission;
use App\Models\Status;
use App\Models\User;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = RequestsClients::
        with('notes')
        ->with('files')
        ->with('article')
        ->with('description')
        ->get();

        return view('pages.author.index' , [
            'authors' => $authors
        ]);
    }

    public function upload(Request $request, $id){
        try{
            $author = RequestsClients::find($id);
            if(!$author){
                throw new \Exception("Cliente não encontrado");
            }
            $user = User::where("id", $request['user'])->first();

            $awsS3 = new AwsS3();
            $url = $awsS3->publish($request['name'].".".$request['type'], $request['file']);

            $lastFile = RequestsClientsFiles::where("clients", $author->id)->orderBy("created_at", "DESC")->first();

            $material = new RequestsClientsFiles();
            $material->user = $user->id;
            $material->clients = $author->id;
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
                'url' => $url,
                'extension' => $material->extension
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $cryptography = new Cryptography();
            $awsS3 = new AwsS3();
            $urlPhoto = $awsS3->publish($request->filename_photo, $request->file_photo);

            $author = new RequestsClients();
            $author->name = $request->name;
            $author->last_name = $request->last_name;
            $author->email = $request->email;
            $author->ddi = $request->ddi;
            $author->cellphone = $request->cellphone;
            $author->cover = $urlPhoto;
            $author->save();

            $address = new RequestsClientsAddress();
            $address->client = $author->id;
            $address->zipcode = $request->zipcode;
            $address->city = $request->city;
            $address->state = $request->state;

            $description = new RequestsClientsDescription();
            $description->client = $author->id;
            $description->find_us = $request->where_finded;
            $description->area = $request->area;
            $description->save();

            if($request->on_brazil){
                $address->address = $cryptography->encrypt($request->address);
                $address->number = $cryptography->encrypt($request->number);
                $address->country = 'Brasil';
                $address->complement = $request->complement;
                $address->neighborhood = $request->neighborhood;
            } else {
                $address->addressline = $cryptography->encrypt($request->addressline1);
                $address->addressline2 = $cryptography->encrypt($request->addressline2);
                $address->country = $request->country;
            }

            $address->save();

            $document = new RequestsClientsDocuments();
            $document->client = $author->id;
            $document->birthday = $cryptography->encrypt($request->birthday);
            $document->is_valid = false;
            $document->is_complete = false;

            if($request->on_brazil){
                $document->document = null;
                $document->cpf = $cryptography->encrypt($request->cpf);
                $document->rg = $cryptography->encrypt($request->rg);
            } else {
                $document->rg = null;
                $document->cpf = null;
                $document->document = $cryptography->encrypt($request->document);
            }
            $document->save();

            if($request->with_submission){
                $urlSubmission = $awsS3->publish($request->filename_submission, $request->file_submission);
                $article = new RequestsClientsMaterial();
                $article->client = $author->id;
                $article->url_material = $urlSubmission;
                $article->name_material = $request->filename_submission;
                $article->size_material = $request->size_submission;
                $article->url_photo = $urlPhoto;
                $article->name_photo = $request->filename_photo;
                $article->size_photo = $request->size_photo;
                $article->save();

                $extension = explode(".", $request->filename_submission);
                $extension = end($extension);

                $files = new RequestsClientsArticleFiles();
                $files->article = $article->id;
                $files->clients = $author->id;
                $files->url_material = $urlSubmission;
                $files->label = $request->filename_submission;
                $files->size_material = $request->size_submission;
                $files->extension = $extension;
                $files->version = 0;
                $files->user = $request->user;
                $files->save();

                $dataSubmission = new RequestsClientsSubmission();
                $dataSubmission->client = $author->id;
                $dataSubmission->article = $article->id;
                $dataSubmission->find_us = $request->where_finded;
                $dataSubmission->area = $request->area;
                $dataSubmission->save();

                $firstStatus = Status::first();

                $status = new RequestClientsStatus();
                $status->client = $author->id;
                $status->article = $article->id;
                $status->status = $firstStatus->id;
                $status->save();

            }

            $this->saveOnLog('Cliente ' . $request->name . ' foi cadastrado');
            return response()->json([
                'success' => true,
                'id' => $author->id,
                'link' => route('author.show', $author->id)
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store__note(Request $request, $id)
    {

        try{
            $author = RequestsClients::where("id", $id)->first();
            $user = User::where('id', $request["user"])->first();

            if(!$author || !$user){
                throw new \Exception("Cliente não encontrado");
            }

            $note = new RequestsClientsNotes();
            $note->client = $author->id;
            $note->user = $user->id;
            $note->message = $request["message"];
            $note->save();

            return response()->json([
                'success' => true,
                'user' => [
                    'name' => $user->name,
                    'cover' => photo_user($user->cover)
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $author = RequestsClients::
            with('notes')
            ->with('files')
            ->with('submission')
            ->with('status')
            ->with('address')
            ->with('material')
            ->with('document')
            ->with('article')
            ->find($id);

            if(!$author)
                throw new Exception('Cliente não encontrado');
            return view('pages.author.show', [
                'author' => $author
            ]);
        } catch (\Exception $e) {
            return redirect()->route('author.index')->with('error', 'Erro ao buscar cliente');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update__information(Request $request, $id)
    {
        try{
            $author = RequestsClients::find($id);

            if(!$author)
                throw new Exception('Cliente não encontrado');

            $author->name = $request->name;
            $author->last_name = $request->last_name;
            $author->email = $request->email;
            $author->ddi = $request->ddi;
            $author->cellphone = $request->cellphone;
            $author->save();

            $this->saveOnLog('Informações do cliente ' . $request->name . ' foram atualizadas');
            return response()->json([
                'success' => true,
                'name' => $request->name,
                'last_name' => $request->last_name,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update__address(Request $request, $id)
    {
        try {
            $author = RequestsClients::with('address')->findOrFail($id);
            $address = $author->address()->firstOrNew([]);
            $address->zipcode = $request->zipcode;

            $cryptography = new Cryptography();

            if ($request->from_brazil) {
                $fill = [
                    'address' => $cryptography->encrypt($request->address),
                    'number' => $cryptography->encrypt($request->number),
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => 'Brasil',
                    'complement' => $request->complement,
                    'neighborhood' => $request->neighborhood,
                    'addressline' => null,
                    'addressline2' => null,
                ];
            } else {
                $fill = [
                    'city' => $request->international_city,
                    'state' => $request->international_state,
                    'country' => $request->international_country,
                    'addressline' => $cryptography->encrypt($request->addressline1),
                    'addressline2' => $cryptography->encrypt($request->addressline2),
                    'complement' => null,
                    'number' => null,
                    'neighborhood' => null,
                    'address' => null,
                ];
            }
            $address->fill($fill);
            $address->save();

            $this->saveOnLog('Endereço do cliente ' . $author->name . ' foi atualizado');
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update__documentation(Request $request, $id)
    {
        try{

            $author = RequestsClients::with('document')->findOrFail($id);
            if(!$author)
                throw new Exception('Cliente não encontrado');

            $cryptography = new Cryptography();

            $document = $author->document;
            $document->birthday = $cryptography->encrypt($request->birthday);
            $document->is_valid = false;
            $document->is_complete = false;

            if(!$request->international_doc){
                $document->document = null;
                $document->cpf = $cryptography->encrypt($request->cpf);
                $document->rg = $cryptography->encrypt($request->rg);
            } else {
                $document->rg = null;
                $document->cpf = null;
                $document->document = $cryptography->encrypt($request->document);
            }

            $document->save();

            $this->saveOnLog('Documentação do cliente ' . $author->name . ' foi atualizada');
            return response()->json([
                'success' => true
            ]);
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function saveOnLog($message){
        try{
            $log = new \App\Models\Alog();
            $log->user = auth()->user()->id;
            $log->message = $message;
            $log->ip = request()->ip();
            $log->save();
            return $log;
        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function enable($id)
    {
        //
    }

    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
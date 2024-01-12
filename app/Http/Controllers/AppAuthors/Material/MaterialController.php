<?php

namespace App\Http\Controllers\AppAuthors\Material;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AwsS3;
use App\Models\AuthorAccess;
use App\Models\ClientsProccess;
use App\Models\CommentsEditorsProccess;
use App\Models\CommentsEditorsProccessUpload;
use App\Models\CommentsEditorsReportUser;
use App\Models\Editors;
use App\Models\OptionsUsersReports;
use App\Models\RequestsClientsFiles;
use App\Models\RequestsClientsMaterial;
use App\Models\RequestsClientsSubmission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function show($id){

        $process = ClientsProccess::where('id', $id)->with('material_content')->with('verdict')->with('author')->with('analysis')->first();
        $process->deadline = date('d/m/Y', strtotime($process->created_at. ' + '.$process->deadline_amount.' '.$process->deadline_type));

        return view('authors.pages.material.show', [
            "process" => $process,
        ]);
    }

    public function comment_store(Request $request){
        try{
            $request->validate([
                'message' => 'required|string|max:355',
                'to' => 'required',
            ]);

            $analysisId = $request['to'];

            $commentsEditors = CommentsEditorsProccess::where('id', $analysisId)->first();

            $process = ClientsProccess::where('id', $commentsEditors->process)->first();

            if(!$commentsEditors){
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao enviar comentário!',
                ]);
            }

            $newRequestMaterial = false;

            $response = new CommentsEditorsProccess();
            $response->process = $commentsEditors->process;
            $response->message = $request['message'];
            $response->check = false;
            $response->response_to = $commentsEditors->id;
            $response->save();


            if($request['material']){
                $aws = new AwsS3();
                $url = $aws->publish($request['material_name'], $request['material']);

                $requestMaterial = RequestsClientsFiles::where('clients', $process->clients)->orderBy('created_at', 'DESC')->first();
                $newRequestMaterial = new RequestsClientsFiles();
                $newRequestMaterial->article = $requestMaterial->article;
                $newRequestMaterial->clients = $requestMaterial->clients;
                $newRequestMaterial->url_material = $url;
                $newRequestMaterial->label = $request['material_name'];
                $newRequestMaterial->size_material = $request['material_size'];
                $newRequestMaterial->extension = $request['material_extension'];
                $newRequestMaterial->version = (int)$requestMaterial->version+1;
                $newRequestMaterial->save();

                $uploadComments = new CommentsEditorsProccessUpload();
                $uploadComments->comments = $response->id;
                $uploadComments->name = $request['material_name'];
                $uploadComments->size = $request['material_size'];
                $uploadComments->extension = $request['material_extension'];
                $uploadComments->url = $url;
                $uploadComments->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Comentário enviado com sucesso!',
                'comment' => [
                    'id' => $response->id,
                    'message' => $response->message,
                    'created_at' => $response->created_at->format('d/m/Y H:i:s'),
                    'editor' => $response->editor,
                    'check' => $response->check,
                    'response_to' => $response->response_to,
                ],
                'material_url' => isset($newRequestMaterial->url_material)?AwsS3::getFile($newRequestMaterial->url_material) ?? null : false,
                'material' => $newRequestMaterial ?? null,
            ]);

        }catch (\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function report_store(Request $request, $process){
        try{
            $request->validate([
                'report' => 'required',
                'to' => 'required',
                'editor' => 'required',
                'author' => 'required'
            ]);

            $process = ClientsProccess::where('id', $process)->first();

            $comment = CommentsEditorsProccess::where('id', $request['to'])->first();
            $editor = Editors::where('id', $request['editor'])->first();
            $author = AuthorAccess::where('id', $request['author'])->first();

            if(!$process || !$comment || !$editor || !$author){
                throw new Exception('Erro ao enviar relatório!');
            }

            $newReport = new CommentsEditorsReportUser();
            $newReport->editor = $editor->id;
            $newReport->process = $process->id;
            if($request['report']!=="outer"){
                $report = OptionsUsersReports::where('id', $request['report'])->first();
                if(!$report){
                    throw new Exception('Erro ao enviar relatório!');
                }
                $newReport->report = $report->id;
            }else{
                if(trim($request['report_description'])==""){
                    throw new Exception('Erro ao enviar relatório!');
                }
                $newReport->description_case = $request['report_description'];
            }
            $newReport->comment = $comment->id;
            $newReport->author = $author->id;
            $newReport->save();

            return response()->json([
                'success' => true,
                'message' => 'Relatório enviado com sucesso!',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function comment_mark(Request $request, $process){
        try{
            $request->validate([
                'mark' => 'required',
            ]);

            $process = ClientsProccess::where('id', $process)->first();

            if(!$process){
                throw new Exception('Erro ao marcar comentário!');
            }

            $comment = CommentsEditorsProccess::where('id', $request['mark'])->first();

            if(!$comment){
                throw new Exception('Erro ao marcar comentário!');
            }

            $comment->check = true;
            $comment->save();

            return response()->json([
                'success' => true,
                'message' => 'Comentário marcado com sucesso!',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}

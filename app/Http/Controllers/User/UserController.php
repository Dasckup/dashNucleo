<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alog;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile(){
        $auth = Auth::user();
         return view('pages.user.profile.show', [
             "auth" => $auth
         ]);
    }

    public function index(){
        $users = User::with('permissions')->get();
        return view('pages.user.index', [
            "users" => $users

        ]);
    }

    public function show($id){
        $auth = User::with('permissions')->find($id);
        $roles = Permission::all();
        return view('pages.user.show', [
            "auth" => $auth,
            "roles" => $roles
        ]);
    }

    public function create(){
        return "";
    }

    public function changeStatus(Request $request){
        try{
            $author = User::find($request->_user);
            $user = User::find($request->id);
            $status = (int)$request->status;

            if(!$author || !$user){
                throw new \Exception("Usuário não encontrado");
            }

            if($author->id == $user->id){
                throw new \Exception("Você não pode alterar o seu próprio status");
            }

            if($status!=1 && $status!=0){
                throw new \Exception("Você não tem permissão para alterar o status de um usuário");
            }

            $user->active = $status;
            $user->save();

            return response()->json([
                "success" => true,
                "message" => "Status alterado com sucesso"
            ]);

        }catch(\Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $author = User::where("id", $request->user)->first();
            $nomeArquivo = null;

            if ($request->hasFile('fileInputPhotoUser')) {
                $nameWithoutSpecialChars = preg_replace('/[^a-zA-Z0-9]/', '', $request->name);
                $extension = $request->file('fileInputPhotoUser')->getClientOriginalExtension();
                $nomeArquivo = 'avatar_' . $nameWithoutSpecialChars.'_'.sha1(uniqid()).'.' . $extension;

                $caminho = $request->file('fileInputPhotoUser')->storeAs('users/avatars', $nomeArquivo);
            }

            if (!$author) {
                throw new \Exception("Usuário não encontrado");
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->active = 1;
            $user->cover = $nomeArquivo;
            $user->save();
            $user->assignPermission($request->role);
            $this->saveOnLog('Usuário [#'.$user->id.' '.$user->name.'] cadastrado no sistema com a função ['.$request->role.']', $author->id);

            return response()->json([
                "success" => true,
                "message" => "Usuário cadastrado com sucesso"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function update($id, Request $request){
        return response()->json($request);
        try{
            $user = User::find($id);
            $auth = User::find($request->user);
            if(!$user || !$auth){
                throw new \Exception("Usuário não encontrado");
            }

            if ($request->hasFile('fileInputPhotoUser')) {
                $nameWithoutSpecialChars = preg_replace('/[^a-zA-Z0-9]/', '', $request->name);
                $extension = $request->file('fileInputPhotoUser')->getClientOriginalExtension();
                $nomeArquivo = 'avatar_' . $nameWithoutSpecialChars.'_'.sha1(uniqid()).'.' . $extension;
                $user->cover = $nomeArquivo;
                $caminho = $request->file('fileInputPhotoUser')->storeAs('users/avatars', $nomeArquivo);
            }

            $user->name = $request->name;
            $user->email = $request->email;

            if($request->password){
                $user->password = bcrypt($request->password);
            }

            $this->saveOnLog('Usuário [#'.$user->id.' '.$user->name.'] atualizado no sistema', $auth->id);

        }catch(\Exception $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    private function saveOnLog($message, $user){
        try{
            $log = new Alog();
            $log->user = $user;
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

}
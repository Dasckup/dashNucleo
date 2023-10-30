<?php
namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Alog;

class LoginController extends Controller
{
    public function index(){
        if(auth()->check()){
            return redirect()->route("home");
        }
        return view("pages.login.index");
    }

    public function store(Request $request){
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ], [
                'email.required' => 'Esse campo de email é obrigatório',
                'email.email' => 'Esse campo de email deve ser válido',
                'password.required' => 'Esse campo de senha é obrigatório',
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if(!$user){
                return redirect()->route('login.index')->withErrors(['error' => 'Não encontramos nenhum usuário com esse email']);
            }

            if(!Hash::check($request->input('password'), $user->password)){
                return redirect()->route('login.index')->withErrors(['error' => 'Não encontramos nenhum usuário com esses dados']);
            }

            if($request->filled('remember')){
                Auth::login($user, true);
                Auth::guard('web')->viaRemember((1.440*7)); // 7 dias
            } else {
                Auth::login($user);
                Auth::guard('web')->viaRemember(1.440); // 24 horas
            }

            $saveInLog = new Alog();
            $saveInLog->user = Auth::user()["id"];
            $saveInLog->message = "O usuário [#".$user->id." ".$user->name."] fez login";
            $saveInLog->ip = $_SERVER['REMOTE_ADDR'];
            $saveInLog->save();

            return redirect()->route('home');
        }catch(\PDOException $pdoException){
            return redirect()->route('login.index')->withErrors(['error' => 'Não conseguimos processar o seu login, consulte o suporte tecnico e/ou tente novamente mais tarde']);
        }
    }

    public function destroy(){
        Auth::logout();
        return redirect()->route("login.index");
    }
}

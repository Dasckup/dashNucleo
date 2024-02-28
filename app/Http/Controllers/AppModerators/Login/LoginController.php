<?php

namespace App\Http\Controllers\AppModerators\Login;

use App\Http\Controllers\Controller;
use App\Models\Alog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(auth('moderatorAccess')->check()){
            return redirect()->route("AppModerator.home");
        }
        return view("moderator.pages.login.index");
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Esse campo de email é obrigatório',
                'email.email' => 'Esse campo de email deve ser válido',
                'password.required' => 'Esse campo de senha é obrigatório',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::guard('moderatorAccess')->attempt($credentials, $request->filled('remember')))
            {
                $user = Auth::guard('moderatorAccess')->user();

                $saveInLog = new Alog();
                $saveInLog->user = $user->id;
                $saveInLog->message = "O editor [#".$user->id." ".$user->name."] fez login";
                $saveInLog->ip = request()->ip();
                $saveInLog->save();

                return redirect()->route('AppModerator.home');
            } else {
                return redirect()->route('AppModerator.login.index')->withErrors(['error' => 'Credenciais inválidas.']);
            }
        } catch (\PDOException $pdoException) {
            return redirect()->route('AppModerator.login.index')->withErrors(['error' => 'Não conseguimos processar o seu login, consulte o suporte técnico e/ou tente novamente mais tarde']);
        }
    }


    public function destroy(){
        Auth::guard('moderatorAccess')->logout();
        return redirect()->route("AppModerator.login.index");
    }

}

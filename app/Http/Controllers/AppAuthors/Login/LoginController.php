<?php

namespace App\Http\Controllers\AppAuthors\Login;

use App\Http\Controllers\Controller;
use App\Models\Alog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(auth('authorAccess')->check()){
            return redirect()->route("AppAuthor.home");
        }
        return view("authors.pages.login.index");
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'Esse campo de email é obrigatório',
                'email.email' => 'Esse campo de email deve ser válido',
                'password.required' => 'Esse campo de senha é obrigatório',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::guard('authorAccess')->attempt($credentials, $request->filled('remember'))) {
                $user = Auth::guard('authorAccess')->user();

                $saveInLog = new Alog();
                $saveInLog->user = auth()->id();
                $saveInLog->message = "O autor [#".$user->id." ".$user->name."] fez login";
                $saveInLog->ip = request()->ip();
                $saveInLog->save();

                return redirect()->route('AppAuthor.home');
            } else {
                return redirect()->route('AppAuthor.login.index')->withErrors(['error' => 'Credenciais inválidas.']);
            }
        } catch (\PDOException $pdoException) {
            return redirect()->route('AppAuthor.login.index')->withErrors(['error' => 'Não conseguimos processar o seu login, consulte o suporte técnico e/ou tente novamente mais tarde']);
        }
    }

    public function destroy(){
        Auth::guard('authorAccess')->logout();
        return redirect()->route("AppAuthor.login.index");
    }
}

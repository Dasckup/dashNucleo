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
        if(auth('dashboard')->check()){
            return redirect()->route("home");
        }
        return view("pages.login.index");
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

            if (Auth::guard('dashboard')->attempt($credentials, $request->filled('remember'))) {
                $user = Auth::guard('dashboard')->user();

                $saveInLog = new Alog();
                $saveInLog->user = auth()->id();
                $saveInLog->message = "O usuário [#".$user->id." ".$user->name."] fez login";
                $saveInLog->ip = request()->ip();
                $saveInLog->save();

                return redirect()->route('home');
            } else {
                return redirect()->route('login.index')->withErrors(['error' => 'Credenciais inválidas.']);
            }
        } catch (\PDOException $pdoException) {
            return redirect()->route('login.index')->withErrors(['error' => 'Não conseguimos processar o seu login, consulte o suporte técnico e/ou tente novamente mais tarde']);
        }
    }

    public function destroy(){
        Auth::guard('dashboard')->logout();
        return redirect()->route("login.index");
    }
}

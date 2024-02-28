<?php

namespace App\Http\Controllers\AppAuthors\User;

use App\Http\Controllers\Controller;
use App\Models\AuthorAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::guard('authorAccess')->user();
        return view('authors.pages.user.show', [
            'user' => $user
        ]);
    }


    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = Auth::guard('authorAccess')->user();
        $user = AuthorAccess::find($user->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != null){
            if($request->password == $request->password_confirmation){
                $user->password = bcrypt($request->password);
            }
        }
        $user->save();

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }
}

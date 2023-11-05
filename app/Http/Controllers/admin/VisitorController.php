<?php

namespace App\Http\Controllers\admin;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;

class VisitorController extends Controller
{
    public function switch(User $user){
        $user->level = User::EMPRESA_LEVEL;
        $user->save();
        return redirect(route("visitors"))->with("msg", "Nível de acesso de " . $user->name . " foi modificado!");
    }

    public function destroy(User $user){
        if($user->news->count() > 0){
            return redirect()->back()->with("msgdanger","Não é possível excluir este visitante porque há notícias pertencentes a ele.");
        }else{
            $user->delete();  
            return redirect(route("visitors"))->with("msg","Usuário excluído!");
        }
    }
}

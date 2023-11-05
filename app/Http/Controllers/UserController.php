<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    
    public function verifyEmail($email){
        $validator = Validator::make(["email"=>$email], ["email"=>"email"]);
    
        $resp = ["validated"=>true, "exists"=>false];
        if ($validator->fails())
            $resp["validated"] = false;
    
        $user = User::where(["email"=>$email])->first();
        if ($user != null)
            $resp["exists"] = true;
       
        return response()->json($resp);
    }
    

}

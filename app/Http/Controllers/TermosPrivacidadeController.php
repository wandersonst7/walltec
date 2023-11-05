<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermosPrivacidadeController extends Controller
{
    public function index(Request $request)	{
		
		return view("terms_privacy");
		
	}
}

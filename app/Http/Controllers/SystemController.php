<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class SystemController extends Controller
{
    public function companies(Request $request){
        $empresa_level = User::EMPRESA_LEVEL;
        $companies = User::orderBy('name')->where('level', $empresa_level);

        if (isset($request->name)){
            $companies->where("name","like","%$request->name%");
        }

        return view("admin/companies", ["companies"=>$companies->paginate(10)]);
    }

    public function visitors(Request $request){
        $default_level = User::DEFAULT_LEVEL;
        $visitors = User::orderBy('name')->where('level', $default_level);

        if (isset($request->name)){
            $visitors->where("name","like","%$request->name%");
        }

        return view("admin/visitors", ["visitors"=>$visitors->paginate(10)]);
    }

    public function profile(Request $request){
        return view("admin/profile");
    }

    public function categories(Request $request){
        $categoryList = Category::orderBy('name_category');

        if (isset($request->name_category)){
            $categoryList->where("name_category","like","%$request->name_category%");
        }

        return view("admin/categories", ["categoryList"=>$categoryList->paginate(10)]);
    }
    
}

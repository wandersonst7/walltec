<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\HomeController;
use App\Models\User;
use App\Models\News;
use App\Models\CategoryNews;

class CategoryController extends Controller
{
    public function index(Request $request){
        $data = Category::orderBy('created_at', 'DESC')->paginate(0);
        return view("categories",  ["data"=>$data]);
    }

    public function create(){
        $newsList = News::all();
        return view("admin.categories.form", ["data"=>new Category(),
                                            "newsList"=>$newsList]);
    }

    public function store(Request $request){
        $validated = $this->validator($request)->validate();
        $category = new category;
        $category->name_category = $request->name_category;
        $category->user_id = Auth::user()->id; 
        $category->save();
        return redirect(route("categories.update", $category))->with("msg","Salva com sucesso!");
    }
    
    public function destroy(Category $categories){
        if($categories->manynews->count() > 0){
            return redirect()->back()->with("msgdanger","Não é possível apagar a categoria porque ela está vinculada a uma notícia!");
        }else{
            $categories->delete();  
            return redirect(route("categories"))->with("msg","Apagada com sucesso!");
        }
    }

    public function edit(Category $categories){
        $newsList = News::all();
        return view("admin.categories.form",["data"=>$categories,
        "newsList"=>$newsList]);
    }

    public function update(Category $categories, Request $request) {
        $validated = $this->validator($request)->validate();
        $categories->update($request->all());
        return redirect()->back()->with("msg","Atualizada com sucesso!");
    }
    
    public function validator(Request $request){

        $rules = [
            'name_category' => 'required|max:15',
        ];
    
    
        return Validator::make($request->all(), $rules);
    }

}

<?php

namespace App\Http\Controllers\admin;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\HomeController;
use Illuminate\Support\Facades\Validator;
use App\Models\Coment;
use App\Models\News;
use App\Models\Category;
use App\Models\CategoryNews;
use App\Models\User;

class NewsController extends Controller
{
    public function index(Request $request){
        $admin_user = User::ADMIN_LEVEL;
        $empresa_user = User::EMPRESA_LEVEL;

        if(Auth::user()->level == $admin_user){
            $data = News::orderBy('created_at', 'DESC');
            if (isset($request->title)){
                $data->where("title","like","%$request->title%");
            }
        }else if(Auth::user()->level == $empresa_user){
            $data = News::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC');
            if (isset($request->title)){
                $data->where("title","like","%$request->title%");
            }
        }
        
        return view("dashboard", ['data'=>$data->paginate(10), "admin_user"=>$admin_user]);
    }

    public function create(){
        $categoryList = Category::all();
        return view("admin.news.form", ["data"=>new News(), "categoryList"=>$categoryList]);
    }

    public function store(Request $request){
        $validated = $this->validator($request)->validate();
        $data = $this->armazenaImagem($request);
        $data["user_id"] = Auth::user()->id;
        $news = News::create($data);

        // Users
        $admin_user = User::ADMIN_LEVEL;

        #RELACIONAMENTO
        if(Auth::user()->level == $admin_user){
            $category = Category::find($request["category_id"]);
            if ($category != null){
                CategoryNews::create(["news_id"=>$news->id,"category_id"=>$category->id]);
            }
        }else{
            $category = Category::select("categories.id")->where("name_category", "Empregos")->get();
            CategoryNews::create(["news_id"=>$news->id,"category_id"=>$category[0]->id]);
        }

        return redirect(route("news.edit", $news))->with("msg","Salva com sucesso!");
    }
    
    public function destroy(News $news){
        $category_news = CategoryNews::where('news_id', $news->id);
        $news->delete();  
        $category_news->delete();
        return redirect(route("dashboard"))->with("msg","Excluída com sucesso!");
    }

    public function edit(News $news){
        $categoryList = Category::all();
        $categoryNews = CategoryNews::select("category_news.*")
        ->where("news_id",$news->id)->paginate();
        return view("admin.news.form",["data"=>$news, "categoryList"=>$categoryList, "categoryNews"=>$categoryNews]);
    }

    public function update(News $news, Request $request) {
        $categoryNews = CategoryNews::select("category_news.*")
        ->where("news_id",$news->id)->paginate();

        if(count($categoryNews) > 0){

        }else{
            $validated = $this->validator($request)->validate();
        }
        
        $data = $this->armazenaImagem($request);
        $news->update($data);

        $category = Category::find($request["category_id"]);
        if ($category != null){
            CategoryNews::updateOrCreate(["news_id"=>$news->id,"category_id"=>$category->id]);
        }
    
        return redirect()->back()->with("msg","Atualizada com sucesso!");
    }

    public function desvincular(CategoryNews $category_news, $dataNew){
        $item = CategoryNews::where('news_id', $dataNew)->get();
        if(count($item) > 1)
        {
            $category_news->delete();
            return redirect()->back()->with("msg",__("Desvinculado com sucesso!"));
        }
        else {
            return redirect()->back()->with("msgdanger",__("É preciso ter ao menos uma categoria!"));
        }
    }    

    public function validator(Request $request){

        $admin_user = User::ADMIN_LEVEL;

        if(Auth::user()->level == $admin_user){
            $rules = [
                'title' => 'required|max:250',
                'category_id' => 'required|max:250',
                'news_text' => 'required|max:10000',
            ];
        }else{
            $rules = [
                'title' => 'required|max:250',
                'news_text' => 'required|max:10000',
            ];
        }
    
        if ($request->method() == "POST"){
            $rules['image'] = 'required|image|max:1024';
        } else
        if ($request->method() == "PUT"){
            $rules['image'] = 'image|max:1024';
        }
    
        return Validator::make($request->all(), $rules);
    }
    
    private function armazenaImagem(Request $request){
        $data = $request->all();
        if ($request->file('image') != null){
            $path = $request->file('image')->store("news","public");
            $data["image"] = $path;
        }
        return $data;
    }
    
    
}

<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use App\Models\Comment;
use App\Models\Category;
use App\Models\CategoryNews;

class HomePageController extends Controller
{

    public function index(Request $request){
        $contador = 0;

        $search = $request->search;
        
        if(isset($search)){
            $news = News::where("title","like","%$search%")->orderBy('created_at', 'DESC');
            return view('home_page', ["news"=>$news->cursorPaginate(16), "search"=>$search]);
        }else{
            $news = News::orderBy('created_at', 'DESC');
        }
        
        return view('home_page', ["news"=>$news->cursorPaginate(17), "contador"=>$contador]);
    }

    public function get(News $news, Category $category){
        $related = News::select("news.*")
        ->join("category_news","category_news.news_id","=","news.id")
        ->where("category_id",$news->manycategories[0]->id)->orderBy('created_at', 'DESC')->paginate(5);
        $comments = Comment::where('news_id', $news->id)->orderBy('created_at', 'DESC')->cursorPaginate(10); 
        $admin_user = User::ADMIN_LEVEL;
        return view("news",["news"=>$news, "related"=>$related, "comments"=>$comments, "admin_user"=>$admin_user]);
    }

    public function category(CategoryNews $categoryNews, Category $category){
        $news = News::select("news.*")
        ->join("category_news","category_news.news_id","=","news.id")
        ->where("category_id",$category->id)->orderBy('news.created_at', 'DESC');
        return view("category",["news"=>$news->cursorpaginate(16), "category"=>$category]);
    }
     
}

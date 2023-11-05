<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\News;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request){
        $validated = $this->validator($request, null)->validate();
        $comment = new Comment;
        $comment->text_comment = $request->text_comment;
        $comment->user_id = Auth::user()->id;
        $comment->news_id = $request->news_id; 
        $comment->save();
        return redirect()->back()->with("msg", "Comentário publicado!");
    }

    public function destroy(Comment $comment){
        $comment->delete();  
        return redirect()->back()->with("msg","Comentário apagado!");
    }

    public function update(Comment $comment, Request $request) {
        $validated = $this->validator($request, $comment)->validate();
        $comment->text_comment = array_pop($validated['text_comment_edit']);
        $comment->save();
        return redirect()->back()->with("msg","Comentário editado!");
    }

    public function validator(Request $request, $comment){

        if($comment == null){

            $rules = [
                'text_comment' => 'required|max:200',
            ];

        }else{
            $rules = [
                'text_comment_edit.*' => 'required|max:200',
            ];
        }
    
        return Validator::make($request->all(), $rules, $messages = [
            'required' => 'Este campo não pode ser vazio.',
        ]);
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "text"=> "required",
            "user_id"=> "required|integer",
            "post_id"=> "required|integer",
            "parent_id" => "nullable"
        ]);

        $insert = Comment::create($data);

        return response([
            "code" => 200,
            "message" => "succes code",
            "description" => "Nouveau commentaire inserer avec succes",
            "data" => $insert
        ]);
    }

    public function read(){
        $comment = Comment::all();

        return response([
            "code" => 200,
            "message" => "succes code",
            "description" => "Tout les commentaire",
            "data" => $comment
        ]);
    }

    public function delete($id){
        $comment = Comment::find($id);
        if($comment){
            $comment->delete();
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "commentaire supprimer avec succes",
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "Le commentaire n'existe pas",
            ]);
        }
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            "text"=>"required",
        ]);
        $comment = Comment::find($id);
        if($comment){
            $commentMaj = $comment->update($data);
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "commentaire modifier avec succes",
                "data" => $commentMaj,
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "Le commentaire n'existe pas",
            ]);
        }
    }

    public function getComSingleCom(Request $request){
        $cle = Auth::id();
        $com = Comment::where('user_id', $cle)->get()->count();

        return $com;
    }
}

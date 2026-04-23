<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "url"=>"required|url",
            "title"=>"required|string",
            "content"=>"required|string",
            "user_id"=>"required|integer",
        ]);

        $insert = Post::create($data);

        return response([
            "code" => 200,
            "message" => "succes code",
            "description" => "Nouveau post inserer avec succes",
            "data" => $insert
        ]);
    }

    public function read(){
        $post = Post::all();

        return response([
            "code" => 200,
            "message" => "succes code",
            "description" => "Tout les post",
            "data" => $post
        ]);
    }

    public function delete($id){
        $post = Post::find($id);
        if($post){
            $post->delete();
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "post supprimer avec succes",
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "Le post n'existe pas",
            ]);
        }
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            "url"=>"required|url",
            "title"=>"required",
            "content"=>"required",
        ]);
        $post = Post::find($id);
        if($post){
            $postMaj = $post->update($data);
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "post modifier avec succes",
                "data" => $postMaj,
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "Le post n'existe pas",
            ]);
        }
    }

    public function getPostSingleUsers(Request $request){
        $pro = Auth::id();
        $specPost = Post::where('user_id', $pro)->get()->count();
        return $specPost;

    }
    public function getCross(){
        $getcross = Post::join('users', 'posts.user_id', '=', 'users.id')->select('posts.title')->get();

        return $getcross ;
    }
    public function search(Request $request, $search){
        $results = Post::where('title', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%')->get();

        return response()->json([
            "data" => $results
        ]);
    }
}


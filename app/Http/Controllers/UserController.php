<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            "name" => "required|string",
            "email" => ["required", "email", "unique:users"],
            "password" => "required|string|min:8",
            "birthdate" => "required",
        ]);

        $insert = User::create($data);

        return response([
            "code" => 200,
            "message" => "succes code",
            "description" => "Nouvel utilisateur inserer avec succes",
            "data" => $insert
        ]);
    }

    public function UserComment(){
        $data = User::all("id", "name", "created_at");
        return response([
            "code" => 200,
            "message" => "SUCCES",
            "description" => "Id et Nom recuperer avec succes",
            "data" => $data
        ]);
    }

    public function read(){
        if(auth()->user()->admin == 1){
            $user = User::all();

            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "Tout les utilisateur",
                "data" => $user
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "FAILLURE",
                "description" => "Vous n'avez pas les droits de lecture"
            ]);
        }
    }

    public function login(Request $request){
        $login = $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);

        if(!Auth::attempt($login)){
            return response([
                "code" => 400,
                "message" => "FAILURE",
                "description" => "Vos identifiants sont incorrectes"
            ]);
        }else{
            //$request->session()->regenerate();
            //var_dump(Auth()->user()->admin);
            return response([
                "code" => 200,
                "message" => "SUCCES",
                "description" => "connexion effectuer avec succes",
                "token" => auth()->user()->createToken("secret")->plainTextToken
            ]);
        }
    }

    public function rule(Request $request, $id){
        if(auth()->user()->admin == 1){
            $data = $request->validate([
                "admin" => "required|integer"
            ]);
            $user = User::find($id);
            if($user){
                $userRule = $user->update($data);
                return response([
                    "code" => 200,
                    "message" => "succes code",
                    "description" => "Role modifier",
                    "data" => $userRule,
                ]);
            }else{
                return response([
                    "code" => 400,
                    "message" => "error code",
                    "description" => "L'utilisateur n'existe pas",
                ]);
            }
        }else{
            return response([
                "code" => 400,
                "message" => "FAILLURE",
                "description" => "Vous n'avez pas les droits de lecture"
            ]);
        }
    }

    public function delete($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "post supprimer avec succes",
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "L'utilisateur n'existe pas",
            ]);
        }
    }

    public function updatePassword(Request $request, $id){
        $data = $request->validate([
            "password" => "required|string|min:8",
        ]);
        $user = User::find($id);
        if($user){
            $user->update($data);
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "Mots de passe modifier"
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "L'utilisateur n'existe pas",
            ]);
        }
    }

    // c'est ici que je gère la partie pour recuperer les postes d'un même users

    public function update(Request $request, $id){
        $data = $request->validate([
            "name" => "required|string",
            "email" => ["required", "email"],
            // "image" => ["nullable","string"],
        ]);
        $user = User::find($id);
        if($user){
            $userMaj = $user->update($data);
            return response([
                "code" => 200,
                "message" => "succes code",
                "description" => "utilisateur modifier avec succes",
                "data" => $userMaj,
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "error code",
                "description" => "L'utilisateur n'existe pas",
            ]);
        }
    }

    public function disconnection(){
        Auth()->user()->currentAccessToken()->delete();
        Auth::forgetGuards();
        return response(["utilisateur deconnecter avec succes"]);
    }

    public function profile(){
        if(auth()->check()){
            $profile = User::find(auth()->id());

            return response([
                "code" => 200,
                "message" => "SUCCES",
                "description" => "info de l'utilisateur",
                "data" => $profile
            ]);
        }else{
            return response([
                "code" => 400,
                "message" => "FAILLURE",
                "description" => "Utilisateurs introuvable"
            ]);
        }
    }
}

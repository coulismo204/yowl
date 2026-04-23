<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/



Route::post("/login", [UserController::class, "login"])->name("login");
Route::post("/register",[UserController::class, "create"])->name("register");
Route::get("/post", [PostController::class, "read"])->name("all");
Route::get("/comment", [CommentController::class, "read"])->name("all");
Route::get("/UserComment", [UserController::class, "UserComment"])->name("UserComment");

Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::prefix("/user")->name("user.")->group(function(){
        Route::delete("/delete/{id}", [UserController::class, "delete"])->name("delete");
        Route::put("/update/{id}",[UserController::class, "update"])->name("update");
        Route::put("/updatePassword/{id}",[UserController::class, "updatePassword"])->name("updatePassword");
        Route::get("/disconnect", [UserController::class, "disconnection"])->name("disconnect");
        Route::get("/profile", [UserController::class, "profile"])->name("profile");
    });

    Route::prefix("/admin")->name("admin.")->group(function(){
        Route::post("/rule/{id}",[UserController::class, "rule"])->name("rule");
        Route::get("/", [UserController::class, "read"])->name("all");
    });


    Route::prefix("/post")->name("post.")->group(function(){
        Route::post("/add",[PostController::class, "create"])->name("add");
        Route::delete("/delete/{id}", [PostController::class, "delete"])->name("delete");
        Route::post("/update/{id}",[PostController::class, "update"])->name("update");
        Route::get('/cross', [PostController::class, 'getCross']);
        Route::get("/profile", [PostController::class, "getPostSingleUsers"])->name("postuser");
        Route::get('/search/{search}', [PostController::class, "search"]);


    });

    Route::prefix("/comment")->name("comment.")->group(function(){
        Route::post("/add",[CommentController::class, "create"])->name("add");
        Route::delete("/delete/{id}", [CommentController::class, "delete"])->name("delete");
        Route::post("/update/{id}",[CommentController::class, "update"])->name("update");
        Route::get("/profile",[CommentController::class, "getComSingleCom"])->name("getcom");
    });
});

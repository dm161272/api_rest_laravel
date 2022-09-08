<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------

1. POST /players : Create a player.
2. PUT /players/{id} : modifies the name of the player.
3. POST /players/{id}/games/ : A specific player rolls the dice.
4. DELETE /players/{id}/games: deletes the player's rolls.
5. GET /players: returns the list of all the players in the system with their 
average success rate
6. GET /players/{id}/games: returns the list of games for a player.
7. GET /players/ranking: returns the average ranking of all players in the system.
That is, the average percentage of successes.
8. GET /players/ranking/loser: returns the player with the worst success rate.
9. GET /players/ranking/winner: returns the player with the best 
percentage of success.

*/
//1.
Route::post('/players', [UserController::class, 'store']);

//Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);



//PROTECTED ROUTES
Route::group(['middleware' => ['auth:sanctum']], function () {

//Logout user
Route::post('/logout', [UserController::class, 'logout']);

//Logout player
Route::post('/players/logout', [UserController::class, 'logout']);

//5.
Route::get('/players', [UserController::class, 'index']);

//8.
Route::get('/players/ranking/loser', [UserController::class, 'loser']);

//9.
Route::get('/players/ranking/winner', [UserController::class, 'winner']);

//7.
Route::get('/players/ranking', [UserController::class, 'rank']);


//6.
Route::get('/players/{id}', [UserController::class, 'show']);

//2.
Route::put('/players/{id}', [UserController::class, 'update']);

//3.
Route::post('/players/{id}/games', [GameController::class, 'store']);

//4.
Route::delete('/players/{id}/games', [GameController::class, 'destroy']);

});





/*

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

*/
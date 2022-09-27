<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
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

//1.POST /players : Create a player.
Route::post('/players', [UserController::class, 'store'])
->name('players.store');
// POST /login : Login a player.
Route::post('/login', [UserController::class, 'login'])
->name('login');


//PROTECTED ROUTES
Route::group(['middleware' => ['cors', 'json.response']], function() {

//Logout user
Route::post('/logout', [UserController::class, 'logout'])
->middleware('auth:api')
->middleware('can:logout')
->name('logout');

/* 5. GET /players: returns the list of all the players in the system with their 
average success rate */
Route::get('/players', [User::class, 'index'])
->middleware('can:players.list')
->name('players.list');

/*8.GET /players/ranking/loser: returns the player with the worst success rate.*/
Route::get('/players/ranking/loser', [User::class, 'loser'])
->middleware('can:players.loser')
->name('players.loser');

/*9.GET /players/ranking/winner: returns the player with the best 
percentage of success.*/
Route::get('/players/ranking/winner', [User::class, 'winner'])
->middleware('can:players.winner')
->name('players.winner');

/*7. GET /players/ranking: returns the average ranking of all players in the system.
That is, the average percentage of successes.*/
Route::get('/players/ranking', [User::class, 'rank'])
->middleware('can:players.ranks')
->name('players.ranks');


/*6.GET /players/{id}/games: returns the list of games for a player.*/
Route::get('/players/{id}', [User::class, 'show'])
->middleware('can:games.list')
->name('games.list');

/*2.PUT /players/{id} : modifies the name of the player.*/
Route::put('/players/{id}', [UserController::class, 'update'])
->middleware('can:players.update')
->name('players.update');

/*3.POST /players/{id}/games/ : A specific player rolls the dice.*/
Route::post('/players/{id}/games', [GameController::class, 'store'])
->middleware('auth:api')
->middleware('can:players.game')
->name('players.game');

/*4.DELETE /players/{id}/games: deletes the player's rolls.*/
Route::delete('/players/{id}/games', [GameController::class, 'destroy'])
->middleware('can:games.delete')
->name('games.delete');

});

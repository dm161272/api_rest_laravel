<?php

namespace App\Http\Controllers;

use App\Models\Game;

use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth('api')->user()->id == $request->id) {
             $game = Game::game();
        if (($game[0] + $game[1])%7 == 0) 
        {
            Game::where('user_id', $request->id)
            ->update(array('win' => Game::raw('win+1')));
            return response()->json([
                'win', $game[0], $game[1]], 201);
        } 
        else
        {
            Game::where('user_id', $request->id)
            ->update(array('lose' => Game::raw('lose+1')));
            return response()->json([
                'lose', $game[0], $game[1]], 201);
        }
        }
       else 
        {
            return response ([
            'message' => 'Not authorized'], 401);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
    //dd(auth()->user()->roles[0]['name']);
    if(auth('api')->user()->id == $user_id ||
    auth()->user()->roles[0]['name'] == 'admin') {
     $id = Game::select('id')
     ->where('user_id', '=', $user_id)
     ->update(array('win' => 0, 'lose' => 0));
        return response ([
        'message' => 'All user games deleted'], 200);
    }
    else 
    {
         return response ([
         'message' => 'Not authorized'], 401);

    }

   } 
}

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
        if(auth('sanctum')->user()->id == $request->id) {
        if (!Game::game()) {
            Game::where('user_id', $request->id)
            ->update(array('lose' => Game::raw('lose+1')));
        } 
        else 
        {
            Game::where('user_id', $request->id)
            ->update(array('win' => Game::raw('win+1')));
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
    if(auth('sanctum')->user()->id == $user_id ||
    auth()->user()->roles[0]['name'] == 'admin') {
     $id = Game::select('id')
     ->where('user_id', '=', $user_id)
     ->update(array('win' => 0, 'lose' => 0));
    }
    else 
    {
        return response ([
        'message' => 'Not authorized'], 401);

    }

   } 
}

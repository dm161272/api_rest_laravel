<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display players and succes rate percentage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Player::select('players.id', 'players.name', 
        Game::raw('(win/(win + lose))*100 AS success_rate'))
        ->leftJoin('games', 'games.player_id', 'players.id')
        ->get();
    }

    /**
     * Display players ranking success.
     *
     * @return \Illuminate\Http\Response
     */
    public function rank()
    {
        return Player::select('players.id', 'players.name', 
        Game::raw('(win/(win + lose))*100 AS rank'))
        ->leftJoin('games', 'games.player_id', 'players.id')
        ->orderBy('rank', 'DESC')
        ->get();
    }

     /**
     * Display player with most wins.
     *
     * @return \Illuminate\Http\Response
     */
    public function winner()
    {
        $maxValue = Game::max(Game::raw('(win/(win + lose))*100'));
        return Player::select(
        Game::raw('players.id, players.name, (win/(win + lose))*100 AS rank'))
        ->leftJoin('games', 'games.player_id', 'players.id')
        ->where(Game::raw('(win/(win + lose))*100'), $maxValue)
        ->get();
    }

      /**
     * Display player with most lose.
     *
     * @return \Illuminate\Http\Response
     */
    public function loser()
    {
        $minValue = Game::min(Game::raw('(win/(win + lose))*100'));
        return Player::select(
        Game::raw('players.id, players.name, (win/(win + lose))*100 AS rank'))
        ->leftJoin('games', 'games.player_id', 'players.id')
        ->where(Game::raw('(win/(win + lose))*100'), $minValue)
        ->get();
    }


    /**
     * Store players.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $request->validate(['email' => 'required']);
        $player = Player::create($request->all());
        if($player->name == NULL) {
        $player->update(array('name' => 'Anonymous_' . $player->id));
        }
        Game::create(['player_id' => $player['id']]);
        return $player;
    }

    /**
     * Display Player with list of games.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        return Player::select('players.id', 'players.name', 'games.win', 'games.lose')
        ->where('players.id', $id)
        ->leftJoin('games', 'games.player_id', 'players.id')
        ->get();
    }

    /**
     * Update player`s name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $player = Player::find($id);
        $player->update($request->all('name'));
        return $player;

    }

}

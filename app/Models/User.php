<?php

namespace App\Models;


use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


        /**
     * Display users and succes rate percentage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::select('users.id', 'users.name', 
        Game::raw('(win/(win + lose))*100 AS success_rate'))
        ->leftJoin('games', 'games.user_id', 'users.id')
        ->get();
    }

    /**
     * Display users ranking success.
     *
     * @return \Illuminate\Http\Response
     */
    public function rank()
    {
        return User::select('users.id', 'users.name', 
        Game::raw('(win/(win + lose))*100 AS rank'))
        ->leftJoin('games', 'games.user_id', 'users.id')
        ->orderBy('rank', 'DESC')
        ->get();
    }

     /**
     * Display user with most wins.
     *
     * @return \Illuminate\Http\Response
     */
    public function winner()
    {
        $maxValue = Game::max(Game::raw('(win/(win + lose))*100'));
        return User::select(
        Game::raw('users.id, users.name, (win/(win + lose))*100 AS rank'))
        ->leftJoin('games', 'games.user_id', 'users.id')
        ->where(Game::raw('(win/(win + lose))*100'), $maxValue)
        ->get();
    }

      /**
     * Display user with most lose.
     *
     * @return \Illuminate\Http\Response
     */
    public function loser()
    {
        $minValue = Game::min(Game::raw('(win/(win + lose))*100'));
        return User::select(
        Game::raw('users.id, users.name, (win/(win + lose))*100 AS rank'))
        ->leftJoin('games', 'games.user_id', 'users.id')
        ->where(Game::raw('(win/(win + lose))*100'), $minValue)
        ->get();
    }

      /**
     * Display User with list of games.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
       if(auth('api')->user()->id == $id || 
       auth('api')->user()->roles[0]['name'] == 'admin') {
        return User::select('users.id', 'users.name', 'games.win', 'games.lose')
        ->where('users.id', $id)
        ->leftJoin('games', 'games.user_id', 'users.id')
        ->get();} 
        else 
        {
            return response ([
                'message' => 'Not authorized'], 401);

        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
     * Store users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $fields = $request->validate([
            'name' => 'string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|string'
        ]);

        if(!isset($fields['name'])) {
           $user = User::create([
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        $user->update(['name' => 'Anonymous_' . $user->id]);
        }
        else 
        {
        $user = User::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'password' => bcrypt($fields['password'])
        ]);}

        $user->assignRole($fields['role']);

        Game::create(['user_id' => $user['id']]);

        $token = $user->createToken('apptoken')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

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

    /**
     * Update user`s name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       if(auth('api')->user()->id == $id || 
       auth()->user()->roles[0]['name'] == 'admin') {
        $user = User::find($id);
        $user->update($request->all('name'));
        return $user;}
        else
        {
            return response ([
            'message' => 'Not authorized'], 401);

        }


    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        //check email
        $user = User::where('email', $fields['email'])->first();
        //check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response ([
                'message' => 'Bad credentials'
            ], 401);
        }
        $token = $user->createToken('apptoken')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout() {

        auth()->user()->token()->revoke();

        /* $tokenRepository = app('Laravel\Passport\TokenRepository');
        $user = auth('api')->user();
    
        if ($user) {
            $tokenRepository->revokeAccessToken($user->token()->id);
            $user->token()->delete();
    
            return response()->json(['status', 'Logged Out']);
        } else {
            return response()->json(['status', 'Already Logged Out']);
        } */

       return [
           'message' => 'User logged out'
        ];
    }


}

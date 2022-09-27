<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Store users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $role = User::role('admin')
        ->get()
        ->toArray();
        $fields = $request->validate([
            'name' => 'string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|string'
        ]);
        //dd((!isset($role[0])), $fields['role'] == 'admin');
        if((isset($role[0])) && ($fields['role'] == 'admin')) { 

            return response('User with administrator priviledges already exists', 409);
        }
        else 
        {
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
                
             $user->assignRole($fields['role']);}
        
           
        Game::create(['user_id' => $user['id']]);

        $token = $user->createToken('apptoken')->accessToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

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

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->tokens()->delete();

       return [
           'message' => 'User logged out'
        ];
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        //$role = User::role('admin')
        //->get()
        //->toArray();

        $fields = [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|string'
        ];

        $validated = Validator::make($request->all(), $fields, ['email.unique' => 'Invalid entry']);

        if($validated->fails())
        {
            return response()->json(['messages' => 'The given data was invalid.', 'errors' => $validated->errors()], 422);
        }


        //if((isset($role[0])) && ($request->get('role') == 'admin')) { 

           // return response()->json(['message' => 'User with administrator priviledges already exists'], 409);
       // }
       // else 
        {
         
             $user = User::create([
             'name' => $request->get('name'),
             'email' => $request->get('email'),
             'password' =>  bcrypt($request->get('password')),
             ]);
                
            $user->assignRole($request->get('role'));}

            $token = $user->createToken('apptoken')->accessToken;

        $response = [
            'id' => $user['id'],
            'username' => $user['name'],
            'email' => $user['email'],
            'token' => $token,
            'role' => $user['role'],
        ];

        return response($response, 201);
    }
//}

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
              'message' => 'Bad credentials'], 401);
        }
        $token = $user->createToken('apptoken')->accessToken;

        $response = [
            'message' => 'User logged in',
            'id' => $user['id'],
            'user' => $user['name'],
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

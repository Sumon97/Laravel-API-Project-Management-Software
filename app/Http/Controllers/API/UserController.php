<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Validation\ValidationException;
use Auth;

class UserController extends Controller
{
   
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'          =>  'required|max:100',
            'email'         =>  'required|email|max:35|unique:users,email',
            'password'      =>  'required|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            $token  =   $user->createToken($user->email.'_Token')->plainTextToken;

           return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token' => $token,
                'message'=>'Registration Successfull',
            ]);


        }
    }

    public function login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email'         =>  'required|email|max:191',
            'password'      =>  'required|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credentials',
                ]);
            }
            else
            {
                if( $user->role_as == 1 ) //1 is admin
                {
                    $role = 'admin';
                    $token = $user->createToken($user->email.'_AdminToken', ['server:admin'])->plainTextToken;
                }
                else
                {
                    $role = '';
                    $token  =   $user->createToken($user->email.'_Token')->plainTextToken;
                }
               

                return response()->json([
                        'status'=>200,
                        'username'=>$user->name,
                        'token' => $token,
                        'message'=>'Login Successfull',
                        'role'=>$role,
                ]);
            }
        }
    }

    public function profile()
    {
       if(Auth::check()){
            $username = Auth::name();
            return response()->json([
                'status'=>200,
                'username'=>$username,
            ]);
        }
        
    }

    public function chekingAuthenticated()
    {
        return response()->json(['message'=>'You are in', 'status'=>200], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logout Success',
        ]);
    }

    
}

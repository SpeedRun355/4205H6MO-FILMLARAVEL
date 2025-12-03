<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Http;

class RegisterController extends BaseController
{
   /**

     * Register api

     *

     * @return \Illuminate\Http\Response

     */

     public function register(Request $request)

     {
 
         $validator = Validator::make($request->all(), [
 
             'name' => 'required',
 
             'email' => 'required|email',
 
             'password' => 'required',
 
             'c_password' => 'required|same:password',
             'g-recaptcha-response' => 'required',
 
         ]);
 
        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors(), 422);       

        }

        // 🔹 Vérification reCAPTCHA côté serveur
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response')
        ]);
 

        $captcha = $response->json();
        if (empty($captcha['success']) || !$captcha['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Échec de la vérification reCAPTCHA.'
            ], 400);
        }

        // Create the user after validation and captcha
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return response()->json([$success, "message"=> 'User register successfully.']);

 
     }
 
    
 
     /**
 
      * Login api
 
      *
 
      * @return \Illuminate\Http\Response
 
      */
 
     public function login(Request $request)
 
     {
 
         if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 


 
             $user = User::find(Auth::id()); 
 
             $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
 
             $success['name'] =  $user->name;
 
             return response()->json([$success, "message"=> 'User login successfully.']);
 
         } 
 
        else{ 

            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);

        } 
 
     }

         /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // If using Sanctum personal access tokens, delete current access token
        if ($request->user()) {
            $token = $request->user()->currentAccessToken();
            if ($token) {
                $token->delete();
            }
        }

        return response()->json(['message' => 'User déconnecter.']);
    }
}

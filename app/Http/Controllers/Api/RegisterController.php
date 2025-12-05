<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $secret = env('RECAPTCHA_SECRET_KEY');
        $token = $request->input('g-recaptcha-response');

        if (empty($secret)) {
            Log::error('reCAPTCHA secret missing (RECAPTCHA_SECRET_KEY).');
            return $this->sendError('reCAPTCHA configuration error.', [], 500);
        }
        if (empty($token)) {
            return $this->sendError('reCAPTCHA token missing from request.', [], 422);
        }

        // perform verification (no-verify only for local debugging)
        try {
            $response = Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                // 'remoteip' => $request->ip(), // optional
            ]);
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA HTTP request failed: '.$e->getMessage(), ['exception' => $e]);
            return $this->sendError('reCAPTCHA verification failed (network).', [], 500);
        }

        if (! $response->successful()) {
            Log::error('reCAPTCHA siteverify returned non-success', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return $this->sendError('reCAPTCHA verification error.', ['body' => $response->body()], 500);
        }

        $captcha = $response->json();
        Log::info('reCAPTCHA verification response', $captcha);

        if (empty($captcha['success']) || !$captcha['success']) {
            // include error-codes from Google if present
            return response()->json([
                'success' => false,
                'message' => 'Échec de la vérification reCAPTCHA.',
                'errors' => $captcha['error-codes'] ?? null,
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

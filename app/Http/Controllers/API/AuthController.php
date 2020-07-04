<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responder\ResponderFacade as Responder;
use Auth;

use App\Models\User;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $input = $request->all();        
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken(env('APP_NAME', 'MyApp'))->accessToken;
        $success['name'] =  $user->name;
   
        // return $this->sendResponse($success, 'User register successfully.');
        return Responder::setMessage('User register successfully.')
                    ->respondCreated($success);
    }
   
    public function login(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken(env('APP_NAME', 'MyApp'))->accessToken;
            $success['name'] =  $user->name;
   
            return Responder::setMessage('User login successfully.')
                    ->setRespondData($success)
                    ->respond();
        } 
        else{
            return Responder::setRespondError(['user' => 'invalid username or password'])
                ->respondUnauthorizedError();
                    
        } 
    }

    public function unauthorized() { 
        return Responder::respondUnauthorizedError();
    }
}

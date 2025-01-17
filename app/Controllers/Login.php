<?php

namespace App\Cotrollers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $userModel->where('email', $email)->first();
        if(is_null($user)) {
            return $this->respond(['error' =>'invalid username or password.'], 401);
        }
        $pwd_verify = password_verify($password, $user['password']);
        if(!$pwd_verify) {
            Return $this->respond(['error' =>'ivalid username or password.']. 401);
        }
        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;
        $payload = array (
            "iss" => "Issuer of the JWT",
            "aud" => "Audience tha the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat,
            "exp" => $exp,
            "email" => $user['email'],
        );
        $token = JWT::encode($payload, $key, 'HS256');
        $response =[
            'message' => 'Login Succesful',
            'token' => $token
        ];
        return $this->respond($response, 200);
    }
}
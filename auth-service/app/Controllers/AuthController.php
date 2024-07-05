<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    public function __construct(){
        helper("cookie");
    }

    public function register()
    {
        $payload = $this->request->getJSON();

        $rules = [
            'name'=> 'required',
            'email'=> 'required|valid_email|is_unique[users.email]',
            'password'=> 'required|min_length[6]',
        ];

        $payloadArray = (array) $payload;

        if(!$this->validateData( $payloadArray, $rules, [
            'email' => ['is_unique' => 'Email already exists'],
        ] )){
            return $this->response->setJSON([
                'message' => 'Validation failed',
                'error' => $this->validator->getErrors(),
            ])->setStatusCode(400);
        }

        $password = password_hash($payload->password, PASSWORD_BCRYPT);

        $user = new UserModel();
        $user->insert([
            'name' => $payload->name,
            'email' => $payload->email,
            'password' => $password
        ]);

        // $user_id = $user->getInsertID();

        // $db = db_connect();
        // $builder = $db->table('user_groups');

        // $q = $builder->insert(
        //     ['group_id'=> 1,'user_id'=> $user_id]
        // );

        return $this->response->setJSON([
            'message' => 'User created successfully',
            'data' => null
        ]);
    }

    public function login(){
        $payload = $this->request->getJSON();

        $user = new UserModel();
        $userData = $user->where('email', $payload->email)
                        ->where('is_registered', 1)
                        ->first();

        if(!$userData){
            return $this->response->setJSON([
                'message' => 'User not found',
                'error' => ['User not found']
            ])->setStatusCode(404);
        }

        $verifyPassword = password_verify($payload->password, $userData['password']);
        if(!$verifyPassword){
            return $this->response->setJSON([
                'message' => 'Wrong password',
                'error' => ['Wrong password']
            ])->setStatusCode(401);
        }

        $key = 'secret';
        $now = new DateTime();
        $expTime = new DateTime();
        $exp = $expTime->modify('+1 day')->getTimestamp();

        $jwtPayload = [
            'iss'=> 'localhost',
            'aud'=> 'localhost',
            'iat'=> $now->getTimestamp(),
            'exp'=> $exp,
            'id'=> $userData['id'],
            'name'=> $userData['name'],
            'email'=> $userData['email'],
        ];
        
        $oneDay = 60*60*24;
        $token = JWT::encode($jwtPayload, $key, 'HS256');

        set_cookie(
           name: 'access_token',
           value: $token,
           expire: $oneDay,
           httpOnly: true
        );

        return $this->response->setJSON([
            'message' => 'User logged in successfully',
            'data' => [
                'token' => $token
            ]
        ])->setStatusCode(200);
        
    }




    public function logout(){

        //delete_cookie('access_token');
        return $this->response->setJSON([
            'message' => 'User logged out successfully',
            'data' => null
        ])->setStatusCode(200)->deleteCookie('access_token');
    }



}

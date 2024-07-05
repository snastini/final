<?php

namespace App\Services;

use CodeIgniter\Config\Services;

class AuthService
{
    protected $auth;
    protected $baseUrl;

    public function __construct()
    {
        $this->auth = Services::curlrequest([
            'base_uri' => env('auth_service_url'),
            'http_errors' => false
        ]);
    }

    //AUTH

    public function login($data){
        $response = $this->auth->post('api/login', [
            'json' => $data
        ]);

        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            return json_decode($response->getBody(), false);
           // throw new \Exception($response->getBody(), $response->getStatusCode());
        }
    }

    public function getUser($token){
        $response = $this->auth->get('api/user', [
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ]
        ]);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to get user data.', $response->getStatusCode());
        }
    }

    public function getUserById($id){
        $response = $this->auth->get('api/users/'.$id);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to get user data.', $response->getStatusCode());
        }
        
    }

    public function logout(){
        $response = $this->auth->get('api/logout');

        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getStatusCode(), true);
        } else {
            throw new \Exception('Failed to logout.', $response->getStatusCode());
        }

    }

    public function register($data){
        $response = $this->auth->post('api/register', [
            'json' => $data
        ]);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            return json_decode($response->getBody(), false);
            //throw new \Exception('Failed to Register.', $response->getStatusCode());
        }
    }

    // USERS
    public function getAllUsers(){
        $response = $this->auth->get('api/users');
        if($response->getStatusCode() === 200|| $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to get data', $response->getStatusCode());
        }
    }

    public function updateUser($id, $data){
        $response = $this->auth->put('api/users/'.$id, [
            'json' => $data
        ]);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            return json_decode($response->getBody(), false);
            //throw new \Exception('Failed to accept user.', $response->getStatusCode());
        }
    }

    public function changePassword($id, $data){
        $response = $this->auth->put('api/users/change_password/'.$id, [
            'json' => $data
        ]);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            return json_decode($response->getBody(), false);
            //throw new \Exception('Failed to accept user.', $response->getStatusCode());
        }
    }

    public function deleteUser($id){
        $response = $this->auth->delete('api/users/'.$id);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to delete user.', $response->getStatusCode());
        }
    }

    public function addUserGroup($data){
        $response = $this->auth->post('api/users/add_group', [
            'json' => $data
        ]);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to add user into group.', $response->getStatusCode());
        }
    }

    public function getUserDetail($id){
        $response = $this->auth->get('api/users/'.$id);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to get user detail.', $response->getStatusCode());
        }
    }

    public function getUserGroup($id){
        $response = $this->auth->get('api/users/groups/'.$id);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to get user group.', $response->getStatusCode());
        }
    }

    public function deleteUserGroups($id){
        $response = $this->auth->delete('api/users/groups/'.$id);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to delete user group.', $response->getStatusCode());
        }
    }

    public function deleteUserGroup($data){
        $response = $this->auth->delete('api/users/group/', [
            'json' => $data
        ]);
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to delete user group.', $response->getStatusCode());
        }
    }

    // GROUPS

    public function getAllGroups(){
        $response = $this->auth->get('api/group');
        if($response->getStatusCode() === 200 || $response->getStatusCode() === 201){
            return json_decode($response->getBody(), true);
        } else {
            throw new \Exception('Failed to get data', $response->getStatusCode());
        }
    }
}

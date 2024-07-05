<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\PermissionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Firebase\JWT\JWT;


class UserController extends BaseController
{
    
    public function showAll(): ResponseInterface{
        $userModel = new UserModel();

        $users = $userModel->builder()->select(
            ["users.id id", 
            "users.name name", 
            "users.email email", 
            "users.is_registered is_registered",
            "groups.name group_name", 
            "groups.id group_id"]
        )->join('user_groups', 'users.id = user_groups.user_id', 'left')
        ->join('groups', 'user_groups.group_id = groups.id', 'left')
        ->orderBy('users.id', 'ASC')
        ->get()->getResultArray();

        if(!$users){
            return $this->response->setJSON([
                'message'=> 'Users not found',
                'data'=> null
            ]);
        }

        $dataUser = [];

        foreach($users as $user){
            $userID = $user['id'];
            if(!isset($dataUser[$userID])){
                $dataUser[$userID] = [];
            }

            $dataUser[$userID]['name'] = $user['name'];
            $dataUser[$userID]['email'] = $user['email'];
            $dataUser[$userID]['is_registered'] = $user['is_registered'];
            
            
            if(!isset($dataUser[$userID]['groups'])){
                $dataUser[$userID]['groups'] = [];
            }

            $dataUser[$userID]['groups'][$user['group_id']] = $user['group_name'];                
            
        }

        return $this->response->setJSON([
            'message'=> 'Users retrieved successfully',
            'data'=> $dataUser
        ]);
    }

    public function show($id): ResponseInterface{
        $userModel = new UserModel();
        $user = $userModel->builder()->select(
            ["id", "name", "email", "is_registered"]
        )->where("id", $id)->get()->getFirstRow();
        
        if(!$user){
            return $this->response->setJSON([
                'message'=> 'User not found',
                'data'=> null
            ]);
        }
        return $this->response->setJSON([
            'message'=> 'User retrieved successfully',
            'data'=> $user
        ]);
    }       

    public function update($id): ResponseInterface{
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if(!$user){
            return $this->response->setJSON([
                'message'=> 'User not found',
                'data'=> null
            ]);
        }

        $payload = $this->request->getJSON();

        if(isset($payload->email)){
            $rules = [
                'email'=> 'required|valid_email|is_unique[users.email]'
            ];

            $payloadArray = (array) $payload;

            if(!$this->validateData( $payloadArray, $rules, [
                'email' => ['is_unique' => 'Email already exists'],
            ] )){
                return $this->response->setJSON([
                    'message'=> 'Validation failed',
                    'error'=> $this->validator->getErrors(),
                ])->setStatusCode(400);
            }
        }

        $userModel->update($id, $this->request->getJSON());
        return $this->response->setJSON([
            'message'=> 'User updated successfully',
            'data'=> null
        ]);
    }

    public function delete($id): ResponseInterface{
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if(!$user){
            return $this->response->setJSON([
                'message'=> 'User not found',
                'data'=> false
            ]);
        }
        $userModel->delete($id);
        return $this->response->setJSON([
            'message'=> 'User deleted successfully',
            'data'=> true
        ]);
    }

    public function changePassword($id){

        $payload = $this->request->getJSON();
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if(!$user){
            return $this->response->setJSON([
                'message'=> 'User not found',
                'data'=> false
            ]);
        }

        $rules = [
            'password'=> 'required|min_length[6]',
        ];

        $payloadArray = (array) $payload;

        if(!$this->validateData( $payloadArray, $rules)){
            return $this->response->setJSON([
                'message'=> 'Validation failed',
                'error'=> $this->validator->getErrors(),
            ])->setStatusCode(400);
        }

        $password = password_hash($payload->password, PASSWORD_BCRYPT);

        $userModel->update($id, [
            'password' => $password
        ]);
        return $this->response->setJSON([
            'message'=> 'Password reset successfully',
            'data'=> true
        ]);
    }

    public function addUserGroup() : ResponseInterface
    {
        $payload = $this->request->getJSON();
        $user_id = $payload->user_id;
        $group_id = $payload->group_id;

        $rules = [
            'user_id'=> 'required|integer',
            'group_id'=> 'required|integer',
        ];

        $payloadArray = (array) $payload;

        if(!$this->validateData( $payloadArray, $rules, [
            'group_id' => ['is_unique[user_groups.user_id, group_id, ' . $user_id . ']' => 'User have group already'],
        ] )){
            return $this->response->setJSON([
                'message' => 'Validation failed',
                'data' => $this->validator->getErrors(),
            ]);
        }

        $db = db_connect();
        $builder = $db->table('user_groups');

        $q = $builder->insert(
            ['group_id'=> $group_id,'user_id'=> $user_id]
        );

        return $this->response->setJSON([
            "message" => "User Group created successfully",
            "data"=> $q
        ]);

    }

    public function getUserGroup($id): ResponseInterface{
        $db = db_connect();
        $builder = $db->table('user_groups');
        $q = $builder->select(
                ["user_groups.group_id group_id", 
                "groups.name group_name"]
            )->join('groups', 'groups.id = user_groups.group_id', 'left')
             ->where('user_id', $id)->get()->getResultArray();

        return $this->response->setJSON([
            "message" => "User Group retrieved successfully",
            "data"=> $q
        ]);

    }

    public function deleteUserGroups($id): ResponseInterface{
        $db = db_connect();
        $builder = $db->table('user_groups');
        $q = $builder->delete(['user_id'=> $id]);
        return $this->response->setJSON([
            "message" => "User Groups deleted successfully",
            "data"=> true
        ]);
    }

    public function deleteUserGroup(): ResponseInterface{
        $payload = $this->request->getJSON();
        $user_id = $payload->user_id;
        $group_id = $payload->group_id;
        $db = db_connect();
        $builder = $db->table('user_groups');
        $q = $builder->delete(['group_id'=> $group_id, 'user_id'=> $user_id]);
        return $this->response->setJSON([
            "message" => "User Group deleted successfully",
            "data"=> true
        ]);
    }
}

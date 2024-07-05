<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\PermissionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Firebase\JWT\JWT;


class PermissionController extends BaseController
{
    public function store(): ResponseInterface{
        $permission = new PermissionModel();
        $permission->insert($this->request->getJSON());

        return $this->response->setJSON([
            "message" => "Permission created successfully",
            "data"=> $permission
        ]);
    }

    public function update(int $id): ResponseInterface{
        $permissionModel = new PermissionModel();
        $permission = $permissionModel->find($id);

        if(!$permission){
            return $this->response->setJSON([
                "message" => "Permission not found",
                "data"=> null
            ])->setStatusCode(404);            
        }

        $permissionModel->update($id, $this->request->getJSON());
        return $this->response->setJSON([
            "message" => "Permission updated successfully",
            "data"=> $permission
        ]);
    }

    public function addGroupPermission(): ResponseInterface{
        $payload = $this->request->getJSON();
        $group_id = $payload->group_id;
        $permission_id = $payload->permission_id;

        $rules = [
            'group_id'=> 'required|integer',
            'permission_id'=> 'required|integer',
        ];

        $payloadArray = (array) $payload;

        if(!$this->validateData( $payloadArray, $rules, [
            'permission_id' => ['is_unique[group_permissions.group_id, permission_id, ' . $group_id . ']' => 'Group have permission already'],
        ] )){
            return $this->response->setJSON([
                'message' => 'Validation failed',
                'data' => $this->validator->getErrors(),
            ]);
        }

        $db = db_connect();
        $builder = $db->table("group_permissions");

        $q = $builder->insert(
            [
                'group_id' => $group_id,
                'permission_id' => $permission_id
            ]
        );
        return $this->response->setJSON([
            "message" => "Group Permission created successfully",
            "data"=> $q
        ]);
    }

    public function getUserPermission(){
        $currentUser = $this->request->user;
        $user = new UserModel();

        $userData = $user->where('id', $currentUser['id'])->first();

        $groupModel = new GroupModel();
        $userPermissions = $groupModel->builder()->select([
                'groups.id group_id',
                'groups.name group_name',
                'permissions.id permission_id',
                'permissions.name permission_name'])
            ->join('user_groups', 'user_groups.group_id = groups.id')
            ->join('group_permissions', 'group_permissions.group_id = groups.id')
            ->join('permissions', 'group_permissions.permission_id = permissions.id')
            ->where('user_groups.user_id', $userData['id'])
            ->get()->getResultArray();

        $permissionsByGroup = [];

        foreach ($userPermissions as $permission) {
            $groupName = $permission['group_name'];
            $permissionName = $permission['permission_name'];

            if(!isset($permissionsByGroup[$groupName])) {
                $permissionsByGroup[$groupName] = [];
            }

            $permissionsByGroup[$groupName][] = $permissionName;
        }

        $activeGroup = $groupModel->where('id', 1)->first();

        return $this->response->setJSON([
            'message' => 'User permissions',
            'data' => [
                'user_id'=> $userData['id'],
                'name'=> $userData['name'],
                'email'=> $userData['email'],
                'permissions'=> $userPermissions,
                'permissions_by_group'=> $permissionsByGroup,
                'active_group' => $activeGroup['name']
            ],
        ])->setStatusCode(200);


    }


}

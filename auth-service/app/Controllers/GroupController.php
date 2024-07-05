<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use CodeIgniter\HTTP\ResponseInterface;

class GroupController extends BaseController
{
    public function showAll(): ResponseInterface{
        $group = new GroupModel();
        $groups = $group->findAll();
        return $this->response->setJSON([
            "message"=> 'Groups retrieved successfully',
            'data'=> $groups
        ]);
    }

    public function show(int $id): ResponseInterface{
        $groupModel = new GroupModel();
        $group = $groupModel->find($id);
        if(!$group){
            return $this->response->setJSON([
                "message" => "Group not found",
                "data"=> null
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            "message"=> 'Group retrieved successfully',
            'data'=> $group
        ]);
    }

    public function store(): ResponseInterface{
        $group = new GroupModel();
        $group->insert($this->request->getJSON());

        return $this->response->setJSON([
            "message" => "Group created successfully",
            "data"=> $group
        ]);
    }

    public function update(int $id): ResponseInterface{
        $groupModel = new GroupModel();
        $group = $groupModel->find($id);

        if(!$group){
            return $this->response->setJSON([
                "message" => "Group not found",
                "data"=> null
            ])->setStatusCode(404);            
        }

        $groupModel->update($id, $this->request->getJSON());
        return $this->response->setJSON([
            "message" => "Group updated successfully",
            "data"=> $group
        ]);
    }

    public function delete(int $id): ResponseInterface{
        $groupModel = new GroupModel();
        $group = $groupModel->find($id);
        if(!$group){
            return $this->response->setJSON([
                "message" => "Group not found",
                "data"=> null
            ])->setStatusCode(404);
        }
        $groupModel->delete($id);

        return $this->response->setJSON([
            "message" => "Group deleted successfully",
            "data"=> null
        ]);
    }
        
}

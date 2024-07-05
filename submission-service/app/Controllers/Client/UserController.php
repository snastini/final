<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Exception;

class UserController extends BaseController
{

    use ResponseTrait;
    protected $authService;

    public function __construct(){
        
        $this->authService = Services::AuthServiceApi();
    }

    public function index()
    {
        try {
            $users = $this->authService->getAllUsers();
            $group = $this->authService->getAllGroups();
            $groupPermission = session('permissions_by_group');

            $data = [
                'title' => 'User Management',
                'list'  => $users,
                'list_group'  => $group['data'],
                'groupPermission' => $groupPermission
                
            ];
            
            return view('user/page', $data);
        }
        catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function getUser(){
        try{
            $id = $this->request->getPost('id');
            $user = $this->authService->getUserById($id);

            return $this->response->setJSON($user);

        } catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back();
        }
            
    }


    public function updateUser($id){
        try{
            //$id = $this->request->getPost('id');
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email')
            ];
            $user = $this->authService->updateUser($id, $data);

            if(isset($user->error)){
                $e = [];
                foreach($user->error as $key => $value){
                    array_push($e, $value);
                }
                session()->setFlashdata('errors', $e);
                return redirect()->back()->withInput();            
            } 

            session()->setFlashdata('success', $user['message']);  
            return redirect()->back(); 

        } catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back();
        }
        
    }

    public function resetPassword($id){

        try{
            $password1 = $this->request->getPost('user_password');
            $password2 = $this->request->getPost('user_password2');

            if($password1 != $password2){
                session()->setFlashdata('errors', ['Password does not match.']);
                return redirect()->back()->withInput();
            }

            $data = [
                'password' => $password1
            ];
            $user = $this->authService->changePassword($id, $data);

            if(isset($user->error)){
                $e = [];
                foreach($user->error as $key => $value){
                    array_push($e, $value);
                }
                session()->setFlashdata('errors', $e);
                return redirect()->back()->withInput();            
            }

            session()->setFlashdata('success', $user['message']);

            return redirect()->back();

        }

        catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back();
        }
    }

    public function getGroup(){

        try{
            $id = $this->request->getPost('id');
            $group = $this->authService->getUserGroup($id);           

            return $this->response->setJSON($group);


        } catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back();
        }
    }

    public function accept($id){

        try{
           
            $data = ['is_registered'=> 1];
            $acc =  $this->authService->updateUser($id, $data);

            if($acc['data'] == null){
                session()->setFlashdata('errors', [$acc['message']]);
                return redirect()->back();
            }

            $userGroup = [
                'user_id' => $id,
                'group_id' => 1
            ];

            $addGroup = $this->authService->addUserGroup($userGroup);

            if($addGroup['data'] == null){
                session()->setFlashdata('errors', [$addGroup['message']]);
                return redirect()->back();
            }

            session()->setFlashdata('success', $acc['message']);
            return redirect()->back();

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back();
        }

    }

    public function delete($id){
        try{

            $delUserGroup = $this->authService->deleteUserGroups($id);
            $result = $this->authService->deleteUser($id);
            

            if($result['data'] == false){
                session()->setFlashdata('errors', [$result['message']]);
                return redirect()->back();
            }

            session()->setFlashdata('success', $result['message']);
            return redirect()->back();

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage(),
                'data' => false
            ])->setStatusCode(500);
        }
    }
    

    public function addGroup($id){
        try{
            $del = $this->authService->deleteUserGroups($id);
            $data = $this->request->getPost();

            foreach($data as $key => $value){
                $params = [
                    'user_id' => $id,
                    'group_id' => $value
                ];

                $result = $this->authService->addUserGroup($params);
                if($result['data'] == null){
                    session()->setFlashdata('errors', [$result['message']]);
                    return redirect()->back();
                } 
            }

            session()->setFlashdata('success', 'Group updated successfully');
            return redirect()->back();



        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage(),
                'data' => false
            ])->setStatusCode(500);
        }
    }

    public function deleteGroup(){

        try{
            $data = [
                'user_id' => $this->request->getPost('user_id'),
                'group_id' => $this->request->getPost('group')
                ];

            $result = $this->authService->deleteUserGroup($data);

            if($result['data'] == null){
                session()->setFlashdata('errors', [$result['message']]);
                return redirect()->back();
            }

            session()->setFlashdata('success', $result['message']);
            return redirect()->back();

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back();
        }
    }


}

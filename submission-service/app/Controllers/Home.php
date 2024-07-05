<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Exception;

class Home extends BaseController
{

    use ResponseTrait;
    protected $authService;

    public function __construct(){
        
        $this->authService = Services::AuthServiceApi();
    }

    public function index(): string
    {
        return view('login');
    }

    public function unAuthorized() {
        $data = [
            'title' => 'Unauthorized',
            'message' => 'You do not have permission to access this page.',
            'code' => 401,
            'page' => 'login',
            'url' => base_url('/')
        ];
        return view('errors/unauthorized', $data);
    }

    public function forbidden() {
        $data = [
            'title' => 'Forbidden',
            'message' => 'You do not have permission to access this page.',
            'code' => 403,
            'page' => 'dashboard',
            'url' => base_url('dashboard')
        ];
        return view('errors/unauthorized', $data);
    }

    public function login(){
        try{ 
             $email  = $this->request->getPost('email');
             $password = $this->request->getPost('password');

            $input = [
                'email'=> $email,
                'password'=> $password
            ];  

            //$input = $this->request->getJSON(true);

            $validation = Services::validation();
            $validation->setRules([
                'email' => 'required|valid_email',
                'password' => 'required'
            ]);

            if(!$validation->run($input)){
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
            $user = $this->authService->login(
                [
                    'email'=> $input['email'],
                    'password'=> $input['password']
                ]);

            if(isset($user->error)){
                $e = [];
                foreach($user->error as $key => $value){
                    array_push($e, $value);
                }
                session()->setFlashdata('errors', $e);

                return redirect()->back()->withInput();
                                
            } 
            
            // if($user['data'] == null){
            //     session()->setFlashdata('errors', ['Invalid email or password.']);
            //     return redirect()->back()->withInput();
            // } 


            $userAuth = $this->authService->getUser($user['data']['token']);
            $userData = $userAuth['data'];

            $sessionData = [
                'user_id' => $userData['user_id'],
                'name'=> $userData['name'],
                'email'=> $userData['email'],
                'permissions'=> $userData['permissions'],
                'permissions_by_group'=> $userData['permissions_by_group'],
                'active_group' => $userData['active_group']
            ];

            $session = Services::session();
            $session->set($sessionData);  
    
  
            return redirect('dashboard');

        } catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back()->withInput();
        }
    }



    public function register(){
        return view('register');
    }

    public function submitRegister(){
        try{
            $name  = $this->request->getPost('name');
            $email  = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $password2 = $this->request->getPost('password2');

            if($password != $password2){
                session()->setFlashdata('errors', ['Password does not match.']);
                return redirect()->back()->withInput();
            }

            $input = [
                'name'=> $name,
                'email'=> $email,
                'password'=> $password
            ];

            $validation = Services::validation();
            $validation->setRules([
                'name' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required'
            ]);

            if(!$validation->run($input)){
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }

            $user = $this->authService->register(
                [
                    'name'=> $input['name'],
                    'email'=> $input['email'],
                    'password'=> $input['password']
                ]);
            
            
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
            

            //session()->setFlashdata('success', 'User created successfully.');
            // return $this->response->setJSON($user->data);//redirect()->back()->withInput();

        } catch (Exception $e) {
            $this->logger->error("Error from Auth Service: " . $e->getMessage());
            session()->setFlashdata('errors', [$e->getMessage()]);
            return redirect()->back()->withInput();
        }
    }
}

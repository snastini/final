<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class DashboardController extends BaseController
{
    use ResponseTrait;
    protected $submissionService;
    protected $authService;
    public function __construct()
    {
        $this->submissionService = Services::SubmissionServiceApi();
        $this->authService = Services::AuthServiceApi();
    }
    public function index()
    {
        
        $groupPermission = session('permissions_by_group');
        $submission = $this->submissionService->getSubmissionRecap();


        $data = [
            'title' => 'Dashboard',
            'groupPermission' => $groupPermission,
            'submission' => $submission
        ];
        
        return view('dashboard/page', $data);
    }

    public function changeGroup(){

        //$payload = $this->request->getJSON();
        $request = Services::request();
        $groupName = $request->getPost('groupName');

        $session = Services::session();
        $session->set('active_group', $groupName);  

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function changePassword($id){
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
}

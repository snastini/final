<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Exception;

class AuthController extends BaseController
{

    use ResponseTrait;
    protected $authService;

    public function __construct(){
        helper("cookie"); 
        $this->authService = Services::AuthServiceApi();
    }

    public function logout()
    {
        $user = $this->authService->logout();

        if (!$user) {
            return $this->response->setJSON([
                'message' => 'User failed to logged out successfully',
                'data' => $user
            ]);
        }
        
        $session = Services::session();
        $session->destroy(); 
        return redirect('/');
    }


}

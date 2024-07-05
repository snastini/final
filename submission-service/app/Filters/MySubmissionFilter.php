<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class MySubmissionFilter implements FilterInterface
{
    use ResponseTrait;
    protected $submissionService;

    public function __construct(){

        $this->submissionService = Services::SubmissionServiceApi();
    }

    public function before(RequestInterface $request, $arguments = null){

        $uri = $request->getUri();
        $segment = $uri->getSegment(3);

        $detail = $this->submissionService->getSubmissionDetail($segment);

        if(session('active_group') == 'Pegawai'){
            if($detail['data'][0]['request_user_id'] != session('user_id')){
                return redirect('forbidden');
            }
        }

        return $request;

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
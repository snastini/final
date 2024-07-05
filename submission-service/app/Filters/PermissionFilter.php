<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null){

        $permissionByGroup = session('permissions_by_group');
        $activeGroup = session('active_group');
        
        foreach($arguments as $arg){
            if(!in_array($arg, $permissionByGroup[$activeGroup])){
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
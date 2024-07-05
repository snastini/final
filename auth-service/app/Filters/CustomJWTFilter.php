<?php 
namespace App\Filters;

use App\Exceptions\UnauthorizedException;
use App\Models\GroupModel;
use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;


class CustomJWTFilter implements FilterInterface{

    public function before(RequestInterface $request, $arguments = null){
        $key = 'secret';

        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        $splitHeader = explode(' ', $authHeader);

        if(count($splitHeader) != 2){
            throw new UnauthorizedException('Invalid Token');
        }

        if($splitHeader[0] != 'Bearer'){
            throw new UnauthorizedException('Invalid Token');
        }

        $jwt = $splitHeader[1];

        try{
            $jwtKey = new Key($key, 'HS256');
            $decoded = JWT::decode($jwt, $jwtKey);
            $decoded_array = (array) $decoded;         
            
        } catch(ExpiredException $e){
            throw new UnauthorizedException('Expired Token');
        } catch(Exception $e){
            throw new UnauthorizedException('Invalid Token');
        }

        $user = new UserModel();
        $user = $user->where('email', $decoded_array['email'])->first();

        log_message('debug', "User: " . json_encode($user));

        if(!$user){
            throw new UnauthorizedException('User Not Found');
        }

        $userPermissions = [];

        $cacheKey = 'user_permissions_' . $user['id'];

        if(!cache($cacheKey)){
            $groupModel = new GroupModel();
            $userPermissions = $groupModel->builder()->select([
                    'groups.id group_id',
                    'groups.name group_name',
                    'permissions.id permission_id',
                    'permissions.name permission_name'])
                ->join('user_groups', 'user_groups.group_id = groups.id')
                ->join('group_permissions', 'group_permissions.group_id = groups.id')
                ->join('permissions', 'group_permissions.permission_id = permissions.id')
                ->where('user_groups.user_id', $user['id'])
                ->get()->getResultArray();

            $expCache = 60*60*24;

            cache()->save($cacheKey, $userPermissions, $expCache);

        } else {
            $userPermissions = cache($cacheKey);
        }   
        
        $request->user = $user;
        $request->user_permissions = $userPermissions;

        return $request;

    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        // Do something here    
    }
}
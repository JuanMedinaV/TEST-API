<?php

namespace App\Cotrollers;

use App\Controllers\BaseController;
use App\CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait as APIResponseTrait;

use function PHPUnit\Framework\matches;

class register extends BaseController
{
    use APIResponseTrait;

    public function index()
    {
        $rules =[
            'email' =>['rules' => 'required|min_legth[4]|max_legth[255]valid_email|is_unique[users.email]'],
            'password'=>['rules' => 'required|min_legth[8]max_legth[255]'],
            'corfirm_password' => ['label' => 'confirm password', 'rules' => 'matches[password]']
        ];

        if($this->validate($rules)){
            $model = new UserModel ();
            $data = [
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $model->save($data);

            return $this->respond(['message' => 'registered succesfully'], 200);
        }else{
            $response =[
                'errors' => $this->validator->getErrors(),
                'message' => 'invalid inputs'
            ];
            return $this->fail($response, 409);
        }
    }
}
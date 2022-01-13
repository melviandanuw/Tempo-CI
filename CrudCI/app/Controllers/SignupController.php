<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class SignupController extends Controller
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('signup', $data);
    }

    public function store()
    {
        $request = \Config\Services::request();

        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
            'confirmpassword'  => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();

            $data = [
                'name'     => $request->getVar('name'),
                'email'    => $request->getVar('email'),
                'password' => password_hash($request->getVar('password'), PASSWORD_DEFAULT)
            ];

            $userModel->save($data);

            return redirect()->to('/signin');
        } else {
            $data['validation'] = $this->validator;
            echo view('signup', $data);
        }
    }
}

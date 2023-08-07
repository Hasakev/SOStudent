<?php

namespace App\Controllers;

class Login extends BaseController
{
    protected $helpers = ['cookie'];
    public function index()
    {
        $qMod = model('App\Models\Question_model');
        $questions = $qMod->get_question();
        $data['ques'] = $questions;
        $data['error'] = "";
        // check whether the cookie is set or not, if set redirect to welcome page, if not set, check the session
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            echo view("template/header");
            echo view("homepage", $data);
            echo view("template/footer");
        }
        else {
            $session = session();
            $username = $session->get('username');
            $password = $session->get('password');
            if ($username && $password) {
                echo view("template/header");
                echo view("homepage", $data);
                echo view("template/footer");
            } else {
                echo view('template/header');
                echo view('login', $data);
                echo view('template/footer');
            }
        }
    }

    public function check_login() {
        $qMod = model('App\Models\Question_model');
        $questions = $qMod->get_question();
        $data['ques'] = $questions;
        $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\">Password is incorrect. Please try again. </div> ";
        $username = $this->request->getPost('username'); 
        $password = $this->request->getPost('password');
        $model = model('App\Models\User_model');
        $check = $model->login($username, $password);
        $if_remember = $this->request->getPost('remember');
        $check_username = $model->check_exists('username', $username);
        if ($check) {
            # Create a session 
            $session = session();
            $session->set('username', $username);
            $newpass = ($model->get_details($_SESSION['username']))['password'];
            $session->set('password', $newpass);
            if ($if_remember) {
                # Create a cookie
                set_cookie('username', "$username", (86400 * 30)); #30 days
                set_cookie('password', "$password", (86400 * 30));
            }
            $model->drop_code_when_login($username);
            echo view("template/header");
            echo view("homepage", $data);
            echo view("template/footer");
        } else if ($check_username) {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Username does not exists. <br> <a href=\"https://infs3202-e717fd19.uqcloud.net/index/signup\"> Create a new account.</a> </div> ";
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        } else {
            echo view('template/header');
            echo view('login', $data);
            echo view('template/footer');
        }
    }

    public function logout() {
        helper('cookie');
        $session = session();
        $session->destroy();
        //destroy the cookie
        setcookie('username', '', time() - 3600, "/");
        setcookie('password', '', time() - 3600, "/");
        return redirect()->to(base_url('login'));
    }
}


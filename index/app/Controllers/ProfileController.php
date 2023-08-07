<?php

namespace App\Controllers;
use COdeIgniter\HTTP\IncomingRequest;

class ProfileController extends BaseController
{
    protected $helpers = ['cookie'];

    public function index() {
        $session = session();
        if (! ($session->has('username'))) {
            header("Location: login");
        }
        $value = $session->get('username');
        $model = model('App\Models\User_model');
        $details = $model->get_details($value);
        echo view('template/header');
        echo view('profile', $details);
        echo view('template/footer');
    }
    public function verify($code)
    {   
        $request = $this->request;
        if(!($request->isAJAX())) {
            return view('errors/html/error_404');
        }
        $value = session()->get('username');
        $model = model('App\Models\User_model');
        $details = $model->get_details($value);
        $email = $details['email'];
        if ($model->verification_status($email)) {
            return "Verified";
        }
        if ($model->check_verification_code($email, $code)) {
            $model->verify_success($email);
            return "Verified";
        } else {
            if (!($code == 'empty')) {
            print("<div class=\"alert alert-danger\" role=\"alert\"> Invalid Code, Please Try Again</div> ");
            }
        }
        
        return "Unverified";
    } 

    public function change_detail($string, $string2='username') {
        if (!(session()->has('username'))) {
            header("Location: login");
        }
        if (!($string == 'firstname' || $string == 'username')) {
            return view('errors/html/error_404');
        }
        $data['error'] = "";
        $model = model('App\Models\User_model');
        $value = $this->request->getPost($string);
        $value2 = $this->request->getPost($string2);
        if (! $this->request->is('post')) {
            $this->reprint($data, 'change_'.$string);
            return;
        }
        if ($string == $string2) {
            $rules = ['username' => 'required|min_length[4]|max_length[15]'];
        } else {
            $rules = [
                'firstname' => 'required|alpha|max_length[16]',
                'lastname' => 'required|alpha_space|max_length[16]'
            ];
        }
        if (! ($this->validate($rules))) {
            $data['validation'] = $this->validator;
            $this->reprint($data, 'change_'.$string);
            return;
        }
        $session = session();
        if ($string == 'username' && !($model->check_exists($string, $value))) {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Username already exists. Try a different one. ";
            if ($value = $_SESSION['username']) {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> This is your current username. Try a different one. ";
            }
            $this->reprint($data, 'change_'.$string);
            return;
        }
        $model->change_details($string, $value, $_SESSION['username']);
        if ($string != $string2) {
            $model->change_details($string2, $value2, $_SESSION['username']);
        }
        echo view('template/header');
        if ($string == $string2) {
            $session->set($string, $value);
            if (has_cookie('username')) {
                set_cookie('username', "$value", (86400 * 30));
            }
        }
        
        if ($string == $string2) {
            print('<div id="main"> Username successfully changed. <br>');
        } else {
            print('<div id="main"> Name successfully changed. <br>');
        }
        echo anchor(base_url()."profile", 'Go Back');
        print('</div>');
        echo view('template/footer');
        return;
    }

    private function reprint($data, $page) {
        echo view('template/header');
        echo view($page, $data);
        echo view('template/footer');
        return;
    }

}

?>

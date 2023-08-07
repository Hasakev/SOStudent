<?php
namespace App\Controllers;
class PasswordController extends BaseController
{
    protected $helpers = ['form', 'text'];
    public function index()
    {
        if (!(session()->has('username'))) {
            header("Location: login");
        }
        $data['error'] = "";
        $model = model('App\Models\User_model');
        $oldpassword = $this->request->getPost('oldpassword');
        $password = $this->request->getPost('password');
        if (! $this->request->is('post')) {
            $this->reprint_register($data);
            return;
        }

        $rules = [
            'oldpassword' => 'required',
            'password' => [
                'rules' => 'required|min_length[10]|max_length[999]|differs[oldpassword]',
                'errors' => [
                    'required' => 'Please enter a new password.',
                    'max_length' => 'Your password is too long please try again.',
                    'differs' => 'Your old password is the same as your new password, please try again.'        
                ]
                ],
            'passwordconf' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please re-enter your password for confirmation.',
                    'matches' => 'The new passwords you entered do not match. Please try again.'
                ]
            ]
        ];
        if (! ($this->validate($rules))) {
            $data['validation'] = $this->validator;
            $this->reprint_register($data);
            return;
        }
        $session = session();
        $check = false;
        if (password_verify("$oldpassword", $_SESSION['password'])) {
            $check = true;
        }
        if (! $check) {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Your old password was incorrect, try again. ";
            $this->reprint_register($data);
            return;
        }
        $model->change_details('password', password_hash("$password", PASSWORD_DEFAULT), $_SESSION['username']);
        echo view('template/header');
        $newpass = ($model->get_details($_SESSION['username']))['password'];
        $session->set('password', $newpass);
        if (has_cookie('username')) {
            set_cookie('username', "$newpass", (86400 * 30));
        }
        print('<div id="main"> Password successfully changed. <br>');
        echo anchor(base_url()."profile", 'Go Back');
        print('</div>');
        echo view('template/footer');
        return;
        
    }

    private function reprint_register($data) {
        echo view('template/header');
        echo view('change_password', $data);
        echo view('template/footer');
        return;
    }

    public function forgot_password() {
        if ($this->request->is('post')) {
            $data['error'] = "";
            $data['message'] = "";
            $model = model('App\Models\User_model');
            $email = $this->request->getPost('email');
            if ($model->check_exists('email', $email)) {
                $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\">There is no account attached to this email. Please try again. </div> ";
            } else {
                $code = random_string('crypto', 10);
                $url = base_url()."forgot/verify/".$code;
                $message = 
                "Hi!\n 
                At your request, We have sent you a link to reset your password.\n
                If this was not you, please ignore this message. \n
                If you remember your password and log in, the link will be terminated. \n
                To set your new password, visit the following link:\n" 
                . $url ."\nThe SOSStudent Team";
                $subject = "SOSStudent - Password Reset";
                $model->send_email($email, $subject, $message);
                $data['message'] = "<div> We have sent a link to reset your password to your email. <br> 
                If you attempt to reset your password again, we will re-send the link but the previous emailed link will become invalid. </div>";
                $model->code_to_database($email, $code); 
            }
            echo view('template/header');
            echo view('reset_password', $data);
            echo view('template/footer');
            return;
        }
        $data['message'] = "";
        $data['error'] = "";
            echo view('template/header');
            echo view('reset_password', $data);
            echo view('template/footer');
        return;
    }

    public function forgot_verify($code) {
        $data['code'] = $code;
        if ($this->request->is('POST')) {
            $this->verification_forgot_pass($data);
            return; 
        }
        $model = model('App\Models\User_model');
        if ($model->code_exists_return_email($code) == false) {
            return view('errors/html/error_404');
        } else {
            echo view('template/header');
            echo view('change_pass_reset', $data);
            echo view('template/footer');
            return;
        }
    }
    private function verification_forgot_pass($data) {
        $password = $this->request->getPost("password");
        $rules = [
            'password' => ['rules' => 'required|min_length[10]|max_length[999]'],
            'passconf' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please re-enter your password for confirmation.',
                    'matches' => 'The new passwords you entered do not match. Please try again.'
                ]
            ]
        ];
        if (! ($this->validate($rules))) {
            $data['validation'] = $this->validator;
            echo view('template/header');
            echo view('change_pass_reset', $data);
            echo view('template/footer');
            return;
        }
        $model = model('App\Models\User_model');
        $model->change_pass_via_forgot($data['code'], $password);
        echo view('template/header');
        print('<div id="main"> Password successfully changed. <br>');
        echo anchor(base_url()."login", 'Go Back');
        print('</div>');
        echo view('template/footer');
        return;
        
    }
}
?>
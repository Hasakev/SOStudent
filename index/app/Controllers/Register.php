<?php
namespace App\Controllers;
class Register extends BaseController
{
    protected $helpers = ['form','text'];
    public function index() 
    {
        $data['error'] = "";
        $model = model('App\Models\User_model');
        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        if (! $this->request->is('post')) {
            $this->reprint_register($data);
            return;
        }

        $rules = [
            'firstname' => 'required|alpha|max_length[16]',
            'lastname' => 'required|alpha_space|max_length[16]',
            'username' => 'required|min_length[4]|max_length[15]',
            'password' => 'required|min_length[10]|max_length[999]',
            'passconf' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                'required' => 'Please re-enter your password for confirmation.',
                'matches' => 'The passwords you entered do not match. Please try again.'
                ]
            ],
            'email'    => 'required|valid_email',
        ];
        if (! ($this->validate($rules))) {
            $data['validation'] = $this->validator;
            $this->reprint_register($data);
            return;
        }
        $check = $model->register($firstname,$lastname,$username,$email,$password);
        if ($check != null) {
            $data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Your " . $check[0] . " is already taken. Please try again. </div> ";
            $this->reprint_register($data);
            return;
        }
        $code = random_string('crypto',10);
        $model->email_verify($email, $code);
        $message = 
        "Hi " . $firstname . ",\n
        Welcome to SOSStudent! \n
        Please verify your email using the following code: \n"
        . $code . "\n
        By verifying your email we are able to reset your password 
        and also provide you with other privileges.\n
        Thanks,\n 
        The SOSStudent team";
        $subject = "SOSStudent - Email Verification";
        if ($model->send_email($email, $subject, $message)) {
            echo view('template/header');
            echo view('account_success');
            echo view('template/footer');
            return;
        } else {
            echo view('template/header');
            echo view('account_success');
            echo 'Error sending email. Please try again later in your profile page.';
            echo view('template/footer');
            return;
        }
    }
    private function reprint_register($data) {
        echo view('template/header');
        echo view('register', $data);
        echo view('template/footer');
        return;
    }

    
}
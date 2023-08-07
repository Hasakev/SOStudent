<?php

namespace App\Models;

use CodeIgniter\Email\Email;
use CodeIgniter\Model;

class User_model extends Model
{
    protected $helpers = ['text'];
    public function login($username, $password)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('username', $username);
        $query = $builder->get(); 
        $crypt = $query->getRow('password');
        if (password_verify($password,$crypt)) { 
            return true;
        }
        return false;
    }

    public function check_exists($string, $field) { #checks if email already exists
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where($string, $field)
        ->select($string);
        $query = $builder->get(); 
        if ($query->getRowArray()==null) { 
            return true;
        }
        return false;
    }

    public function register($firstname, $lastname, $username, $email, $password)
    {
        if (!($this->check_exists('username', $username))) {
            return ['username', $username];
        } else if (!($this->check_exists('email', $email))) {
            return ['email', $email];
        }
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'password' =>  password_hash($password, PASSWORD_DEFAULT),
        ];
        $builder->insert($data);
        return null;
    }

    public function email_verify($email, $code)
    {
        $db = \Config\Database::connect();
        $builder = $db -> table('email_verify');
        $data = [
            'email' => $email,
            'code' => $code,
            'status' => false
        ];
        $builder->insert($data);
        return;
    }

    public function get_details($username)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('username', $username);
        $query = $builder->get(1); 
        $first = $query->getRow('firstname');
        $last = $query->getRow('lastname');
        $email = $query->getRow('email');
        $password = $query->getRow('password');
        $arr = [
                'username' => $username,
                'first' => $first,
                'last' => $last,
                'email' => $email,
                'password' => $password];
        return $arr;
    }

    public function change_details($target, $value, $username) 
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users'); 
        $updatedData = [$target => $value];
        $builder->where('username', $username);
        $builder->update($updatedData);
        return;
    }
    public function verification_status($email)
    {
        $db = \Config\Database::connect();
        $builder = $db -> table('email_verify');
        $builder->where('email', $email);
        $query = $builder->get(1);
        return $query->getRow('status');
    }

    public function verify_success($email)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('email_verify');
        $builder->where('email', $email);
        $updatedData = ['status' => 1];
        $builder->update($updatedData);
        return;
    }

    public function check_verification_code($email, $code)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('email_verify');
        $builder->where('email', $email);
        $query = $builder->get(1); 
        $check = $query->getRow('code');
        if ($code == $check) {
            return true;
        }
        return false;
    }

    public function send_email($email, $subject, $message) {
        $verification_email = new Email();
        $emailConf = [
            'protocol' => 'smtp',
            'wordWrap' => true,
            'SMTPHost' => 'mailhub.eait.uq.edu.au',
            'SMTPPort' => 25
        ];
        $verification_email->initialize($emailConf);
        $verification_email->setTo($email);
        $verification_email->setFrom("admin.account-zone@uqcloud.net");
        $verification_email->setSubject($subject);
        $verification_email->setMessage($message);
        if ($verification_email->send()) {
            return true;
        }
        return false;
    }

    public function code_to_database($email, $code) {
        $db = \Config\Database::connect();
        $builder = $db->table('forgot_password');
        if ($this->get_code($email)) {
            $builder->where('email', $email);
            $updatedData = ['code' => $code];
            $builder->update($updatedData);
            return null;
        }
        $data = [
            'email' => $email,
            'code' => $code
        ];
        $builder->insert($data);
        return null;
    }

    private function get_code($email) {
        $db = \Config\Database::connect();
        $builder = $db->table('forgot_password');
        $builder->where('email', $email);
        $query = $builder->get();
        if ($query->getRowArray()==null) {
            return false;
        } 
        $code = $query->getRow('code');
        return $code;
    }

    public function code_exists_return_email($code) {
        $db = \Config\Database::connect();
        $builder = $db->table('forgot_password');
        $builder->where('code', $code);
        $query = $builder->get();
        if ($query->getRowArray()==null) {
            return false;
        } else {
            $email = $query->getRow('email');
            return $email;
        }
    }
    private function drop_code($code) {
        $db = \Config\Database::connect();
        $builder = $db->table('forgot_password');
        $builder->where('code', $code);
        $builder->delete();
        return;
    }
    private function get_username_from_email($email) {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('email', $email);
        $query = $builder->get(1);
        return $query->getRow('username');
    }
    
    public function change_pass_via_forgot($code, $password) {
        $email = $this->code_exists_return_email($code);
        $username = $this->get_username_from_email($email);
        $this->change_details('password', password_hash($password, PASSWORD_DEFAULT), $username);
        $this->drop_code($code);
        return;
    }

    public function drop_code_when_login($username) {
        $details = $this->get_details($username);
        $email = $details['email'];
        $code = $this->get_code($email);
        $this->drop_code($code);
        return;
    }
}

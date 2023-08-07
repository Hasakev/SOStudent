<?php

namespace App\Models;

use CodeIgniter\Model;

class Upload extends Model
{
    public function upload($username, $filename)
    {
        $file = [
            'username' => $username,
            'filename' => $filename,
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('profile_pic');
        if ($this->check_exists($username)) {
            $db = \Config\Database::connect();
            $updatedData = ['filename' => $filename];
            $builder->where('username', $username);
            $builder->update($updatedData);
            return true;
        }
        if ($builder->insert($file)) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exists($username) {
        $db = \Config\Database::connect();
        $builder = $db->table('profile_pic');
        $builder->where('username', $username)
        ->select('username');
        $query = $builder->get(); 
        if ($query->getRowArray()==null) { 
            return false;
        }
        return true;
    }
        
}
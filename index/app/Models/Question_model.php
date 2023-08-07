<?php

namespace App\Models;

use CodeIgniter\Model;

use function PHPSTORM_META\map;

class Question_model extends Model
{
    protected $helpers = ['text'];

    public function add_question($username, $subject, $question, $content)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $data = [
            'username' => $username,
            'subject' => $subject,
            'question' =>  $question,
            'content' => $content,
            'id' => random_string("cypto", 5),
            'rating' => 0,
            'time' => date("d/m/Y, h:i:s a")
        ];
        $builder->insert($data);
        return null;
    }

    public function add_comment($username, $id, $comment)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comment');
        $data = [
            'username' => $username,
            'id' => $id,
            'comment' => $comment
        ];
        $builder->insert($data);
        return null;
    }

    public function get_details($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $builder->where('id', $id);
        $query = $builder->get(1); 
        $username = $query->getRow('username');
        $subject = $query->getRow('subject');
        $question = $query->getRow('question');
        $rating = $query->getRow('rating');
        $content = $query->getRow('content');
        $time = $query->getRow('time');
        $arr = [
                'id' => $id,
                'username' => $username,
                'subject' => $subject,
                'question' => $question,
                'rating' => $rating,
                'content' => $content,
                'time' => $time
        ];
        return $arr;
    }

    public function get_question()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $builder->orderBy('rating', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function get_comments($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('comment');
        $builder->where('id', $id);
        return $builder->get()->getResultArray();
    }

    public function delete_question($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $builder->delete(['id' => $id]); 
    }

    public function check_exists($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $builder->where('id',$id)->select('id');
        $query = $builder->get(); 
        if ($query->getRowArray()==null) { 
            return false;
        } 
        return true;
    }

    public function get_username($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $builder->where('id',$id)->select('username');
        $query = $builder->get();
        return $query->getRow('username');
    }

    public function like($id, $like) {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $plusOne = $this->get_likes($id) + 1;
        $minusOne = $this->get_likes($id) - 1;
        $updatedData = ['rating' => $minusOne];
        if ($like == '1') {
            $this->add_like($id, session()->get('username'));
            $updatedData = ['rating' => $plusOne];
        } else {
            $this->delete_like($id, $this->get_username($id));
        }
        $builder->where('id', $id);
        $builder->update($updatedData);
        return;
    }
    private function get_likes($id) {
        $db = \Config\Database::connect();
        $builder = $db->table('question');
        $builder->where('id', $id)->select('rating');
        $query = $builder->get();
        return intval($query->getRow('rating'));
    }

    private function add_like($id, $username) {
        $db = \Config\Database::connect();
        $builder = $db->table('fav');
        $data = [
            'username' => $username,
            'id' => $id
        ];
        $builder->insert($data);
        return null;
    }

    private function delete_like($id, $username) {
        $db = \Config\Database::connect();
        $builder = $db->table('fav');
        $builder->delete(['id' => $id, 'username' => $username]); 
    }

    public function has_liked($id, $username) {
        $db = \Config\Database::connect();
        $builder = $db->table('fav');
        $builder->where('id', $id);
        $builder->where('username', $username);
        $query = $builder->get(); 
        if ($query->getRowArray()!=null) { 
            return true;
        } else {
            return false;
        }
    }
}

<?php
namespace App\Controllers;
class QuestionController extends BaseController
{
    protected $helpers = ['form','text'];
    public function index() 
    {
        $data['error'] = "";
        $model = model('App\Models\Question_model');
        $subject = $this->request->getPost('subject');
        $question = $this->request->getPost('question');
        $content = $this->request->getPost('content');
        if (! $this->request->is('post')) {
            $this->reprint_register($data);
            return;
        }

        $model->add_question(session()->get('username'), $subject, $question, $content);
        echo view('template/header');
        print("<div id=\"main\"> Successfully posted new question! <br>");
        echo anchor(base_url()."login", 'Go Back');
        print("</div>");
        echo view('template/footer');
        return;
    }
    private function reprint_register($data) {
        echo view('template/header');
        echo view('post_question', $data);
        echo view('template/footer');
        return;
    }

    public function view_question($id) {
        session()->set('id', $id);
        $model = model('App\Models\Question_model');
        if (! ($model->check_exists($id))) {
            header("Location: /index/login");
        }
        echo view('template/header');
        
        $data = $model->get_details($id);
        $data['comments'] = $model->get_comments($id);
        echo view('question_page', $data);
        return;
    }

    public function delete_question($id) {
        $request = $this->request;
        if(!($request->isAJAX())) {
            return view('errors/html/error_404');
        }
        $model = model('App\Models\Question_model');
        $model->delete_question($id);
        header("Location: ".base_url()."/login");
        return;
    }
    
    public function like($id,$t) {
        $request = $this->request;
        if(!($request->isAJAX())) {
            return view('errors/html/error_404');
        }
        $model = model('App\Models\Question_model');
        $model->like($id,$t);
    }

    public function index_c() 
    {
        $id = session()->get('id');
        $data['error'] = "";
        $model = model('App\Models\Question_model');
        $comment = $this->request->getPost('comment');
        if (! $this->request->is('post')) {
            $this->reprint_register_c($data);
            return;
        }
        $model->add_comment(session()->get('username'), $id, $comment);
        echo view('template/header');
        print("<div id=\"main\"> Successfully posted added comment <br>");
        echo anchor(base_url()."question/".$id, 'Go Back');
        print("</div>");
        echo view('template/footer');
        return;
    }

    private function reprint_register_c($data) {
        echo view('template/header');
        echo view('add_comment', $data);
        echo view('template/footer');
        return;
    }
}
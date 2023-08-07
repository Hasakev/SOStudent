<?php
namespace App\Controllers;
class Upload extends BaseController
{
	public function index() {
        $data['errors'] = "";
        echo view('template/header');
        echo view('upload_form', $data);
        echo view('template/footer');
    }

    public function upload_file() {
        $data['errors'] = "";
        $username = session()->get("username");
        $file = $this->request->getFile('userfile');
        $file->move(WRITEPATH . 'uploads');
        $filename = $file->getName();
        $model = model('App\Models\Upload_model');
        $check = $model->upload($username, $filename);
        if ($check) {
            echo view('template/header');
            print('<div id="main"> Profile picture successfully changed. <br>');
            echo anchor(base_url()."profile", 'Go Back');
            echo view('template/footer');
        } else {
            $data['errors'] = "<div class=\"alert alert-danger\" role=\"alert\"> Upload failed!! </div> ";
            echo view('template/header');
            echo view('upload_form', $data);
            echo view('template/footer');
        }
        
    }
}

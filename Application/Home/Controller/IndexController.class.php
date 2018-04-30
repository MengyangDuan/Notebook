<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo"Hello";
        if(session('user')!=null){
            redirect('Application/pages/writenote.html', 0, '');
        }
        redirect('/Notebook/Application/pages/home.html', 0, '');

    }



}
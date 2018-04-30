<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/12/5
 * Time: 上午12:16
 */

namespace Home\Controller;


use Think\Controller;
use Home\Model\NoteModel as nm;

class NoteController extends Controller
{
    public function noteList(){
        $nm = new nm();
        $this->ajaxReturn($nm->getNotes(),"JSON");
    }

    public function noteAdd(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteAdd(),"JSON");
    }

    public function noteDelete(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteDelete(),"JSON");
    }

    public function noteModify(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteModify(),"JSON");
    }

    public function noteSearch(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteSearch(),"JSON");
    }

    public function noteIn(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteIn(),"JSON");
    }

    public function noteOut(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteOut(),"JSON");
    }

    public function noteDetail(){
        $nm = new nm();
        $this->ajaxReturn($nm->noteDetail(),"JSON");
    }

    public function labelSearch(){
        $nm = new nm();
        $this->ajaxReturn($nm->labelSearch(),"JSON");
    }

    public function noteShare(){
        $nm = new nm();
        $this->ajaxReturn($nm->NoteShare(),"JSON");
    }



}
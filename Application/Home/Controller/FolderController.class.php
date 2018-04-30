<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/12/5
 * Time: 下午2:58
 */

namespace Home\Controller;

use Think\Controller;
use Home\Model\FolderModel as fm;

class FolderController extends Controller
{
    public function folderList(){
        $fm = new fm();
        $this->ajaxReturn($fm->folderList(),"JSON");
    }

    public function folderDetail(){
        $fm = new fm();
        $this->ajaxReturn($fm->forderDetail(),"JSON");
    }

    public function folderAdd(){
        $fm = new fm();
        $this->ajaxReturn($fm->folderAdd(),"JSON");
    }

    public function folderDelete(){
        $fm = new fm();
        $this->ajaxReturn($fm->folderDelete(),"JSON");
    }

    public function folderSearch(){
        $fm = new fm();
        $this->ajaxReturn($fm->folderSearch(),"JSON");
    }

    public function labelSearch(){
        $fm = new fm();
        $this->ajaxReturn($fm->labelSearch(),"JSON");
    }

    //    public function folderIn(){
//        $fm = new fm();
//        $this->ajaxReturn($fm->folderIn(),"JSON");
//    }
//
//    public function folderOut(){
//        $fm = new fm();
//        $this->ajaxReturn($fm->folderOut(),"JSON");
//    }

}
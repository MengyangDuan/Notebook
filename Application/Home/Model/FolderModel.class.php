<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/12/5
 * Time: 上午12:28
 */

namespace Home\Model;


use Think\Model;
use MessageInfo;
class FolderModel extends Model
{
    public function folderList(){
        $user = session('user');
        $db = M('folder_record');
        $sql ="select * from folder_record where ownerid=".$user['id']." ";
        $result = $db->query($sql);
        if($result == null){
            return new MessageInfo(true,null,"还未建立任何笔记本");
        }
        return new MessageInfo(true,$result,"1560:获取笔记本列表成功");
    }

    public function folderDetail(){
        $user = session('user');
        $db = M('note_record');
        $folderid = I('post.id');
        $tem = $db->where("folderid=". $folderid.' AND ownerid='.$user['id'])->find();
        if($tem!=null){
            return new MessageInfo(true,$tem,"1560:获取成功");
        }
        else
            return new MessageInfo(false,null,"1520:获取失败");
    }


    public function folderAdd(){
        $user = session('user');
        if($user == null)
            return new MessageInfo(false,null,"请登录");
        $db = M('folder_record');
        $tem['ownerid'] = $user['id'];
        $tem['ownername'] = $user['username'];
        $tem['title']=I('post.title');
        $tem['label'] = I('post.label');
        $tem['createdate'] = time();
        $result = $db->data($tem)->add();
        if($result == false)
            return new MessageInfo(false,null,"1520:添加笔记本失败");
        return new MessageInfo(true,$tem,"1620:添加笔记本成功" );
    }

    public function folderDelete(){
        $user = session('user');
        $db = M('folder_record');
        $folderid = I('post.id');
        if($db->where('id='.$folderid.' AND ownerid='.$user['id'])->find()!=null){
            $db->where('id='.$folderid)->delete();
            $db2=M('note_record');
            $db2->where('folderid='.$folderid.' AND ownerid='.$user['id'])->delete();
            return new MessageInfo(true,null,"1620:删除成功");
        }else{
            return new MessageInfo(false,null,"1520:无权限删除");
        }
    }

    public function folderModify(){
        $user = session('user');
        $db = M('folder_record');
        $folder = I('post.');
        if($db->where('id='.$folder['id'].' AND ownerid='.$user['id'])->find()!=null){
            $data['title']=$folder['title'];
            $data['label']=$folder['label'];
            $db->where('id='.$folder['id'])->setField($data);
            $result=$db->where('id='.$folder['id'])->find();
            return new MessageInfo(true,$result,"1620:修改成功");
        }else {
            return new MessageInfo(false, null, "1520:无权限修改");
        }
    }

    public function folderSearch(){
        $user = session('user');
        $db = M('folder_record');
        $name = I('post.foldername');
        $result = "%".$name."%";
        $map['foldername'] = array('like',$result);
        $map['ownerid'] = $user['id'];
        $findNote = $db->where($map)->select();
        if(count($findNote) >= 0) {
            return new MessageInfo(true, $findNote, "1560:查找成功");
        }else{
            return new MessageInfo(false,null,"1520:未找到相关笔记本");
        }
    }

    public function labelSearch(){
        $user = session('user');
        $db = M('folder_record');
        $label = I('post.label');
        $result = "%".$label."%";
        $map['label'] = array('like',$result);
        $map['ownerid'] = $user['id'];
        $findFolder = $db->where($map)->select();
        if(count($findFolder) >= 0) {
            return new MessageInfo(true, $findFolder, "1560:查找成功");
        }else{
            return new MessageInfo(false,null,"1520:未找到相关笔记");
        }
    }

}
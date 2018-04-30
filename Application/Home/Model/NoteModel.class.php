<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/12/5
 * Time: 上午12:27
 */

namespace Home\Model;


use Think\Model;
use MessageInfo;
class NoteModel extends Model
{
    public function noteList(){
        $user = session('user');
        $db = M('note_record');
        $sql ="select ownerid, ownername, title,label,createTime from note_record where ownerid=".$user['id']."order by createtime desc";
        $result = $db->query($sql);
        if($result == null){
            return new MessageInfo(true,null,"还未发表任何笔记");
        }
        return new MessageInfo(true,$result,"1560:获取笔记列表成功");
    }

    public function noteDetail(){
        $user = session('user');
        $db = M('note_record');
        $noteid = I('post.id');
        $tem = $db->where("id=". $noteid.' AND ownerid='.$user['id'])->find();
        if($tem!=null){
            return new MessageInfo(true,$tem,"1560:获取笔记成功");
        }
        else
            return new MessageInfo(false,null,"1520:未找到该笔记");
    }

    public function noteAdd(){
        $user = session('user');
        if($user == null)
            return new MessageInfo(false,null,"请登录");
        $db = M('note_record');
        $tem['ownerid'] = $user['id'];
        $tem['ownername'] = $user['username'];
        $tem['title']=I('post.title');
        $tem['label']=I('post.label');
        $tem['content'] = I('post.content');
        $tem['createdate'] = time();
        $result = $db->data($tem)->add();
        if($result == false)
            return new MessageInfo(false,null,"1520:添加笔记失败");
        return new MessageInfo(true,$tem,"1620:添加笔记成功" );
    }

    public function noteDelete(){
        $user = session('user');
        $db = M('note_record');
        $noteid = I('post.id');
        if($db->where('id='.$noteid.' AND ownerid='.$user['id'])->find()!=null){
            $db->where('id='.$noteid)->delete();
            return new MessageInfo(true,null,"1620:删除成功");
        }else{
            return new MessageInfo(false,null,"1520:无权限删除");
        }
    }

    public function noteModify(){
        $user = session('user');
        $db = M('note_record');
        $note = I('post.');
        if($db->where('id='.$note['id'].' AND ownerid='.$user['id'])->find()!=null){
            $data['title']=$note['title'];
            $data['content']=$note['content'];
            $data['label']=$note['label'];
            $db->where('id='.$note['id'])->setField($data);
            $result=$db->where('id='.$note['id'])->find();
            return new MessageInfo(true,$result,"1620:修改成功");
        }else {
            return new MessageInfo(false, null, "1520:无权限修改");
        }
    }

    public function noteSearch(){
        $user = session('user');
        $db = M('note_record');
        $name = I('post.notename');
        $result = "%".$name."%";
        $map['notename'] = array('like',$result);
        $map['ownerid'] = $user['id'];
        $findNote = $db->where($map)->select();
        if(count($findNote) >= 0) {
            return new MessageInfo(true, $findNote, "1560:查找成功");
        }else{
            return new MessageInfo(false,null,"1520:未找到相关笔记");
        }
    }

    public function noteIn(){
        $user = session('user');
        $db = M('folder_record');
        $folder = I('post.');
        $data['ownerid'] = $user['id'];
        $data['noteid'] = $folder['noteid'];
        $data['folderid']=$folder['folderidid'];
        $tem1 = $db->where("ownerid=". $user['id']." AND "."noteid=".$folder['noteid'])->find();
        if($tem1==null){
            return new MessageInfo(false,null,"1420:未找到该笔记");
        }
        $tem2 = $db->where("ownerid=". $user['id']." AND "."noteid=".$folder['noteid'] ." AND "."folderid=".$folder['folderid'])->find();
        if($tem2!=null){
            return new MessageInfo(false,$tem2,"1420:该笔记已经在此文件夹中");
        }
        $result = $db->data($data)->setField('folderid',$data['folderid']);
        if($result == false)
            return new MessageInfo(false,null,"1420:移动失败");
        return new MessageInfo(true,$data,"1460:移动成功" );
    }

    public function noteOut(){
        $user = session('user');
        $db = M('note_record');
        $folder = I('post.');
        $tem1 = $db->where("ownerid=". $user['id']." AND "."noteid=".$folder['noteid'])->find();
        if($tem1==null){
            return new MessageInfo(false,null,"1420:未找到该笔记");
        }
        $tem2 = $db->where("ownerid=". $user['id']." AND "."noteid=".$folder['noteid'] ." AND "."folderid=".$folder['folderid'])->find();
        if($tem2==null){
            return new MessageInfo(false,$tem2,"1420:该笔记不在该文件夹中");
        }
        $result = $db->where("noteid=".$folder['noteid'] ." AND "."folderid=".$folder['folderid'])->setField('folderid',0);
        if($result == false)
            return new MessageInfo(false,null,"1420:移动失败");
        return new MessageInfo(true,null,"1460:移动成功" );
    }

    public function labelSearch(){
        $user = session('user');
        $db = M('note_record');
        $label = I('post.label');
        $result = "%".$label."%";
        $map['label'] = array('like',$result);
        $map['ownerid'] = $user['id'];
        $findNote = $db->where($map)->select();
        if(count($findNote) >= 0) {
            return new MessageInfo(true, $findNote, "1560:查找成功");
        }else{
            return new MessageInfo(false,null,"1520:未找到相关笔记");
        }
    }

    public function noteShare(){
        $user = session('user');
        if($user == null)
            return new MessageInfo(false,null,"请登录");
        $note = I('post.');
        $db = M('moments_record');
        $tem['ownerid'] = $user['id'];
        $tem['ownername'] = $user['username'];
        $tem['noteid'] =$note['id'];
        $tem['title'] =$note['title'];
        $tem['createdate'] = time();
        $tem['thumbCount']=0;
        $result = $db->data($tem)->add();
        if($result == false)
            return new MessageInfo(false,null,"1520:发布朋友圈失败");
        return new MessageInfo(true,$tem,"1620:发布成功" );
    }
}
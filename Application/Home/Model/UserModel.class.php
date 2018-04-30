<?php
/**
 * Created by PhpStorm.
 * User: duanmengyang
 * Date: 2017/11/19
 * Time: 下午12:03
 */
namespace Home\Model;
use Think\Model;
use MessageInfo;
class UserModel extends Model
{
    protected $tablePrefix = '';

    // 定义自动完成


    public function add(){
        $User = M('User');
        $data = I('post.');
        $result1 =   $User->data($data)->add();
        if($result1 == true){
            $userResult = $User->where('username='.$data['userName'])->find();
            $findUser=$userResult->data();
            session('user',$findUser);
            $tem = new MessageInfo(true,$findUser,'登录成功');
            return $tem;
        }else{
            $tem = new MessageInfo(false,null,$User->getError().'注册失败');
            return $tem;
        }
    }

    public function login(){
        $User = M('User');
        $data = I('post.');
        $result = $User->where('username="'.$data['userName'].'"'.'AND password="'.$data['password'].'"')->find();
        if($result != null){
            $findUser = $User->data();
            session('user',$findUser);
            return new MessageInfo(true,$findUser,'登录成功');
        }else if ($result == null){
            return new MessageInfo(false,null,'账号不存在或密码错误,请重新输入!');
        }else{
            return new MessageInfo(false,null,'非法输入!');
        }
    }


    public function basicInfo(){
        $User = M('User');
        $result = $User->where('username="'.session('user')['username'].'"'.'AND password="'.session('user')['password'].'"')->find();
        if($result == null ){
            return new MessageInfo(false,null,'账户未登录');
        }
        $vo['username'] = $result['username'];
        $vo['email'] = $result['email'];
        return new MessageInfo(true,$vo,"信息获取成功");
    }


    public  function  basicInfoHome(){
        $user = session('user');
        $friendDB = M('friend_record');
        $result = $friendDB->where('userid='.$user['id'])->select();
        $allMile = 0;
        $allCal = 0;
        for ($i=0;$i<count($result);$i++){
            $allMile+=$result[$i]['walkmile'];
            $allCal+=$result[$i]['calorie'];
        }
        $allData['id'] = $user['id'];
        $allData['name'] = $user['username'];
        $allData['email']= $user['email'];
        $allData['my'] = $friendDB->where('ownerid='.$user['id'])->count();
        $allData['fans'] = $friendDB->where('friendid='.$user['id'])->count();
        return $allData;
//        return new MessageModel(true,$allData,"1260:查询成功");

    }


    public function modifyBasicinfo(){
        $user = session('user');
        $data = I("post.");
        $userDB = M('user');
        if($userDB->where("id=".$user['id'])->save($data)>=1)
            return new MessageInfo(true,null,"1260:修改成功");
        return new MessageInfo(false,null,"1220:修改失败");

    }

    public function modifyPassword(){
        $user = session('user');
        $userDB = M('user');
        $tem = $userDB->where("id=".$user['id'])->find();
        $data = I("post.");
        if ($data['oldpass'] != $tem['password']){
            return new MessageInfo(false,null,"1220:原密码不正确,请重新输入");
        }
        $temD['password'] = $data['newpass'];
        $tem = $userDB->where("id=".$user['id'])->save($temD);
        if($tem>=1)
            return new MessageInfo(true,null,"1260:修改成功");
        return new MessageInfo(false,null,"1220:修改失败");
    }

    public function logout(){
        session('user',null);
    }

    public function userDelete(){
        $user = session('user');
        $db = M('User');
        $userid = I('post.id');
        if($db->where('id='.$userid.' AND'.$user['id']='admin')->find()!=null){
            $db->where('id='.$userid)->delete();
            return new MessageInfo(true,null,"1620:删除成功");
        }else{
            return new MessageInfo(false,null,"1520:无权限删除");
        }
    }

    public function search(){
        $user = session('user');
        $db = M('User');
        $name = I('post.username');
        $result = "%".$name."%";
        $map['username'] = array('like',$result);
        $findNote = $db->where($map)->select();
        if(count($findNote) >= 0) {
            return new MessageInfo(true, $findNote, "1560:查找成功");
        }else{
            return new MessageInfo(false,null,"1520:未找到相关笔记");
        }
    }

    public function userList(){
        $db = M('note_record');
        $sql ="select id, username, email from USER ";
        $result = $db->query($sql);
        if($result == null){
            return new MessageInfo(true,null,"还没有用户");
        }
        return new MessageInfo(true,$result,"1560:获取笔记列表成功");
    }
}
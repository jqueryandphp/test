<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Cookie;

class User extends Controller
{
    public function login()
    {
        // 查session, 若session里存在值, 则直接跳转至首页
        if(Session::has('adminInfo')) {
            $this->success('管理员已经登录', 'index/index');
        }
        // 查cookie值
        if(Cookie::has('adminInfo')) {
            $this -> view -> assign(['adminInfo'=>Cookie::get('adminInfo')]);
        }
        
        return $this -> view -> fetch();
    }

    public function logout()
    {
        Session::delete('adminInfo');
        $this->success('退出登陆成功', url('login'));
    }
    
}

?>
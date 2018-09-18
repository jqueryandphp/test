<?php
namespace app\admin\controller;
use think\Controller;
use app\common\model\User;
use think\Session;

class Base extends Controller
{
    // 获取管理员的信息
    public function _initialize()
    {
        // 先判断是否已经登录
        if(!Session::has('adminInfo')) {
            $this -> error('管理员未登录', 'user/login');        
        }
        parent::_initialize();
        $adminInfo=User::get(Session::get('adminInfo'));
        $this -> view -> share(['adminInfo'=>$adminInfo]);
    }
}
?>
<?php
namespace app\admin\controller;
use think\Db;
use app\common\model\User;

class Admin extends Base
{
    public function role_list()
    {
        // 查询角色信息
        $role=Db::table('role')->field('id, role_name')->select();
        $this -> view -> assign(['role'=>$role]);

        return $this -> view -> fetch('admin-role');
    }

    public function roleAdd()
    {
        return $this -> view -> fetch('admin-role-add');
    }

    public function limit_list()
    {
        return $this -> view -> fetch('admin-permission');
    }

    public function admin_list()
    {
        $adminArr=array();
        if($this -> adminInfo['is_admin']==1) {
            // 查询所有管理员信息
            $user=new User;
            $adminArr=$user->select();
        } else {
            // 查询这名管理员信息
            array_push($adminArr, $this->adminInfo);
        }
        // echo '<pre>';
        // print_r($adminArr);
        // echo '</pre>';
        $this -> view -> assign(['adminArr'=>$adminArr]);
        return $this -> view -> fetch('admin-list');
    }

    public function admin_add()
    {
        return $this -> view -> fetch('admin-add');
    }
}
?>
<?php
    namespace app\api\controller;
    use think\controller\Rest;
    use think\Request;
    use app\common\model\User as UserModel;
    use think\Session;
    use think\Cookie;

    class User extends Rest
    {
        public function tong(Request $request)
        {
            $status=0;
            $msg='';
            $data=[];
            switch ($this->method) {
                case 'get':
                    // 查询操作
                    if($request->param()['captcha']==='') {
                        $status=10001;
                        $msg='验证码不能为空';
                        break;
                    }
                    if(!captcha_check($request->param()['captcha'])) {
                        $status=10002;
                        $msg='验证码输入错误';
                        break;
                    }
                    if($request->param()['username']==='') {
                        $status=10003;
                        $msg='用户名不能为空';
                        break;
                    }
                    if($request->param()['password']==='') {
                        $status=10004;
                        $msg='密码不能为空';
                        break;
                    }
                    $param=array();
                    $param['username']=$request->param()['username'];
                    $param['password']=md5($request->param()['password']);
                    $result=UserModel::get($param);
                    if($result===null) {
                        $status=10005;
                        $msg='用户名后者密码输入错误';
                    } else {
                        // 将管理员信息存在session中
                        Session::set('adminInfo', $result['id']);
                        $status=1;
                        $msg='用户登录成功';
                        // 管理员点击保存密码, 则将密码存在cookie中
                        if(isset($request->param()['online'])) {
                            Cookie::set('adminInfo', $param);
                        }
                        // 更新管理员登录次数
                        $user=new UserModel;
                        $result=$user->where('id', $result['id'])->setInc('login_num');
                        if($result===0) {
                            $status=10006;
                            $msg='更新登录次数失败';
                            break;
                        }
                    }
                    $data=$request->param();
                    break;
                
                default:
                    # code...
                    break;
            }  

            return ['status' => $status, 'msg' => $msg, 'data' => $data];
        }
    }
?>
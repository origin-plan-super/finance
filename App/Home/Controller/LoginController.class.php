<?php
/**
* +----------------------------------------------------------------------
* 创建日期：2017年11月17日
* +----------------------------------------------------------------------
* https：//github.com/ALNY-AC
* +----------------------------------------------------------------------
* 微信：AJS0314
* +----------------------------------------------------------------------
* QQ:1173197065
* +----------------------------------------------------------------------
* #####登录控制器#####
* @author 代码狮
*
*/
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    
    //ThinkPHP提供的构造方法
    public function login(){
        
        
        if(IS_POST){
            
            $user_code=I('post.user_code');
            $user_id=I('post.user_id');
            $code= session('user_code');
            
            if($user_code==$code){
                //验证码正确
                
                session('user_id',$user_id);
                
                $url=U('Index/index');
                echo "<script>top.location.href='$url'</script>";
            }else{
                //验证码不正确
                echo '验证码错误！请返回重试！';
            }
            session('user_code',null);
            
        }else{
            $this->display();
        }
        
        
    }
    
    /**
    * 判断是否登录
    */
    public function isLogin(){
        
        if (empty(session('user_id'))) {
            $res['res']=-999;
        }else{
            $res['res']=1;
        }
        echo json_encode($res);
        
    }
    
    public function sinOut(){
        session(null);
        $url=U('Login/login');
        echo "<script>top.location.href='$url'</script>";
    }
    
}
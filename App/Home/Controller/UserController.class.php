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
* #####用户控制器#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    /**
    * 显示用户的报名信息
    */
    public function User(){
        
        $model              =   M('Sign');
        $result             =   $model
        ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
        ->table('fi_sign as t1,fi_exam as t2')
        ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
        ->order('t1.add_time desc')
        ->select();
        $this->assign('user_exam_info',$result);
        $this->display();
        
    }
}
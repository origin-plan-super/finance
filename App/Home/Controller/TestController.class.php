<?php
/**
* +----------------------------------------------------------------------
* 创建日期：2017年11月21日
* +----------------------------------------------------------------------
* https：//github.com/ALNY-AC
* +----------------------------------------------------------------------
* 微信：AJS0314
* +----------------------------------------------------------------------
* QQ:1173197065
* +----------------------------------------------------------------------
* #####测试#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class TestController extends CommonController {
    
    public function index(){
        //先生成订单号
        $order_add['order_id']    =   date('Ymdhis').rand(1000,9999);//订单号
        
        $sign_id            =   json_decode(session('sign_id'));//从session中取出sign_id
        
        
        $model              =   M('sign');//创建模型
        $where['sign_id']   =   array('in',$sign_id);
        
        
        $model              =   M('Sign');
        $result             =   $model
        ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
        ->table('fi_sign as t1,fi_exam as t2')
        ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
        ->where($where)
        ->order('t1.add_time desc')
        ->select();
        $exam_id            =   [];//课程的id数组
        
        // ========================
        // ==== 记录订单的课程信息 ====
        // ========================
        //放到order_info表中
        
        
        dump($result);
        
    }
}
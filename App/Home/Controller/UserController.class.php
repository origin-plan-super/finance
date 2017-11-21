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
    * 显示用户的订单信息
    */
    public function User(){
        
        
        // $model              =   M('Sign');
        // $result             =   $model
        // ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
        // ->table('fi_sign as t1,fi_exam as t2')
        // ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
        // ->order('t1.add_time desc')
        // ->select();
        
        
        
        // $model              =   M('Order');
        // $result             =   $model
        // ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
        // ->table('fi_sign as t1,fi_exam as t2')
        // ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
        // ->order('t1.add_time desc')
        // ->select();
        
        
        // $this->assign('user_exam_info',$result);
        // $this->display();
        
        
        
        $model=M('Order');
        
        $count= $model->count();
        $res['count']=$count;
        $result= $model->limit("$page,$limit")->order('add_time desc')->select();
        
        $this->assign('user_exam_info',$result);
        $this->display();
        
    }
    
    
    public function show(){
        $where['order_id']=I('get.order_id');
        $model=M('Order');
        $result=$model->where($where)->find();
        if($result){
            
            $model=M('OrderInfo');
            //取出order_info表中的数据
            $model                  =   M('OrderInfo');
            $order_info             =   $model
            ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
            ->table('fi_order_info as t1,fi_exam as t2')
            ->where('t1.exam_id = t2.exam_id')
            ->where($where)
            ->order('t1.add_time desc')
            ->select();
            
            
            $this->assign('order',$result);
            $this->assign('order_info',$order_info);
            $this->display();
        }else{
            //没有这个订单
            echo '订到未找到！：'.I('get.order_id');
        }
    }
    
    /**
    * 删除一个
    */
    public function del(){
        
        
        $model=M('Order');
        $where['order_id']=I('get.order_id');
        $where['state']=0;
        $result=$model->where($where)->delete();
        
        if($result !==false){
            //删除成功
            
            //再删除订单信息表中的数据
            
            $model=M('OrderInfo');
            $result=$model->where($where)->delete();
            
            $res['res']=0;
            $res['msg']=$result;
            
        }else{
            //删除失败
            $res['res']=-1;
            $res['msg']=$result;
        }
        $res['sql']=$model->_sql();
        
        echo json_encode($res);
    }
    
    
    
}
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
* #####订单控制器#####
* @author 代码狮
*
*/

namespace Admin\Controller;
use Think\Controller;
class OrderController extends CommonController {
    public function Order(){
        $this->display();
    }
    /**
    * 获得
    */
    public function getList(){
        
        $model=M('Order');
        $page=I('get.page');
        $limit=I('get.limit');
        
        $page=($page-1)* $limit;
        
        if(!empty(I('get.key'))){
            
            $key=I('get.key');
            
            $where['order_id|user_pid|exam_id'] = array(
            'like',
            "%".$key."%",
            'OR'
            );
            
            $result= $model->limit("$page,$limit")->order('add_time desc')->where($where)->select();
            $res['count']=$model->where($where)->count();
            
        }else{
            
            $count= $model->count();
            $res['count']=$count;
            $result= $model->limit("$page,$limit")->order('add_time desc')->select();
            
        }
        
        
        if($result){
            $res['code']=0;
            $res['msg']='更新了'.$res['count'].'条数据';
            $res['data']= $result;
        }else{
            $res['code']=-1;
            $res['msg']='没有数据！';
        }
        echo json_encode($res);
        
    }
    
    /**
    * 查看订单
    */
    public function show(){
        
        $where['order_id']=I('get.order_id');
        $model=M('Order');
        $result=$model->where($where)->find();
        if($result){
            
            $examM=M('exam');
            
            $exam_arr=json_decode($value['exam_id']);
            
            $exam_info=   $examM->where($exam_arr)->select();
            
            $result['exam_info']=$exam_info;
            
            $this->assign('order',$result);
            $this->display();
        }else{
            //没有这个订单
        }
        
        
    }
    
    
}
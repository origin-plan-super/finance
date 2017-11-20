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
* #####订单控制器#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class OrderController extends CommonController {
    
    public function order(){
        
        
        if(IS_POST){
            
            
            $sign_id=I('post.sign_id');
            
            //把sign_id存起来，等支付订单的时候要用
            session('sign_id',json_encode($sign_id));
            
            $where['sign_id']=array('in',$sign_id);
            
            $model              =   M('Sign');
            $result             =   $model
            ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
            ->table('fi_sign as t1,fi_exam as t2')
            ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
            ->where($where)
            ->order('t1.add_time desc')
            ->select();
            
            
            
            // ========================
            // ==== 获得优惠 ====
            // ========================
            
            $model              =   M('discount');
            $discount           =   $model->order('full desc')->select();
            $this->assign('discount',$discount);
            
            // ========================
            // ====  开始计算价格 ====
            // ========================
            
            $sub_money=0;
            
            foreach ($result as $key => $value) {
                $sub_money += $value['exam_money'];
            }
            
            $discount = $model->order('full desc')->select();
            $red;
            //优惠减免
            foreach ($discount as $key => $value) {
                
                if($sub_money >= $value['full']){
                    
                    $sub_money-=$value['red'];
                    $red=$value['red'];
                    break
                    ;
                }
                
            }
            
            
            
            $this->assign('red',$red);
            $this->assign('sub_money',$sub_money);
            
            $this->assign('user_exam_info',$result);
            $this->display();
            
            
        }else{
            echo '没有数据！';
        }
        
        
        
    }
    
    public function code(){
        
        $code=I('post.discountCode');
        
        $model=M('DiscountCode');
        $where['discount_code_id']=$code;
        $result=$model->where($where)->find();
        
        if($result){
            $res['res']=0;
            $res['msg']=$result['money'];
            
        }else{
            $res['res']=-1;
            $res['msg']='优惠码错误';
            
        }
        
        echo json_encode($res);
        
        
    }
    /**
    * 添加订单
    */
    public function add(){
        
        /**
        * 先创建订单
        *
        * order_id：订单号
        * user_pid：用户id
        * money：订单金额
        * method：支付方式
        * state：状态
        * exam_id：课程的id，这是个数组转字符串
        * add_time：添加时间
        * edit_time：最后修改时间
        *
        */
        
        if(IS_POST){
            $post=I('post.');
            
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
            
            //循环找到exam_id
            foreach ($result as $key => $value) {
                $exam_id[]      =   $value['exam_id'];//添加到数组中
            }
            
            $add['exam_id']     =   json_encode($exam_id);//保存exam_id
            
            
            // ========================
            // ==== 计算价格 ====
            // ========================
            //先算总价
            $sub_money=0;
            foreach ($result as $key => $value) {
                $sub_money += $value['exam_money'];
            }
            
            
            $model              =   M('discount');
            //再算优惠减免
            $discount = $model->order('full desc')->select();
            $red;
            //优惠减免
            foreach ($discount as $key => $value) {
                if($sub_money >= $value['full']){
                    $sub_money-=$value['red'];
                    $red=$value['red'];
                    break
                    ;
                }
            }
            
            //再算优惠码 a75970e82b9722853e8fc36c39461f09
            $code=I('post.code');
            
            $model=M('DiscountCode');
            $where['discount_code_id']=$code;
            $result=$model->where($where)->find();
            
            if($result){
                $sub_money-=$result['money'];
            }
            
            //得到价格
            $add['money']       =   $sub_money;
            
            // ========================
            // ==== 计算价格结束 ====
            // ========================
            
            
            $add['method']      =   $post['method'];//支付方式，微信或支付宝或银联
            $add['user_pid']    =   session('user_pid');//用户id
            $add['order_id']    =   date('Ymdhis').rand(1000,9999);//订单号
            $add['add_time']    =   time();//添加时间
            $add['edit_time']   =   $add['add_time'] ;//最后一次修改时间
            $add['state']       =   0 ;//状态：未支付
            
            
            $model=M('Order');
            $result             =   $model->add($add);
            if($result!==false){
                $res['res']     =   0;
                $res['msg']     =   $add['order_id'];
            }else{
                $rse['res']     =   -1;
                $res['msg']     =   'no!!!!!';
            }
            
            echo json_encode($res);
            
            
        }
        
    }
    
    /***
    *
    * 支付页面
    * 需要传递订单id
    */
    public function payment(){
        
        if(!empty(I('get.order_id'))){
            //传了订单
            //先看看订单在数据库中有没有
            $model                  =   M('order');
            $where['order_id']      =   I('get.order_id');
            $result                 =   $model->where($where)->find();
            
            
            if($result){
                //二维码路由
                $url    =   U("Weixin/get",'order_id='.$result['order_id']);
                
                
                $this->assign('order',$result);
                $this->assign('url',$url);
                $this->display();
            }else{
                echo '订单查找失败！请返回重新提交订单';
            }
            
            
        }else{
            //没有传订单
        }
        
        
        
    }
    
}
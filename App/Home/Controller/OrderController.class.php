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
                    $red+=$value['red'];
                    break
                    ;
                }
                
            }
            
            // ========================
            // ==== 满科减 ====
            // ========================
            //先获得
            $model              =   M('DiscountSubject');
            $DiscountSubject           =   $model->order('full desc')->select();
            $this->assign('DiscountSubject',$DiscountSubject);
            //再计算
            foreach ($DiscountSubject as $key => $value) {
                //这里计算数量
                
                if(count($result) >= $value['full']){
                    $red+=$value['red'];
                    break
                    ;
                }
            }
            
            $sub_money-=$red;
            
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
        $where['is_use']=0;
        $result=$model->where($where)->find();
        
        if($result){
            $res['res']=0;
            $res['msg']=$result['money'];
            
        }else{
            $res['res']=-1;
            $res['msg']='没有找到优惠码或已被使用';
            
        }
        
        echo json_encode($res);
        
        
    }
    /**
    * 添加订单
    */
    public function add(){
        
        //先生成订单号
        $order_add[]    =   [];//订单号
        $order_add['order_id']    =   date('Ymdhis').rand(1000,9999);//订单号
        
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
            $sign_info=    $result             =   $model
            ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
            ->table('fi_sign as t1,fi_exam as t2')
            ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
            ->where($where)
            ->order('t1.add_time desc')
            ->select();
            $exam_id            =   [];//课程的id数组
            
            
            
            
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
                    $red+=$value['red'];
                    break
                    ;
                }
            }
            
            //再算优惠码 a75970e82b9722853e8fc36c39461f09
            $code=I('post.code');
            
            $model=M('DiscountCode');
            $where['discount_code_id']=$code;
            $where['is_use']=0;
            $result=$model->where($where)->find();
            
            if($result){
                $red+=$result['money'];
            }
            
            //把优惠码弃用
            $save['is_use']=1;
            $model->where($where)->save($save);
            
            
            // ========================
            // ==== 满科减 ====
            // ========================
            //先获得
            $model              =   M('DiscountSubject');
            $DiscountSubject           =   $model->order('full desc')->select();
            $this->assign('DiscountSubject',$DiscountSubject);
            //再计算
            foreach ($DiscountSubject as $key => $value) {
                //这里计算数量
                
                if(count($result) >= $value['full']){
                    $red+=$value['red'];
                    break
                    ;
                }
            }
            
            
            //得到价格
            $order_add['money']       =   $sub_money-$red;
            // ========================
            // ==== 计算价格结束 ====
            // ========================
            
            
            $order_add['method']      =   $post['method'];//支付方式，微信或支付宝或银联
            $order_add['user_pid']    =   session('user_pid');//用户id
            $order_add['add_time']    =   time();//添加时间
            $order_add['edit_time']   =   $order_add['add_time'] ;//最后一次修改时间
            $order_add['state']       =   0 ;//状态：未支付
            
            $model=M('Order');
            $result             =   $model->add($order_add);
            if($result!==false){
                
                // ========================
                // ==== 记录订单的课程信息 ====
                // ========================
                //放到order_info表中
                
                //创建信息表的模型
                $Sign=M('Sign');
                $OrderInfo=M('OrderInfo');
                //组装数据
                
                //遍历sign，找到exam_id，组装数据
                
                $sign_id            =   json_decode(session('sign_id'));//从session中取出sign_id
                $where['sign_id']   =   array('in',$sign_id);
                
                $Signarr= $Sign->where($where)->select();
                
                foreach ($sign_info as $key => $value) {
                    $Signarr[$key]['order_id']=$order_add['order_id'];
                    $Signarr[$key]['add_time']=time();
                    $Signarr[$key]['edit_time']=time();
                    unset($Signarr[$key]['sign_id']);
                }
                $OrderInfo->addAll($Signarr);
                
                $res['res']     =   0;
                $res['msg']     =   $order_add['order_id'];
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
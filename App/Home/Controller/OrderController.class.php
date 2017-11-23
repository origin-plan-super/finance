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
            
            
            $sign_m              =   M('Sign');//购物车的模型
            
            //联表查询，需要查找到科目的信息
            $signDate=  $sign_m->where($where)
            ->field('t1.*,t2.*,t3.*')
            ->table('fi_sign as t1,fi_exam_subject as t2,fi_exam as t3')
            ->where('t1.subject_id = t2.subject_id AND t1.user_id = '.session('user_id').' AND t2.exam_id = t3.exam_id ')
            ->where($where)
            ->order('t1.add_time desc')
            ->select();//找多个
            
            $this->assign('user_exam_info',$signDate);
            
            
            // dump($signDate);
            // die;
            // ==== 查找end ====
            
            
            // ==== 获得优惠 ====
            
            $model              =   M('discount');
            $discount           =   $model->order('full desc')->select();
            $this->assign('discount',$discount);
            
            
            // ========================
            // ====  开始计算价格 ====
            // ========================
            
            $sub_money=0;
            
            foreach ($signDate as $key => $value) {
                //计算总价
                $sub_money += $value['money'];
            }
            
            $discount = $model->order('full desc')->select();
            $red=0;//这个是要用总价减去的数
            //优惠减免
            foreach ($discount as $key => $value) {
                
                if($sub_money >= $value['full']){
                    $red+=$value['red'];
                    break
                    ;
                }
            }
            //优惠减免没问题
            
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
                if(count($signDate) >= $value['full']){
                    $red+=$value['red'];
                    break
                    ;
                }
            }
            
            $sub_money-=$red;//减去优惠的钱
            $sub_money = $sub_money<=0 ?0 :$sub_money;//如果负数就等于0
            
            
            $this->assign('red',$red);//减去的钱
            $this->assign('sub_money',$sub_money);//优惠过后的总价
            
            //计算到此结束
            
            $this->assign('red',$red);
            $this->assign('sub_money',$sub_money);
            
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
            //有优惠码
            //过期不能用
            $time=time();
            
            if($time>$result['time']){
                //过期了
                $res['res']=-2;
                $res['msg']='验证码已过期';
            }else{
                
                $res['res']=0;
                $res['msg']=$result['money'];
                
            }
            
            
            
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
        * user_id：用户id
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
            
            
            //联表查询，需要查找到科目的信息
            $model              =   M('Sign');
            $sign_info=    $result             =   $model
            ->where($where)
            ->field('t1.*,t2.*,t3.*')
            ->table('fi_sign as t1,fi_exam_subject as t2,fi_exam as t3')
            ->where('t1.subject_id = t2.subject_id AND t1.user_id = '.session('user_id').' AND t2.exam_id = t3.exam_id ')
            ->where($where)
            ->order('t1.add_time desc')
            ->select();//找多个
            
            $exam_id            =   [];//课程的id数组
            
            
            
            
            // ========================
            // ==== 计算价格 ====
            // ========================
            //先算总价
            $sub_money=0;
            foreach ($result as $key => $value) {
                $sub_money += $value['money'];
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
                
                if(count($sign_info) >= $value['full']){
                    $red+=$value['red'];
                    break
                    ;
                }
            }
            
            $sub_money =$sub_money-$red;
            
            $sub_money = $sub_money<=0 ?0 :$sub_money;
            
            //得到价格
            $order_add['money']       =   $sub_money;
            // ========================
            // ==== 计算价格结束 ====
            // ========================
            
            
            $order_add['method']      =   $post['method'];//支付方式，微信或支付宝或银联
            $order_add['user_id']    =   session('user_id');//用户id
            $order_add['add_time']    =   time();//添加时间
            $order_add['edit_time']   =   $order_add['add_time'] ;//最后一次修改时间
            
            
            //如果金额是0，就不执行了，直接完成订单
            
            
            if($order_add['money']<=0){
                $order_add['state']       =   1 ;//完成
            }else{
                $order_add['state']       =   0 ;//状态：未支付
            }
            
            
            
            
            
            $model=M('Order');
            $result             =   $model->add($order_add);
            if($result!==false){
                //订单创建成功，现在记录订单信息表
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
                
                
                if($order_add['money']<=0){
                    $res['res']     =   1;
                }else{
                    $res['res']     =   0;
                }
                
                
                
                
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
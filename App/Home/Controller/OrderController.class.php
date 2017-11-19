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
class OrderController extends Controller {
    
    public function order(){
        
        
        if(IS_POST){
            
            
            $sign_id=I('post.sign_id');
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
                    break;
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

}
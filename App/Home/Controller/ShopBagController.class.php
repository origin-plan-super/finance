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
* #####购物车控制器#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class ShopBagController extends CommonController {
    /**
    * 显示购物车
    */
    public function ShopBag(){
        
        
        
        
        if(IS_POST){
            
            
            $post=I('post.');
            dump($post);
            
            
            
            
        }else{
            $model              =   M('Sign');
            $result             =   $model
            ->field('t2.exam_id,t2.exam_date,t2.exam_time,t2.exam_money,t2.exam_name,t1.*')
            ->table('fi_sign as t1,fi_exam as t2')
            ->where('t1.exam_id = t2.exam_id AND t1.user_pid = '.session('user_pid'))
            ->order('t1.add_time desc')
            ->select();
            $this->assign('user_exam_info',$result);
            
            
            
            
            // discount
            
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
                    break;
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
            
            
            // die;
            
            
        }
        
        $sub_money-=$red;
        
        
        $this->assign('red',$red);
        $this->assign('sub_money',$sub_money);
        
        $this->display();
        
    }
    
    
}

/**
* 删除购物车
*/
public function del(){
    
    $id=I('post.sign_id');
    $res['id']=$id;
    
    
    $model = M('sign');
    $where['sign_id'] = $id;
    $result= $model->where($where)->delete();
    
    if($result!==false){
        $res['res']=0;
        $res['msg']='';
    }else{
        $res['res']=-1;
        $res['msg']=$result;
        
    }
    $res['sql']=$model->_sql();
    echo json_encode($res);
    
    
}
}
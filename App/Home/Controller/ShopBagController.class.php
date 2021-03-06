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
        
        
        $sign_m              =   M('Sign');//购物车的模型
        
        //联表查询，需要查找到科目的信息
        $signDate=  $sign_m->where($where)
        ->field('t1.*,t2.*,t3.*')
        ->table('fi_sign as t1,fi_exam_subject as t2,fi_exam as t3')
        ->where('t1.subject_id = t2.subject_id AND t1.user_id = '.session('user_id').' AND t2.exam_id = t3.exam_id ')
        ->select();//找多个
        
        $this->assign('user_exam_info',$signDate);
        
        
        //满减信息
        $model              =   M('discount');
        $discount           =   $model->order('full desc')->select();
        $this->assign('discount',$discount);
        
        //满科减信息
        $model              =   M('DiscountSubject');
        $DiscountSubject    =   $model->order('full desc')->select();
        $this->assign('DiscountSubject',$DiscountSubject);
        
        $this->display();
        
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
    
    public function getAllMoney(){
        
        $sign_id=I('post.sign_id');
        //把sign_id存起来，等支付订单的时候要用
        
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
        
        
        // ========================
        // ====  开始计算价格 ====
        // ========================
        $sub_money=0;
        
        foreach ($signDate as $key => $value) {
            //计算总价
            $sub_money += $value['money'];
        }
        
        $sub_money=   discount($sub_money,count($signDate));
        
        // $red;//减去的钱
        // $sub_money;//优惠过后的总价
        
        $res['res']=1;
        $res['msg']['red']=$sub_money['red'];
        $res['msg']['sub_money']=$sub_money['sub_money'];
        
        echo json_encode($res);
        
        
    }
}
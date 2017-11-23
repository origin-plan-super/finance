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
            
            $where['order_id|user_pid|money'] = array(
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
        
        $order_id=I('get.order_id');
        
        $model=M('Order');
        $result=$model->where($where)->find();
        if($result){
            
            $model=M('OrderInfo');
            //取出order_info表中的数据
            $model                  =   M();
            $order_info             =   $model
            ->field('t1.*,t2.*,t3.*')
            ->table('fi_order_info as t1,fi_order as t2,fi_exam_subject as t3')
            ->where("t1.order_id = '".$order_id."' AND t1.order_id = t2.order_id AND  t1.subject_id = t3.subject_id ")
            ->order('t1.add_time desc')
            ->select();
            
            $m=M('exam');
            foreach ($order_info as $key => $value) {
                
                $w['exam_id']=$value['exam_id'];
                $r  =$m->where($w)->find();
                $order_info[$key]['exam_name']=$r['exam_name'];
                
            }
            
            
            
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
        
        if(IS_POST){
            
            $model=M('Order');
            $where['order_id']=I('post.order_id');
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
            
        }else{
            $res['res']=-1;
            $res['msg']='no';
        }
        echo json_encode($res);
    }
    
    /**
    * 保存用户字段操作
    * 可上传任意字段保存，慎用，以后加字段验证
    */
    public function saveInfo(){
        if(IS_POST){
            
            $save=I('post.save');
            $save['eidt_time']=time();
            $model=M('Order');
            $where['order_id']=I('post.order_id');
            $result=$model->where($where)->save($save);
            if($result !==false){
                //修改成功
                $res['res']=0;
                $res['msg']=$result;
                
            }else{
                //修改失败
                $res['res']=-1;
                $res['msg']=$result;
            }
            $res['sql']=$model->_sql();
            
        }else{
            $res['res']=-1;
            $res['msg']='no';
        }
        
        echo json_encode($res);
        
    }
    
    /**
    * 输出表格
    */
    public function printXls(){
        
        $order_id=I('get.order_id');
        $where = "t1.order_id in($order_id)";
        $model=M();
        //          SELECT t1.*,t2.title FROM mia_goods as t1,mia_class as t2 WHERE (t1.class_id = t2.class_id)
        /**配置输出 */
        $result = $model
        ->field('t1.*,t2.*,t3.*')
        ->table('fi_order_info as t1,fi_order as t2,fi_exam_subject as t3')
        ->where("t1.order_id in ($order_id) AND t1.order_id = t2.order_id AND t1.subject_id = t3.subject_id ")
        ->order('t1.add_time desc')
        ->select();
        
        // dump($model->_sql());
        // dump($result);
        //
        $fileName='财金通【'.date('Y年m月d日 H:i:s')."】-- 订单表($order_id)";
        
        
        $this->assign('table',$result);
        $this->assign('fileName',$fileName);
        $this->display();
        
        
    }
}
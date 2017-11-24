<?php
/**
* +----------------------------------------------------------------------
* 创建日期：2017年11月19日
* +----------------------------------------------------------------------
* https：//github.com/ALNY-AC
* +----------------------------------------------------------------------
* 微信：AJS0314
* +----------------------------------------------------------------------
* QQ:1173197065
* +----------------------------------------------------------------------
* #####优惠码控制器#####
* @author 代码狮
*
*/
namespace Admin\Controller;
use Think\Controller;
class DiscountCodeController extends CommonController {
    
    public function showList() {
        
        $this->display();
        
    }
    
    
    /**
    * 获得
    */
    public function getList(){
        
        $model=M('discount_code');
        $page=I('get.page');
        $limit=I('get.limit');
        
        $page=($page-1)* $limit;
        
        
        if(!empty(I('get.key'))){
            
            $key=I('get.key');
            
            //如果数据是已使用或者未使用，直接查询不用模糊查询
            
            switch ($key) {
                case '已使用':
                    $where['is_use'] = 1;
                    break;
                case '未使用':
                    $where['is_use'] = 0;
                    break;
                case '已过期':
                    $where = 'end_time < '.time();
                    break;
                case '未过期':
                    $where = 'end_time > '.time();
                    break;
                default:
                    $where['discount_code_id'] = array(
                    'like',
                    "%".$key."%",
                    'OR'
                    );
                    break ;
                    
            }
            
            $result= $model->limit("$page,$limit")->order('add_time desc')->where($where)->select();
            $res['count']=$model->where($where)->count();
            
        }else{
            
            $count= $model->count();
            $res['count']=$count;
            $result= $model->limit("$page,$limit")->order('add_time desc')->select();
            
        }
        
        $time=time();
        
        foreach ($result as $key => $value) {
            
            if($time>$value['end_time']){
                $result[$key]['isEnd']=true;
            }
            
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
    * 生成优惠码
    */
    public function add(){
        
        if(IS_POST){
            $money=I('post.money');
            $num=I('post.num');
            $end_time=I('post.end_time');
            
            
            
            //循环生成优惠码
            $model=M('DiscountCode');
            $count=0;
            
            
            
            for ($i=1; $i <= $num; $i++) {
                $add=array();
                
                $add['add_time']=time();
                $add['edit_time']=$add['add_time'];
                $add['money']=$money;
                $add['end_time']=strtotime($end_time);
                $add['discount_code_id']=md5($add['add_time'].$add['money'].rand().__KEY__);
                
                $result=$model->add($add);
                
                if($result!==false){
                    $count++;
                }
                
            }
            
            $res['res']=$count;
            $res['msg']=$count;
            echo json_encode($res);
            
        }else{
            $this->display();
        }
        
        
    }
    /**
    * 删除一个
    */
    public function del(){
        
        if(IS_POST){
            
            $model=M('DiscountCode');
            $where['discount_code_id']=I('post.discount_code_id');
            $result=$model->where($where)->delete();
            if($result !==false){
                //删除成功
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
    *
    * 批量删除
    *
    */
    public function removes() {
        
        if (!empty(I('post.discount_code_id'))) {
            
            $discount_code_id = I('post.discount_code_id');
            $where = "discount_code_id in($discount_code_id)";
            $model = M('DiscountCode');
            $result = $model -> where($where) -> delete();
            
            if($resut!==false){
                $res['res'] = $result;
                $res['msg'] ='成功' ;
            }else{
                $res['res'] = -1;
                $res['msg'] =$result ;
            }
            
        }
        
        echo json_encode($res);
    }
    
    /*
    * 保存字段操作
    * 可上传任意字段保存，慎用，以后加字段验证
    */
    public function saveInfo(){
        if(IS_POST){
            
            $save=I('post.save');
            $save['edit_time']=time();
            $model=M('DiscountCode');
            $where['discount_code_id']=I('post.id');
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
    
}
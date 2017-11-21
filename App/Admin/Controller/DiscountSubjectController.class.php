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
* #####科目优惠管理#####
* @author 代码狮
*
*/
namespace Admin\Controller;
use Think\Controller;
class DiscountSubjectController extends Controller {
    
    /**
    * 显示
    */
    public function showList() {
        
        $this->display();
    }
    
    /**
    * 获得科目优惠列表
    */
    public function getList(){
        
        // 科目满减 满10科减10元
        
        $model=M('DiscountSubject');
        $page=I('get.page');
        $limit=I('get.limit');
        
        $page=( $page-1)* $limit;
        
        if(!empty(I('get.key'))){
            
            $key=I('get.key');
            
            //职位
            $where['discount_subject_id|full|red'] = array(
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
    * 添加科目优惠信息
    */
    public function add(){
        
        if(IS_POST){
            
            $add['full']=I('post.full');
            $add['red']=I('post.red');
            $add['add_time']=time();
            $add['edit_time']=$add['add_time'];
            $add['discount_subject_id']=md5($add['add_time'].$add['full'].$add['red'].rand().__KEY__);
            
            $model=M('DiscountSubject');
            $result=$model->add($add);
            
            if($result!==false){
                $res['res']=0;
                $res['msg']='添加成功';
            }else{
                $res['res']=-1;
                $res['msg']=$result;
            }
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
            
            $model=M('DiscountSubject');
            $where['discount_subject_id']=I('post.discount_subject_id');
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
        
        if (!empty(I('post.discount_subject_id'))) {
            
            $discount_subject_id = I('post.discount_subject_id');
            $where = "discount_subject_id in($discount_subject_id)";
            $model = M('DiscountSubject');
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
    
    /**
    * 保存字段操作
    * 可上传任意字段保存，慎用，以后加字段验证
    */
    public function saveInfo(){
        if(IS_POST){
            
            $save=I('post.save');
            $save['edit_time']=time();
            $model=M('DiscountSubject');
            $where['discount_subject_id']=I('post.discount_subject_id');
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
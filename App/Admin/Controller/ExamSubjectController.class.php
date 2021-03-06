<?php
/**
* +----------------------------------------------------------------------
* 创建日期：2017年11月23日
* +----------------------------------------------------------------------
* https：//github.com/ALNY-AC
* +----------------------------------------------------------------------
* 微信：AJS0314
* +----------------------------------------------------------------------
* QQ:1173197065
* +----------------------------------------------------------------------
* #####科目控制器#####
* @author 代码狮
*
*/

namespace Admin\Controller;
use Think\Controller;
class ExamSubjectController extends CommonController {
    public function index(){
        
        
    }
    
    /**
    * 显示列表
    */
    public function showList(){
        
        $model=M('exam');
        $w['exam_id']=I('get.exam_id');
        $r= $model->where($w)->find();
        
        $this->assign('exam_info',$r);
        $this->display();
    }
    
    /**
    * 获得
    */
    public function getList(){
        
        
        $model=M('ExamSubject');
        $w['exam_id']=I('get.exam_id');
        
        $result= $model->where($w)->select();
        
        foreach ($result as $key => $value) {
            //已经报名的人数
            $result[$key]['peoples']= countSubject($value['subject_id']);
            //总人数
            $max_num=$value['max_num'];
            //计算剩余人数
            $result[$key]['surplus']=$max_num- countSubject($value['subject_id']);
            
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
    * 添加科目
    */
    public function add(){
        
        if(IS_POST){
            
            $add=I('post.');
            $add['add_time']=time();
            $add['edit_time']= $add['add_time'];
            $add['subject_id']= md5($add['add_time'].rand().__KEY__);
            
            $model=M('examSubject');
            
            $result= $model->add($add);
            if($result!==false){
                $res['res']=0;
                $res['mes']=$result;
            }else{
                $res['res']=-1;
                $res['mes']='添加失败';
            }
            echo json_encode($res);
        }else{
            
            $model=M('exam');
            $w['exam_id']=I('get.exam_id');
            $r= $model->where($w)->find();
            $this->assign('exam_info',$r);
            $this->display();
        }
    }
    
    /**
    * 编辑课程
    */
    public function edit(){
        
        if(IS_POST){
            //保存
            
            $save=I('post.');
            $save['edit_time'] = time();
            
            $where['subject_id'] = $save['subject_id'];
            unset($save['subject_id']);
            
            $model=M('examSubject');
            $result = $model->where($where)->save($save);
            
            if($result!==false){
                
                $res['res']=0;
                $res['mes']=$result;
                
            }else{
                
                $res['res']=-1;
                $res['mes']='保存失败';
                
            }
            
            echo json_encode($res);
            
        }else{
            //显示
            
            $model=M('examSubject');
            $where['subject_id'] = I('get.subject_id');
            $result = $model->where($where)->find();
            $this->assign('subject_info',$result);
            $this->display();
            
        }
        
    }
    /**
    * 删除一个课程
    */
    public function del(){
        
        if(IS_POST){
            
            $model=M('examSubject');
            $where['subject_id']=I('post.subject_id');
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
    * 保存用户字段操作
    * 可上传任意字段保存，慎用，以后加字段验证
    */
    public function saveInfo(){
        if(IS_POST){
            
            $save=I('post.save');
            $model=M('examSubject');
            $where['subject_id']=I('post.subject_id');
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
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
* #####考试、课程控制器#####
* @author 代码狮
*
*/

namespace Admin\Controller;
use Think\Controller;
class ExamController extends CommonController {
    public function index(){
        $this->display();
    }
    
    /**
    * 显示列表
    */
    public function showList(){
        $this->display();
    }
    
    public function getList(){
        
        $model=M('Exam');
        $page=I('get.page');
        $limit=I('get.limit');
        
        $page=( $page-1)* $limit;
        
        if(!empty(I('get.key'))){
            
            $key=I('get.key');
            
            //职位
            $where['exam_name|exam_id'] = array(
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
        
        //计算剩余考位
        foreach ($result as $key => $value) {
            //计算剩余考位
            //到sign里面统计查询
            $model=M('ExamSubject');
            $where['exam_id']=$value['exam_id'];
            $r=$model->where($where)->select();
            $result[$key]['subject_info']=$r;
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
    * 添加课程
    */
    public function add(){
        
        if(IS_POST){
            
            $add=I('post.');
            $add['add_time']=time();
            $add['edit_time']= $add['add_time'];
            $add['exam_id']= md5($add['add_time'].rand().__KEY__);
            $add['exam_subject']= json_encode($add['exam_subject']);
            
            $model=M('Exam');
            
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
            $save['exam_subject'] = json_encode($save['exam_subject']);
            
            $where['exam_id'] = $save['exam_id'];
            unset($save['exam_id']);
            
            $model=M('Exam');
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
            
            $model=M('Exam');
            $where['exam_id'] = I('get.exam_id');
            $result = $model->where($where)->find();
            
            $textarea = "";
            
            $exam_subject = json_decode($result['exam_subject'],true);
            
            
            foreach($exam_subject as $value){
                
                $title=$value['title'];
                $money= empty($value['money']) ?'':$value['money'];
                
                $textarea .= $title.','.$money."\n";
            }
            
            
            $result['exam_subject'] =  chop($textarea);
            
            $this->assign('exam_info',$result);
            $this->display();
            
        }
        
    }
    /**
    * 删除一个课程
    */
    public function del(){
        
        if(IS_POST){
            
            $model=M('Exam');
            $where['exam_id']=I('post.exam_id');
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
            $model=M('exam');
            $where['exam_id']=I('post.exam_id');
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
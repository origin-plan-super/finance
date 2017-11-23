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

namespace Home\Controller;
use Think\Controller;
class ExamSubjectController extends Controller {

    /**
    * 获得一个科目信息，并且计算剩余人数
    */
    public function get(){
        $model=M('ExamSubject');
        
        $w['subject_id']=I('get.id');
        $ExamSubjectDate= $model->where($w)->find();
        
        // ========================
        // ==== 人数计算 ====
        // ========================
        
        //先取出最大人数
        $max_num=$ExamSubjectDate['max_num'];
        //1、获得当前人数
        $count=countSubject($ExamSubjectDate['subject_id']);
        //2、然后计算，用最大人数减去当前人数
        $surplus=$max_num-$count;
        //3、给它
        $ExamSubjectDate['surplus']=$surplus;
        
        
        // ========================
        // ==== 人数计算end ====
        // ========================
        
        if($ExamSubjectDate){
            $res['res']= 1;
            $res['msg']= $ExamSubjectDate;
        }else{
            $res['res']=-1;
            $res['msg']='没有数据！';
        }
        echo json_encode($res);
    }
    
   
}
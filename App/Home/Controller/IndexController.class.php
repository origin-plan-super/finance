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
* #####首页控制器#####
* @author 代码狮
*
*/

namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    /**
    * 首页显示
    */
    public function index2(){
        
        // session('user_id',null);
        
        if(IS_POST){
            
            
            $add=I('post.');//这东西要添加到购物车里面
            
            
            //先找科目数据
            $examSubject=M('examSubject');
            $where['subject_id']=$add['subject_id'];
            $examSubjectDate=$examSubject->where($where)->find();//科目数据
            
            // ========================
            // ==== 先统计一下是否满员 ====
            // ========================
            
            
            //取得选中的科目id
            $w['subject_id']=$add['subject_id'];
            
            //计数
            $m=M('sign');
            $signCount  =   $m->where($w)->count();//计数
            $signCount  =   $examSubjectDate['max_num']-$count;//总的减去已经报名的
            
            
            if($signCount<=0){
                //满了
                $res['res']=-2;
                $res['msg']=$count;
                echo json_encode($res);
                exit;
            }
            //没有满，继续
            
            //创建购物车模型
            $sign_m=M('sign');
            //组建购物车信息
            $add['sign_id']=md5($add['subject_id'].$add['user_name'].$add['user_phone'].rand());
            $add['add_time']=time();
            $add['edit_time']=$add['add_time'];
            $add['user_id']=  session('user_id');
            
            //=====课程id和科目id在post里面
            
            //添加进去
            $result= $sign_m->add($add);
            
            if($result!==false){
                //没有错误
                $res['res']=0;
                $res['msg']=$result;
                
                $model=M('exam');
                $where['exam_id']=I('post.exam_id');
                
            }else{
                //错了
                $res['rse']=-1;
                $rse['msg']='添加错误';
            }
            
            echo json_encode($res);
            
            
        }else{
            
            //显示
            //1、查询总的记录数
            $model  =   M('exam');
            $count  =   $model->count();
            //2、实例化分页类，传递参数
            $page   =   new \MyPages\Page($count,10);
            $page->setConfig('prev', '上一页'); //第三步：定义提示
            $page->setConfig('next', '下一页'); //第三步：定义提示
            $page->setConfig('last', '末页'); //第三步：定义提示
            $page->setConfig('first', '首页'); //第三步：定义提示
            //3、可选，定制分页按钮的提示文字
            
            //4、通过show输出url连接
            $show   =   $page->show();
            
            //5、展示数据
            $result =   $model->limit($page->firstRow,$page->listRows)->order('add_time desc')->select();
            foreach ($result as $key => $value) {
                $result[$key]['exam_subject']=json_decode($value['exam_subject'],true);
                //计算剩余考位
                //到sign里面统计查询
                
                $m=M('sign');
                $where['exam_id']=$value['exam_id'];
                $count=$m->where($where)->count();
                
                $result[$key]['surplus']=$value['exam_num']-$count;
                
            }
            $this->assign('exam_info',$result);
            
            //6、传递给模板
            $this->assign('pages',$show);
            
            
            // ========================
            // ==== 公告 ====surplus
            // ========================
            
            $model=M('Notice');
            $result =   $model->order('edit_time desc')->find();
            $notice_content=htmlspecialchars_decode($result['content']);
            
            $this->assign('notice_content',$notice_content);
            
            $this->display();
        }
        
        
        
    }
    
    
    public function index(){
        
        if(IS_POST){
            $add=I('post.');//这东西要添加到购物车里面
            
            
            //先找科目数据
            $examSubject=M('examSubject');
            $where['subject_id']=$add['subject_id'];
            $examSubjectDate=$examSubject->where($where)->find();//科目数据
            
            // ========================
            // ==== 先统计一下是否满员 ====
            // ========================
            
            
            //取得选中的科目id
            $w['subject_id']=$add['subject_id'];
            
            //计数
            $m=M('sign');
            $signCount  =   $m->where($w)->count();//计数
            $signCount  =   $examSubjectDate['max_num']-$signCount;//总的减去已经报名的
            
            
            if($signCount<=0){
                //满了
                $res['res']=-2;
                $res['msg']=$signCount;
                echo json_encode($res);
                exit;
            }
            //没有满，继续
            
            //创建购物车模型
            $sign_m=M('sign');
            //组建购物车信息
            $add['sign_id']=md5($add['subject_id'].$add['user_name'].$add['user_phone'].rand());
            $add['add_time']=time();
            $add['edit_time']=$add['add_time'];
            $add['user_id']=  session('user_id');
            
            //=====课程id和科目id在post里面
            
            //添加进去
            $result= $sign_m->add($add);
            
            if($result!==false){
                //没有错误
                $res['res']=0;
                $res['msg']=$result;
                
                $model=M('exam');
                $where['exam_id']=I('post.exam_id');
                
            }else{
                //错了
                $res['rse']=-1;
                $rse['msg']='添加错误';
            }
            
            echo json_encode($res);
            
            
        }else{
            
            
            
            // ========================
            // ==== 分页开始 ====
            // ========================
            
            //1、查询总的记录数
            $model  =   M('exam');
            $count  =   $model->count();
            //2、实例化分页类，传递参数
            $page   =   new \MyPages\Page($count,10);
            $page->setConfig('prev', '上一页'); //第三步：定义提示
            $page->setConfig('next', '下一页'); //第三步：定义提示
            $page->setConfig('last', '末页'); //第三步：定义提示
            $page->setConfig('first', '首页'); //第三步：定义提示
            //3、可选，定制分页按钮的提示文字
            
            //4、通过show输出url连接
            $show   =   $page->show();
            
            
            // ==== 课程列表展示 ====
            
            
            //5、展示数据
            $exam_info =   $model->limit($page->firstRow,$page->listRows)->
            order('add_time desc')->
            select();
            
            
            
            $model  =   M('examSubject');
            $sign  =   M('sign');
            
            foreach ($exam_info as $key => $value) {
                $w['exam_id']=$value['exam_id'];
                
                $r=   $model ->where($w)->select();
                
                foreach ($r as $k => $v) {
                    //计算已经报名的人数
                    $sing_w['subject_id']=$r[$k]['subject_id'];//课程的id
                    $count= $sign->where($sing_w)->count();//计数
                    $max_num=$r[$k]['max_num'];
                    $r[$k]['surplus']= $max_num-$count;
                    
                }
                
                $exam_info[$key]['subject_info']=$r;
                
            }
            
            // dump($exam_info);
            // die;
            
            $this->assign('exam_info',$exam_info);
            $this->assign('exam_info_json',json_encode($exam_info));
            //6、传递给模板
            $this->assign('pages',$show);
            // ==== 课程列表结束end ====
            
            
            
            // ========================
            // ==== 分页end ====
            // ========================
            
            
            
            
            
            
            
            // ========================
            // ==== 公告 ====surplus
            // ========================
            
            $model=M('Notice');
            $result =   $model->order('edit_time desc')->find();
            $notice_content=htmlspecialchars_decode($result['content']);
            $this->assign('notice_content',$notice_content);
            
            $this->display();
            
        }
        
        
        
    }
}
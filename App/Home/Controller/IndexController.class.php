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
    public function index(){
        
        
        if(IS_POST){
            
            //保存购物车信息
            $add=I('post.');
            
            $add['sign_id']=md5($add['exam_id'].$add['user_name'].$add['user_phone'].rand());
            $add['add_time']=time();
            $add['edit_time']=$add['add_time'];
            
            session('user_pid',$add['user_pid']);
            
            
            $model=M('sign');
            $result= $model->add($add);
            
            if($result!==false){
                $res['res']=0;
                $res['msg']=$result;
                
                $model=M('exam');
                $where['exam_id']=I('post.exam_id');
                
            }else{
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
                $result[$key]['exam_subject']=json_decode($value['exam_subject']);
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
}
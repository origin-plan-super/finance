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
* #####公告控制器#####
* @author 代码狮
*
*/

namespace Admin\Controller;
use Think\Controller;
class NoticeController extends Controller {
    
    /**
    * 编辑公告
    */
    public function edit(){
        
        $model=M('Notice');
        if(IS_POST){
            
            //保存公告
            $save=I('post.');
            $save['edit_time']=time();
            $result=$model->add($save,null,true);
            if($result!==false){
                $res['res']=0;
                $res['msg']=$result;
            }else{
                $res['res']=-1;
                $res['msg']=$result;
            }
            $res['result']=$result;
            
            echo json_encode($res);
            
            
        }else{
            
            $result =   $model->order('edit_time desc')->find();
            
            $this->assign('notice',$result);
            $this->display();
            
            
        }
        
        
        
    }
    
    
}
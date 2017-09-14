<?php
/**
 * 趣读商城
 * ============================================================================
 * * 版权所有 2015-2027 河南趣读信息科技有限公司，并保留所有权利。
 * 网站地址: http://www.qudukeji.com
 * ----------------------------------------------------------------------------
 * ============================================================================
 */

namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller
{
	/**----------------------------------------------*/
	/*           Admin控制器的基类控制器               */
	/**----------------------------------------------*/
    /**
     * 析构函数
     */
	function __construct() 
    {
		parent::__construct();

			foreach($_COOKIE as $key=>$value){
                cookie($key,$value,3600);
                        
            }
					
        //用户中心面包屑导航
        $navigate_admin = navigate_admin();
        
        $this->assign('navigate_admin',$navigate_admin);
	
	    $this->assign('egold_name',C('EGOLD_NAME'));
     
	    $this->assign('web_name',C('WEB_NAME'));
	
	    $this->assign('web_domain_url',C('WEB_DOMAIN_URL'));
	}
	

    /*
     * 初始化操作
     */
    public function _initialize() 
	{
		$this->assign('action',ACTION_NAME);
		
		$flag = $this->checkUserFromAdmin();
		
		if($flag != 1)
		{
			//过滤不需要登陆的行为
			if(!in_array(ACTION_NAME,array('login','logout','vertify','register','forgetPassWord','mkDoc','sendInfo','index','mkLink')) &&
				!in_array(CONTROLLER_NAME,array('Ueditor','Uploadify','Api','Backup')))
			{
				if(cookie('uid') <= 0)
				{
					$url = U('Admin/Admin/login');
					
					$this->error('请先登陆',$url,1);
				}
			}
			
			$channelModel=M('distribution_channels');
            $res=$channelModel->field('adpower')->where('channelid = '.cookie('channelid'))->find();
            if($res){
                cookie('adpower',$res['adpower']);
            }

            $adpath = C('AD_CONFIG');
            include  $adpath;
			
			$this->public_assign();
		}
    }
    
	/**
     * 保存公告变量到 smarty中 比如 导航 
     */
	public function public_assign()
	{
		$tpshop_config = array();
       	$tp_config     = M('config')->select();
       	
       	foreach($tp_config as $k => $v)
       	{
          	$tpshop_config[$v['inc_type'].'_'.$v['name']] = $v['value'];
       	}
       	
       	$this->assign('tpshop_config', $tpshop_config);       
	}
	
	//检查管理员菜单操作权限
	public function check_priv()
    {
		$ctl 	     = CONTROLLER_NAME;
    	$act  	     = ACTION_NAME;
		$permissions = cookie('permissions');//权限
		$no_check    = array('login','logout','vertifyHandle','vertify','imageUp','upload');
    	
    	if($ctl == "Index" && $act == 'index')
    	{
    		return true;
    	}
    	elseif(strpos('ajax',$act) || in_array($act,$no_check) || $act_list == 'all')
    	{
    		return true;
    	}
    	else
    	{
    		$mod_id   = M('system_module')->where("ctl='$ctl' and act='$act'")->getField('mod_id');
    		$act_list = explode(',', $act_list);
    		
    		if($mod_id)
    		{
    			if(!in_array($mod_id, $act_list))
    			{
					$this->error('您的账号没有此菜单操作权限,超级管理员可分配权限',U('Admin/Index/index'));
    				exit;
    			}
    			else
    			{
    				return true;
    			}
    		}
    		else
    		{
				$this->error('请系统管理员先在菜单管理页添加该菜单',U('Admin/System/menu'));
				
    			exit;
    		}
    	}
    }
	
	/**
	 * 检查用户是不是从www.mianfeidushu.com/admin/index.php跳转过来的
	 * 是的话，返回1；否则，返回0；
	 * @return int
	 */
    private function checkUserFromAdmin()
    {
	    if(session('jieqiUserId') == 1)
	    {
		    session('act_list' ,'all');
		
		    cookie('uid',session('jieqiUserId'));
		
		    cookie('uname',session('jieqiUserUname'));
		
		    $condition['uname'] = session('jieqiUserUname');
		
		    $condition['uid'] = session('jieqiUserId');
		
		    $adminInfo = M('system_users')->where(array('uid' => 1))->find();
		
		    if($adminInfo['isshumengadmin'] == 1)
		    {
			    cookie('permissions',1); //管理员权限
		    }
		    else
		    {
			    cookie('permissions',0); //普通权限
		    }
		
		    return 1;
	    }
	    else
	    {
		    return 0;
	    }
	}
}
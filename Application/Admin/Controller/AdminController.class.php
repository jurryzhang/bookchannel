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

use Think\Verify;

class AdminController extends BaseController
{
	/**----------------------------------------------*/
	/*                 管理员控制器                   */
	/**----------------------------------------------*/
	public function index()
	{
		$res = $list = array();
		
    	$keywords = I('keywords');
    	
    	if(empty($keywords))
    	{
    		$res = D('admin')->select();
    	}
    	else
    	{
    		$res = D()->query("select * from __PREFIX__admin where user_name like '%$keywords%' order by admin_id");
    	}
    	
    	$roles = D('admin_role')->select();
    	
    	if($res && $roles)
    	{
    		foreach ($roles as $v)
    		{
    			$role[$v['role_id']] = $v['role_name'];
    		}
    		
    		foreach ($res as $val)
    		{
    			$val['role']     =  $role[$val['role_id']];
    			$val['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
    			$list[]          = $val;
    		}
    	}
    	
    	$this->assign('list',$list);
    	
        $this->display();
    }

	/****推广教程****/
    public function lectures(){
        $this->display();
    }
    
    public function admin_info()
    {
    	$uid = I('get.uid',0);
    	
    	if($uid)
    	{
    		$info = D('system_users')->where("uid = $uid")->find();
    		
    		$this->assign('info',$info);
    	}
    	
    	$act = empty($uid) ? 'add' : 'edit';
    	
    	$this->assign('act',$act);
    	
    	$role = D('admin_role')->where('1=1')->select();
    	
    	$this->assign('role',$role);
    	
    	$this->display();
    }
    
    public function adminHandle()
    {
    	$data = I('post.');
    	
    	if(empty($data['password']))
    	{
    		unset($data['password']);
    	}
    	else
    	{
    		$data['password'] = encrypt($data['password']);
    	}
    	
    	if($data['act'] == 'add')
    	{
    		unset($data['admin_id']);
    		
    		$data['add_time'] = time();
    		
    		if(D('admin')->where("user_name='".$data['user_name']."'")->count())
    		{
    			$this->error("此用户名已被注册，请更换",U('Admin/Admin/admin_info'),1000);
    		}
    		else
    		{
    			$r = D('admin')->add($data);
    		}
    	}
    	elseif($data['act'] == 'edit')
    	{
    		$r = D('admin')->where('admin_id='.$data['admin_id'])->save($data);
    	}
        elseif($data['act'] == 'del' && $data['admin_id'] > 1)
        {
    		$r = D('admin')->where('admin_id='.$data['admin_id'])->delete();

    		exit(json_encode(1));
    	}
    	
    	if($r)
    	{
    		$this->success("操作成功",U('Admin/Admin/index'),1000);
    	}
    	else
    	{
    		$this->error("操作失败",U('Admin/Admin/index'),1000);
    	}
    }
    
    /*
     * 管理员登陆
     */
    public function login()
    {
        if(session('?admin_id') && session('admin_id') > 0)
        {
             $this->error("您已登录",U('Admin/Index/index'));
        }

        $username    = I('post.username');
        $password    = I('post.password');
        $vertifyCode = I('post.verify');
        $username    = trim($username);
        $password    = trim($password);
	    $vertifyCode = trim($vertifyCode);
	
        if(IS_POST)
        {
           /*  $verify = new Verify();
	
	        if (!$verify->check($vertifyCode, "Admin/Login"))
            {
            	$this->error('验证码错误',U('Admin/Admin/login'),2);

            	exit();
            } */
            
            $condition['uname']     = $username;
            $condition['pass']      = $password;
	        $condition['ischannel'] = '1';
            
            if(!empty($condition['uname']) && !empty($condition['pass']))
            {
				$condition['pass'] = encrypt($condition['pass']);
               	
	            $admin_info = M('system_users')->where($condition)->find();
	   
                if(is_array($admin_info))
                {
	                /*setcookie('uid','',time() -3600);
	                unset($_COOKIE['uid']);
	
	                setcookie('uname','',time() -3600);
	                unset($_COOKIE['uname']);
	
	                setcookie('ischanneladmin','',time() -3600);
	                unset($_COOKIE['ischanneladmin']);
	                cookie('channelid',null);
	                setcookie('permissions','',time() -3600);
	                unset($_COOKIE['permissions']);
					cookie('pid',null);
					cookie('adpower',null);
                	cookie('cpid',null);*/
                    foreach($_COOKIE as $key=>$value){
                        cookie($key,"",time()-60);
                    }
	                
                	
                	cookie('uid',$admin_info['uid']);
	
	                cookie('uname',$admin_info['uname']);
					
					if($admin_info['ischannelbind']==0){
						 
                        $this->error('您的账户未绑定渠道',U('Admin/Admin/login'),3);
                    }
                	
                	if($admin_info['ischanneladmin'] == 1)
	                {
		                cookie('permissions',1,3600); //管理员权限
		
		                $url = session('from_url') ? session('from_url') : U('Admin/Index/index');
	                }
	                else
	                {
		                cookie('permissions',0,3600);//普通权限
                        $channel_info  = M('distribution_channels')->where(array('uid'=>$admin_info['uid']))->find();
                        cookie('cpid',$channel_info['pid']);
                        cookie('pid',$channel_info['pid']);
		                cookie('channelid',$channel_info['channelid']);
		                $url = session('from_url') ? session('from_url') : U('Admin/Index/index');
	                }
                    
                    //$this->success('登录成功',$url,1);
					redirect($url);

                    exit();
                }
                else
                {
                	$this->error('帐号或密码错误,请重新登录',U('Admin/Admin/login'),3);

                	exit();
                }
            }
            else
            {
            	$this->error('请填写账号密码',U('Admin/Admin/login'),3);

            	exit();
            }
        }
	
        $this->display();
    }
    
    /**
     * 退出登陆
     */
    public function logout()
    {
        session_unset();
        session_destroy();
		
		foreach($_COOKIE as $key=>$value){
            setCookie($key,"",time()-60);
        }
        /*cookie('uid',null);
        cookie('uname',null);
        cookie('ischanneladmin',null);
        cookie('permissions',null);
        cookie('pid',null);
        cookie('cpid',null);
        cookie('channelid',null);
        cookie('channelname',null);
		 cookie('adpower',null);
	    cookie(null);*/
        
        $this->success("退出成功",U('Admin/Admin/login'));
    }
    
    /**
     * 验证码获取
     */
    public function vertify()
    {
    	ob_get_clean();//处理验证码图片崩溃的情况
    	
        $config = array
                    (
			            'fontSize' => 60,
			            'length'   => 4,
			            'useCurve' => false,
			            'useNoise' => false,
			        );
        
        $Verify = new Verify($config);
	
	    $Verify->codeSet = '0123456789';
        
        $Verify->entry("Admin/Login");
    }
    
    public function role()
    {
    	$list = D('admin_role')->order('role_id desc')->select();
    	$this->assign('list',$list);
    	$this->display();
    }
    
    public function role_info()
    {
    	$role_id = I('get.role_id');
    	$tree = $detail = array();
    
    	if($role_id)
    	{
    		$detail = D('admin_role')->where("role_id=$role_id")->find();
    		$this->assign('detail',$detail);
    	}

    	$res = D('distribution_system_module')->order('mod_id ASC')->select();
    	
    	if($res)
    	{
    		foreach($res as $k => $v)
    		{
    			if($detail['act_list'])
    			{
    				$act_list = explode(',', $detail['act_list']);
    				$v['enable'] = in_array($v['mod_id'], $act_list) ? 1 : 0;
    			}
    			else
    			{
    				$v['enable'] = 0 ;
    			}
    			
    			$modules[$v['mod_id']] = $v;
    		}
    		
    		if($modules)
    		{
    			foreach($modules as $k=>$v)
    			{
    				if($v['module'] == 'top')
    				{
    					$tree[$k] = $v;
    				}
    			}
    			
    			foreach($modules as $k => $v)
    			{
    				if($v['module'] == 'menu')
    				{
    					$tree[$v['parent_id']]['menu'][$k] = $v;
    				}
    			}
    			
    			foreach($modules as $k => $v)
    			{
    				if($v['module'] == 'module')
    				{
    					$ppk = $modules[$v['parent_id']]['parent_id'];
    					$tree[$ppk]['menu'][$v['parent_id']]['menu'][$k] = $v;
    				}
    			}
    		}
    	}

    	$this->assign('menu_tree',$tree);
    	$this->display();
    }
    
    public function roleSave()
    {
    	$data = I('post.');
    	$res = $data['data'];
    	$res['act_list'] = is_array($data['menu']) ? implode(',', $data['menu']) : '';
    	
    	if(empty($data['role_id']))
    	{
    		$r = D('admin_role')->add($res);
    	}
    	else
    	{
    		$r = D('admin_role')->where('role_id='.$data['role_id'])->save($res);
    	}
    	
		if($r)
		{
			adminLog('管理角色',__ACTION__);
			
			$this->success("操作成功!",U('Admin/Admin/role_info',array('role_id'=>$data['role_id'])));
		}
		else
		{
			$this->success("操作失败!",U('Admin/Admin/role'));
		}
    }
    
    public function roleDel()
    {
    	$role_id = I('post.role_id');
    	$admin = D('admin')->where('role_id='.$role_id)->find();
    	
    	if($admin)
    	{
    		exit(json_encode("请先清空所属该角色的管理员"));
    	}
    	else
    	{
    		$d = M('admin_role')->where("role_id=$role_id")->delete();
    		
    		if($d)
    		{
    			exit(json_encode(1));
    		}
    		else
    		{
    			exit(json_encode("删除失败"));
    		}
    	}
    }
	
    
    
	/**
	 * 书盟用户注册
	 */
    public function register()
    {
	    if(session('?admin_id') && session('admin_id') > 0)
	    {
		    $this->error("您已登录",U('Admin/Index/index'));
	    }
	
	    $username    = I('post.username');
	    $password    = I('post.password');
	    $vertifyCode = I('post.verify');
	    $username    = trim($username);
	    $password    = trim($password);
	    $vertifyCode = trim($vertifyCode);
	
	    if(IS_POST)
	    {
		    $verify = new Verify();
		
		    if (!$verify->check($vertifyCode, "Admin/Login"))
		    {
			    $this->error('验证码错误',U('Admin/Admin/login'));
			
			    exit();
		    }
		
		    $condition['uname']          = $username;
		    $condition['pass']           = $password;
		    $condition['faceImg']        = 'http://img.mianfeidushu.com/facePic/01.png';
		    $condition['ischannel']      = '1';
		    $condition['ischanneladmin'] = '0';
		
		    if(!empty($condition['uname']) && !empty($condition['pass']))
		    {
			    $condition['pass'] = encrypt($condition['pass']);
			
			    $count = M('system_users')->where($condition)->count();
			
			    if($count)
			    {
				    $this->error('注册失败，用户名存在！',U('Admin/Admin/register'),3);
				
				    exit();
			    }
			    else
			    {
			    	$uID = M('system_users')->add($condition);
			    	
			    	if($uID)
				    {
					    $this->success('注册成功，请联系管理员进行渠道设置！先逛书城吧',U('Admin/Admin/login'),3);
					
					    exit();
				    }
				    else
				    {
					    $this->error('注册失败，请重试！',U('Admin/Admin/register'),3);
					
					    exit();
				    }
			    }
		    }
		    else
		    {
			    $this->error('请填写账号和密码',U('Admin/Admin/register'),3);
			
			    exit();
		    }
	    }
	
    	$this->display();
    }
	
	/**
	 * 找回密码
	 */
    public function forgetPassWord()
    {
	    $this->display();
    }
	
	/**
	 * checkUserName，检测用户名是否存在
	 */
	public function checkUserName()
	{
		$userName = I('username');
		
		$count    = M('system_users')->where(array('uname' => $userName))->count();
		
		if($count)
		{
			$returnArr = array
			(
				'status' => '0',
				'msg'    => '该用户名已存在！',
				'data'   => array('url' => U('admin/register'))
			);
		}
		else
		{
			$returnArr = array
			(
				'status' => '0',
				'msg'    => '用户名可以用！',
				'data'   => array('url' => U('admin/register'))
			);
		}
		
		$this->ajaxReturn(json_encode($returnArr));
	}
    
	public function cleanCache()
	{
		$html_arr = glob("./Application/Runtime/Html/*.html");
		
		print_var($html_arr,'$html_arr');
	}
}

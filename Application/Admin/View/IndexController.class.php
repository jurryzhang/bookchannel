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
use Think\Db\Driver\Mysql;
use Think\Model;
use Think\AjaxPage;

class IndexController extends BaseController 
{
	/**----------------------------------------------*/
	/*                   主页控制器                   */
	/**----------------------------------------------*/
	protected function _model()
	{
		return new \Think\Model();
	}
	
	/**
	 * 首页
	 */
	public function index()
    {
		$is_mobile=is_mobile();
		$this->assign('is_mobile',$is_mobile);
		
        $permissions = cookie('permissions');
        
        if(isset($permissions))
        {
	        $menu_list = $this->getRoleMenu($permissions);
	
	        $this->assign('menu_list',$menu_list);
	
	        $adminInfo = getAdminInfo(cookie('uid'));
	
	        $this->assign('admin_info',$adminInfo);
	
	        $this->display();
        }
        else
        {
	        $this->display('Admin/login');
        }
    }
   
    public function welcome()
    {
		$is_mobile=is_mobile();
        $this->assign('is_mobile',$is_mobile);
		
	    $permissions = cookie('permissions');
	
	    if($permissions)
	    {
		
		    $channelInfo          = $this->getChannelShowInfo();
		
		    $dailyInfo            = $this->getChannelDailyInfo();

		    $count['users']       = $channelInfo['usersum'];
		
		    $count['channel']     = $channelInfo['channelsum'];
		
		    $count['new_pay']     = $dailyInfo['paylogsum'];
		
		    $count['new_user']    = $dailyInfo['usersum'];
		
		    $count['new_channel'] = $dailyInfo['channelsum'];
		
		    $count['new_sale']    = $dailyInfo['salesum'];
			//eidt by muyi 2017/05/09 增加日充值金额
			$count['daysumpay']    = $dailyInfo['daysumpay'];
			$count['daysign']=D('User')->getdaySignCount();

			/*统计*/
            $channelid=cookie('channelid');
            $today=date("Ymd",time());
			//用户数据统计
            $userModel=D('User');
            $dayUserInfo=$userModel->getDayUserInfo();

            $user_file='./userInfo/statistics_'.$channelid.'.txt';
            $dataUser=file_get_contents($user_file);
            $dataUserArr=json_decode($dataUser,true);
            if($dataUserArr['today']==$today){
                $userInfo=$dataUserArr;
            }else{
                $userInfo=$userModel->getUserInfo();
            }
            $this->assign('dayUserInfo',$dayUserInfo);
            $this->assign('userInfo',$userInfo);
            //用户充值信息
            $payModel=D('pay');
            $dayPayInfo=$payModel->dayPayInfo();  /*今日充值信息*/

            $pay_file='./paylogInfo/statistics_'.$channelid.'.txt';
            $dataPay=file_get_contents($pay_file);
            $dataPayArr=json_decode($dataPay,true);
            if($dataPayArr['today']==$today){
            	
                $payInfo=$dataPayArr;
            }else{
                $payInfo=$payModel->sumPayInfo();
            }
            $sumTonglePay = $payModel->getSumTonglePay();
            $payInfo['sumTonglePay'] = $sumTonglePay;
            //var_dump($sumTonglePay);
            //var_dump($payInfo);
            $this->assign('dayPayInfo',$dayPayInfo);
            $this->assign('payInfo',$payInfo);
            
            //公告
            $afficheModel=D('Affiche');
            $affInfo=$afficheModel->order('addtime DESC')->find();
            $this->assign('affInfo',$affInfo);
            $data=$afficheModel->search();
            $this->assign('affList',$data['affList']);
            $this->assign('page',$data['pageShow']);

		    $this->assign('count',$count);
		
		    $this->assign('sys_info',$this->get_sys_info());
		
		    $this->display();
	    }
	    else
	    {
	        header('location:' . U('Channel/index'));
	    }
    }
    
    public function map()
    {
	    $permissions = cookie('permissions');
    	
    	$all_menu = $this->getRoleMenu($permissions);
    	
    	$this->assign('all_menu',$all_menu);
    	$this->display();
    }
    
    public function get_sys_info()
    {
		$sys_info['os']             = PHP_OS;
		$sys_info['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
		$sys_info['safe_mode']      = (boolean) ini_get('safe_mode') ? 'YES' : 'NO';//safe_mode = 
		$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
		$sys_info['curl']			= function_exists('curl_init') ? 'YES' : 'NO';	
		$sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv']           = phpversion();
		$sys_info['ip'] 			= GetHostByName($_SERVER['SERVER_NAME']);
		$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
		$sys_info['max_ex_time'] 	= @ini_get("max_execution_time").'s'; //脚本最大执行时间
		$sys_info['set_time_limit'] = function_exists("set_time_limit") ? true : false;
		$sys_info['domain'] 		= $_SERVER['HTTP_HOST'];
		$sys_info['memory_limit']   = ini_get('memory_limit');		
        $sys_info['version']   		= file_get_contents('./Application/Admin/Conf/version.txt');
        
        //burn添加，2016-08-22
		$Model         = new  Model();
		$mysql_version = $Model->query("select version() as version");
		
		$sys_info['mysql_version'] = $mysql_version[0]['version'];
		
		if(function_exists("gd_info"))
		{
			$gd = gd_info();
			$sys_info['gdinfo'] = $gd['GD Version'];
		}
		else
		{
			$sys_info['gdinfo'] = "未知";
		}
		
		return $sys_info;
    }
    
    public function getRoleMenu($permissions)
    {
	    if(!$permissions)
	    {
		    $permissions = 0;
	    }
	    
		$modules = $roleMenu = array();
	    
    	//$rs = M('distribution_system_module')->where('level > 1 AND visible = 1')->order('orderby ASC')->select();

	    
    	if($permissions == 1)
    	{
    		$rs = M('distribution_system_module')->where('level > 1 AND visible = 1 AND ischannel=0')->order('orderby ASC')->select();
    		
    	}

    	if($permissions == 0){
    		$rs = M('distribution_system_module')->where('level > 1 AND visible = 1 AND ischannel=1')->order('orderby ASC')->select();

    	}

		foreach($rs as $row)
    		{
    			if($row['level'] == 3)
    			{
				    $row['url'] = U($row['ctl'] . "/" . $row['act'] . "");
				    
				    $modules[$row['parent_id']][] = $row;//子菜单分组
    			}
    			
    			if($row['level'] == 2)
    			{
    				$pmenu[$row['mod_id']] = $row;//二级父菜单
    			}
    		}

	
    	$keys = array_keys($modules);//导航菜单
    	
    	foreach ($pmenu as $k => $val)
    	{
    		if(in_array($k, $keys))
    		{
    			$val['submenu'] = $modules[$k];//子菜单
    			$roleMenu[] 	= $val;
    		}
    	}
    	//var_dump($roleMenu);exit;
    	return $roleMenu;
    }
    
    /**
     * ajax 修改指定表数据字段  一般修改状态 比如 是否推荐 是否开启 等 图标切换的
     * table,id_name,id_value,field,value
     */
    public function changeTableVal()
    {
		$table    = I('table'); // 表名
	    $id_name  = I('id_name'); // 表主键id名
        $id_value = I('id_value'); // 表主键id值
		$field 	  = I('field'); // 修改哪个字段
	    $value    = I('value'); // 修改字段值                        
		
	    M($table)->where("$id_name = $id_value")->save(array($field=>$value)); // 根据条件保存修改的数据
    }
	
	public function pushVersion()
	{
		if(!empty($_SESSION['isset_push']))
		{
			return false;
		}
		
		$_SESSION['isset_push'] = 1;
		error_reporting(0);//关闭所有错误报告
		$app_path = dirname($_SERVER['SCRIPT_FILENAME']).'/';
		$version_txt_path = $app_path.'/Application/Admin/Conf/version.txt';
		$curent_version = file_get_contents($version_txt_path);
		
		$vaules = array
		(
			'domain'=>$_SERVER['SERVER_NAME'],
			'last_domain'=>$_SERVER['SERVER_NAME'],
			'key_num'=>$curent_version,
			'install_time'=>INSTALL_DATE,
			'cpu'=>'0001',
			'mac'=>'0002',
			'serial_number'=>SERIALNUMBER,
		);
		
		$url = "http://service.tp".'-'."shop".'.'."cn/index.php?m=Home&c=Index&a=user_push&".http_build_query($vaules);
		stream_context_set_default(array('http' => array('timeout' => 3)));
		file_get_contents($url);
	}
	
	public function clean()
	{
		delFile('./Application/Runtime/Cache');
		
		delFile('./Application/Runtime/Data');
		
		delFile('./Application/Runtime/Logs');
		
		delFile('./Application/Runtime/Temp');
		
		delFile('./Application/Runtime');
		
		delFile('./Runtime/Cache');
		
		delFile('./Runtime/Data');
		
		delFile('./Runtime/Logs');
		
		delFile('./Runtime/Temp');
		
		delFile('./Runtime');
		
		$return = '清除成功！';
		
		$return = json_encode_ex($return);
		
		$this->ajaxReturn($return);
	}
	
	/**
	 * 获取渠道的信息，包括用户数量和渠道数量
	 */
	private function getChannelShowInfo()
	{
		$result['usersum']    = M('distribution_system_users')->where(1)->count();
		
		$result['channelsum'] = M('distribution_channels')->where(1)->count();
	
		return $result;
	}
	
	/**
	 * 获取渠道的每日统计信息
	 */
	private function getChannelDailyInfo()
	{
		$todayTime = strtotime(date('Y-m-d'));
		
		$userCondition['regdate']   = array('egt',$todayTime);
		
		$result['usersum']          = M('distribution_system_users')->where($userCondition)->count();
		
		$payLogContion['buytime']   = array('egt',$todayTime);
		
		$payLogContion['payflag']   = 1;
		
		$payLogContion['_logic']    = "AND";
		
		$result['paylogsum']        = M('distribution_pay_paylog')->where($payLogContion)->count();
		
		$channelContion['posttime'] = array('egt',$todayTime);
		
		$result['channelsum']       = M('distribution_channels')->where($channelContion)->count();
		
		$buyInfoContion['buytime']  = array('egt',$todayTime);
		
		$result['salesum']          = M('distribution_obook_obuyinfo')->where($buyInfoContion)->count();
		//edit by muyi 增加日充值金额
		$result['daysumpay']=D('Pay')->getDaySumpay();
		
		return $result;
	}
	
	/**
	 * 新增充值
	 */
	public function newPayLog()
	{
		$todayTime = strtotime(date('Y-m-d'));
		
		$channelID = cookie('channelid');
		
		if($channelID)
		{
			//$payLogContion['channelid'] = $channelID;
			$payIds = M('distribution_channels')->field('channelid')->where(array('pid'=>$channelID))->select();
			$str = '';
				foreach($payIds as $v){
					$str.= ','.$v['channelid'];
				}
				$ids = $str.",".$channelID;
				
				$payLogContion['channelid'] = array('IN',($ids));
		}
		
		$payLogContion['buytime'] = array('egt',$todayTime);
		
		$payLogContion['payflag'] = 1;
		
		$payLogContion['_logic']  = "AND";
		$paylog = M('distribution_pay_paylog');	
		$payLogSum                = $paylog->where($payLogContion)->count();
			
		$this->assign('payLogCount',$payLogSum);
		
		$this->display('payLogList');
	}
	/***
    *获取渠道登录名
    **/
    public function getUname($uid){
    	$uname = M('system_users')->field('uname')->where(array('uid'=>$uid))->find();
    	return $uname;
    }
	public function ajaxPayLogList()
	{
		if(cookie('uid'))
		{
			$todayTime = strtotime(date('Y-m-d'));
			
			$channelID = cookie('channelid');
		
			if($channelID)
			{
				//$payLogContion['channelid'] = $channelID;
				$payIds = M('distribution_channels')->field('channelid')->where(array('pid'=>$channelID))->select();
				$str = '';
				foreach($payIds as $v){
					$str.= ','.$v['channelid'];
				}
				$ids = $str.",".$channelID;
			$ids = ltrim($ids,',');	
				$payLogContion['channelid'] = array('IN',($ids));
			}
			
			$payLogContion['buytime']   = array('egt',$todayTime);
			
			$payLogContion['payflag']   = 1;
			
			$payLogContion['_logic']    = "AND";
			
			$count = M('distribution_pay_paylog')->where($payLogContion)->count();
			
			$Page = new AjaxPage($count, 10);
			
			$show = $Page->show();
			
			$orderStr = C('DB_PREFIX') . "distribution_pay_paylog.buytime desc";
			$paypayLog = M('distribution_pay_paylog');
			$payLogList = $paypayLog->where($payLogContion)->limit($Page->firstRow . ',' . $Page->listRows)->order($orderStr)->select();
	//	var_dump($payLogList);
	//echo M()->getLastSql();
			foreach($payLogList as $key => $item)
			{
				$payLogList[$key]['buytime'] = date('Y-m-d H:i:s', $item['buytime']);
				
				if($item['payflag'])
				{
					$payLogList[$key]['flag'] = '已充值';
				}
				else
				{
					$payLogList[$key]['flag'] = '待充值';
				}
				//edit by muyi 显示昵称
				$userModel=D('User');
				$payLogList[$key]['buyname']=$userModel->getNameById($payLogList[$key]['buyid']);
				$channelInfo = $this->getChannelInfo($item['channelid']);
				$userInfo = $this->getUname($channelInfo['uid']);

				$payLogList[$key]['channelname'] = $channelInfo['channelname'];
				$payLogList[$key]['uname'] = $userInfo['uname'];
				$payLogList[$key]['uid'] = $userInfo['uid'];
				$payLogList[$key]['channeltype'] = $channelInfo['channeltype'];
				
				/*edit by dai 余额*/
				$balance=$userModel->getBalanceByuid($item['buyid']);

				$payLogList[$key]['balance']=$balance['egold'];
			}
			
			$this->assign('payloglist', $payLogList);
			
			$this->assign('page', $show);
			
			$this->display();
		}
		else
		{
			$this->display('Admin/login');
		}
	}
	
	/**
	 * 新增用户
	 */
	public function newUser()
	{
		$todayTime = strtotime(date('Y-m-d'));
		
		$channelID = I('channel_id');
		
		if($channelID)
		{
			$userCondition['channelid'] = $channelID;
		}
		
		$userCondition['regdate'] = array('egt',$todayTime);
		
		$userSum                  = M('distribution_system_users')->where($userCondition)->count();
		
		$this->assign('usercount',$userSum);
		
		$this->display('userList');
	}
	
	public function ajaxUserList()
	{
		if(cookie('uid'))
		{
			$todayTime = strtotime(date('Y-m-d'));
			
			$keyWord   = I('key_word');
			
			$channelID = I('channel_id');
			
			if($channelID)
			{
				$condition['channelid'] = $channelID;
			}
		
	
		     	$condition['name']    = array('like', '%' . $keyWord . '%');
			
			$condition['regdate'] = array('egt',$todayTime);
			
			$condition['_logic']  = 'AND';
			
			$count = M('distribution_system_users')->where($condition)->count();
			
			$Page  = new AjaxPage($count, 10);
			
			$show  = $Page->show();
			
			$orderStr = C('DB_PREFIX') . "distribution_system_users.{$_POST['orderby1']} {$_POST['orderby2']}";
			
			$userList = M('distribution_system_users')->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->order($orderStr)->select();
			
			foreach($userList as $key => $value)
			{
				$userList[$key]['lastlogin'] = date('Y-m-d H:i:s',$value['lastlogin']);
			}
			
			$this->assign('userlist', $userList);
			
			$this->assign('page', $show);
			
			$this->display();
		}
		else
		{
			$this->display('Admin/login');
		}
	}
	
	/**
	 * 新增渠道
	 */
	public function newChannel()
	{
		$todayTime = strtotime(date('Y-m-d'));
		
		$channelContion['posttime'] = array('egt',$todayTime);
		
		$channelSum                 = M('distribution_channels')->where($channelContion)->count();
		
		$this->assign('channelcount',$channelSum);
		
		$this->display('channelList');
	}
	
	/**
	 * 加载渠道列表
	 */
	public function ajaxChannelList()
	{
		if(cookie('permissions') == 0)
		{
			$keyWord   = cookie('channelname');
			
			$isChannel = 1;
			
			$this->assign('ischannel',$isChannel);
		}
		else
		{
			$keyWord = I('key_word');
		}
		
		if(cookie('uid'))
		{
			$todayTime = strtotime(date('Y-m-d'));
			
			$channelContion['posttime']    = array('egt',$todayTime);
			
			$channelContion['channelname'] = array('like','%' . $keyWord . '%');
			
			$channelContion['_logic']      = 'AND';
			
			$count       = M('distribution_channels')->where($channelContion)->count();
			
			$Page        = new AjaxPage($count,10);
			
			$show        = $Page->show();
			
			$channelList = M('distribution_channels')->where($channelContion)->limit($Page->firstRow . ',' . $Page->listRows)->select();
			
			$channelList = convert_arr_key($channelList,'channelid');
			
			foreach($channelList as $key => $value)
			{
				$channelList[$key] = $this->getChannelPayLog($value['channelid']);
			}
			
			$this->assign('channelList',$channelList);
			
			$this->assign('page',$show);// 赋值分页输出
			
			$this->display();
		}
	}
	
	/**
	 * 根据$channelID获取渠道的结算信息
	 *
	 * @param $channelID
	 * @return mixed
	 */
	private function getChannelPayLog($channelID)
	{
		$channelPayLog = M('distribution_pay_log')->where(array('channelid' => $channelID))->find();
		
		$channelInfo   = M('distribution_channels')->where(array('channelid' => $channelID))->find();
		
		$convertProportion = C('CONVERTIBLE_PROPORTION');//兑换比例
		
		$channelPayInfo['channelid']    = $channelInfo['channelid'];
		
		$channelPayInfo['channelname']  = $channelInfo['channelname'];
		
		$channelPayInfo['summoney']    = ($channelPayLog['paidmoney'] + $channelPayLog['remainmoney']) * $convertProportion;
		
		$channelPayInfo['remainmoney']  = $channelPayLog['remainmoney'] * $convertProportion * $channelInfo['proportion'];
		
		$channelPayInfo['proportion']   = $channelInfo['proportion'];
		
		$channelPayInfo['paidmoney']   = $channelPayLog['paidmoney'] ? $channelPayLog['paidmoney'] * $convertProportion : 0;
		
		return $channelPayInfo;
	}
	
	/**
	 * 新增消费
	 */
	public function newSale()
	{
		$todayTime = strtotime(date('Y-m-d'));
		
		$buyInfoContion['buytime'] = array('egt',$todayTime);
		
		$buyInfoSum                = M('distribution_obook_obuyinfo')->where($buyInfoContion)->count();
		
		$this->assign('buyinfosum',$buyInfoSum);
		
		$this->display('buyInfo');
	}

	public function ajaxBuyInfo()
	{
		if(cookie('uid'))
		{
			$todayTime = strtotime(date('Y-m-d'));

			$condition['buytime'] = array('egt',$todayTime);
			
			$count = M('distribution_obook_obuyinfo')->where($condition)->count();
			
			$Page = new AjaxPage($count, 10);
			
			$show = $Page->show();
			
			$orderStr = C('DB_PREFIX') . "distribution_obook_obuyinfo.buytime desc";
			
			$buyInfoList = M('distribution_obook_obuyinfo')->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->order($orderStr)->select();
			
			foreach($buyInfoList as $key => $item)
			{
				$buyInfoList[$key]['buytime'] = date('Y-m-d H:i:s', $item['buytime']);
				
				$userInfo = M('distribution_system_users')->where(array('uid' => $item['userid']))->find();
				
				$buyInfoList[$key]['uname']       = $userInfo['uname'];
				
				$buyInfoList[$key]['name']        = $userInfo['name'];
				
				$channelInfo = $this->getChannelInfo($item['channelid']);
				
				$buyInfoList[$key]['channelname'] = $channelInfo['channelname'];
				
				$buyInfoList[$key]['channeltype'] = $channelInfo['channeltype'];
			}
			
			$this->assign('buyinfolist', $buyInfoList);
			
			$this->assign('page', $show);
			
			$this->display();
		}
		else
		{
			$this->display('Admin/login');
		}
	}
	
	private function getChannelInfo($channelID)
	{
		$channelInfo = M('distribution_channels')->where(array('channelid' => $channelID))->find();
		
		if(!$channelInfo)
		{
			$channelInfo['channelname'] = '官方渠道';
			
			$channelInfo['channeltype'] = '暂无统计';
		}
		
		return $channelInfo;
	}
}

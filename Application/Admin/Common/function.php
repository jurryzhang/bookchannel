<?php
/**
 * 趣读商城
 * ============================================================================
 * * 版权所有 2015-2027 河南趣读信息科技有限公司，并保留所有权利。
 * 网站地址: http://www.qudukeji.com
 * ----------------------------------------------------------------------------
 * ============================================================================
 */
 
 
/**edit by muyi  2017/05/24
 * @param $curl
 * @param bool $https
 * @param string $method
 * @param null $data
 * @return mixed
 * 发送请求
 */
function request($curl, $https=true, $method='get', $data=null){
    $ch = curl_init();//初始化
    curl_setopt($ch, CURLOPT_URL, $curl);//设置访问的URL
    curl_setopt($ch, CURLOPT_HEADER, false);//设置不需要头信息
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//只获取页面内容，但不输出
    if($https){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器认证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
    }
    if($method == 'post'){
        curl_setopt($ch, CURLOPT_POST, true);//设置请求是POST方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置POST请求的数据
    }
    $str = curl_exec($ch);//执行访问，返回结果
    curl_close($ch);//关闭curl，释放资源
    return $str;

}

 
 

/**
 * 管理员操作记录
 * @param $log_url 操作URL
 * @param $log_info 记录信息
 */
function adminLog($log_info)
{
    $add['log_time'] = time();
    $add['admin_id'] = session('admin_id');
    $add['log_info'] = $log_info;
    $add['log_ip']   = getIP();
    $add['log_url']	 = __ACTION__;
    
    $res = M('admin_log')->add($add);
}

function getAdminInfo($admin_id)
{
	return D('system_users')->where("uid = $admin_id")->find();
}

/**
 * 面包屑导航  用于后台管理
 * 根据当前的控制器名称 和 action 方法
 */
function navigate_admin()
{        
    $navigate = include APP_PATH.'Common/Conf/navigate.php';
    
//    $location = strtolower('Admin/' . CONTROLLER_NAME);//将字符串转化为小写
	
	$location = strtolower(CONTROLLER_NAME);//将字符串转化为小写
    
    $arr      = array
			    (
			    	'后台首页' => U('Admin/Index/welcome'),
					$navigate[$location]['name'] => U($location . "/" . ACTION_NAME),
					$navigate[$location]['action'][ACTION_NAME] => U($location . "/" . ACTION_NAME),
			    );
			
    return $arr;
}

/**
 * 导出excel
 * @param $strTable	表格内容
 * @param $filename 文件名
 */
function downloadExcel($strTable,$filename)
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Type: application/force-download");
	header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
	header('Expires:0');
	header('Pragma:public');
	echo '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$strTable.'</html>';
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '')
{
	$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
	
	for($i = 0; $size >= 1024 && $i < 5; $i++)
	{
		$size /= 1024;
	}
	
	return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 根据id获取地区名字
 * @param $regionId id
 */
function getRegionName($regionId)
{
    $data = M('region')->where(array('id'=>$regionId))->field('name')->find();
    return $data['name'];
}

/**
 * 将字符串转换为拼音
 * @param $str
 * @param int $ishead
 * @param int $isclose
 * @return string
 */
function getPinYinFromStr($str, $ishead = 0, $isclose = 0)
{
	global $pinYins;
	
	$str  = iconv("UTF-8","GBK//IGNORE",$str);
	
	$ret  = '';
	$str  = trim($str);
	$slen = strlen($str);
	
	if ($slen < 2)
	{
		return $str;
	}
	
	if (!isset($pinYins) || !is_array($pinYins))
	{
		$pinYins = array();
		
		$fp = fopen(dirname(__FILE__) . '/pinyin.dat', 'r');
		
		while (!feof($fp))
		{
			$line = trim(fgets($fp));
			
			$pinYins[$line[0] . $line[1]] = substr($line, 2);
		}
		
		fclose($fp);
	}
	
	$i = 0;
	
	for (; $i < $slen; $i++)
	{
		if (128 < ord($str[$i]))
		{
			$c = $str[$i] . $str[$i + 1];
			$i++;
			
			if (isset($pinYins[$c]))
			{
				if (!$ishead)
				{
					$ret .= $pinYins[$c];
				}
				else
				{
					$ret .= $pinYins[$c][0];
				}
			}
			else
			{
				$ret .= '_';
			}
		}
		else if (preg_match('/[a-z0-9]/i', $str[$i]))
		{
			$ret .= $str[$i];
		}
		else
		{
			$ret .= '_';
		}
	}
	
	if ($isclose)
	{
		unset($pinYins);
	}
	
	return $ret;
}

/**
 * 获取拼音的首字符大写
 * @param $str    汉语拼音
 * @return string
 */
function getPinYinInitial($str)
{
	$ret = getPinYinFromStr($str, 1);
	
	return $ret[0] == '_' ? '1' : strtoupper($ret[0]);
}

/**
 * 检测图片格式
 *
 * @param $url
 * @return string
 */
function checkImageType($url)
{
	$fileType = substr(strrchr($url, '.'), 1);
	
	$fileType = strtolower($fileType);
	
	$imgTypeArray = array('jpg','gif','bmp','jpeg','png');
	
	if(in_array($fileType,$imgTypeArray))
	{
		return "s." . $fileType;
	}
}

/*
*功能：php完美实现下载远程图片保存到本地
*参数：文件url,保存文件目录,保存文件名称，使用的下载方式
*当保存文件名称为空时则使用远程文件原来的名称
*/
function getImage($url,$saveDir = '',$fileName = '',$type = 0)
{
	if(trim($url) == '')
	{
		return array('file_name' => '','save_path' => '','error' => 1);
	}
	
	if(trim($saveDir) == '')
	{
		$save_dir = './';
	}
	
	if(trim($fileName) == '')
	{
		$filename = checkImageType($url);
	}
	
	//创建保存目录
	if(!file_exists($saveDir) && !mkdir($saveDir,0777,true))
	{
		return array('file_name' => '','save_path' => '','error' => 2);
	}
	
	//获取远程文件所采用的方法
	if($type)
	{
		$ch      = curl_init();
		$timeout = 5;
		
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$img = curl_exec($ch);
		curl_close($ch);
	}
	else
	{
		ob_start();
		readfile($url);
		$img = ob_get_contents();
		
		ob_end_clean();
	}
	
	//文件大小
	$fp2 = @fopen($saveDir.$fileName,'a');
	fwrite($fp2,$img);
	fclose($fp2);
	unset($img,$url);
	return array('file_name' => $fileName,'save_path' => $saveDir.$fileName,'error' => 0);
}

/**
 * object(SimpleXMLElement) 对象转换为数组
 * convert simplexml object to array sets
 * $array_tags 表示需要转为数组的 xml 标签。例：array('item', '')
 * 出错返回False
 *
 * @param object $simplexml_obj
 * @param array $array_tags
 * @param int $strip_white 是否清除左右空格
 * @return mixed
 */
function xmlToArray($simpleXmlElement)
{
	$simpleXmlElement = (array)$simpleXmlElement;
	
	foreach($simpleXmlElement as $k => $v)
	{
		if($v instanceof SimpleXMLElement ||is_array($v))
		{
			$simpleXmlElement[$k] = xmlToArray($v);
		}
	}
	return $simpleXmlElement;
}

/**
 * 将服务器返回的xml转为array
 * @param string $url 服务器地址，返回值为xml格式
 * @throws WxPayException
 *
 */
function arrayFromUrl($url)
{
	@set_time_limit(0);
	ini_set('memory_limit', '16M');
	
	ob_end_clean();
	
	ob_start();

	$fileSize = readfile($url);

	if($fileSize)
	{
		$xml = ob_get_contents();
		
		ob_end_clean();
		
		//禁止引用外部xml实体
		libxml_disable_entity_loader(true);
		
		if($xml)
		{
			//将XML转为array
			$xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			return xmlToArray($xmlObj);
		}
		else
		{
			echo "\r\n ----error: ToXml File False!  --- \r\n";
		}
	}
	else
	{
		ob_end_clean();
		
		echo "\r\n ----error: Read File False!  --- \r\n";
	}
}

function _rand()
{
	$length = 26;
	$chars  = "0123456789abcdefghijklmnopqrstuvwxyz";
	$max    = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	$string = '';
	
	for($i = 0; $i < $length; $i++)
	{
		$string .= $chars[mt_rand(0, $max)];
	}
	
	return $string;
}

/**
 * 从远程地址获取xml数据，并转换为数组
 *
 * @param $url
 */
function xmlFileToArray($url)
{
	$ch = curl_init();
	
	curl_setopt ($ch,CURLOPT_URL,$url);
	
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	
	$hearderList = array
					(
						'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
						'Accept-Language:zh-CN,zh;q=0.8,en;q=0.6',
						'Cache-Control:no-cache',
						'Connection:keep-alive',
						'Cookie:yunsuo_session_verify=90ccbc313f288fe93691637f0904f94e; channelid=0; yunsuo_session_verify=faa32ebdde413788ce0abe4c077f4591; PHPSESSID=81859d7225a687b420e5427c6fc8a35c',
						'Host:m.ziycw.com',
						'Pragma:no-cache',
					);
	
	curl_setopt($ch,CURLOPT_HTTPHEADER,$hearderList);
	
	curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, sdch");
	
	curl_setopt($ch,CURLOPT_REFERER,"http://m.ziycw.com/");
	
	curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36");
	
	$xml = curl_exec($ch);
	
	curl_close ($ch);
	
		//禁止引用外部xml实体
	libxml_disable_entity_loader(true);
		
	if($xml)
	{
		//将XML转为array
		$xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		return xmlToArray($xmlObj);
	}
	else
	{
		echo "\r\n ----error: ToXml File False!  --- \r\n";
	}
}

/**
 * 备份数据库需要
 *
 * @param $inputFilePath
 * @return mixed
 */
function backupArrayFromUrl($inputFilePath)
{
	header("Content-type: text/html; charset=utf-8");
	
	$xmlstring  = file_get_contents($inputFilePath);
	
	$update_str = str_replace('encoding="ISO-8859-1"', 'encoding="UTF-8"', $xmlstring);
	
	$xml = mb_convert_encoding($update_str,'utf-8','gbk');
	
	//将XML转为array
	$xmlObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	
	return xmlToArray($xmlObj);
}

/**
 * 编码检测
 *
 * @param $file
 * @return mixed|null
 */
function detectncoding($file)
{
	$list = array('GBK', 'UTF-8', 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1');
	$str = file_get_contents($file);

	foreach ($list as $item)
	{
		$tmp = mb_convert_encoding($str, $item, $item);
	
		if (md5($tmp) == md5($str))
		{
			return $item;
		}
	}
	return null;
}

/**
 * 输出xml字符
 *
 * burn添加，2016-12-22
 *
 * 微信支付
 *
 **/
function arrayToXml($inputArray)
{
	if(!is_array($inputArray) || count($inputArray) <= 0)
	{
		$errorMessage = "数据组异常";
	}
	
	$xml = '';
	
	foreach ($inputArray as $key => $val)
	{
		$xmLStr = "<" . $key . ">" . iconv("UTF-8","GBK//IGNORE",$val) . "</" . $key . ">\r\n";
		
		$xml .= $xmLStr;
	}
	
	return $xml;
}

/**
 * 将数据转化为json
 *
 * @param  $var
 * @return string
 * @throws Exception
 */
function json_encode_ex($var)
{
	if ($var === null)
	{
		return 'null';
	}
	
	if ($var === true)
	{
		return 'true';
	}
	
	if ($var === false)
	{
		return 'false';
	}
	
	static $reps = array
	(
		array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"', ),
		array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"', ),
	);
	
	if (is_scalar($var))
	{
		return '"' . str_replace($reps[0], $reps[1], (string) $var) . '"';
	}
	
	if (!is_array($var))
	{
		throw new Exception('JSON encoder error!');
	}
	
	$isMap = false;
	$i     = 0;
	
	foreach (array_keys($var) as $k)
	{
		if (!is_int($k) || $i++ != $k)
		{
			$isMap = true;
			
			break;
		}
	}
	
	$s = array();
	
	if ($isMap)
	{
		foreach ($var as $k => $v)
		{
			$s[] = '"' . $k . '":' . call_user_func(__FUNCTION__, $v);
		}
		
		return '{' . implode(',', $s) . '}';
	}
	else
	{
		foreach ($var as $v)
		{
			$s[] = call_user_func(__FUNCTION__, $v);
		}
		
		return '[' . implode(',', $s) . ']';
	}
}

//递归删除文件夹
function delFile($dir,$file_type='')
{
	if(is_dir($dir))
	{
		$files = scandir($dir);
		
		//打开目录 //列出目录中的所有文件并去掉 . 和 ..
		foreach($files as $filename)
		{
			if($filename!='.' && $filename!='..')
			{
				if(!is_dir($dir.'/'.$filename))
				{
					if(empty($file_type))
					{
						unlink($dir.'/'.$filename);
					}
					else
					{
						if(is_array($file_type))
						{
							//正则匹配指定文件
							if(preg_match($file_type[0],$filename))
							{
								unlink($dir.'/'.$filename);
							}
						}
						else
						{
							//指定包含某些字符串的文件
							if(false!=stristr($filename,$file_type))
							{
								unlink($dir.'/'.$filename);
							}
						}
					}
				}
				else
				{
					delFile($dir.'/'.$filename);
					rmdir($dir.'/'.$filename);
				}
			}
		}
	}
	else
	{
		if(file_exists($dir))
		{
			unlink($dir);
		}
	}
}
<?php
return array(
     'URL_HTML_SUFFIX'        => '',  // URL伪静态后缀设置
    // 'OUTPUT_ENCODE' =>  true, //页面压缩输出支持   配置了 没鸟用
    'PAYMENT_PLUGIN_PATH'     => PLUGIN_PATH.'payment',
    'LOGIN_PLUGIN_PATH'       => PLUGIN_PATH.'login',
    'SHIPPING_PLUGIN_PATH'    => PLUGIN_PATH.'shipping',
    'FUNCTION_PLUGIN_PATH'    => PLUGIN_PATH.'function',
	'SHOW_PAGE_TRACE' 	      => false,
	'CFG_SQL_FILESIZE'        => 5242880,
    'URL_MODEL'               => 3, //
    //默认错误跳转对应的模板文件
    'TMPL_ACTION_ERROR'       => 'Public:dispatch_jump',
    //默认成功跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'     => 'Public:dispatch_jump',
	'URL_HTML_SUFFIX'         => 'html',
	'HTML_CACHE_ON'           => true, // 开启静态缓存
    'HTML_CACHE_TIME'         => 60,   // 全局静态缓存有效期（秒）
	
	'DIR_PATH'                => 'D:\\\\www\\\\bacoolread\\\\configs\\\\article\\\\',//文件夹路径
	
	'FIRST_SORT_FILE_PATH'    => 'filter.php',
	'SECONDE_SORT_FILE_PATH'  => 'sort.php',
	'THIRD_SORT_FILE_PATH'    => 'sort.php',
	'CONVERTIBLE_PROPORTION'  => 0.01,//100：1的兑换比，100小说币兑换1元人民币
	
	'TXT_FILE_PATH'           => 'E:\\\\files\\\\\article\\\\txt\\\\',//txt文件路径
	
	'IMAGE_FILE_PATH'         => 'E:\\\\files\\\\\article\\\\image\\\\',//书籍封面路径
	
	'PAY_CONFIG'                => 'C:\\\\mobilebook\\\\paylimit.php',//支付配置文件
	'AD_CONFIG'                => 'C:\\\\mobilebook\\\\adswitch.php',//广告配置文件
	'BOOK_DIR'                 => 'E:\\\\files\\\\',//广告配置文件
	
	'DOC_TPL'=>'Application/Common/Conf/tpl.php',//生成文案的模版文件

    //图片url
    'IMAGE_FILE_URL' => 'http://pic.kyread.com/image',
    'DEFAULT_ARTICLE_COVER' => 'http://book.kyread.com/modules/article/images/nocover.jpg',//默认书籍封面
	
	'DISTRIBUTION_URL'        => 'http://wap.kyread.com/?secretkey=%s&channel=%s&type=%s',
	
	'WEB_NAME'                => '渠道',
	
	'EGOLD_NAME'              => '小说币',
	
	'WEB_DOMAIN_URL'          => 'http://wap.kyread.com',
	
	'WEIXIN_DISTRIBUTION_URL' => 'http://wap.kyread.com/User/getWeiXinInfo/backurl/Index-index/secretkey/%s/channel/%s/type/%s.html',
	'DOC_URL' => 'http://wap.kyread.com/User/getWeiXinInfo/backurl/%s/secretkey/%s/channel/%s/type/%s.html',
);
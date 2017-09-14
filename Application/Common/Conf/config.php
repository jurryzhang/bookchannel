<?php
return array
(
	//'配置项'=>'配置值'
	'AUTH_CODE'       => "MIANFEIDUSHU_SHUMENG",//安装完毕之后不要改变，否则所有密码都会出错
	'LOAD_EXT_CONFIG' => 'db,html,weixin', // 加载数据库配置文件
	'URL_HTML_SUFFIX' => 'html',
	'URL_MODEL'       => 3,//URL模式为兼容模式
	'DEFAULT_FILTER'  => 'trim', // 系统默认的变量过滤机制

	/*
	 * RBAC认证配置信息
	 */
	'SESSION_AUTO_START'    => true,
	'USER_AUTH_ON'          => true,
	'USER_AUTH_TYPE'        => 1,         // 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY'         => 'authId',  // 用户认证SESSION标记
	'ADMIN_AUTH_KEY'        => 'administrator',
	'USER_AUTH_MODEL'       => 'User',    // 默认验证数据表模型
	'AUTH_PWD_ENCODER'      => 'md5',     // 用户认证密码加密方式
	'SHOW_PAGE_TRACE'       => true,
	
	/************ 图片相关的配置 ***************/
    'IMAGE_CONFIG' => array(
        'maxSize' => 1024*1024,
        'exts' => array('jpg', 'gif', 'png', 'jpeg'),
        'rootPath' => './Public/upload/',  // 上传图片的保存路径  -> PHP要使用的路径，硬盘上的路径
        'viewPath' => '/Public/upload/',   // 显示图片时的路径    -> 浏览器用的路径，相对网站根目录
    )
);
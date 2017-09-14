<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
//if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 定义应用目录
define('APP_PATH','./Application/');

//定义运行时目录
define('RUNTIME_PATH','./Runtime/');

define('UPLOAD_PATH','./Public/upload/'); // 编辑器图片上传路径

//绑定入口文件Admin模块访问
define('BIND_MODULE','Admin');

//绑定入口文件BURN模块访问
//define('BIND_MODULE','BURN');

// 引入ThinkPHP入口文件,上述应用的目录结构只是默认设置,事实上,在实际部署应用的时候,我们建议除了应用入口文件和 Public 资源目录外,其他文件都放到非WEB目录下面,具有更好的安全性。
// require './ThinkPHP/ThinkPHP.php';

require './ThinkPHP/ThinkPHP.php';

?>

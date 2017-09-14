<?php
// 面包屑导航配置
    return array
    (
    	0 => array
			(
    			'title'   => '个人信息管理',
				'icon'    => 'fa-user',
				'submenu' => array
                (
                    0 => array
                         (
                         	'title' => '个人信息修改',
                         	'url'   => U('Home/Secretary/addWorker?editype=1'),
                         ),
                )
    	    ),
    		1 => array
    		(
    			'title'   => '任务管理',
				'icon'    => 'fa-flag',
				'submenu' => array
                (
                    0 => array
                		(
                			'title' => '任务列表',
                			'url'   => U('Home/Task/viewTask'),
                		),
                )
    		)
    );
?>

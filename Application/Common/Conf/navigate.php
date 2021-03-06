<?php
// 面包屑导航配置
    return array
    (        
          'admin/index' => array
		  (
              'name'     => '书盟系统管理',
               'action'  => array
		        (
                    'index' => '欢迎页面',
                )
          ),
	    
          'channel' => array
          (
          'name'   => '渠道管理',
              'action' => array
                          (
                              'channelList' => '渠道列表',
                              'channelAffiche' => '公告信息',
                              'channelBankinfo' => '收款信息',
                              'channelListCombine' => '代理管理',
                              'ptList' => '推广链接',
                              'tplList' => '模板消息',
                              'keywordList' => '关键词回复',
                              'wxSet' => '公众号设置',
                              'commonUrl' => '常用链接',
                              'channelInfoList' => '渠道推广信息',
                              
                          )
          ),


          'user' => array
          (
          'name'   => '用户管理',
              'action' => array
                          (
                              'userSearch' => '用户查询',
                              'editMyPass' => '修改密码',
                              'channelPayLogListByChannleID' => '订单管理',
                              'channelUserAccessLog' => '渠道用户访问记录',
                              'userAccessLogList' => '用户访问记录',
                              'payLogList' => '充值记录',
                              'userList' => '用户列表',

                          )
          ),

          'booksale' => array
          (
          'name'   => '促销管理',
              'action' => array
                          (
                              'promotionList' => '促销活动',
                              'bookSaleListByChannelID' => '渠道销售列表',
                              'bookSaleList' => '书籍销售列表',
                              
                              
                              
                          )
          ),


          'source' => array
          (
		      'name'   => '文案模板管理',
              'action' => array
                          (
                              'picList' => '图片列表',
                              'picAdd' => '图片添加',
                              'titleList' => '文案标题列表',
                              'titleAdd' => '文案标题添加',
                              'contAdd' => '正文模板添加',
                              'contList' => '正文模板列表',
                              'foucsList' => '引导模板列表',
                              'foucsAdd' => '引导模板添加',
                              'removeOffShelfBook' => '清除下架书籍',
                              
                              
                              
                          )
		      ),

    
          'sort' => array
          (
              'name'   => '小说分类查看',
              'action' => array
                          (
                              'firstSortList'  => '频道分类',
                              'secondSortList' => '小说分类',
		                      'thirdSortList'  => '小说详细分类',
                         )
           ),
	    
          'admin/order'=>array(
            'name' =>'订单管理',
            'action'=>array(
                 'index'=>'订单列表',
                 'edit_order'=>'编辑订单',
                 'delivery_list'=>'发货单列表',
                 'delivery_info'=>'订单发货',
                 'add_order'=>'添加订单',
                 'split_order'=>'拆分订单',
                 'detail'=>'订单详情',
                 'return_list'=>'退货申请列表',
              )
           ),
          'admin/user'=>array(
            'name' =>'会员管理',
            'action'=>array(
                 'index'=>'用户列表',
                 'address'=>'收货地址',
                 'account_log'=>'用户资金',
                 'levelList'=>'等级列表',
                 'level'=>'添加等级',
              )
           ),
          'ad'=>array(
            'name' =>'广告管理',
            'action'=>array(
                 'adList'=>'广告列表',
                 'edit'=>'编辑广告',
                 'ad'=>'新增广告',
                 'adStats'=>'广告统计',
                 'adSwitch'=>'广告权限管理',
                 'adList'=>'广告列表',
                 'positionList'=>'广告位置',
                 'position'=>'编辑广告位',
              )
           ),
          'admin/article'=>array(
            'name' =>'文章管理',
            'action'=>array(
                 'categorylist'=>'分类列表',
                 'category'=>'编辑分类',
                 'articlelist'=>'文章列表',
                 'article'=>'编辑文章',
                 'linkList'=>'友情链接列表',
                 'link'=>'编辑友情链接',
              )
           ),
          'admin/admin'=>array(
            'name' =>'权限管理',
            'action'=>array(
                 'index'=>'管理员列表',
                 'admin_info'=>'编辑信息',
                 'log'=>'管理员日志',
                 'role'=>'角色管理',
                 'role_info'=>'创建编辑角色',
              )
           ),
          'admin/comment'=>array(
            'name' =>'评论管理',
            'action'=>array(
                 'index'=>'评论列表',
                 'detail'=>'评论回复',
              )
           ),
          'admin/template'=>array(
            'name' =>'模板管理',
            'action'=>array(
                 'templatelist'=>'模板选择',
                 'templateList'=>'PC模板',
				 'templateList'=>'手机端模板',
              )
           ),
          'admin/coupon'=>array(
            'name' =>'促销管理',
            'action'=>array(
                 'index'=>'优惠券',
                 'add_coupon'=>'添加优惠券',
                 'edit_coupon'=>'编辑优惠券',
              )
           ),
          'admin/wechat'=>array(
            'name' =>'微信管理',
            'action'=>array(
                 'index'=>'公众号管理',
                 'setting'=>'微信配置',
                 'menu'=>'微信菜单',
                 'text'=>'文本回复',
                 'add_text'=>'编辑文本回复',
                 'img'=>'图文回复',
                 'add_img'=>'编辑图文回复',
                 'news'=>'组合图文回复',
                 'add_news'=>'编辑图文',
              )
           ),
          'admin/plugin'=>array(
            'name' =>'插件管理',
            'action'=>array(
                 'index'=>'插件列表',
                 'setting'=>'插件配置',
              )
           ),
           'admin/topic'=>array(
                'name' =>'专题管理',
                'action'=>array(
                    'topicList'=>'专题列表',
                    'topic'=>'添加专题',
                )
           ),
           'admin/promotion'=>array(
                'name' =>'促销管理',
                'action'=>array(
                    'group_buy_list'=>'团购管理',
                    'group_buy'=>'编辑团购',
                    'flash_sale'=>'限时抢购',
                    'prom_order_list'=>'订单促销',
                    'prom_goods_list' => '商品促销'
                )
           ),
           'admin/tools'=>array(
                'name' =>'工具管理',
                'action'=>array(
                    'index'=>'数据备份',
                    'restore'=>'数据还原',
                )
           ),
           'admin/report'=>array(
                'name' =>'报表统计',
                'action'=>array(
                    'index'=>'销售概况',
                    'saleTop'=>'销售排行',
                    'userTop'=>'会员排行',
                    'saleList'=>'销售明细',
                    'user'=>'会员统计',
                    'finance'=>'财务统计',
                )
           ),
    );
?>

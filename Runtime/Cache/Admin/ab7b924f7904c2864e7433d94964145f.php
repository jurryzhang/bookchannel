<?php if (!defined('THINK_PATH')) exit(); if(empty($userinfo)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
		<link rel="shortcut icon" href="/Public/images/favicon.ico" />
    	<title>免费读书 | <?php echo ($web_name); ?></title>
    	<!-- Tell the browser to be responsive to screen width -->
    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Bootstrap 3.3.4 -->
    	<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    	<!-- FontAwesome 4.3.0 -->
 		<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    	<!-- Ionicons 2.0.0 --
    	<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    	<!-- Theme style -->
    	<link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    	<!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    	<link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    	<!-- iCheck -->
    	<link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    	<!-- jQuery 2.1.4 -->
    	<script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    	<script src="/Public/js/common.js"></script>
    	<script src="/Public/js/myFormValidate.js"></script>    
    	<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    	<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    	<script src="/Public/js/myAjax.js"></script>
		<script src="/Public/js/jquery-table-color.js"></script>
		<script src="/Public/js/clipboard.min.js"></script>
    	<script type="text/javascript">
    		function delfunc(obj)
    		{
    			layer.confirm('确认删除？', 
				{
    		  		btn: ['确定','取消'] //按钮
    			}, 
    			function()
    			{
    		    	// 确定
   					$.ajax(
					{
   						type : 'post',
   						url : $(obj).attr('data-url'),
   						data : {act:'del',del_id:$(obj).attr('data-id')},
   						dataType : 'json',
   						success : function(data)
   						{
	   						if(data == 1)
	   						{
	   							layer.msg('操作成功', {icon: 1});
	   							$(obj).parent().parent().remove();
	   						}
	   						else
	   						{
	   							layer.msg(data, {icon: 2,time: 2000});
	   						}
	   						layer.closeAll();
						}
   					})
    			}, 
    			function(index)
    			{
    				layer.close(index);
    				return false;// 取消œ
    			});
    		}
    
    		function selectAll(name,obj)
    		{
    			$('input[name*='+name+']').prop('checked', $(obj).checked);
    		}    
    	</script>
<style type="text/css">
	    	#riframe{min-height:inherit !important}
			.alertBox{display:none;width:100%;height:100%;position:relative;top:0;left:0;z-index:1;}
			.alertBox .mark{
				width:100%;height:100%;
				position:fixed;top:0;left:0;
				background:#000;opacity:0.3;
			}
			.alertBox .alert{
				display:none;
				width: 700px;height:498px;
				background:#FFF;
				position:fixed;top:50%;left:50%;
				z-index:9;
			}
			.alertBox .alt-header{
				cursor:move;
				padding:4px 17px;
				height:7%;line-height:20px;
				font-size:17px;
				border-bottom: 1px solid #CCCCCC;
			}
			.alertBox .alt-header .icon{
				float:right;
				cursor:pointer;
				font-style:normal;
			}
			.alertBox .alt-body{
				padding:10px 26px;
			}
			.alertBox .alt-body tr td{
				padding:8px 20px;
			}
			.alertBox .alt-footer{
				text-align: right;
				margin-right: 10px;
				border-top: 1px solid #CCCCCC;
			}
	    </style>		
	</head>
  	<body style="background-color:#ecf0f5;display:block;overflow:auto;margin:0 auto;">

<div class="wrapper">
    <section class="content">

        <div class="row">
            <div class="tabs-container">
                <ul class="nav nav-tabs" style="border-bottom: none">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">用户信息</a>
                    </li>
                    <li><button type="submit" onclick="oneBuyLogList('<?php echo U('User/getUserBuySearch',array('id'=>$userinfo['uid']));?>','<?php echo ($userinfo['name']); ?>消费记录',900,800)" id="button-filter search-order" class="btn btn-primary">
                                消费记录
                                </button></li>
                    <!-- <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">消费记录</a>
                    </li> -->
                    <!-- <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">订单记录</a>
                    </li> -->
                    <li><button type="submit" onclick="onePayLogList('<?php echo U('User/getUserPaySearch',array('id'=>$userinfo['uid']));?>','<?php echo ($userinfo['name']); ?>充值记录',900,800)" id="button-filter search-order" class="btn btn-primary">
                                充值记录
                                </button></li>
                </ul>
                <div class="tab-content" style="margin:20px 0;background: #ffffff">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">

                            <div class="col-md-6 col-sm-6 col-xs-12" style="text-align: right;">
                                <div style="text-align: center;">
                                    <img src="<?php echo ($userinfo["faceImg"]); ?>" style="width:60px;height:60px;" />
                                </div>
                                <div style="text-align: center;margin-top:10px;">
                                    <p><b>昵称:</b> <?php echo ($userinfo["name"]); ?> (<b>ID:</b> <?php echo ($userinfo["uid"]); ?>)</p>
                                </div>
                                <div style="text-align: center;margin-top:10px;">
                                    <p>
                                        <?php if($userinfo["isfollow"] == 1): ?><img src="/Public/images/follow.png"/>
                                        <?php else: ?>
                                            <img src="/Public/images/unfollow.jpg"/><?php endif; ?>    
                                            <span>书币:</span><?php echo ($userinfo["egold"]); ?>
                                        
                                    </p>
                                </div>
                                
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12" style="text-align: left;">
                                <div style="text-align: left;">
                                <ul style="list-style:none;">
                                    <li>
                                        <b>渠道账户名:</b> <?php echo ($channelInfo["fchannel"]); ?>
                                    </li>
                                    <p><br/></p>
                                    
                                </ul>

                                </div>
                                <div style="text-align: left;">
                                <ul style="list-style:none;">
                                    <li>
                                        <b>代理账户名:</b> <?php echo ($channelInfo["uname"]); ?>
                                    </li>
                                    <p><br/></p>
                                    
                                </ul>

                                </div>
                                <div style="text-align: left;">
                                    <ul style="list-style:none;">
                                        <li>
                                            <b>用户注册时间:</b> <?php echo (date("y-m-d H:i:s",$userinfo["regdate"])); ?>
                                        </li>
                                    </ul>
                                    
                                </div>
                                <div style="text-align: left;">
                                    <ul style="list-style:none;">
                                        <li>
                                            <b>总消费金币:</b>
                                            <?php if(empty($sumMoney["sumMoney"])): ?>0
                                            <?php else: ?>
                                            <?php echo ($sumMoney['sumMoney']); endif; ?>
                                        </li>
                                    </ul>
                                    
                                </div>
                                 <div style="text-align: left;">
                                    <ul style="list-style:none;">
                                        <li>
                                            <b>总充值金额:</b>
                                            <?php if(empty($sumPay["sumPay"])): ?>0
                                            <?php else: ?>
                                            <?php echo ($sumPay['sumPay']); endif; ?>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div><?php endif; ?>
<script type="text/javascript">
    // ajax 抓取页面 form 为表单id  page 为当前第几页

    /*
    * 消费记录
    * */
    function oneBuyLogList(url,title,w,h){
        var heading=$('#search-form2').offset();
        layer.open({
            type: 2,
            title: title,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            offset: [ //为了演示，随机坐标
            heading.top/2],
            content: url
        });
        
    }
     /*
    * 充值记录
    * */
    function onePayLogList(url,title,w,h){
        var heading=$('#search-form2').offset();
        layer.open({
            type: 2,
            title: title,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            offset: [ //为了演示，随机坐标
            heading.top/2],
            content: url
        });
        
    }
    /*function ajax_get_table(form,page)
    {
        uid = $("input[name=userid]").val();

        cur_page = page; //当前页面 保存为全局变量

        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=User&a=getUserPaySearch&id="+uid+"&p="+cur_page,
                data    : $('#' + form).serialize(),// 你的formid
                success : function(data)
                {
                    $("#ajax_return").html('');
                    $.each(data[0],function(i,n){
                        //alert(n.obookname);
                        
                    });
                    $("#ajax_return").append(n.obookname);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }*/

       // 点击分页触发的事件
    $(".pagination  a").click(function()
    {
        cur_page = $(this).data('p');
        $("input[name=page]").val(cur_page);
        ajax_get_table('form-order',cur_page);
    });
</script>
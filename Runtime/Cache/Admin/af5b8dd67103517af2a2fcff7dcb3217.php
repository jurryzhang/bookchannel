<?php if (!defined('THINK_PATH')) exit(); if($_COOKIE['permissions']== 0): ?><!DOCTYPE html>
<html>
  	<head>
	    <meta charset="UTF-8"/>
	    <link rel="shortcut icon" href="/Public/images/favicon.ico" />
	    <title>快阅云 | <?php echo ($web_name); ?></title>
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- Bootstrap 3.3.4 -->
	    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	    <!-- FontAwesome 4.3.0 -->
	 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	    <!-- Ionicons 2.0.0 --
	    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
	    <!-- Theme style -->
	    <link href="/Public/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
	    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />	    
	    <!-- iCheck -->
	    <!-- <link href="/Public/plugins/iCheck/flat/green.css" rel="stylesheet" type="text/css" />  -->
		<link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" /> 
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->   
	    <!-- jQuery 2.1.4 -->
	    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	    <script src="/Public/js/common.js"></script>
	    <!-- <script src="/Public/js/upgrade.js"></script> --><!-- 升级文件的js，burn修改，不添加升级接口，2016-08-09， -->
		<script src="/Public/js/layer/layer.js"></script><!--弹窗js 参考文档 http://layer.layui.com/--> 
		<script src="/Public/js/jquery-table-color.js"></script>
		
		<script src="/Public/js/clipboard.min.js"></script>
		<style type="text/css">
	    	#riframe{min-height:inherit !important}
			
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
  	
	<!--<body class="skin-green-light sidebar-mini"   style="<?php if($ischannel) echo 'overflow:hidden;';?> margin:0 auto;display:block">-->

	
		<body class="skin-blue  sidebar-mini"   style="margin:0 auto;display:block">
		
			<div class="wrapper">
  			<header class="main-header">
      		    <!-- Logo -->
				<?php if($_COOKIE['permissions']== 0): ?><a href="<?php echo U('Index/index');?>" class="logo" style="background-color: #222d32;color: #fff;">
        			<!-- mini logo for sidebar mini 50x50 pixels -->
        			<span class="logo-mini">
        				<i class="glyphicon glyphicon-home"></i>
        			</span>
        			<!-- logo for regular state and mobile devices -->
        			<!-- <img src="/Public/images/newLogo.png" width="150" height="60"> -->首页
      			</a>
				<?php else: ?>
					<a href="/" class="logo" style="background-color: #222d32;color: #fff;">
						<!-- mini logo for sidebar mini 50x50 pixels -->
						<span class="logo-mini">
        				<i class="glyphicon glyphicon-home"></i>
        			</span>
						<!-- logo for regular state and mobile devices -->
						<!-- <img src="/Public/images/newLogo.png" width="150" height="60"> -->首页
					</a><?php endif; ?>

      			<!-- Header Navbar: style can be found in header.less -->
      			<nav class="navbar navbar-static-top" role="navigation" style="background-color: #222d32;color: #fff;">
        		

						<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
							<span class="sr-only">Toggle navigation</span>
						</a>
					
	        		<div class="navbar-custom-menu">
	          			<ul class="nav navbar-nav">
	          				

	           				<li>
								<?php if($_COOKIE['permissions']== 0): ?><!-- <a href="<?php echo U('Channel/index');?>" target="_blank">
									<i class="glyphicon glyphicon-home"></i>
									<span>网站前台</span>
								</a> -->
								<?php else: ?>
									<a href="<?php echo ($web_domain_url); ?>" target="_blank">
										<i class="glyphicon glyphicon-home"></i>
										<span>网站前台</span>
									</a><?php endif; ?>
	           				</li>

							

							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" id="user_nameZ" data-toggle="dropdown">
									<!--  <img src="/Public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
									<i class="glyphicon glyphicon-user"></i>
									<?php if($_COOKIE['permissions']== 1): ?><span class="hidden-xs">欢迎：<?php echo ($admin_info["name"]); ?></span>
										<?php else: ?>
										<span class="hidden-xs">欢迎：<?php echo (cookie('uname')); ?></span><?php endif; ?>
								</a>
								<ul class="dropdown-menu" id="user_optionZ" style="display:none;width: 192px">
									<li class="user-footer" >
										<div class="pull-right">
											<?php if($_COOKIE['permissions']== 1): ?><a href="javascript:void(0)" data-url="<?php echo U('Index/map');?>" class="btn btn-default btn-flat model-map">网站地图</a><?php endif; ?>
											<a href="<?php echo U('Admin/logout');?>" class="btn btn-default btn-flat">安全退出</a>
										</div>
									</li>
								</ul>
							</li>

								<!-- Control Sidebar Toggle Button -->
							<!-- <?php if($_COOKIE['permissions']== 1): ?><li>
									<a href="#" data-toggle="control-sidebar">
										<i class="fa fa-street-view"></i>换肤
									</a>
								</li><?php endif; ?> -->

	          			</ul>
	        		</div>
	     		</nav>
				
	     		<script>
	     			$(function()
					{
	     				/*$('#user_name').mouseover(function()
						{
                        $('#user_option').show();
						});
                        $('#user_name').mouseout(function()
                        {
                            $('#user_option').hide();
                        });*/
                        $('#user_option').mouseover(function()
                        {
                            $('#user_option').show();
                        });
                        $('#user_option').mouseout(function()
                        {
                            $('#user_option').hide();
                        });
						/************************start**************************/
                        $('#user_nameZ').mouseover(function()
                        {
                            $('#user_optionZ').show();
                        });
                        $('#user_nameZ').mouseout(function()
                        {
                            $('#user_optionZ').hide();
                        });
                        $('#user_optionZ').mouseover(function()
                        {
                            $('#user_optionZ').show();
                        });
                        $('#user_optionZ').mouseout(function()
                        {
                            $('#user_optionZ').hide();
                        });
                        /*************************end************************/



                        $('#wx_name').mouseover(function()
                        {
                            $('#wx_option').show();
                        });

                        $('#wx_name').mouseout(function()
                        {
                            $('#wx_option').hide();
                        });

                        $('#wx_option').mouseover(function()
                        {
                            $('#wx_option').show();
                        });

                        $('#wx_option').mouseout(function()
                        {
                            $('#wx_option').hide();
                        });

						
						 $('#pt_name').mouseover(function()
                        {
                            $('#pt_option').show();
                        });

                        $('#pt_name').mouseout(function()
                        {
                            $('#pt_option').hide();
                        });

                        $('#pt_option').mouseover(function()
                        {
                            $('#pt_option').show();
                        });

                        $('#pt_option').mouseout(function()
                        {
                            $('#pt_option').hide();
                        });
                        $('#money_name').mouseover(function()
                        {
                            $('#money_option').show();
                        });

                        $('#money_name').mouseout(function()
                        {
                            $('#money_option').hide();
                        });

                        $('#money_option').mouseover(function()
                        {
                            $('#money_option').show();
                        });

                        $('#money_option').mouseout(function()
                        {
                            $('#money_option').hide();
                        });
						
						
						//特殊链接菜单
                        $('#url_name').mouseover(function()
                        {
                            $('#url_option').show();
                        });

                        $('#url_name').mouseout(function()
                        {
                            $('#url_option').hide();
                        });

                        $('#url_option').mouseover(function()
                        {
                            $('#url_option').show();
                        });

                        $('#url_option').mouseout(function()
                        {
                            $('#url_option').hide();
                        });

						
                        /*********广告业务**********/

                        $('#ad_name').mouseover(function()
                        {
                            $('#ad_option').show();
                        });

                        $('#ad_name').mouseout(function()
                        {
                            $('#ad_option').hide();
                        });

                        $('#ad_option').mouseover(function()
                        {
                            $('#ad_option').show();
                        });

                        $('#ad_option').mouseout(function()
                        {
                            $('#ad_option').hide();
                        });





	     			})

					function clean()
					{
						var url = "<?php echo U('Index/clean');?>";

                        $.ajax(
						{
							type    : "GET",
							url     : url,
							success : function(data)
							{
								alert(data);
							},
							error   : function(data)
							{
								alert('error -- data = ' + data.responseText);
							}
						});
                    }
	     		</script>
	  		</header><?php endif; ?>


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

    <style>#search-form > .form-group{margin-left: 10px;}</style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回">
                    <i class="fa fa-reply">
                    </i>
                </a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        打赏记录
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="navbar navbar-default">
                        <form action="" id="search-form2" class="navbar-form form-inline" method="post">
                            <div class="form-group">
                                <label class="control-label" for="input-order-id">关键词</label>
                                <div class="input-group">
                                    <input type="text" name="key_word" value="<?php echo ($keywords); ?>" placeholder="用户名/小说名" id="input-order-id" class="form-control">
                                </div>
                            </div>

                            <button type="submit" id="button-filter search-order" class="btn btn-primary">
                                <i class="fa fa-search"></i> 筛选
                            </button>
                        </form>
                    </div>
                    <?php if(empty($giftsList)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-center">
                                            用户名
                                        </td>

                                        <td class="text-center">
                                            小说名
                                        </td>

                                        <td class="text-center">
                                            动作名称
                                        </td>

                                        <td class="text-center">
                                            数量
                                        </td>

                                        <td class="text-center">
                                            书币
                                        </td>

                                        <td class="text-center">
                                            作者回复
                                        </td>

                                        <td class="text-center">
                                            动作时间
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($giftsList)): $i = 0; $__LIST__ = $giftsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="">
                                            <td class="text-center" style="padding: 1% 0px;">
                                                <?php echo ($list["username"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["articlename"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["giftsname"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["amount"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["needegold"]); ?>
                                            </td>

                                            <td class="replyBtn" data-id="<?php echo ($list['giftsid']); ?>" data-name="<?php echo ($list['username']); ?>" style="text-align:center;border-left: none;cursor: pointer;">
                                                <?php if($list['reply'] == ''): ?><i class="fa fa-comment-o"></i>
                                                    <?php else: ?>
                                                    <i class="fa fa-comment"></i><?php endif; ?>
                                                <input type="hidden" value="<?php echo ($list["reply"]); ?>" data-name="<?php echo ($list["username"]); ?>" id="reply<?php echo ($list['giftsid']); ?>"/>
                                            </td>

                                            <td class="text-center">
                                                <?php echo date('Y-m-d H:i:s',$list['givetime']);?>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-3 text-left"></div>
                            <div class="col-sm-9 text-right"><?php echo ($page); ?></div>
                        </div><?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div id="replyBox" style="cursor: move;width: 450px;height:330px;display: none;position: fixed;bottom: 40%;left: 30%;z-index:100;background: rgba(0,0,0,0.6);color: #FFFFff;padding: 10px;">
    <div id="replyHeader" style="margin-bottom: 15px;"></div>
    <textarea rows="10" cols="58%" id="content" style="background: rgba(0,0,0,0.6);"></textarea>
    <div style="text-align: center">
        <button class="btn btn-primary" title="" id="submitBtn" data-toggle="tooltip" data-original-title="保存">
            保存
        </button>
        &nbsp;&nbsp;&nbsp;
        <a href="javascript:void(0)" id="back" data-toggle="tooltip" title=""
           class="btn btn-default" data-original-title="返回"> 取消
        </a>
        &nbsp;&nbsp;&nbsp;
        <a href="javascript:void(0)" id="clear" data-toggle="tooltip" title=""
           class="btn btn-default" data-original-title="清空"> 清空
        </a>
    </div>

</div>
<script>
    /*回复按钮*/
    var giftsid='';
    $('.replyBtn').click(function(even){
        even.preventDefault();
        //弹出窗口居中
        var alt_T=$(window).height()/2-$('#replyBox').height()/2;
        var alt_L=$(window).width()/2-$('#replyBox').width()/2;
        $('#replyBox').fadeIn();
        $('#replyBox').css({top:alt_T,left:alt_L});

        $('#replyBox textarea').html('');
        $('#replyBox').css('display','block');
        giftsid=$(this).attr('data-id');
        var content=$("#reply"+giftsid).val();
        $('#replyBox textarea').html(content);

        var username=$("#reply"+giftsid).attr('data-name');
        $('#replyHeader').html('回复 '+username);
        $('#submitBtn').click(function(){
            content=$("#content").val();
            $.ajax({
                type    : 'POST',
                url     : '/index.php?m=Admin&c=Doc&a=giftsReply',
                data    : {giftsid:giftsid,content:content},
                success : function(data){
                    if(data.status==1){
                        $('#replyBox').css('display','none');
                        layer.msg(data.message,{icon:6});
                        location.reload();
                    }else{
                        layer.msg(data.message,{icon:5});
                    }
                }
            });
        });
    });
    /*回复框取消*/
    $('#back').click(function(){
        $('#replyBox').css('display','none');
    });
    /*清空回复框内容*/
    $('#clear').click(function(){
        $('#replyBox textarea').html('');
    });
    /*鼠标按下弹框窗口并移动，离开弹框停留*/
    var isMove=false;
    $('#replyHeader').mousedown(function(e_down){
        e_down.preventDefault();
        var abs_x=e_down.pageX-$('#replyBox').offset().left;
        var abs_y=e_down.pageY-$('#replyBox').offset().top;
        isMove=true;
        /*获取鼠标移动后，窗口距当前视口的左、上距离*/
        $(document).mousemove(function(e_move){
            e_move.preventDefault();
            if(isMove){
                //鼠标拖拽坐标
                var left_E=e_move.pageX-abs_x;
                var top_E=e_move.pageY-abs_y-$(window).scrollTop();//移动后的鼠标纵坐标减去滚轴的高度是鼠标在一屏的坐标
                //弹框窗最大left top
                var maxLeft=$(window).width()-$('#replyBox').width();
                var maxTop=$(window).height()-$('#replyBox').height();
                if(left_E<0){
                    left_E=0;
                }
                if(left_E>maxLeft){
                    left_E=maxLeft;
                }
                if(top_E<0){
                    top_E=0;
                }
                if(top_E>maxTop){
                    top_E=maxTop;
                }
                $('#replyBox').css({top:top_E,left:left_E});
            }
        });
    }).mouseup(function(){
        isMove=false;
    });
</script>
</body>
</html>
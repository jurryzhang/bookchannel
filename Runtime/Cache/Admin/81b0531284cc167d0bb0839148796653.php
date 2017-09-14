<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
<!--公共js 代码 --><script src="/Public/js/common.js" charset="utf-8"        type="text/javascript"></script><!--公共js end代码 --><link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" /><script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script><script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script><div class="wrapper">    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
		<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li>
	        		<!-- burn修改，2016-07-26 -->
	        		<a href="<?php echo ($v); ?>">
	        			<i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?>
	        		</a>
	        	</li>
	    	<?php else: ?>    
	        	<li>
	        		<!-- burn修改，2016-07-26 -->
	        		<a href="<?php echo ($v); ?>"><?php echo ($k); ?></a>
	        		<!-- <?php echo ($k); ?> -->
	        	</li><?php endif; endforeach; endif; ?>          
	</ol>
</div>
    <section class="content">        <!-- Main content -->        <div class="container-fluid">            <div class="pull-right">                <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                   class="btn btn-default" data-original-title="返回"> <i                        class="fa fa-reply"> </i>                </a>            </div>            <div class="panel panel-default">                <div class="panel-heading">                    <h3 class="panel-title">                        <i class="fa fa-list"> </i>                        编辑主渠道                    </h3>                </div>                <div class="panel-body">                    <!--表单数据-->                    <form method="post" id="addSChannel">                        <!--通用信息-->                        <div class="tab-content">                            <div class="tab-pane active" id="tab_tongyong">                                <table class="table table-bordered">                                    <tbody>                                    <tr>                                        <td class="text-center">                                            账户名(登录用):                                        </td>                                        <td>                                            <?php if($channel["uname"] == ''): ?><input type="text" value="" name="uname" id='uname' placeholder="请填写用户名" class="form-control" style="width: 350px; display: inline-block" />                                                <span id="err_uname" style="color: #F00;">                                                </span>                                                <?php else: ?>                                                <?php echo ($channel["uname"]); endif; ?>                                        </td>                                    </tr>                                    <tr>                                        <td class="text-center">                                            登录密码:                                        </td>                                        <td>                                            <?php if($channel["uname"] == ''): ?><input type="text" value="" name="pass" id='pass' placeholder="请填写密码,不填默认为111111" class="form-control" style="width: 350px; display: inline-block" />                                                <?php else: ?>                                                <input type="text" value="" name="pass" id='pass' placeholder="不填代表不修改密码" class="form-control" style="width: 350px; display: inline-block" /><?php endif; ?>                                        </td>                                        </td>                                    </tr>                                    <tr>                                        <td class="text-center">                                            渠道名称:                                        </td>                                        <td>                                                                                   <input type="text" value=" <?php echo ($channel["channelname"]); ?>" name="channelname" id='channelname' placeholder="填写渠道名称" class="form-control" style="width: 350px; display: inline-block" />                                            <span id="err_channelname" style="color: #F00;">                                                </span>                                                                                    </td>                                    </tr>                                        <tr>                                            <td class="text-center">                                                分成比例：                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($channel["proportion"]); ?>" placeholder="填0-1之间的小数如:0.3" name="proportion"  id='proportion' class="input-sm" />                                                <span id="err_proportion"                                                      style="color: #F00; "> 该比例为渠道提供商所占比例，为小数，如：0.3，即该渠道供应商占收益的30%；                                                </span>                                            </td>                                        </tr>                                    <tr>                                        <td class="text-center">                                            引导关注章节数:                                            <p style="font-size:12px;color:red">(填几就是第几章要关注公众号)</p>                                        </td>                                        <td>                                            <input type="text" value="<?php echo ($channel["readchaptercount"]); ?>" name="readchaptercount" onblur="if(this.value==''){this.value=10}" id='readchaptercount' class="input-sm" placeholder="10"/>                                            <span style="color: #F00;">                                                    不填默认为10                                                </span>                                        </td>                                    </tr>                                    <tbody />                                </table>                            </div>                        </div>                        <input type="hidden" name="channelid" value="<?php echo ($channel["channelid"]); ?>">                        <input type="hidden" name="uid" value="<?php echo ($channel["uid"]); ?>">                        <input type="hidden" name="action" value="<?php echo ($action); ?>">                        <div class="pull-right">                            <button class="btn btn-primary" onclick="saveAction()" title="" data-toggle="tooltip" type="button" data-original-title="保存">                                保存                            </button>                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                               class="btn btn-default" data-original-title="返回"> 取消                            </a>                        </div>                    </form>                    <!--表单数据-->                </div>            </div>        </div>    </section></div><script>    function isPirce(s){        s = $.trim(s);//        var p =/^[1-9](\d+(\.\d{1,2})?)?$/;        var p1=/^[0-9](\.\d{1,2})?$/;        return p1.test(s);    }    function saveAction() {        var channelName      = $('#channelname').val();        var uname      = $('#uname').val();        var proportion      = $('#proportion').val();        $('#err_goods_name').text('');        if (channelName=='') {            if (check_text_isNULL(channelName)) {                $('#err_channelname').text('渠道名称不能为空!');            }        } else  {            if (check_text_isNULL(uname)) {                $('#err_uname').text('用户名不能为空!');            }else {                if(!isPirce(proportion)){                    $('#err_proportion').text('');                    $('#err_proportion').text('分成比例:请输入0-1之间的小数');                }else {                    var proportionNum = parseFloat(proportion);                    if (proportionNum>1||proportionNum<0) {                        $('#err_proportion').text('');                        $('#err_proportion').text('分成比例:请输入0-1之间的小数');                    }else{                        $('#addSChannel').submit();                    }                }            }        }    }</script></body></html>
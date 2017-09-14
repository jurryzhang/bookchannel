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

<!--公共js 代码 -->
<script src="/Public/js/common.js" charset="utf-8"
        type="text/javascript"></script>
<!--公共js end代码 -->
<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
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

    <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                   class="btn btn-default" data-original-title="返回"> <i
                        class="fa fa-reply"> </i>
                </a>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"> </i>
                        添加公告
                    </h3>
                </div>

                <div class="panel-body">
                    <!--表单数据-->
                    <form method="post" id="addAffiche" action="">
                        <!--通用信息-->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_tongyong">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                            公告标题
                                        </td>

                                        <td>
                                            <input type="text" value="<?php echo ($affInfo['title']); ?>" name="title" id='title' class="form-control" style="width: 700px; display: inline-block" />
                                            <span id="err_title" style="color: #F00; display: inline-block;"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            公告内容:
                                        </td>
                                        <td>
                                            <textarea id="editor_id" rows="30" cols="160" name="content">
                                                <?php echo ($affInfo['content']); ?>
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tbody />
                                </table>
                            </div>
                        </div>

                        <div class="pull-right">
                            <button class="btn btn-primary" title="" data-toggle="tooltip" type="submit" data-original-title="保存">
                                保存
                            </button>
                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""
                               class="btn btn-default" data-original-title="返回"> 取消
                            </a>
                        </div>
                    </form>
                    <!--表单数据-->
                </div>
            </div>
        </div>
    </section>
</div>
<script charset="utf-8" src="/Public/plugins/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/Public/plugins/kindeditor/lang/zh-CN.js"></script>
<script>
    //编辑器
    KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id');
    });

    function isPirce(s){
        s = $.trim(s);
//        var p =/^[1-9](\d+(\.\d{1,2})?)?$/;
        var p1=/^[0-9](\.\d{1,2})?$/;
        return p1.test(s);
    }

    function saveAction() {
        var channelName      = $('#title').val();
        var proportion       = $('#channel_proportion').val();
        var readchaptercount = $('#channel_readchaptercount').val();

        $('#err_title').text('');
        if (channelName==''||proportion=='') {
            if (check_text_isNULL(channelName)) {
                $('#err_title').text('不能为空!');
            }
        } else {
            ajax_submit_form('addEditChannelForm','<?php echo U("Channel/addEditChannel?is_ajax=1");?>');
        }
    }
</script>
</body>
</html>
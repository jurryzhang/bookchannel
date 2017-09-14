<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
<div class="wrapper">    <link type="text/css" rel="stylesheet" href="/Public/js/jedate/skin/jedate.css">    <script type="text/javascript" src="/Public/js/jedate/jquery.jedate.js"></script>    <div class="breadcrumbs" id="breadcrumbs">
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
    <style>#search-form > .form-group{margin-left: 10px;}</style>    <!-- Main content -->    <section class="content ">        <div class="container-fluid " >            <div class="pull-right" >                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回">                    <i class="fa fa-reply">                    </i>                </a>            </div>            <div class="panel panel-default">                <div class="panel-heading">                    <h3 class="panel-title">                        <i class="fa fa-list"></i>                        添加模版消息                    </h3>                </div>                <div class="panel-body">                    <div class="navbar navbar-default " >                        <form method="post" action="/index.php?s=/Channel/tplAdd.html" id="addtpl" >                            <!--通用信息-->                            <div class="tab-content" >                                <div class="tab-pane active" id="tab_tongyong" style="width: 85%; margin-left: 15%">                                    <div class="form-group" style="margin: 25px 10px 10px 25px;">                                        <label class="col-sm-2 control-label " style="text-align: right">任务名称:</label>                                        <input type="text"  name="title"  class="form-control" style="width: 350px; display: inline-block" />                                    </div>                                    <div class="form-group" style="margin: 25px 10px 10px 25px;">                                        <label class="col-sm-2 control-label " style="text-align: right">选择模板:</label>                                        <select id="template_id" name="template_id" class="form-control" style="width: 350px; display: inline-block;">                                            <option value="">请选择模版</option>                                        </select>                                        <span id="tplinfo" style="color:#009933;font-size: 13px; font-weight: bold"></span>                                    </div>                                    <div id="tpl-control" style="display:none;margin-bottom: 20px;">                                        <div class="form-group"  style="margin: 25px 10px 10px 25px;">                                            <label class="col-sm-2 control-label " style="text-align: right">模版使用样例:</label>                                            <div class="col-sm-10"   style="margin-bottom:10px;font-size: 10px;font-weight: bold; " >                                                <div id="exmple" style="width: 600px;background: #ffffff;border: 3px solid #990033;padding: 15px"></div>												<br/>												<p style="color:#990033">提醒:模板中使用 {wxname} 可以被替换成用户的昵称!</p>												                                            </div>                                            <br/>                                            <br/>                                            <br/>                                        </div>                                        <div class="form-group" style="margin: 25px 10px 10px 25px;">                                            <label class="col-sm-2 control-label " style="text-align: right">模版参数填写:</label>                                            <div class="col-sm-10"  style="margin-bottom:10px">                                                <div  id="tpl" style="width: 600px;background: #ffffff;border: 5px solid #009933;padding: 15px" >                                                </div>                                            </div>                                        </div>                                    </div>                                    <div class="form-group" style="margin: 25px 10px 10px 25px;">                                        <label class="col-sm-2 control-label " style="text-align: right">点击跳转链接:</label>                                        <input type="text"  name="url"  class="form-control" style="width: 350px; display: inline-block" />                                    </div>                                    <div class="form-group" style="margin: 25px 10px 10px 25px;">                                        <label class="col-sm-2 control-label " style="text-align: right">预约发送时间:</label>                                        <input type="text"  id="date01" name="sendtime"  class="form-control" style="width: 350px; display: inline-block" />                                    </div>                                    <div class="form-group" style="margin: 25px 10px 10px 25px;">                                        <label class="col-sm-2 control-label " style="text-align: right">测试用户ID:</label>                                        <input type="text"  name="uid"  class="form-control" style="width: 350px; display: inline-block" />                                        <button type="button"   style="margin-left: 30px;" class="btn btn-success" onclick="testsend()" type="button">                                            测试发送                                        </button>                                    </div>                                    <input type="hidden" name="channelid" value="<?php echo (cookie('channelid')); ?>">                                    <input type="hidden" id="action" name="action" value="add">                                    <input type="hidden" id="tpltitle" name="tpltitle" value="">                                </div>                            </div>                            <div class="text-center" style="margin-bottom: 15px ;">                                <button type="submit" class="btn btn-primary" onclick="dosubmit('add')" type="button">                                    保存                                </button>                                <button type="submit" class="btn btn-danger" onclick="dosubmit('send')" type="button">                                    发送                                </button>                                <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                                   class="btn btn-default" data-original-title="返回"> 取消                                </a>                                <!--                                <button type="submit" style="margin-left: 30px;" class="btn btn-success" onclick="dosubmit('send')" type="button">                                    保存并发送                                </button>-->                            </div>                        </form>                        <div class="row">                            <div class="col-sm-3 text-left"></div>                            <div class="col-sm-9 text-right"><?php echo ($page); ?></div>                        </div>                    </empty>                </div>            </div>        </div>    </section>    <!-- /.content --></div><!-- /.content-wrapper --><script>    var tpl='';    //页面一加载就执行的动作    $(function () {        getTpl()    });    //从微信后台获取公众号模版信息    function getTpl() {        $('#tplinfo').html('<img style="width: 20px;" src="/Public/images/load.gif">模版加载中...');        $.ajax({            type: "get",            url: "/index.php?s=/Channel/getTplList/id/<?php echo (cookie('channelid')); ?>",            data: "",            success: function(msg){                //保存模版                eval('tpl='+msg);                //停止加载状态                if(tpl!=''){                    $('#tplinfo').html('<i class=" fa  fa-check"></i> 模版加载成功!')                }else {                    $('#tplinfo').html(' <button type="submit" class="btn btn-primary" onclick="getTpl()" type="button"><i class=" fa  fa-refresh"></i> 刷新</button><strong style="color:red "><i class=" fa  fa-close"></i> 您还没有模板，请先到公众号后台申请。</strong>')                }                //添加模版选项                $.each(tpl,function (k,v) {                    $('#template_id').append('<option value="'+v.template_id+'">'+v.title+'</option>');                });            },          error:function () {              $('#tplinfo').html('<strong style="color:red ">网络连接错误!</strong>')          }        });    }    //切换模版    $('#template_id').change(function () {        var tplid=$('#template_id option:selected').val();        //显示模版模块        if(tplid==''){            $("#tpl-control").css('display','none');        }else        {            $("#tpl-control").css('display','block');        }        $.each(tpl,function (k,v) {            if(v.template_id==tplid){                //处理返回的json模版信息                $('#tpltitle').val(v.title);                var tplstr =v.content.replace(/\n/g, '<br>');                tplstr = tplstr.replace(/\{{([A-Za-z0-9_]+).DATA}\}/ig, function() {                    return '<input  type="hidden" name="' + arguments[1] + '[0]" value="' + arguments[1] + '"><input type="text" name="' + arguments[1] + '[1]" id="' + arguments[1] + '"  style="width: 210px;margin: 10px 0px; color: #0000ff" >&nbsp;&nbsp;&nbsp;&nbsp;<select name="' + arguments[1] + '[2]" onchange="setcolor(this,\'' + arguments[1] + '\')"><option value="#0000ff">蓝</option><option value="#000000">黑</option><option value="#ff0000">红</option><option value="#ff1493">粉</option><option value="#9370db">紫</option></select>';                });                $('#tpl').html(tplstr);                //显示样例               var  expstr =v.example.replace(/\n/g, '<br>');                $('#exmple').html(expstr);            }        });    });    //设置模版值的颜色    function setcolor(e,key) {        var color=$(e).children('option:selected').val();        $('#'+key).css('color',color);    }    //设置提交动作    function dosubmit(action){        $('#action').val(action);        $('#addtpl').submit();    }    //测试发送    function testsend() {        $('#action').val('test');        $.ajax({            type: "post",            url: "/index.php?s=/Channel/testsend.html",            data:$('#addtpl').serialize(),            success: function (msg) {                layer.alert(msg);            }        });    }</script><script>    $("#date01").jeDate({        isinitVal:true,        festival:true,        ishmsVal:false,        minDate: $.nowDate(0),        maxDate: '2099-06-16 23:59:59',        format:"YYYY-MM-DD hh:mm:ss",        zIndex:3000,    })</script></body></html>
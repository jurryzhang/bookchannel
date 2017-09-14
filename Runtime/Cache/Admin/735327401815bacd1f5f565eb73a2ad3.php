<?php if (!defined('THINK_PATH')) exit();?>

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
                
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        小说列表
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="navbar navbar-default">
                        <form action="/index.php?s=/Doc/bookList/" id="search-form2" class="navbar-form form-inline" method="post" >

                                <!-- <div class="form-group" style="margin-left: 10px;">
                                    <select id="channel" name="channel" class="form-control" style="width: 100px; display: inline-block;">
                                        <option value=""  <?php if(($channel == '全部')): ?>selected="selected"<?php endif; ?> >全部</option>
                                        <option value="通用" <?php if(($channel == '通用')): ?>selected="selected"<?php endif; ?> >通用</option>
                                        <option value="男频" <?php if(($channel == '男频')): ?>selected="selected"<?php endif; ?> >男频</option>
                                        <option value="女频" <?php if(($channel == '女频')): ?>selected="selected"<?php endif; ?> >女频</option>
                                    </select>
                                </div> -->
                                    <input type="hidden" id="channel" name="channel" value="">
                                    <div class="btn-group " role="group" id="orderBtnGroup">
                                        <button value="全部" type="submit" class="btn btn-default <?php if(($channel == "全部")): ?>btn-primary active<?php endif; ?>" >全部</button>
                                        <!-- <button value="通用" type="submit"  class="btn btn-default <?php if(($channel == "通用")): ?>btn-primary active<?php endif; ?>"  >通用</button> -->
                                        <button value="男频" type="submit" class="btn btn-default <?php if(($channel == "男频")): ?>btn-primary active<?php endif; ?>"  >男频</button>
                                        <button value="女频" type="submit" class="btn btn-default <?php if(($channel == "女频")): ?>btn-primary active<?php endif; ?>"  >女频</button>
                                    </div>
                                
                                <!-- <button type="submit" onclick="this.form.submit()" id="button-filter search-order" class="btn btn-primary">
                                    <i class="fa fa-filter"></i> 筛选
                                </button> -->


                            <!-- <div class="form-group" style="margin-left: 40px;">
                                <label class="control-label" for="input-order-id">章节数:</label>
                                <div class="input-group">
                                    <input  style="width: 65px;" size="2" maxlength="2" min="1" max="20" type="number" name="number" id="number" value="5" placeholder="章节数"  class="form-control">
                                </div>
                            </div> -->


                            <!--章节选择-->

                           <!-- <div class="form-group" style="margin-left: 40px;">
                                <label class="control-label" for="input-order-id">选择渠道:</label>
                                <select id="pt" name="pt" class="form-control" style="width: 150px; display: inline-block;">
								<option value="">--请选择渠道--</option>
                                    <?php if(is_array($pt)): $i = 0; $__LIST__ = $pt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["ptid"]); ?>" ><?php echo ($list["ptname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                                </select>
                            </div> -->


                            <div style="text-align: right;float: right; display: inline-table;margin-right: 20px;">
                            <div class="form-group ">
                                <div class="input-group">
                                    <input type="text" name="keyword" value="" placeholder="小说名称" id="input-order-id" class="form-control">
                                </div>
                            </div>
                            <button type="submit" onclick="this.form.submit()" id="button-filter search-order" class="btn btn-primary">
                                <i class="fa fa-search"></i> 搜索
                            </button>
                            </div> 


                        </form>
                    </div>
                    <?php if(empty($data)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
											   书号ID
											</td><?php endif; ?>

                                        <td class="text-center">
                                            封面
                                        </td>

                                        <td class="text-left">
                                            小说名称
                                        </td>
										
										<!-- <td class="text-center">
                                            付费人数
                                        </td> -->

                                        <td class="text-center">
                                            字数
                                        </td>

                                       <!-- <td class="text-center">
                                            状态
                                        </td>-->

                                        <td class="text-center">
                                            分类
                                        </td>

                                        <td class="text-center">
                                            频道
                                        </td>
										
										 <td class="text-center">
                                            派单指数
                                        </td>
										
                                        <!-- <td class="text-center">
                                            操作
                                        </td> -->
                                       

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="">
											<?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
													<?php echo ($list["articleid"]); ?>
												</td><?php endif; ?>

                                            <td class="text-center">
                                                <a href="<?php echo U('bookInfo',array('articleId'=>$list['articleid']));?>" target="_blank">
                                                <img width="50px" src="<?php echo ($list["cover"]); ?>">
                                                </a>
                                            </td>

                                            <td class="text-left">
                                                <a href="<?php echo U('bookInfo',array('articleId'=>$list['articleid']));?>" target="_blank" style="font-weight:100;">
                                                    <span style="font-size: 15px;" > <?php echo ($list["articlename"]); ?></span>
                                                </a>
                                                <?php if($list["fullflag"] != '完本'): ?><span>[<?php echo ($list["fullflag"]); ?>]</span>
                                                    <?php else: ?>
                                                    <span>[<?php echo ($list["fullflag"]); ?>]</span><?php endif; ?>
                                                <div style="font-size: 12px;color: #777;margin-top: 7px"><?php echo ($list["recommend"]); ?></div>
                                            </td>

											<!-- <td class="text-center" style="color:#C00;">
                                                <?php echo ($list["allvisit"]); ?>
                                            </td> -->
											
                                            <td class="text-center">
                                                <strong> <?php echo (round($list['size']/2/10000,1)); ?>万</strong>
                                            </td>


                                            <!--<td class="text-center">
                                                <?php if($list["fullflag"] != '完本'): ?><span class="badge bg-red"><?php echo ($list["fullflag"]); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge bg-green"><?php echo ($list["fullflag"]); ?></span><?php endif; ?>
                                            </td>-->

                                            <td class="text-center">
                                                <?php if($list["channel"] == '女频'): ?><span class="label label-warning"><?php echo ($list["category"]); ?></span>
                                                    <?php else: ?>
                                                    <span class="label label-success"><?php echo ($list["category"]); ?></span><?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($list["channel"] == '女频'): ?><span class="badge bg-red"><?php echo ($list["channel"]); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge bg-green"><?php echo ($list["channel"]); ?></span><?php endif; ?>
                                            </td>
											
											<td class="text-center">
                                                <?php echo ($list["orderby"]); ?>
                                            </td>


                                            <!-- <td class="text-center">
                                                <a href="javascript:void(0)"  onclick="mkDoc(<?php echo ($list["articleid"]); ?>)"  id="mkdoc" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="生成文案">
                                                    <span>生成文案</span>
                                                </a>
                                            </td> -->

                                            
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
 <script>
$('#number').change(
    function () {
        var num=$(this).val();
        if(isNaN(num)){
            $(this).val(5);
        }
        if(num<1){
            $(this).val(1);
        }else if(num>20){
            $(this).val(20);
        }

    }
)

function mkDoc(id) {
    var num=$('#number').val();
    var ptid=$('#pt option:selected').val();
    if(ptid==''){
        layer.confirm('还未选择渠道，确认要生成文案？',{
            btn:['确定' ,'取消']},
            function(){
                window.open("/index.php?s=/Doc/mkDoc/id/"+id+"/num/"+num+"/ptid/"+ptid);
            }
        );
    }else{
        window.open("/index.php?s=/Doc/mkDoc/id/"+id+"/num/"+num+"/ptid/"+ptid);
    }
}

//提交筛选
$("#orderBtnGroup button").click(function(){
     $("#channel").val($(this).val()) ; 

        $("#search-form2").submit();
        $("#orderBtnGroup").children().removeClass("btn-primary active");
        $(this).addClass('btn-primary active');
        /*url = "/index.php?s=/Doc/bookList";
        data = {'channel':channel};
        $.post(url,data);*/


});
    


</script>
</body>
</html>
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
                            <span style="color: #9e9e9e"></span>代理结算单
                        </h3>
                    </div>
                    <div class="navbar navbar-default">
                        <form action="" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">
                            
                             <!--edit by dai-->
                                <label class="control-label">选择日期</label>
                                <div class="form-group">
                                    <input type="text" id="datestart" value="<?php echo ($starttime); ?>" name="starttime" class="form-control"  style="width:150px"> ---
                                    <input type="text" id="dateend" value="<?php echo ($endtime); ?>" name="endtime" class="form-control" style="width:150px">
                                </div>
                                <label class="control-label">代理名称:</label>
                                <select class="form-control" name="dailiname" >
                                  <option value="">--请选择代理--</option>
                                  <?php if(is_array($channelArr)): $i = 0; $__LIST__ = $channelArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["channelid"]); ?>"><?php echo ($val["uname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <!-- <input type="text" id="" name="dailiname" value="" class="form-control"> -->

                                <button type="submit" onclick="ajax_get_table2('search-form2')" id="button-filter search-order" class="btn btn-primary">
                                    <i class="fa fa-search"></i> 筛选
                                </button>
                                
                                <div class="btn-group" role="group" id="orderBtnGroup" >
                                        <button value="昨天" type="submit" data-status="1" class="btn btn-default <?php if(($iswhen == 1)): ?>btn-primary active<?php endif; ?>" >昨天</button>
                                        <!-- <button value="通用" type="submit"  class="btn btn-default <?php if(($channel == "通用")): ?>btn-primary active<?php endif; ?>"  >通用</button> -->
                                        <button value="前天" type="submit" data-status="2" class="btn btn-default <?php if(($iswhen == 2)): ?>btn-primary active<?php endif; ?>"  >前天</button>
                                        <button value="近7天" type="submit" data-status="3" class="btn btn-default <?php if(($iswhen == 3)): ?>btn-primary active<?php endif; ?>"  >近7天</button>
                                        <button value="本月" type="submit" data-status="4" class="btn btn-default <?php if(($iswhen == 4)): ?>btn-primary active<?php endif; ?>"  >本月</button>
                                        <button value="上月" type="submit" data-status="5" class="btn btn-default <?php if(($iswhen == 5)): ?>btn-primary active<?php endif; ?>"  >上月</button>
                                    </div>
                                    <!-- <div class="btn-group " id="orderBtnGroup2" role="group">
                                        <button value="已结算" type="submit"  class="btn btn-default overpay btn-primary active">已结算</button>
                                        <button value="未结算" type="submit" class="btn btn-default overpay"  >未结算</button>
                                    </div>-->
                           <input type="hidden" id="iswhen" name="iswhen" value="">  
                           <input type="hidden" id="isoverpay" name="isoverpay" value="">  
                        </form>
                        <div class="panel panel-default center-block">
                            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <div class="info-box" style="height:136px">
                              <!-- Default panel contents -->
                                    <div class="panel-heading"><h2>充值金额: ￥<span id="sumaskmoney">
                                    <?php if(empty($data["sumaskmoney"])): ?>0
                                    <?php else: ?>
                                    <?php echo ($data["sumaskmoney"]); endif; ?>
                                    </span></h2></div>
                                    <div style="margin-left: 20px;">总笔数:<span id="paycount">
                                    <?php if(empty($data["paycount"])): ?>0
                                    <?php else: ?>  
                                    <?php echo ($data["paycount"]); endif; ?>
                                    </span></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top: 20px;">
                                <div class="info-box" style="height:136px">
                              <!-- Default panel contents -->
                                    <div class="panel-heading"><h2>结算总额: ￥<span id="sumpaymoney">
                                    <?php if(empty($data["sumpaymoney"])): ?>0
                                    <?php else: ?>
                                    <?php echo ($data["sumpaymoney"]); endif; ?>
                                    </span></h2></div>
                                    
                                </div>
                            </div>
                            <!-- <div class="col-md-4 col-sm-4 col-xs-8" style="margin-top: 20px;">
                                <div class="info-box" style="height:136px"> -->
                              <!-- Default panel contents -->
                                  <!--   <div class="panel-heading"><h2>利润: ￥<span id="profit"><?php echo ($data["profit"]); ?></span></h2></div>
                                    
                                </div>
                            </div> -->
                        </div>
                    </div>
                    
               
            </div>
               
            
                <div class="panel panel-default">
                    
                        <div id="ajax_return_channel"></div>
                    
                </div>
                    
        <!-- /.row -->
    </section>
        
          
          
    <!-- /.content -->
</div>

        
<!-- /.content-wrapper -->
<script src="/Public/js/laydate/laydate.js"></script>
<script>
   
   //时间选择器
laydate.render({
  elem: '#datestart'
  
});

laydate.render({
  elem: '#dateend'
  
});

$(document).ready(function()
    {
        // ajax 加载商品列表
         var page=1;
         //isoverpay = '已结算';
        //var cookiepage=getCookie('pg');
        /*if(cookiepage>1){
            page =cookiepage;
        }*/
        //$("#orderBtnGroup button:first").addClass("btn-primary active");
        //ajax_get_table2('search-form2');
        ajax_get_table('search-form2',page);
        //ajax_get_table('form-order',1);

        
    });
function ajax_get_table2(form)
    {

         //当前页面 保存为全局变量
        dd = $('#' + form).serialize();
        
        //alert($('#isoverpay').val())
        //alert(dd)
        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=Channel&a=getNextRemainMoney",
                data    : $('#' + form).serialize(),// 你的formid

                success : function(data)
                {
                    //alert(data);

                    $("#sumaskmoney").html('');
                    if(!(data.sumaskmoney)){
                        data.sumaskmoney=0;
                    }
                    $("#sumaskmoney").html(data.sumaskmoney);

                    $("#paycount").html('');
                    if(!(data.paycount)){
                        data.paycount=0;
                    }
                    $("#paycount").html(data.paycount);

                    $("#sumpaymoney").html('');

                    if(!(data.sumpaymoney)){
                        data.sumpaymoney=0;
                    }
                    $("#sumpaymoney").html(data.sumpaymoney);

                    $("#profit").html('');

                    if(!(data.profit)){
                        data.profit=0;
                    }
                    $("#profit").html(data.profit);

                    $("#sumpaymoney").html(data.sumpaymoney);

                    $("#profitrate").html('');

                    if(!(data.profitrate)){
                        data.profitrate=0+"%";
                    }
                    $("#profitrate").html(data.profitrate);

                    //$("#ajax_return_channel").append(data);
                    //var page =1;
                    //ajax_get_table('search-form2',page);

                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }
    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_table(form,page,ischannel)
    {
        //
        cur_page = page; //当前页面 保存为全局变量
        dd = $('#' + form).serialize();
        $('#isoverpay').val($('.overpay.btn-primary.active').val());
        
        //alert($('#isoverpay').val())
        //alert(dd)
        //ajax_get_table2('search-form2');
        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=Channel&a=ajaxGetNextRemainMoney&p="+page+"&issum=1",
                data    : $('#' + form).serialize(),// 你的formid

                success : function(datas)
                {
                    $("#orderBtnGroup").children().removeClass("btn-primary active");
                    $("#ajax_return_channel").html('');

                    $("#ajax_return_channel").append(datas);

                    ajax_get_table2('search-form2');


                },
                error   : function(datas)
                {
                    alert('error -- data = ' + datas.responseText);
                }
            });

    }

    

    function addDate(dd,dadd){
        var a = new Date(dd)
        a = a.valueOf()
        a = a + dadd * 24 * 60 * 60 * 1000
        a = new Date(a)
        return a;
    }

      


    //提交筛选
$("#orderBtnGroup button").click(function(){
     datetime = new Date();  
    //datetime.setTime(time());
    //var timestamp = Date.parse(new Date()); 
     syear = datetime.getFullYear();
     smonth = datetime.getMonth()+1;
     sday = datetime.getDate();

    //alert(smonth);
    
    //alert(datetime.getDate());
    
    datevalue = $(this).attr('data-status');
   //alert(datevalue);
    if(datevalue==1){
        preDate = addDate(syear+"-"+smonth+"-"+sday,-1);
        //alert(ssday);
        years = preDate.getFullYear();
        months = preDate.getMonth()+1;
        days = preDate.getDate();
        startime = years+"-"+months+"-"+days;
        $("#dateend").val(startime);
        $("#datestart").val(startime);
        $("#iswhen").val(1);
    }else if(datevalue==2){
        preDate = addDate(syear+"-"+smonth+"-"+sday,-2);
        //alert(ssday);
        years = preDate.getFullYear();
        months = preDate.getMonth()+1;
        days = preDate.getDate();
        startime = years+"-"+months+"-"+days;
        $("#datestart").val(startime);

        nextDate = addDate(syear+"-"+smonth+"-"+sday,-2);
        nyears = nextDate.getFullYear();
        nmonths = nextDate.getMonth()+1;
        ndays = nextDate.getDate();
        endtime = nyears+"-"+nmonths+"-"+ndays;
        $("#dateend").val(endtime);
        $("#iswhen").val(2);
    }else if(datevalue==3){
        preDate = addDate(syear+"-"+smonth+"-"+sday,-7);
        //alert(ssday);
        years = preDate.getFullYear();
        months = preDate.getMonth()+1;
        days = preDate.getDate();
        startime = years+"-"+months+"-"+days;
        $("#datestart").val(startime);

        nextDate = addDate(syear+"-"+smonth+"-"+sday,-1);
        nyears = nextDate.getFullYear();
        nmonths = nextDate.getMonth()+1;
        ndays = nextDate.getDate();
        endtime = nyears+"-"+nmonths+"-"+ndays;
        
        $("#dateend").val(endtime);
        $("#iswhen").val(3);
    }else if(datevalue==4){
        //preDate = addDate(syear+"-"+smonth+"-"+sday,-7);
        //alert(ssday);
        years = datetime.getFullYear();
        months = datetime.getMonth()+1;
        days = 1;
        startime = years+"-"+months+"-"+days;
        $("#datestart").val(startime);

        nextDate = addDate(syear+"-"+smonth+"-"+sday,-1);
        nyears = nextDate.getFullYear();
        nmonths = nextDate.getMonth()+1;
        ndays = nextDate.getDate();
        endtime = nyears+"-"+nmonths+"-"+ndays;
        
        $("#dateend").val(endtime);
        $("#iswhen").val(4);
    }else if(datevalue==5){
        years = datetime.getFullYear();
        months = datetime.getMonth();
        sdays = 1;
        startime = years+"-"+months+"-"+sdays;
        $("#datestart").val(startime);

        smonth = datetime.getMonth()+1;
        //sendtime = years+"-"+smonth+"-"+sdays;
        nextDate = addDate(years+"-"+smonth+"-"+sdays,-1);
        nyears = nextDate.getFullYear();
        nmonths = nextDate.getMonth()+1;
        ndays = nextDate.getDate();
        endtime = nyears+"-"+nmonths+"-"+ndays;
        $("#dateend").val(endtime);
        $("#iswhen").val(5);
    }
      

        
        $("#orderBtnGroup").children().removeClass("btn-primary active");
        $(this).addClass('btn-primary active');

        ajax_get_table2('search-form2');

        ajax_get_table('search-form2',1);
        /*url = "/index.php?s=/Channel/bookList";
        data = {'channel':channel};
        $.post(url,data);*/


});

</script>
</body>
</html>
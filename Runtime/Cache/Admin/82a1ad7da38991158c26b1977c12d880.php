<?php if (!defined('THINK_PATH')) exit();?>


<div class="wrapper">
    



    <style>#search-form > .form-group{margin-left: 10px;}</style>
    <!-- Main content -->
    <section class="content">
        
		
                
		
		<div class="container-fluid">
            
                <!-- <div class="pull-right">
                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回">
                        <i class="fa fa-reply">
                        </i>
                    </a>
                </div> -->
        
            <div class="panel panel-default">
                    <!-- <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-list"></i>
                            <span style="color: #9e9e9e"></span>代理结算单
                        </h3>
                    </div> -->
                
                    
                <div class="panel-body">
                    <div class="navbar navbar-default">
                        <form action="" id="search-form" class="navbar-form form-inline" method="post" onsubmit="return false">
                             <div class="btn-group " id="orderBtnGroup2" role="group">
                                <button value="未结算" type="submit" data-status="0" class="btn btn-default overpay <?php if(($isoverpay == 0)): ?>btn-primary active<?php endif; ?>"  >未结算</button>
                                <button value="已结算" type="submit" data-status="2"  class="btn btn-default overpay <?php if(($isoverpay == 2)): ?>btn-primary active<?php endif; ?>">已结算</button>
                                
                            </div>
                            <!-- <input type="hidden" id="isoverpay" name="isoverpay" value=""> --> 
                        </form> 
                    </div>   
                    <?php if(empty($data)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                            <div class="table-responsive">
                                
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-center">
                                            日期
                                        </td>
                                        <td class="text-center">
                                            代理账户名(登录用)
                                        </td>
                                        <!-- <td class="text-center">
                                            总笔数
                                        </td> -->
                                        <td class="text-center">
                                            充值金额
                                        </td>
                                        <td class="text-center">
                                            账单金额
                                        </td>
                                        <td class="text-center">
                                            分成比例
                                        </td>
                                        <td class="text-center">
                                            状态
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="text-center">
                                                <?php echo ($val['asktime']); ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo U('/Channel/remainMoney',array('channelid' => $val['channelinfo']['channelid']));?>"><?php echo ($val['channelinfo']['uname']); ?></a>
                                            </td>

                                            <!-- <td class="text-center">
                                                <a href="/index.php?s=/Channel/paymentInfo/time/<?php echo date('Y-m-d',$val['buytime']);?>/channelid/<?php echo ($val['channelinfo']['channelid']); ?>.html">
                                                    <?php echo ($val["count"]); ?>
                                                </a>
                                            </td> -->

                                            <td class="text-center">
                                                <?php echo ($val["askmoney"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($val['askmoney'] * $val['proportion']); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($val['proportion']); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($issum == 1): if($val['status'] == 1): ?><a href="javascript:void(0);"
                                                           data-time="<?php echo ($val['asktime']); ?>" data-id="<?php echo ($val["channelid"]); ?>" data-askmoney="<?php echo ($val["askmoney"]); ?>"
                                                           data-pro="<?php echo ($val['proportion']); ?>" data-paymoney="<?php echo ($val['paymoney']); ?>"
                                                           class="badge bg-yellow dealAskpay" style="padding: 5px 10px">
                                                            用户申请结算
                                                        </a>
                                                        <?php elseif($val['status'] == 2): ?>
                                                        <a href="/index.php?s=/Channel/paymentInfo/time/<?php echo ($val['asktime']); ?>/channelid/<?php echo ($val["channelid"]); ?>.html"
                                                           class="badge bg-green" style="padding: 5px 10px">
                                                            结算成功
                                                        </a>
                                                        <?php else: ?>
                                                        <a href="javascript:void(0);"
                                                           data-time="<?php echo ($val['asktime']); ?>" data-id="<?php echo ($val["channelid"]); ?>" data-askmoney="<?php echo ($val["askmoney"]); ?>"
                                                           data-pro="<?php echo ($val['proportion']); ?>" data-paymoney="<?php echo ($val['paymoney']); ?>"
                                                           class="badge bg-red dealAskpay" style="padding: 5px 10px">
                                                            未结算
                                                        </a><?php endif; endif; ?>

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
               
          
        <!-- /.row -->
       
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
   
 
// 点击分页触发的事件
    $(".pagination  a").click(function()
    {
        cur_page = $(this).data('p');
        //setCookie('pg',cur_page,1);
        ajax_get_table('search-form2',cur_page);
    });

// ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_table(form,page,ischannel)
    {
        cur_page = page; //当前页面 保存为全局变量
        dd = $('#' + form).serialize();
        //$('#isoverpay').val($('.overpay.btn-primary.active').val());
        //alert($('#isoverpay').val())
        //alert(dd)
        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=Channel&a=ajaxGetNextRemainMoney&p="+page+"&issum=1",
                data    : $('#' + form).serialize(),// 你的formid

                success : function(data)
                {
                    //alert($("#ajax_return_channel").html());
                    $("#ajax_return_channel").html('');

                    $("#ajax_return_channel").append(data);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }

    //提交筛选
$("#orderBtnGroup2 button").click(function(){

     $("#isoverpay").val($(this).attr('data-status')) ; 
    $("#orderBtnGroup2").children().removeClass("btn-primary active");
    $(this).addClass('btn-primary active');

    ajax_get_table('search-form2',1);
       
        
        /*url = "/index.php?s=/Channel/bookList";
        data = {'channel':channel};
        $.post(url,data);*/


});

/*处理结算申请*/
 $(function(){

    $('.dealAskpay').click(function(){
        var _this=$(this);
        if(time<1){
            dealAsk(_this);
        }
    });     
})

 var time=0;
    function dealAsk(_this){
        var asktime=_this.attr('data-time');
        var channleid=_this.attr('data-id');
        var askmoney=_this.attr('data-askmoney');
        var paymoney=_this.attr('data-paymoney');
        var proportion=_this.attr('data-pro');
        if(_this.hasClass('bg-green')){
            layer.msg('已结算',{icon:7});
            history.go(0);
            return false;
        }
        if(time<1) {
            $.ajax(
                {
                    type: "POST",
                    url: "/index.php?m=Admin&c=Askpayment&a=dealAskpay",
                    data: {
                        asktime: asktime,
                        channelid: channleid,
                        askmoney: askmoney,
                        paymoney: paymoney,
                        proportion: proportion
                    },
                    success: function (data) {
                        time++;
                        if (data.result == 1) {
                            layer.msg(data.msg, {icon: 6});
                            _this.removeClass('bg-red').addClass('bg-green').html('结算成功');
                            history.go(0);
                        } else {
                            layer.msg(data.msg, {icon: 5});
                            history.go(0);
                        }

                    }
                });
            time++;
        }
    }
</script>
</body>
</html>
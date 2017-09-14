<?php if (!defined('THINK_PATH')) exit(); if(empty($channelList)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    ID
                </td>

                <td class="text-center">
                    账号名(登录用)
                </td>
                <td class="text-center">
                    渠道名称
                </td>

				 <?php if($ischannel != 1): ?><td class="text-center">
                    联系人
                </td><?php endif; ?>

                <td class="text-center">
                    渠道分成比例
                </td>


                <?php if($ischannel == 1): ?><td class="text-center">
                        成本
                    </td><?php endif; ?>

                <td class="text-center">
                    总充值（元）
                </td>

                <td class="text-center">
                    已结算（元）
                </td>

                <td class="text-center">
                    待结算（元）
                </td>


                    <td class="text-center">
                        操作
                    </td>

            </tr>
            </thead>
            <tbody>
            <?php if(is_array($channelList)): $i = 0; $__LIST__ = $channelList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($list["channelid"]); ?>
                    </td>

                    <td class="text-center">
                        <!-- <a href="<?php echo U('Channel/getChannelInfo',array('id' => $list['channelid']));?>"> -->
                        
                            <?php echo ($list["uname"]); ?>
                        
                    </td>
                    <td class="text-center">
                        <!-- <a href="<?php echo U('Channel/getChannelInfo',array('id' => $list['channelid']));?>"> -->
						<a href="<?php echo U('Channel/channelListCombine',array('id' => $list['channelid']));?>">
                            <?php echo ($list["channelname"]); ?>
                        </a>
                    </td>

					 <?php if($ischannel != 1): ?><td class="text-center">
                        <a href="javascript:void(0);" onclick="channelBankinfo('<?php echo ($list["channelname"]); ?>收款信息','<?php echo U('Channel/channelBankinfo',array('id' => $list['channelid']));?>',600,680)">
                            <?php if($list["pname"] == ''): ?>未添加<?php endif; ?> <?php echo ($list["pname"]); ?>
                        </a>
                    </td><?php endif; ?>


                    <td class="text-center">
                        <?php echo ($list["proportion"]); ?>
                    </td>

                    <?php if($ischannel == 1): ?><td class="text-center">
                        <?php echo ($list["cost"]); ?>
                    </td><?php endif; ?>

                    <td class="text-center">
                        <?php echo ($list["sumpays"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo (round($list["paidmoney"],2)); ?>
                    </td>

                    <td class="text-center">
                        <a href="<?php echo U('Channel/remainMoney',array('channelid'=>$list['channelid']));?>">
                            <!--<?php echo (round($list['remainmoney']*$list['proportion'],2)); ?>-->
                            <!-- <?php echo (round($list['remainmoney'],2)); ?> -->
							<?php echo (round($list['remainmoney']*$list['proportion']-$list['daysumpay']*$list['proportion'],2)); ?>

                            
                        </a>

                    </td>

                    <td class="text-center">
                        <?php if($ischannel != 1): ?><!-- <a href="javascript:void (0)" onclick="settlement(this,<?php echo ($list['channelid']); ?>)" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                <span>结算</span>
                            </a> -->

                            <a href="<?php echo U('Admin/Channel/addEditChannel',array('id' => $list['channelid'],'action' => 'edit'));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="编辑信息" target="rightContent">
                                <span>编辑信息</span>
                            </a>

							<!--
                            <a href="<?php echo U('Admin/Channel/bindUserChannel',array('id' => $list['channelid'],'channelname' => $list['channelname']));?>" data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="绑定账号" target="rightContent">
                                <span>绑定账号</span>
                            </a>-->

                            <a href="javascript:void(0);" onclick="del('<?php echo ($list['channelid']); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除渠道">
                                <span>删除渠道</span>
                            </a>

                            <a href="<?php echo U('Channel/remainMoney',array('channelid'=>$list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="结算统计" target="rightContent">
                                <span>结算统计</span>
                            </a>
                         <?php else: ?>
                            <a href="<?php echo U('Admin/Channel/editSChannel',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="编辑信息" target="rightContent">
                                <span>编辑信息</span>
                            </a>

                            <a href="<?php echo U('Channel/remainMoney',array('channelid'=>$list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="结算统计" target="rightContent">
                                <span>结算统计</span>
                            </a><?php endif; ?>
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
<script>

    // 点击分页触发的事件
    $(".pagination  a").click(function()
    {
        cur_page = $(this).data('p');

        ajax_get_table('search-form2',cur_page);
    });

    // 删除操作
    function del(id)
    {
        if(!confirm('确定要删除吗?'))
        {
            return false;
        }

        $.ajax(
        {
            url     : "/index.php?m=Admin&c=Channel&a=delChannel&id="+id,
            success : function(v)
            {
                var v =  eval('('+v+')');

                if(v.hasOwnProperty('status') && (v.status == 1))
                {
                    ajax_get_table('search-form2',cur_page);
                }
                else
                {
                    layer.msg(v.msg, {icon: 2,time: 1000}); //alert(v.msg);
                }
            }
        });

        return false;
    }

    function settlement(obj,id){
        var channelname=$(obj).parents("tr").children("td:eq(1)").text();
        var pay=$(obj).parents("tr").children("td:eq(6)").text();
        layer.confirm('确认要给 <strong style="color: darkred">'+channelname+' </strong>结算 <strong style="color: darkred">'+pay+'</strong> 元吗？',function(index){
            $.ajax({
                type: 'GET',
                url: '/index.php?s=/Channel/channelSettlement/id/'+id,
                success: function(data){
                    if(data.status==1){
                        layer.msg(data.info,{icon:1,time:1500},function () {
                            parent.rightContent.location.reload();
                        });
                    }else {
                        layer.msg(data.info,{icon:5,time:3000});
                    }
                },
            });
        });
    }


    /*弹出层*/
    /*
     参数解释：
     title	标题
     url		请求的url
     id		需要操作的数据id
     w		弹出层宽度（缺省调默认值）
     h		弹出层高度（缺省调默认值）
     */
    function layer_show(title,url,w,h){
        if (title == null || title == '') {
            title=false;
        };
        if (url == null || url == '') {
            url="404.html";
        };
        if (w == null || w == '') {
            w=800;
        };
        if (h == null || h == '') {
            h=($(window).height() - 50);
        };
        var heading=$('#heading').offset();
        layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            offset: [ //为了演示，随机坐标
                heading.top/2],
            title: title,
            content: url
        });
    }
    /*关闭弹出框口*/
    function layer_close(){
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    }


    function channelBankinfo(title,url,w,h) {
        layer_show(title,url,w,h);
    }

</script>
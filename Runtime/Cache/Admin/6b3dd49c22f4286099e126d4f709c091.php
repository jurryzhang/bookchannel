<?php if (!defined('THINK_PATH')) exit(); if(empty($channelList)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <!-- <td class="text-center">
                        ID
                    </td>-->
                    <td class="text-center">
                        创建时间
                    </td>
                    <td class="text-center">
                        账号名(登录用)
                    </td>
                    <?php if(($_COOKIE['cpid']> 0)): else: ?>
                    <td class="text-center">
                        代理名称
                    </td><?php endif; ?>
					   <td class="text-center">
                        佣金比例
                    </td>

                    <!-- <td class="text-right">
                        今日充值金额
                    </td>
                    <td class="text-center">
                        今日新增用户
                    </td>

                    <td class="text-right">
                        今日新增关注
                    </td>

                    <td class="text-center">
                        新增用户
                    </td>

                    <td class="text-right">
                        新增关注
                    </td> -->

                 

                    <!-- <?php if($ischannel == 1): ?><td class="text-center">
                            成本
                        </td><?php endif; ?> -->

                    <td class="text-right">
                        总充值金额
                    </td>
					
					<td class="text-right">
						待结算
					</td>

                    <td class="text-center">
                        操作
                    </td>
                    
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($channelList)): $i = 0; $__LIST__ = $channelList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                       <!-- <td class="text-center">
                            <?php echo ($list["channelid"]); ?>
                        </td>-->
                        <td class="text-center">
                            <?php echo (date("Y-m-d H:i:s",$list["posttime"])); ?>
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0);" onclick="channelBankinfo('<?php echo ($list["uname"]); ?>收款信息','<?php echo U('Channel/channelBankinfo',array('id' => $list['channelid']));?>',600,680)">
                            <?php echo ($list["uname"]); ?>
                            </a>
                        </td>
                        <?php if(($_COOKIE['cpid']> 0)): else: ?>
                        <td class="text-center">
                            <a href="<?php echo U('Admin/channel/ptList',array('id' => $list['channelid']));?>">
                                <span  style="font-size:14px;"><?php echo ($list["channelname"]); ?></span>
                            </a>
                        </td><?php endif; ?>
						 <td class="text-center">
                           <span  style="font-size:14px;"> <?php echo ($list["proportion"]); ?></span>
                        </td>

                        <!-- <td class="text-right">
                            <span  style="font-size:14px;"><?php echo ($list["todaypaylogsum"]); ?></span>
                            <p style="color:#aaa;font-size:12px;margin-top:4px;"><?php echo ($list["todaypaylogcount"]); ?>笔</p>
                        </td>

                        <td class="text-center">
                            <span  style="font-size:14px;"><?php echo ($list["todayusersum"]); ?></span>
                        </td>

                        <td class="text-right">
                            <span  style="font-size:14px;"><?php echo ($list["todayfollowusersum"]); ?></span>
                            <p style="color:#aaa;font-size:12px;margin-top:4px;">关注率 <?php echo (round($list['todayfollowusersum']/$list['todayusersum']*100,0)); ?>%</p>
                        </td>

                        <td class="text-center">
                            <span  style="font-size:14px;"><?php echo ($list["usersum"]); ?></span>
                        </td>

                        <td class="text-right">
                            <span  style="font-size:14px;"><?php echo ($list["followusersum"]); ?></span>
                            <p style="color:#aaa;font-size:12px;margin-top:4px;">关注率 <?php echo (round($list['followusersum']/$list['usersum']*100,0)); ?>%</p>
                        </td> -->

                       

                        <!-- <td class="text-center">
                            <span  style="font-size:14px;"><?php echo ($list["cost"]); ?></span>
                        </td> -->

                        <td class="text-right">
                            <!-- <?php echo (round($list['paidmoney']/$list['proportion']+$list['remainmoney'],2)); ?> -->
							<span  style="font-size:14px;"><?php echo ($list["paylogsum"]); ?></span>
                            <p style="color:#aaa;font-size:12px;margin-top:4px;"> <?php echo ($list["paylogcount"]); ?>笔</p>
                        </td>
						
						<td class="text-right">
							<span  style="font-size:14px;"><?php echo (round($list['remainmoney']*$list['proportion']-$list['todaypaylogsum']*$list['proportion'],2)); ?></span>
						</td>

                        <td class="text-center">
						<?php if($_COOKIE['permissions']== 0): ?><a href="<?php echo U('Admin/Channel/editSChannel',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="编辑信息" target="rightContent">
                                <span>编辑</span>
                            </a>

                            <a href="<?php echo U('Channel/remainMoney',array('channelid'=>$list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="结算统计" target="rightContent">
                                <span>结算</span>
                            </a><?php endif; ?>
                            <a href="<?php echo U('Admin/User/channelPayLogListByChannleID',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                <span>订单</span>
                            </a>
                            <!-- <a href="<?php echo U('Admin/User/channelUserListByChannleID',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                <span>用户</span>
                            </a> -->
							
							<a href="<?php echo U('Admin/Channel/dataStatisticsByChannelid',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                <span>数据统计</span>
                            </a>

                            <a href="<?php echo U('Admin/channel/ptList',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="查看详情" target="rightContent">
                                <span>推广链接</span>
                            </a>

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
        setCookie('pg',cur_page,1);
        ajax_get_table('search-form2',cur_page);
    });

    /*弹出层*/
    /*
     参数解释：
     title  标题
     url        请求的url
     id     需要操作的数据id
     w      弹出层宽度（缺省调默认值）
     h      弹出层高度（缺省调默认值）
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
        var heading=$('#form-order').offset();
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
        //alert(url);
        layer_show(title,url,w,h);
    }
</script>
<script>
    $(function(){
        $('.table').setTableColor('#F9F9F9','#F9F9F9');
    });

   
</script>
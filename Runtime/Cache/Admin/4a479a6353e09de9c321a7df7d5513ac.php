<?php if (!defined('THINK_PATH')) exit(); if(empty($ptlist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover" style="font-size:15px;">
            <thead>
            <tr><td class="text-left">
                    推广链接
                </td>

                <td class="text-left">
                    入口页面
                </td>

				<td class="text-center">
                    点击
                </td>
                <?php if($_COOKIE['cpid']== 0): ?><td class="text-center">
                        新增用户数
                    </td>



                    <td class="text-right">
                        新增关注
                    </td><?php endif; ?>
               <!-- <td class="text-center">
                    充值笔数
                </td>-->
                
                <td class="text-center">
                    成本（元）
                </td>
				
				<td class="text-right">
                    充值金额
                </td>

                <!-- <td class="text-center">
                    利润（元）
                </td> -->
				
                <td class="text-center">
                        操作
                    </td>

            </tr>
            </thead>
            <tbody>
            <?php if(is_array($ptlist)): $i = 0; $__LIST__ = $ptlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr id="pt-<?php echo ($list["ptid"]); ?>">
					<td class="text-left">
						<?php echo ($list["ptname"]); ?>
						<?php if($list["ptlink"] != ''): ?><p style="color:#337ab7;font-size:14px;margin-top: 10px">
								<!-- <span id="docurl<?php echo ($list["ptid"]); ?>" onclick="copyS(<?php echo ($list['ptid']); ?>)" data-clipboard-target="#docurl<?php echo ($list["ptid"]); ?>"><?php echo ($list["ptlink"]); ?></span> -->							
								<input type="text" style="border:none;width:350px;background:transparent;" readonly="readonly" value="<?php echo ($list["ptlink"]); ?>" id="docurl<?php echo ($list["ptid"]); ?>" onclick="copyS(<?php echo ($list['ptid']); ?>)" data-clipboard-target="#docurl<?php echo ($list["ptid"]); ?>"/>
								<i class="fa fa-copy" id="copy<?php echo ($list["ptid"]); ?>" onclick="copy(<?php echo ($list['ptid']); ?>)" data-clipboard-target="#docurl<?php echo ($list["ptid"]); ?>" style="color: #000;cursor: pointer"></i>															
							</p><?php endif; ?>
						<p style="color:#aaa;font-size:12px;"> 创建时间:<?php echo (date('Y-m-d H:i',$list['addtime'])); ?></p>
                    </td>                   

                    <td class="text-left">
                        <p style="color:#337ab7;font-size:14px;margin-top: 10px"><a href="/Doc/bookInfo/articleId/<?php echo ($list["articleid"]); ?>.html" target="_blank"><?php echo ($list["articlename"]); ?></a></p>
                        <p style="color:#000;font-size:14px;"><?php echo ($list["chaptername"]); ?></p>
                        <!-- <p style="color:#aaa;font-size:14px;">阅读原文章节： <?php echo ($list["readchaptercount"]); ?></p> -->
						<p style="color:#aaa;font-size:14px;">关注章节： <?php echo ($list['readchaptercount']); ?></p>
                    </td>
					
					 <td class="text-center">
                        <?php echo ($list["click"]); ?>
                    </td>
                    <?php if($_COOKIE['cpid']== 0): ?><td class="text-center">
                            <?php echo ($list["sumuser"]); ?>
                        </td>


                        <td class="text-right">
                            <?php echo ($list["sumfollow"]); ?>
    						<p style="color:#aaa;font-size:12px;">关注率 <?php echo (round($list['sumfollow']/$list['sumuser']*100,0)); ?>%</p>
                        </td><?php endif; ?>
                    <!--<td class="text-center">
                        <?php echo ($list["paycount"]); ?>
                    </td>-->
					
					<td class="text-center">
                        <?php echo (round($list["ptcost"],2)); ?>
                    </td>

                    <td class="text-right">
                        <?php echo (round($list['sumpay'],2)); ?>
						<p style="color:#aaa;font-size:12px;"><?php echo ($list["paycount"]); ?>笔</p>
                    </td>
                   
                    <!-- <td class="text-center">
                        <?php echo (round($list['sumpay']-$list['ptcost'],2)); ?>
                    </td> -->


                    <td class="text-center">
                        <!-- Single button -->

                        
						
                        
                        <a href="<?php echo U('Admin/User/ptPaylogListByptid',array('ptid' => $list['ptid'],'channelid'=>$list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                            <span>订单</span>
                        </a>
                        <?php if(($_COOKIE['cpid']> 0)): else: ?>
                            <a href="<?php echo U('Admin/User/ptUserListByptid',array('ptid' => $list['ptid'],'channelid'=>$list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                <span>用户</span>
                            </a><?php endif; ?>
                        <div class="btn-group">
                              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                更多<i class="fa sort-down"></i> <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo U('Admin/Channel/editPt',array('id' => $list['ptid']));?>" data-toggle="tooltip" title=""  data-original-title="编辑信息" target="rightContent"><i class="fa fa-pencil-square-o"></i> 编辑</a>
                                    
                                                    
                                </li>
                                <li>
                                    <?php if($list["wenanlink"] == ''): ?><a href="javascript:void(0);" data-toggle="tooltip" title=""  data-original-title="查看详情" target="rightContent">
                                            <i class="fa fa-print"></i> 文案
                                        </a>
                                <?php else: ?>
                                        <a href="<?php echo ($list["wenanlink"]); ?>" data-toggle="tooltip" title=""  data-original-title="查看详情" target="rightContent">
                                            <i class="fa fa-print"></i> 文案
                                        </a><?php endif; ?>
                                </li>
                                <li>
                                    <a href="javascript:;" name="" onclick="if(confirm('确定删除吗?')){delpt('<?php echo ($list["ptid"]); ?>')}"><i class="fa fa-trash"></i> 删除</a>
                                </li>
                                
                              </ul>
                        </div>
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
        cur_page = $(this).text();
        console.log(cur_page);

        ajax_get_paylog('search-form2',cur_page);
    });

    //删除推广链接

    function delpt(id){
        url = "/index.php?m=Admin&c=Channel&a=delPt",
        postData = {"ptid":id},
        $.post(url,postData,function(result){
            if(result.status==1){
                $("#pt-"+id).remove();
            }else{
                alert('删除失败');
            }
        },'json');

    }

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
        layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
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

<script>
	/*复制原文链接*/
	function copy(ptid){
        var clipboard = new Clipboard('#copy'+ptid);
        clipboard.on('success', function (e) {
            layer.tips('复制连接成功','#docurl'+ptid, {
                tips: [1, '#72b372'],
                time: 4000
            });
        });
    }
    function copyS(ptid){
        var clipboard = new Clipboard('#docurl'+ptid);
        clipboard.on('success', function (e) {
            layer.tips('复制连接成功','#docurl'+ptid, {
                tips: [1, '#72b372'],
                time: 4000
            });
        });
    }
	/*表格隔行换色*/
    $(function(){
        $('.table').setTableColor('#F9F9F9','#F9F9F9');
    });
</script>
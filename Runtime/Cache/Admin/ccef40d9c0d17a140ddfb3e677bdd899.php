<?php if (!defined('THINK_PATH')) exit(); if(empty($userlist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td class="text-center">
                        <a href="javascript:sort('uid');">用户ID</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('name');">用户昵称</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('egold');">用户余额(<?php echo ($egold_name); ?>)</a>
                    </td>


                    <td class="text-center">
                        <a href="javascript:sort('regdate');">注册时间</a>
                    </td>
                    <td class="text-center">
                        <a href="javascript:sort('lastlogin');">最后登录时间</a>
                    </td>


                    <td class="text-center">
                        <a href="javascript:sort('isfollow');">是否关注</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('isfollow');">渠道名称</a>
                    </td>


                    <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                            操作
                        </td><?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
                        <td class="text-center">
                            <?php echo ($user["uid"]); ?>
                        </td>


                        <td class="text-center">
                            <?php echo ($user["name"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($user["egold"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo (date('Y-m-d H:i',$user["regdate"])); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($user["lastlogin"]); ?>
                        </td>

                        <td class="text-center">
                            <?php if($user["isfollow"] == 1): ?><span class="badge bg-green">已关注</span>
                                <?php else: ?>
                                <span class="badge bg-red">未关注</span><?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($user["ptname"]); ?>
                        </td>

                        <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                <a href="<?php echo U('Admin/User/payLogList',array('id' => $user['uid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                    <span>充值记录</span>
                                </a>

                                <a href="<?php echo U('Admin/User/edit',array('id' => $user['uid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="编辑信息" target="rightContent">
                                    <span>编辑信息</span>
                                </a>

                                <a href="<?php echo U('Admin/User/buyInfo',array('id' => $user['uid']));?>" data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="绑定账号" target="rightContent">
                                    <span>消费记录</span>
                                </a>

                                <a href="javascript:void(0);" onclick="del('<?php echo ($user['uid']); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除渠道">
                                    <span>删除用户</span>
                                </a>
                            </td><?php endif; ?>
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
                url     : "/index.php?m=Admin&c=User&a=delUser&id="+id,
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

</script>
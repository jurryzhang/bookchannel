<?php if (!defined('THINK_PATH')) exit(); if(empty($articlelist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td class="text-center">
                        <a href="javascript:sort('articleid');">BooKID</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('articlename');">小说名称</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('author');">小说作者</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('size');">小说字数</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('sumegold');">小说收益</a>(<?php echo ($egold_name); ?>)
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('allvisit');">用户总点击数</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('dayvisit');">用户日点击数</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('weekvisit');">用户周点击数</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('monthvisit');">用户月点击数</a>
                    </td>
                    <td class="text-center">
                        操作
                    </td>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($articlelist)): $i = 0; $__LIST__ = $articlelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): $mod = ($i % 2 );++$i;?><tr>
                        <td class="text-center">
                            <?php echo ($book["articleid"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["articlename"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["author"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["wordsum"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["sumegold"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["allvisit"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["dayvisit"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["weekvisit"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($book["monthvisit"]); ?>
                        </td>

                        <td class="text-center">
                            <a href="<?php echo U('Admin/BookSale/chapterList',array('id' => $book['articleid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                <span>详细销售</span>
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

        ajax_get_table('search-form2',cur_page);
    });


    // 点击排序
    function sort(field)
    {
        $("input[name='orderby1']").val(field);
        var v = $("input[name='orderby2']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='orderby2']").val(v);

        ajax_get_table('search-form2',cur_page);
    }
</script>
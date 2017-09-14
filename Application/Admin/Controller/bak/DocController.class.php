<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/4/20 0020
 * Time: 上午 10:31
 * 文案控制器
 */
namespace Admin\Controller;
use Think\AjaxPage;

class DocController extends BaseController
{
    public function bookList()
    {
        if(cookie('permissions') == 0){
            $this->assign('ischannel',1);
        }
        $bookModel=D('Book');
        $data=$bookModel->search(20);
        //var_dump($data);die;
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('channel',$data['channel']);
        $this->display();
    }

    //生成文案
    public function mkDoc()
    {
        $id=I('id',0);
        $num=I('num',0)+0;
        $num=$num>20?20:$num;
        $num=$num<1?1:$num;
        $bookModel=D('Book');
        $book=$bookModel->getChapterContent($id,$num+1);
        $channel=$bookModel->getChannelByaid($id);
        $title=D('Title')->getRandTitle($channel);
        $pic=D('Pic')->getRandPic($channel);
        $bookname=$book[0]['articlename'];
        $tplpath=C('DOC_TPL');
        include $tplpath;
        //文案章节
        $count=rand(1,count($chapterTpl));
        $ctpl=$chapterTpl[$count];
        $bookStr='';
        $ccount=count($book);
        for($i=0;$i<$ccount-1;$i++) {
            $chapterStr=str_replace('{chaptername}',$book[$i]['chaptername'],$ctpl);
            $chapterStr=str_replace('{content}',$book[$i]['content'], $chapterStr);
            $bookStr.=$chapterStr;

        }

        //文案底部关注
        $fcount=rand(1,count($footerTpl));
        $ftpl=$footerTpl[$fcount];

        //生成连接
       //原文链接的章节ID
        $rchapterid=($book[$ccount-1]['chapterid']);
        //强制关注的回调地址
        $backurl='Article-readChapter-chapter_id-'.$rchapterid.'-book_id-'.$id;
        //获取渠道信息
        $cinfo=M('distribution_channels')->find(cookie('channelid'));
        //生成推广代码;
        $docurl = C('DOC_URL');

        $docurl = sprintf($docurl,$backurl,$cinfo['secretkey'],urlencode($cinfo['channelname']),urlencode($cinfo['channeltype']));
     
        $this->assign('docurl',$docurl);
        $this->assign('bookname',$bookname);
        $this->assign('bookStr',$bookStr);
        $this->assign('footer', $ftpl);
        $this->assign('title',$title);
        $this->assign('pic',$pic);
        $this->display();

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/4/20 0020
 * Time: 上午 10:31
 * 文案控制器
 */
namespace Admin\Controller;
header('content-type:text/html;charset=utf-8');
use Think\AjaxPage;
use Think\Page;

class DocController extends BaseController
{
    public function bookList()
    {
        //获取当前渠道的平台信息
        $ptmodel=M('distribution_channel_pt');
        if(cookie('permissions')==1&&cookie('uid')==1){
            $pt='';
        }else{
            $where=array('channelid'=>cookie('channelid'));
            $pt=$ptmodel->where($where)->select();
            $this->assign('ischannel',1);
        }

        $bookModel=D('Book');
        $data=$bookModel->search(20);
        //dump($data);exit();
        $this->assign('data',$data['data']);
        $this->assign('pt',$pt);
        $this->assign('page',$data['page']);
        $this->assign('channel',$data['channel']);
        $this->display();
    }

    //生成文案
    public function mkDoc()
    {
        $id=I('id',0);  /*articleId*/
        $num=I('num',0)+0;
        $channelid=cookie('channelid');
        $ptid=I('ptid')+0;
        $num=$num>20?20:$num;
        $num=$num<1?1:$num;
        $bookModel=D('Book');
        $book=$bookModel->getChapterContent($id,$num+1);
        $channel=$bookModel->getChannelByaid($id);/*频道*/
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
        //推广连接
        //$backurl='Article-readChapter-chapter_id-'.$rchapterid.'-book_id-'.$id;
        if(cookie('permissions')==1&&cookie('uid')==1){
            $channelid=12;
        }
        if($ptid==0){
            $docurl="http://m.kyread.com/Article/readChapter/chapter_id/$rchapterid/book_id/$id/cid/$channelid.html";
        }else{
            $docurl="http://m.kyread.com/Article/readChapter/chapter_id/$rchapterid/book_id/$id/cid/$channelid/ptid/$ptid.html";
        }

        $this->assign('docurl',$docurl);
        $this->assign('bookname',$bookname);
        $this->assign('bookStr',$bookStr);
        $this->assign('footer', $ftpl);
        $this->assign('title',$title);
        $this->assign('pic',$pic);
        $this->display();

    }
    /*
     * 小说详情信息
     * */
    public function bookInfo(){
        header('content-type:text/html;charset=utf-8');
        $articleId=I('articleId');
        $bookModel=D('Book');
        $data=$bookModel->field('articleid,articlename,intro,author,size,sortid,fullflag,orderby,recommend')->find($articleId);
        $data['cover']=$bookModel->getCover($articleId);
        $bookInfo=$bookModel->getbookinfo($articleId);
        //dump($bookInfo);exit();

        $this->assign('book',$data);
        $this->assign('bookInfo',$bookInfo['data']);
        $this->assign('page',$bookInfo['page']);
        $this->display();
    }
    /*
     * 章节内容
     * */
    public function chapterContent(){
        $articleId=I('articleId');
        $chapterId=I('chapterId');
        $bookModel=D('Book');
        $chapterInfo = M('article_chapter')->where(array('chapterid' =>$chapterId))->find();
        $chapterInfo['prevchapter']  = $bookModel->getContextChapterID($chapterInfo['chapterorder'],$chapterInfo['articleid'],-1);
        $chapterInfo['nextchapter'] = $bookModel->getContextChapterID($chapterInfo['chapterorder'],$chapterInfo['articleid'],1);
        $content=$bookModel->getContent($articleId,$chapterId);
        //dump($chapterInfo);exit();

        $this->assign('content',$content);
        $this->assign('chapterInfo',$chapterInfo);

        $this->display();
    }
    /*
     * 派单指数排序
     * */
    public function changeOrderby(){
        $orderbyVal=I('post.orderbyVal');
        $articleId=I('articleId');
        $bookModel=D('Book');
        //$data['orderby']=$orderbyVal;
        //$where['articleid']=$articleId;
        //$res=$bookModel->where($where)->save($data);
        $res=$bookModel
            ->where(array('articleid'=>$articleId))
            ->save(array('orderby'=>$orderbyVal));
        if($res!==false){
            $this->ajaxReturn(array('status'=>1,'msg'=>$orderbyVal));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>$orderbyVal));
        }
    }
    /*
     * 添加推荐语
     * */
    public function recommend(){
        $sentence=I('post.sentence');
        $articleId=I('articleId');
        $bookModel=D('Book');
		$data['recommend']=$sentence;
        $res=$bookModel
            ->where(array('articleid'=>$articleId))
            ->save($data);
        if($res!==false){
            $this->ajaxReturn(array('status'=>1,'msg'=>'推荐语设置成功'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'请填写推荐语'));
        }
    }
	 /*
     * 打赏记录
     * */
    public function giftsList(){
        $giftsModel=M('distribution_gifts');

        $keywords=I('key_word');
        if($keywords){
            $condition['a.articlename']=array('LIKE','%'.$keywords.'%');
            $condition['u.name']=array('LIKE','%'.$keywords.'%');
            $condition['_logic'] = 'OR';
        }
        $this->assign('keywords',$keywords);

        /*$parameter=array('keyword'=>$keywords);*/
        /*$parameter=$keywords;*/
        $parameter = $_POST;
        /* 分页 */
        $totalRow = $giftsModel->where($condition)->count();
        $pageSize=15;
        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $giftsList=$giftsModel
            ->alias('g')
            ->field('g.*,u.name,a.articlename')
            ->join('LEFT JOIN __DISTRIBUTION_SYSTEM_USERS__ u ON u.uid=g.userid')
            ->join('LEFT JOIN __ARTICLE_ARTICLE__ a ON a.articleid=g.articleid')
            ->where($condition)
            ->order('g.givetime DESC')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        //echo $giftsList;exit();
        foreach($giftsList as $key=>$val){
            $giftstypeNo=$val['giftstype'];
            switch($giftstypeNo){
                case 1:
                    $giftstype='鲜花';break;
                case 2:
                    $giftstype='红包';break;
                case 3:
                    $giftstype='酒水';break;
                case 4:
                    $giftstype='香囊';break;
                case 5:
                    $giftstype='钻石';break;
                case 6:
                    $giftstype='跑车';break;
                case 7:
                    $giftstype='皇冠';break;
            }
            $giftsList[$key]['giftsname']=$giftstype;
        }
        $this->assign('giftsList',$giftsList);

        $this->assign('page',$pageShow);

        $this->display();
    }
    /*
     * 催更记录
     * */
    public function urgeList(){
        $urgeModel=M('distribution_user_urgeupdate');

        $keywords=I('key_word');
        if($keywords){
            $condition['a.articlename']=array('LIKE','%'.$keywords.'%');
            $condition['u.name']=array('LIKE','%'.$keywords.'%');
            $condition['_logic'] = 'OR';
        }
        $this->assign('keywords',$keywords);

        $parameter=array('keyword'=>$keywords);
        /* 分页 */
        $totalRow = $urgeModel->where($condition)->count();
        $pageSize=15;
        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $urgeList=$urgeModel
            ->alias('ur')
            ->field('ur.*,u.name,a.articlename')
            ->join('LEFT JOIN __DISTRIBUTION_SYSTEM_USERS__ u ON u.uid=ur.userid')
            ->join('LEFT JOIN __ARTICLE_ARTICLE__ a ON a.articleid=ur.articleid')
            ->where($condition)
            ->order('ur.givetime DESC')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

        $this->assign('urgeList',$urgeList);

        $this->assign('page',$pageShow);

        $this->display();
    }
    /*
     * 评论记录
     * */
    public function commentList(){
        $commentmodel=M('distribution_comment');

        $keywords=I('key_word');
        if($keywords){
            $condition['a.articlename']=array('LIKE','%'.$keywords.'%');
            $condition['u.name']=array('LIKE','%'.$keywords.'%');
            $condition['_logic'] = 'OR';
        }
        $this->assign('keywords',$keywords);

        //$parameter=array('keyword'=>$keywords);
        /* 分页 */
        $totalRow = $commentmodel->where($condition)->count();
        $pageSize=15;
        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $commentList=$commentmodel
            ->alias('c')
            ->field('c.*,u.name,a.articlename')
            ->join('LEFT JOIN __DISTRIBUTION_SYSTEM_USERS__ u ON u.uid=c.userid')
            ->join('LEFT JOIN __ARTICLE_ARTICLE__ a ON a.articleid=c.articleid')
            ->where($condition)
            ->order('c.addtime DESC')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

        //dump($commentList);
        $this->assign('commentList',$commentList);
        $this->assign('page',$pageShow);
        $this->display();
    }
    /*
     * 更改审核状态
     * */
    public function checkComment(){
        $commentid=I('commentid');
        if(IS_AJAX){
            $commentmodel=M('distribution_comment');
            $data['ischeck']=1;
            $res=$commentmodel->where(array('commentid'=>$commentid))->save($data);
            if($res!==false){
                $this->ajaxReturn(array('status'=>1,'message'=>'审核成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'message'=>'审核失败'));
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'message'=>'非法操作'));
        }
    }
    /*
     * 删除评论记录
     * */
    public function delComment(){
        $commentmodel=M('distribution_comment');
        if(IS_AJAX){
            $commentid=I('commentid');
            $res=$commentmodel->where(array('commentid'=>$commentid))->delete();
            if($res){
                $this->ajaxReturn(array('status'=>1,'message'=>'删除成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'message'=>'删除失败'));
            }
        }
    }
	
	
}
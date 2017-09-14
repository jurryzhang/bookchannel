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
        
		/*付费人数 daidai*/
        foreach($data['data'] as $k=>$v){
            $articleid=$v['articleid'];
            $bookInfo=M('distribution_obook_obook')->field('allvisit')
                ->where(array('articleid'=>$articleid))->find();
            $data['data'][$k]['allvisit']=$bookInfo['allvisit'];
        }
		
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
				
		/*daidai*/
        $titleid=I('titleid',$title['id'],'intval');
        $picid=I('picid',$pic['id'],'intval');
        $titleStr=D('Title')->getTitleByid($titleid);
        $picStr=D('Pic')->getPicByid($picid);

        include $tplpath;
        $chapterTplCount=count($chapterTpl);
        $footerTplCount=count($footerTpl);
        //文案章节        
        $countC=rand(1,$chapterTplCount);
        $count=I('count',$countC,'intval');

        $ctpl=$chapterTpl[$count];
        $bookStr='';
        $ccount=count($book);
        for($i=0;$i<$ccount-1;$i++) {
            $chapterStr=str_replace('{chaptername}',$book[$i]['chaptername'],$ctpl);
            $chapterStr=str_replace('{content}',$book[$i]['content'], $chapterStr);
            $bookStr.=$chapterStr;
        }
        //文案底部关注
        $fcountF=rand(1,$footerTplCount);
        $fcount=I('fcount',$fcountF,'intval');
		
        $ftpl=$footerTpl[$fcount];

        //生成连接
        //原文链接的章节ID
        $rchapterid=($book[$ccount-1]['chapterid']);
		
		/*第一章chapterid daisy*/
        $firstChapter=$book[0]['chapterid'];
		
        //推广连接
        //$backurl='Article-readChapter-chapter_id-'.$rchapterid.'-book_id-'.$id;
        if(cookie('permissions')==1&&cookie('uid')==1){
            $channelid=12;
        }
        if($ptid==0){
            $docurl="http://wap.kyread.com/Article/readChapter/chapter_id/$rchapterid/book_id/$id/cid/$channelid.html";
            $firstDocUrl="http://wap.kyread.com/Article/readChapter/chapter_id/$firstChapter/book_id/$id/cid/$channelid.html";
        }else{
            $docurl="http://wap.kyread.com/Article/readChapter/chapter_id/$rchapterid/book_id/$id/cid/$channelid/ptid/$ptid.html";
            $firstDocUrl="http://wap.kyread.com/Article/readChapter/chapter_id/$firstChapter/book_id/$id/cid/$channelid/ptid/$ptid.html";
        }
		
		$wenanUrl="http://admin.kyread.com/index.php/Doc/mkDoc/id/$id/num/$num/titleid/$titleid/picid/$picid/count/$count/fcount/$fcount";

        $this->assign('docurl',$docurl);
        $this->assign('bookname',$bookname);
        $this->assign('bookStr',$bookStr);
        $this->assign('footer', $ftpl);
        $this->assign('title',$title);
        $this->assign('pic',$pic);
		
		$this->assign('id',$id);
        $this->assign('num',$num);
        $this->assign('chapterTplCount',$chapterTplCount);
        $this->assign('footerTplCount',$footerTplCount);
        $this->assign('titleStr',$titleStr);
        $this->assign('picStr',$picStr);
        $this->assign('ptid',$ptid);
        $this->assign('wenanUrl',$wenanUrl);
		$this->assign('firstDocUrl',$firstDocUrl);
		
        $this->display();

    }
    /*
     * 小说详情信息
     * */
    public function bookInfo(){
        header('content-type:text/html;charset=utf-8');
        $articleId=I('articleId');
        $bookModel=D('Book');
        $data=$bookModel->field('articleid,articlename,intro,author,size,sortid,fullflag,orderby,recommend,peregold')->find($articleId);
        $data['cover']=$bookModel->getCover($articleId);
        $bookInfo=$bookModel->getbookinfo($articleId);
        //dump($bookInfo);exit();
	$bookfreechapter = M('article_chapter')->field('sum(size) AS sumfreesize')->where(array('articleid'=>$articleId,'isvip'=>0))->select();

        //var_dump($bookfreechapter);exit;
        $bookfreechapter = $bookfreechapter[0];
        $this->assign('freechaptersize',$bookfreechapter);	

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
            $condition['articlename']=array('LIKE','%'.$keywords.'%');
            $condition['name']=array('LIKE','%'.$keywords.'%');
            $condition['_logic'] = 'OR';
        }

        $this->assign('keywords',$keywords);

        $parameter=array('key_word'=>$keywords);
        /*$parameter=$keywords;*/
        /*$parameter = $_POST;*/
        /* 分页 */
        $totalRow = $giftsModel->where($condition)->count();
        $pageSize=15;
        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $giftsList=$giftsModel->where($condition)
            ->order('givetime DESC')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

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
            $condition['articlename']=array('LIKE','%'.$keywords.'%');
            $condition['name']=array('LIKE','%'.$keywords.'%');
            $condition['_logic'] = 'OR';
        }
        $this->assign('keywords',$keywords);

        $parameter=array('key_word'=>$keywords);
        /* 分页 */
        $totalRow = $urgeModel->where($condition)->count();
        $pageSize=15;
        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $urgeList=$urgeModel->where($condition)
            ->order('givetime DESC')
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

        $condition['iscomment']=1;

        /*$condition.="content NOT LIKE '%感谢您的努力，希望后续更加精彩%' AND content NOT LIKE '%小说币催促文章尽快更新，要求更新%'";*/

        $parameter=array('key_word'=>$keywords);
        /* 分页 */
        /*$totalRow = $commentmodel->alias('g')
            ->join('LEFT JOIN __DISTRIBUTION_SYSTEM_USERS__ u ON u.uid=g.userid')
            ->join('LEFT JOIN __ARTICLE_ARTICLE__ a ON a.articleid=g.articleid')
            ->where($condition)->count();*/
        $totalRow = $commentmodel->where($condition)->count();
        $pageSize=15;
        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $commentList=$commentmodel->where($condition)->order('addtime DESC')
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
        $articleid=I('articleid');
        if(IS_AJAX){
            $commentmodel=M('distribution_comment');
            $data['ischeck']=1;
            $res=$commentmodel->where(array('commentid'=>$commentid))->save($data);
            

            if($res!==false){
                /*添加打赏记录时更新obook表里sumhurry字段*/
                $obookInfo=M('distribution_obook_obook')->field('sumcomment')->where(array('articleid'=>$articleid))->find();
                
                $dataObook['sumcomment']=$obookInfo['sumcomment']+1;
                M('distribution_obook_obook')->where(array('articleid'=>$articleid))->save($dataObook);
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
	/*
     * 管理员评论回复
     * */
    public function commentReply(){
        $commentmodel=M('distribution_comment');
        if(IS_AJAX){
            $commentid=I('commentid');
            $content=I('content');
            $data['reply']=$content;
			//发送客服消息
			$comment=$commentmodel->find($commentid);
            $contentstr='您的评论:'.$comment['content'].'\n';
            $contentstr.='作者回复:'.$content;
            $userModel=D('User');
            $userModel->sendKefuInfo($comment['userid'],$contentstr);
            $res=$commentmodel->where(array('commentid'=>$commentid))->save($data);
            if($res!==false){
                $this->ajaxReturn(array('status'=>1,'message'=>'回复成功'));
            }else{
                $this->ajaxReturn(array('status'=>1,'message'=>'回复失败'));
            }
        }
    }
    /*
     * 管理员打赏回复
     * */
    public function giftsReply(){
        $giftsModel=M('distribution_gifts');
        if(IS_AJAX){
            $giftsid=I('giftsid');
            $content=I('content');
            $data['reply']=$content;
			//发送客服消息
			$gifts=$giftsModel->find($giftsid);
			$giftstype=$gifts['giftstype'];
			switch($giftstype){
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
            $contentstr='您打赏了: '.$gifts['amount'].' 个'.$giftstype.'\n';
            $contentstr.='作者回复:'.$content;
            $userModel=D('User');
            $userModel->sendKefuInfo($gifts['userid'],$contentstr);
            $res=$giftsModel->where(array('giftsid'=>$giftsid))->save($data);
            if($res!==false){
                $this->ajaxReturn(array('status'=>1,'message'=>'回复成功'));
            }else{
                $this->ajaxReturn(array('status'=>1,'message'=>'回复失败'));
            }
        }
    }
    /*
     * 管理员催更回复
     * */
    public function urgeReply(){
        $urgeModel=M('distribution_user_urgeupdate');
        if(IS_AJAX){
            $urgeid=I('urgeid');
            $content=I('content');
            $data['reply']=$content;
			//发送客服消息
			$urge=$urgeModel->find($urgeid);
            $contentstr='您支付了'.$urge['needegold'].'小说币催促文章尽快更新，要求更新'.$urge['wordsize'].'字以上\n';
            $contentstr.='作者回复:'.$content;
            $userModel=D('User');
            $userModel->sendKefuInfo($urge['userid'],$contentstr);
            $res=$urgeModel->where(array('urgeid'=>$urgeid))->save($data);
            if($res!==false){
                $this->ajaxReturn(array('status'=>1,'message'=>'回复成功'));
            }else{
                $this->ajaxReturn(array('status'=>1,'message'=>'回复失败'));
            }
        }
    }
	/**
     * 生成推广链接
     */
    public function mkLink()
    {

        /*获取当前渠道id*/
        $channelid=cookie('channelid');
        if(cookie('permissions')==1&&cookie('uid')==1){
            $channelid=12;
        }
        if(IS_POST){
            /*书籍名称*/

            $articleid=I('id');
            $articleInfo=M('article_article')->field('articlename')->where(array('articleid'=>$articleid))->find();
            $_POST['articlename']=$articleInfo['articlename'].','.$articleid;
            /*章节名称*/
            $rchapterid=I('rchapterid');

            if(!I('post.ptname')){
                $this->error('渠道名称不能为空');exit;
            }
            $_POST['ptcost']=I('post.ptcost')+0;
            $channelmodel=D('Channel');
            $ptModel=M('distribution_channel_pt');
            $_POST['channelid']=$channelid;
            /*如果没有设置章节数就默认当前渠道的*/
            if(empty($_POST['readchaptercount'])){
                $channel=$channelmodel->find($channelid);
                $_POST['readchaptercount']=$channel['readchaptercount'];
            }
            $_POST['ptdesc']=$_POST['rchapter'].' | '.$_POST['chapterorder'];
            $_POST['addtime']=time();
            $insertId=$ptModel->add(I('post.'));
            if($insertId){
                /*添加成功后更新当前渠道成本*/
                $channelcost=$channelmodel->field('cost')->find($channelid);
                $channelcost=$channelcost['cost']+I('ptcost');
                $cost['cost']=$channelcost;
                $channelmodel->where('channelid='.$channelid)->save($cost);
                /*添加成功之后修改平台原文链接*/
                $data['ptlink']="http://wap.kyread.com/Article/readChapter/chapter_id/$rchapterid/book_id/$articleid/cid/$channelid/ptid/$insertId.html";
                /*文案链接*/
                $wenanUrl="http://admin.kyread.com/Doc/mkLink/id/$articleid/num/".$_POST['num']."/titleid/".$_POST['titleid']."/picid/".$_POST['picid']."/count/".$_POST['count']."/fcount/".$_POST['fcount']."/ptid/$insertId.html";
                $data['wenanlink']=$wenanUrl;
                $ptModel->where(array('ptid'=>$insertId))->save($data);
                header("location:/Doc/mkLink/id/$articleid/num/".$_POST['num']."/titleid/".$_POST['titleid']."/picid/".$_POST['picid']."/count/".$_POST['count']."/fcount/".$_POST['fcount']."/ptid/$insertId.html");
            }else{
                $this->error=$ptModel->getError();
            }
        }
        $id=I('id',0);  /*articleId*/
        $num=I('num',0)+0;
        $num=$num>20?20:$num;
        $num=$num<1?1:$num;
        $bookModel=D('Book');
        $book=$bookModel->getChapterContent($id,$num+1);
        $bookname=$book[0]['articlename'];
        $bookPic=$bookModel->getCover($id);/*获取书籍的封面*/
        $lastChapter=end($book);/*文案最后的一章节*/
        $channel=$bookModel->getChannelByaid($id);/*频道*/

        $title=D('Title')->getRandTitle($channel);
        $titleid=I('titleid',$title['id'],'intval');
        $titleStr=D('Title')->getTitleByid($titleid);

        //获取标题列表
        $titles = D('Title')->getAllTitles();
        //获取图片列表
        $pics = D('Pic')->getAllPics();

        //获取正文模板列表
        $conts = D('Cont')->getAllPics();
        //获取引导模板列表
        $foucses = D('Foucs')->getAllPics();

        $pic=D('Pic')->getRandPic($channel);
        $picid=I('picid',$pic['id'],'intval');

        $picStr=D('Pic')->getPicByid($picid);

        /*$tplpath=C('DOC_TPL');
        include $tplpath;
        $chapterTplCount=count($chapterTpl);
        $footerTplCount=count($footerTpl);*/
        //正文模板//文案章节
        /*$countC=rand(1,$chapterTplCount);
        $count=I('count',$countC,'intval');

        $ctpl=$chapterTpl[$count];*/
        $cont=D('Cont')->getRandPic($channel);
        $count=I('count',$cont['id'],'intval');
        $ctpl=D('Cont')->getPicByid($count);

        //文案底部关注
        /*$fcountF=rand(1,$footerTplCount);
        $fcount=I('fcount',$fcountF,'intval');
        $ftpl=$footerTpl[$fcount];*/
        $foucs=D('Foucs')->getRandPic($channel);
        $fcount=I('fcount',$foucs['id'],'intval');
        $ftpl=D('Foucs')->getPicByid($fcount);

        $ccount = count($book);
        $bookStr=$this->replaceCont($book,$ctpl);//替换正文内容


        //生成连接
        //原文链接的章节ID
        $rchapterid=($book[$ccount-1]['chapterid']);
        /*ptid*/

        $ptid=I('ptid')+0;
        $ptInfo=M('distribution_channel_pt')->where(array('ptid'=>$ptid))->find();

        /*第一章chapterid daisy*/
        $firstChapter=$book[0]['chapterid'];
        $firstDocUrl="http://wap.kyread.com/Article/readChapter/chapter_id/$firstChapter/book_id/$id/cid/$channelid.html";

        $this->assign('ptlink',$ptInfo['ptlink']);
        $this->assign('ptid',$ptid);

        $this->assign('bookname',$bookname);
        $this->assign('bookStr',$bookStr);
        $this->assign('footer', $ftpl);
        $this->assign('title',$title);
        $this->assign('pic',$pic);

        //列表
        $this->assign('titles',$titles);
        $this->assign('pics',$pics);
        $this->assign('conts',$conts);
        $this->assign('foucses',$foucses);


        $this->assign('id',$id);
        $this->assign('num',$num);
        $this->assign('titleStr',$titleStr);
        $this->assign('picStr',$picStr);
        $this->assign('bookPic',$bookPic);
        $this->assign('lastChapter',$lastChapter);
        $this->assign('rchapterid',$rchapterid);
        $this->assign('count',$count);
        $this->assign('fcount',$fcount);
        $this->assign('wenanUrl',$wenanUrl);
        $this->assign('firstDocUrl',$firstDocUrl);

        $this->display();

    }
	/**
     * 获取推广链接
     */
    public function getmkLink()
    {
        if(IS_AJAX){
            /*获取当前渠道id*/
            $channelid=cookie('channelid');
            if(cookie('permissions')==1&&cookie('uid')==1){
                $channelid=12;
            }
            /*书籍名称*/
            $articleid=I('id');
            $articleInfo=M('article_article')->field('articlename')->where(array('articleid'=>$articleid))->find();
            $_POST['articlename']=$articleInfo['articlename'].','.$articleid;
            /*章节名称*/
            $rchapterid=I('rchapterid');

            if(!I('post.ptname')){
                $this->error('渠道名称不能为空');exit;
            }
            $_POST['ptcost']=I('post.ptcost')+0;
            $channelmodel=D('Channel');
            $ptModel=M('distribution_channel_pt');
            $_POST['channelid']=$channelid;
            /*如果没有设置章节数就默认当前渠道的*/
            if(empty($_POST['readchaptercount'])){
                $channel=$channelmodel->find($channelid);
                $_POST['readchaptercount']=$channel['readchaptercount'];
            }
            $_POST['ptdesc']=$_POST['rchapter'].' | '.$_POST['chapterorder'];
            $_POST['addtime']=time();
            $insertId=$ptModel->add(I('post.'));
            if($insertId){
                /*添加成功后更新当前渠道成本*/
                $channelcost=$channelmodel->field('cost')->find($channelid);
                $channelcost=$channelcost['cost']+I('ptcost');
                $cost['cost']=$channelcost;
                $channelmodel->where('channelid='.$channelid)->save($cost);
                /*添加成功之后修改平台原文链接*/
                $data['ptlink']="http://wap.kyread.com/Article/readChapter/chapter_id/$rchapterid/book_id/$articleid/cid/$channelid/ptid/$insertId.html";
                $res=$ptModel->where(array('ptid'=>$insertId))->save($data);
                if($res!==false){
                    $this->ajaxReturn(array('status'=>1,'url'=>$data['ptlink']));
                }else{
                    $this->ajaxReturn(array('status'=>0,'url'=>'获取地址失败'));
                }
            }else{
                $this->error=$ptModel->getError();
            }
        }
    }
	
	/****李****/
    /**
     *替换正文内容
     **/

    public function replaceCont($book,$ctpl)
    {
        $bookStr='';
        $ccount=count($book);
        for($i=0;$i<$ccount-1;$i++) {
            $chapterStr=str_replace('{chaptername}',$book[$i]['chaptername'],$ctpl);
            $chapterStr=str_replace('{content}',$book[$i]['content'], $chapterStr);
            $bookStr.=$chapterStr;
        }

        return $bookStr;
    }

    /**
     *ajax替换正文模板
     **/

    public function changeModel()
    {
        $data = I('post.');
        $path = explode('/',$data['path']);
        /*dump($data);
        dump($path);*/
        if(isset($data['contid'])){
            $count = intval($data['contid']);
            $bookid = $path[4];            
            $numid = substr($path[6],0,-5);
            $bookModel=D('Book');
            $book=$bookModel->getChapterContent($bookid,$numid+1);

            $ctpl=D('Cont')->getPicByid($count);

            $bookStr=$this->replaceCont($book,$ctpl);
            //var_dump($ctpl);exit;
            if($bookStr){
                echo json_encode(array("status"=>1,"message"=>"success","data"=>$bookStr));
            }else{
                echo json_encode(array("status"=>0,"message"=>"error"));
            }
        }else if(isset($data['foucsid'])){
            $fcount = $data['foucsid'];
            $ftpl=D('Foucs')->getPicByid($fcount);
            if($ftpl){
                echo json_encode(array("status"=>1,"message"=>"success","data"=>$ftpl));
            }else{
                echo json_encode(array("status"=>0,"message"=>"error"));
            }
        }


    }
	
}

<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/4/20 0020
 * Time: 下午 1:15
 */
namespace Admin\Model;
use Think\Model;
class BookModel extends Model
{
    protected $tableName='distribution_obook_obook';

    public function search($pageSize = 15,$bookid='')
    {
        /**************************************** 搜索 ****************************************/
        $where = array();
        //设置搜素频道
        if(I('channel',0)&&I('channel',0)!=''){
            $parameter=array('channel'=>I('channel',0));
           $sortid= $this->getChannelSortID(I('channel',0));
           $where=array(
               'b.sortid'=>array('in',$sortid)
           );
        }else{
            unset($where['sortid']);
            unset($parameter);
        }

        //设置搜索小说名
        if(I('keyword',0)&&I('keyword',0)!=''){
            $where=array(
                'b.articlename'=>array('like',"%".I('keyword',0)."%")
            );

        }




        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)
                      ->join('RIGHT JOIN __ARTICLE_ARTICLE__ b ON a.articleid=b.articleid')
                      ->count();
        $page = new \Think\Page($count, $pageSize,$parameter);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;

        /***************** 排序 *****************/
        $orderby = 'b.lastupdate';      // 默认的排序字段
        $orderway = 'desc';   // 默认的排序方式

        /************************************** 取数据 ******************************************/
        $data['data'] = $this->field('b.articleid,b.articlename,b.size,b.sortid,b.fullflag')
            ->alias('a')
            ->where($where)
            ->join('RIGHT  JOIN __ARTICLE_ARTICLE__ b ON a.articleid=b.articleid')
            ->order("$orderby $orderway")
            ->limit($page->firstRow.','.$page->listRows)->select();
        $data['data']= $this->getBooksinfo($data['data']);
        $data['channel']=I('channel',0);
        if($data['channel']==''){
            $data['channel']='全部';
        }
        return $data;
    }

    //获取书籍列表的书籍信息
    public function getBooksinfo($booklist)
    {
        if(empty($booklist)) return '';
        $tempList='';
        foreach ($booklist as $book){
            $book['cover']=$this->getCover($book['articleid']);
            $book['category']=$this->getCategory($book['sortid']);
            $book['channel']=$this->getChannel($book['sortid']);
            $book['fullflag']=$book['fullflag']?'完本':'连载中';
            $book['info']=$this->getInfoUrl($book['articleid']);
            $tempList[]=$book;
        }

        return $tempList;
    }

    //根据书籍ID获取书籍信息
    public function getbookinfo($articleid)
    {

    }

    //获取书籍封面
    public function getCover($bookID)
    {
        $tmpImgPath = '/' . floor($bookID / 1000) . '/' . $bookID. '/' . $bookID . "s.jpg";

        if(file_exists(C('IMAGE_FILE_PATH') . $tmpImgPath))
        {
            $imgUrl = C('IMAGE_FILE_URL') . $tmpImgPath;
        }
        else
        {
            $imgUrl = C('DEFAULT_ARTICLE_COVER');
        }

        return $imgUrl;

    }
//获取数据所属频道
    public function getChannel($sortid)
    {
        $filePath = C('DIR_PATH') . C('SECONDE_SORT_FILE_PATH');

        include $filePath;

        if(isset($jieqiSort['article']) && $jieqiSort['article'])
        {
            $channel = $jieqiSort['article'][$sortid]['group'];
            switch ($channel){
                case 1:
                    $channel='女频';
                    break;
                case 2:
                    $channel='男频';
                    break;
                case 3:
                    $channel='出版';
                    break;
                default:
                    $channel='其他';
                    break;
            }
        }
        return $channel;

    }
    //获取书籍锁在分类
    public function getCategory($sortid)
    {
        $filePath = C('DIR_PATH') . C('SECONDE_SORT_FILE_PATH');

        include $filePath;

        if(isset($jieqiSort['article']) && $jieqiSort['article'])
        {
            $sortName = $jieqiSort['article'][$sortid]['caption'];
        }

        $sortName = iconv('GBK','UTF-8',$sortName);

        return $sortName;

    }
    //获取小说亲详情页url
    public function getInfoUrl($bookid)
    {
        return 'http://www.mianfeidushu.com/info/'.$bookid.'.html';
    }


    //获取小说前几章节做文案内容
    public function getChapterContent($bookid,$count=3)
    {
        $chapterModel=M('article_chapter');
        $data= $chapterModel->field('chapterid,chaptername,articlename')
                            ->where(array('articleid'=>"$bookid",'chaptertype'=>0))
                            ->order('chapterorder asc')
                            ->limit($count)
                            ->select();
        $tempdata=array();
        foreach ($data as $v){
            $v['content']=$this->getContent($bookid,$v['chapterid']);
            $tempdata[]=$v;
        }
        return $tempdata;
    }

    //获取小说章节内容
    public function getContent($articleID,$chapterID)
    {
        $filePath = C('TXT_FILE_PATH') . '/' . floor($articleID / 1000) . '/' . $articleID. '/' . $chapterID . ".txt";

        $flag = file_exists($filePath);
       //echo $flag;die;

        if($flag)
        {
            $content = file_get_contents($filePath,true);

            $content = mb_convert_encoding($content,'UTF-8',"GBK");
			
			 $content = str_replace("\r\n\r\n","</p><p>　 ",$content);
			 $content = str_replace("\n\n\n\n","</p><p>　 ",$content);

            $content = str_replace("\r\n","</p><p>　 ",$content);

            $content = str_replace("\n\n","</p><p>　 ",$content);

            return  $content ;
        }
        else
        {
            $tmp = M('obook_ocontent')->where(array('ochapterid' => $chapterID))->find();

            $content           = $tmp['ocontent'];
			
			$content = str_replace("\r\n\r\n","</p><p>　 ",$content);
			$content = str_replace("\n\n\n\n","</p><p>　 ",$content);

            $content           = str_replace("\r\n","</p><p>　 ",$content);

            $content           = str_replace("\n\n","</p><p>　 ",$content);

            $result['content'] = $content;

            $size              = strlen($result['content']);

            $result['size']    = $size;
        }

        return  $content ;

    }

    //获取频道拥有的所有的分类ID
    public function getChannelSortID($channel)
    {
        $filePath = C('DIR_PATH') . C('SECONDE_SORT_FILE_PATH');

        include $filePath;
        if(isset($jieqiSort['article']) && $jieqiSort['article'])
        {
            switch ($channel){
            case '女频':
                $group=1;
                break;
            case '男频':
                $group=2;
                break;
            case '通用':
                $group=3;
                break;
            }
            $sortid=array();
            foreach ($jieqiSort['article'] as $k=>$v ){
                if($v['group']==$group){
                    $sortid[]=$k;
                }
            }
            $sortid=implode(',',$sortid);
            return $sortid;
        }
    }

    public function getChannelByaid($bookid)
    {
        $book=M('article_article')->field('sortid')->find($bookid);
        return $this->getChannel($book['sortid']);

    }


}
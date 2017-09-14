<?php

/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/5/2
 * Time: 上午 09:15
 */
namespace Admin\Model;
use Think\Model;
use Think\AjaxPage;
class ChannelModel extends Model
{
    protected $tableName='distribution_channels';

    public function search($where=array(),$pageSize = 15,$order="")
    {
        /**************************************** 搜索 ****************************************/

        if((I('key_word',0)&&I('key_word',0)!='')){
            $where['a.channelname']=array('like','%'.I('key_word').'%');
        }

        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new AjaxPage($count,$pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;



        /************************************** 取数据 ******************************************/
        if($order==""){
            $order = " a.posttime desc,b.remainmoney desc,a.channelid DESC";
        }else{
            $order=$order;
        }
        //echo $order;
        $data['data'] = $this->field('a.*,b.paidmoney,b.remainmoney,c.pname')
            ->alias('a')
            ->join('LEFT JOIN __DISTRIBUTION_PAY_LOG__ b ON a.channelid=b.channelid
                    LEFT JOIN __DISTRIBUTION_CHANNEL_INFO__ c ON a.uid=c.uid')
            ->where($where)
            ->group('a.channelid')
			->order($order)
            ->limit($page->firstRow.','.$page->listRows)->select();
            //echo $data['data'];exit;
            //echo M()->getLastSql();exit;
        return $data;
    }


    /**
     * @param $option
     * 钩子函数
     * 删除之前做的事情
     */

    public function _before_delete($option)
    {


    }



    /**
     * @param string $channelid
     * @return mixed
     * 获取渠道信息
     */
    public function getChannelinfo($channelid='')
    {
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
       $data= $this->find($channelid);
        return $data;
    }



    /**
     * @param string $channelid
     * @return mixed
     * 获取子渠道信息
     */
    public function getSChannel($pchannelid='')
    {
        if(empty($pchannelid)){
            $pchannelid=cookie('channelid');
        }
        $where=array('a.pid'=>$pchannelid);
        $data=$this->search($where);
        return $data['data'];

    }

   
    /**
     * 添加子渠道
     */
    public function addSchannle()
    {

        //判断有没有这个渠道,防止伪造cookie登录
        $count=$this->where(array('uid'=>cookie('uid'),'channelid'=>cookie('channelid')))->count();

        if($count>0||cookie('uid')==1){
            $channelUserModel=M('system_users');

            if(cookie('pid')>0){
                $this->error = '子渠道不能再添加渠道';
                return false;
            }
            //添加渠道前先添加渠道用户
            //如果用户名不为空添加用户名
            if(!empty($_POST['uname'])) {
                $usercount = $channelUserModel->where(array('uname' => I('uname')))->count();

                if ($usercount > 0) {
                    $this->error = '用户名已存在';
                    return false;
                } else {
                    //如果渠道名已存在不添加
                    $channelcount=$this->where(array('channelname'=>I('channelname')))->count();
                    if($channelcount>0){
                        $this->error = '渠道名已存在';
                        return false;
                    }
                    //如果密码为空自动用6个1
                   if(empty($_POST['pass'])){
                       $_POST['pass']='111111';
                   }
                    $_POST['pass']=encrypt($_POST['pass']);
                    $_POST['faceImg']        = 'http://img.mianfeidushu.com/facePic/01.png';
                    $_POST['ischannel']      = '1';
                    $_POST['ischanneladmin'] = '0';
                    $_POST['ischannelbind'] = '1';
                    $uid=$channelUserModel->add($_POST);
                    //添加用户成功后返回uid作为新增渠道用户登录使用
                    if($uid>0){
                        $_POST['uid']=$uid;
                    }else{
                        $this->error=$channelUserModel->getError();
                        return false;
                    }

                }
            }else{
                $this->error='用户名不能为空';
                return false;
            }

            if(cookie('uid')==1){
                $_POST['pid']=0;
                if( empty($_POST['proportion'])){
                    $_POST['proportion']=1;
                }

                if(empty($_POST['readchaptercount'])){
                    $_POST['readchaptercount']=3;
                }

            }else{
                $pchannel=$this->getChannelinfo();
                $_POST['pid']=$pchannel['channelid'];

                if( empty($_POST['proportion'])){
                    $_POST['proportion']=$pchannel['proportion'];
                }

                if(empty($_POST['readchaptercount'])){
                    $_POST['readchaptercount']=$pchannel['readchaptercount'];
                }
            }


            if(empty($_POST['channeltype'])){
                $_POST['channeltype']='weixin';
            }

            $_POST['posttime']=time();
            //生成密钥
            $_POST['secretkey']   = substr(md5($_POST['channelname'] . time() . $_POST['channeltype']),8,16);
           $res= $this->add(I('post.'));
           //添加成功后添加充值记录表,用于后期统计充值记录
            if($res){
                $payLogData['channelid']   = $res;
                $payLogData['channelname'] = $_POST['channelname'];
                $payLogData['paidmoney']   = 0;
                $payLogData['remainmoney']  = 0;
                M('distribution_pay_log')->add($payLogData);
                //edit by muyi 2017/08/17 添加渠道微信token
                //如果是一级代理才添加微信
                if( $_POST['pid']==0){
                    $channelwx['channelid'] =$res;
                    $channelwx['token']=md5($_POST['uname'].time());
                    M('distribution_channel_wx')->add($channelwx);
                }
                return true;
            }else{
              return false;
            }
        }else{
            $this->error='没有权限,请联系管理员!';
            return false;
        }
    }

    /**
     * @param $pchannlelist 主渠道列表
     * @return array    主渠道信息汇总
     * 获取主渠道信息
     */

    public function getSumChannelList($pchannlelist)
    {
        $data=array();
        foreach ($pchannlelist as $k => $v){
           $schannel=$this->getSChannel($v['channelid']);
           if(empty($schannel)){
               $data[$k]=$v;
           }else{
               foreach ($schannel as $k1=>$v1){
                   $v['paidmoney']+=$v1['paidmoney'];
                   $v['remainmoney']+=$v1['remainmoney'];
               }
               $data[$k]=$v;
           }
        }
        return $data;
    }

    /**
     * @param $pchannlelist 渠道列表
     * @param int $ischannel  是不是渠道 默认不是渠道用户
     * @return array 返回渠道充值记录数列表
     */
    public function getSumpayChannelList($pchannlelist,$ischannel=0)
    {

        $data=array();
            foreach ($pchannlelist as $k => $v) {
                $temp=$this->getChannelSumpay($v['channelid']);
                $v['paylogsum'] = $temp['paylogsum'];

                $v['unpaylogsum'] = $temp['unpaylogsum'];

                $v['todaypaylogsum'] = $temp['todaypaylogsum'];

                $v['todayunpaylogsum'] =$temp['todayunpaylogsum'];

                if($ischannel==0){
                    //如果是管理员增加子渠道的记录数
                    $schannelid = $this->getSchannelid($v['channelid']);
                    if(!empty($schannelid)){
                        foreach ($schannelid as $v1) {
                            $temp=$this->getChannelSumpay($v1);
                            $v['paylogsum'] += $temp['paylogsum'];

                            $v['unpaylogsum'] += $temp['unpaylogsum'];

                            $v['todaypaylogsum'] += $temp['todaypaylogsum'];

                            $v['todayunpaylogsum'] +=$temp['todayunpaylogsum'];
                        }
                    }

                }
                $data[$k]=$v;
            }

        return $data;

    }
        



    /**
     * @param $pchannelid
     * 获取子渠道ID
     */
    public function getSchannelid($pchannelid)
    {	
		$where=array('pid'=>$pchannelid);
        $schannel=$this->field('channelid')->where($where)->select();
        $sid=array();
        foreach ($schannel as $v){
            $sid[]=$v['channelid'];
        }
        return $sid;
    }


    /**
     * 获取每个渠道总的充值记录数
     */
    public function getChannelSumpay($channelid)
    {
        $data['paylogsum'] = $this->getChannelPayLogSum($channelid);

        $data['unpaylogsum'] = $this->getChannelUnPayLogSum($channelid);

        $data['todaypaylogsum'] = $this->getChannelTodayPayLogSum($channelid);

        $data['todayunpaylogsum'] = $this->getChannelTodayUnPayLogSum($channelid);
        return $data;
    }


    /**
     * @param $channelID
     * @return mixed
     * 渠道充值情况
     * 总充值记录数
     */

    private function getChannelPayLogSum($channelID)
    {
        $condition['channelid'] = $channelID;

        $condition['payflag']   = 1;

        $count = M('distribution_pay_paylog')->where($condition)->count();

        return $count;
    }

    /**
     * @param $channelID
     * @return mixed
     * 总充值未成功记录
     */

    private function getChannelUnPayLogSum($channelID)
    {
        $condition['channelid'] = $channelID;

        $condition['payflag']   = 0;

        $count = M('distribution_pay_paylog')->where($condition)->count();

        return $count;
    }

    /**
     * @param $channelID
     * @return mixed
     * 当天充值成功记录
     */
    private function getChannelTodayPayLogSum($channelID)
    {
        $todayTime              = strtotime(date('Y-m-d'));

        $condition['buytime']   = array('egt',$todayTime);

        $condition['channelid'] = $channelID;

        $condition['payflag']  = 1;

        $count = M('distribution_pay_paylog')->where($condition)->count();

        return $count;
    }

    /**
     * @param $channelID
     * @return mixed
     * 当天没有充值成功的记录数
     */

    private function getChannelTodayUnPayLogSum($channelID)
    {
        $todayTime              = strtotime(date('Y-m-d'));

        $condition['buytime']   = array('egt',$todayTime);

        $condition['channelid'] = $channelID;

        $condition['payflag']  = 0;

        $count = M('distribution_pay_paylog')->where($condition)->count();

        return $count;
    }



    /**
     * @param $pchannlelist
     * @param int $ischannel是否是渠道用户
     * 获取渠道用户注册信息
     */

    public function getSumuserChannelList($pchannlelist,$ischannel=0)
    {

        $data=array();
        foreach ($pchannlelist as $k => $v) {
            $v['usersum'] =$this->getChannelSumuser($v['channelid']);
            $v['todayusersum'] = $this->getTodayChannelSumuser($v['channelid']);
            $v['followusersum']=$this->getChannelSumFollowuser($v['channelid']);
            $v['todayfollowusersum']=$this->getTodayChannelSumFollowuser($v['channelid']);

            if($ischannel==0){
                //如果是管理员增加子渠道的记录数
                $schannelid = $this->getSchannelid($v['channelid']);
                if(!empty($schannelid)){
                    foreach ($schannelid as $v1) {
                        $v['usersum'] +=$this->getChannelSumuser($v1);
                        $v['todayusersum'] += $this->getTodayChannelSumuser($v1);
                        $v['followusersum']+=$this->getChannelSumFollowuser($v1);
                        $v['todayfollowusersum']+=$this->getTodayChannelSumFollowuser($v1);
                    }
                }

            }
            $data[$k]=$v;
        }

        return $data;
    }


    /**
     * @param $channelid
     * 获取每个渠道引导的用户记录
     */
    public function getChannelSumuser($channelid)
    {
        $count = M('distribution_system_users')->where(array('channelid' => $channelid))->count();

        return $count;

    }


    /**
     * @param $channelid
     * 获取渠道当天的引导的用户记录
     */

    public function getTodayChannelSumuser($channelid)
    {
        $todayTime              = strtotime(date('Y-m-d'));

        $condition['regdate']   = array('egt',$todayTime);

        $condition['channelid'] = $channelid;

        $count = M('distribution_system_users')->where($condition)->count();

        return $count;

    }


    /**
     * @param $channelid
     * 获取渠道总的关注用数
     */
    public function getChannelSumFollowuser($channelid)
    {
        $where=array(
               'channelid'=>$channelid,
                'isfollow'=>1,
        );
        $count=M('distribution_system_users')->where($where)->count();
        return $count;
    }
    /**
     * @param $channelid
     * 获取渠道加子渠道总的关注用数
     */
    public function getChannelAllFollowuser($channelid)
    {
        $channelids=$this->getSchannelid($channelid);
        if(empty($channelids)){
            $channelidStr=$channelid;
        }else{
            $channelidStr=join(',',$channelids);
            $channelidStr=$channelid.','.$channelidStr;
        }
        $count=M('distribution_system_users')->where("channelid IN ({$channelidStr}) AND isfollow=1")->count();
        return $count;
    }


    /**
     * @param $channelid
     * @return mixed
     * 获取今天关注人数
     */
    public function getTodayChannelSumFollowuser($channelid)
    {
        $todayTime              = strtotime(date('Y-m-d'));
        $where=array(
            'channelid'=>$channelid,
            'isfollow'=>1,
            'regdate'=>array('gt',$todayTime)
        );
        $count=M('distribution_system_users')->where($where)->count();
        return $count;
    }



    /**
     * 渠道结算
     */

    public function settlement($channelid)
    {
        //获取当前渠道和子渠道的收益信息
        $where=array('a.channelid='.$channelid.' or a.pid='.$channelid);
        $data=$this->search($where,PHP_INT_MAX);
        $data=$data['data'];
        //遍历结算子渠道
        foreach ($data as $k =>$v){
            $v['paidmoney']+=$v['remainmoney']*$v['proportion'];
            $v['remainmoney']=0;
            $v['lastpaytime']=time();
            $paymodel=M('distribution_pay_log');
            $res=$paymodel->where(array('channelid'=>$v['channelid']))->save($v);
           if($res===false){
               $this->error=$paymodel->getError();
               return false;
           }
        }
        return true;
    }

    /**
     * 渠道一键结算
     */
    public function batSettlement()
    {
        $where=array('pid'=>0);
        $data=$this->field('channelid')->where($where)->select();
        foreach ($data as $v){
            $res=$this->settlement($v['channelid']);
            if($res==false){
                echo $this->error;
                return false;
            }
        }
        return true;
    }

    /**
     * @param $channelid
     * @return mixed
     * 获取渠道的财务信息
     */
    public function getChannelBankinfo($channelid)
    {
        $where=array('a.channelid'=>$channelid);
        $data = $this->field('a.channelid,a.channelname,a.uid as userid,c.*')
            ->alias('a')
            ->where($where)
            ->join('LEFT JOIN __DISTRIBUTION_CHANNEL_INFO__ c ON a.uid=c.uid')
            ->select();

        return $data[0];

    }


    /**
     * @param $pchannlelist
     * @param int $ischannel
     * @return array
     * 获取渠道的推广信息
     */
    public function getChanneInfolList($pchannlelist,$ischannel=0)
    {

        $data=array();
        foreach ($pchannlelist as $k => $v) {
            $temp=$this->getChannelSumpay($v['channelid']);
            $v['paylogsum'] = $temp['paylogsum'];

            $v['unpaylogsum'] = $temp['unpaylogsum'];

            $v['todaypaylogsum'] = $temp['todaypaylogsum'];

            $v['todayunpaylogsum'] =$temp['todayunpaylogsum'];

            $v['usersum'] =$this->getChannelSumuser($v['channelid']);
            $v['todayusersum'] = $this->getTodayChannelSumuser($v['channelid']);
            $v['followusersum']=$this->getChannelSumFollowuser($v['channelid']);
            $v['todayfollowusersum']=$this->getTodayChannelSumFollowuser($v['channelid']);

            if($ischannel==0){
                //如果是管理员增加子渠道的记录数
                $schannelid = $this->getSchannelid($v['channelid']);
                if(!empty($schannelid)){
                    foreach ($schannelid as $v1) {
                        $temp=$this->getChannelSumpay($v1);
                        $v['paylogsum'] += $temp['paylogsum'];

                        $v['unpaylogsum'] += $temp['unpaylogsum'];

                        $v['todaypaylogsum'] += $temp['todaypaylogsum'];

                        $v['todayunpaylogsum'] +=$temp['todayunpaylogsum'];

                        $v['usersum'] +=$this->getChannelSumuser($v1);
                        $v['todayusersum'] += $this->getTodayChannelSumuser($v1);
                        $v['followusersum']+=$this->getChannelSumFollowuser($v1);
                        $v['todayfollowusersum']+=$this->getTodayChannelSumFollowuser($v1);
                    }
                }

            }
            $data[$k]=$v;
        }

        return $data;
    }
	//获取channelids数组
    public function getchannelidArr($where=array()){
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
            
        foreach($channelids as $val){
            $channelidArr[]=$val['channelid'];
        }
        return $channelidArr;
    }

    //当日读者
    public function getCurDayReader($where=array()){
        $today_start=strtotime(date('Y-m-d'));
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $count=M('DistributionSystemUsers')
            ->where(array('channelid'=>array('IN',$channelid),'regdate'=>array('egt',$today_start)))
            ->count();
        return $count;
    }
    //当日关注
    public function getCurDayFocus($where=array()){
        $today_start=strtotime(date('Y-m-d'));
        $channelids=$this->getchannelidArr($where);
        $count=M('DistributionSystemUsers')
            ->where(array('channelid'=>array('IN',$channelids),'regdate'=>array('egt',$today_start),'isfollow'=>1))
            ->count();
        return $count;
    }
    //累计关注
    public function getAllFocus($where=array()){
        $channelids=$this->getchannelidArr($where);
        $count=M('DistributionSystemUsers')
            ->where(array('channelid'=>array('IN',$channelids),'isfollow'=>1))
            ->count();;
        return $count;
    }
    //当日充值
    public function getDaySumPay($where=array()){
        $today_start=strtotime(date('Y-m-d'));

        $channelids=$this->getchannelidArr($where);
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>array('IN',$channelids),'buytime'=>array('egt',$today_start)))
            ->select();
        $daySumPay=0;
        foreach($data as $val){
            $daySumPay+=$val['money'];
        }
        return $daySumPay;

    }
    //本月充值
    public function getMonthSumPay($where=array()){
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $channelids=$this->getchannelidArr($where);
        $data=M('DistributionPayPaylog')->field('money')
                ->where(array('payflag'=>1,'channelid'=>array('IN',$channelids),'buytime'=>array('BETWEEN',"{$thismonth_start},{$thismonth_end}")))
                ->select();
        $monthSumPay=0;
        foreach($data as $val){
            $monthSumPay+=$val['money'];
        }
        return $monthSumPay;
    }
    //累计充值
    public function getSumPay($where=array()){
        $channelids=$this->getchannelidArr($where);
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>array('IN',$channelids)))
            ->select();
        $sumPay=0;
        foreach($data as $val){
            $sumPay+=$val['money'];
        }
        return $sumPay;
    }
    //累计成本
    public function getCost($where=array()){
        $channelids=$this->getchannelidArr($where);
        /* $data=M('DistributionPayPaylog')->alias('p')
            ->field('c.*,p.*')
            ->join('RIGHT JOIN __DISTRIBUTION_CHANNELS__ c ON c.channelid=p.channelid')
            ->where(array('c.channelid'=>array('IN',$channelids)))
            ->select(); */
		$data=$this->where(array('channelid'=>array('IN',$channelids)))->select();
        $cost=0;
        foreach($data as $val){
            $cost+=$val['cost'];
        }
        return $cost;
    }
    /***
    *获取子渠道结算信息
    **/
    public function getNextMoney($channelid,$ischannel=0,$issum=0,$pageSize=15,$starttime='',$endtime='',$dailiname='',$isoverpay=0){
        header('content-type:text/html;charset=utf-8');
        //echo 111;exit;
        $todayTime=strtotime(date('Y-m-d'))-1;
        //$todaydate = strtotime(date('Y-m-d'));
        $beforeTime=$todayTime-30*24*60*60;
        if(($ischannel==1 || $issum==1)&&cookie('cpid')==0){
            $channelids=$this->field('channelid')
                ->where(array('pid'=>$channelid))
                ->select();
            foreach($channelids as $val){
                $channelidArr[]=$val['channelid'];
            }
        }

        if($isoverpay==2){
            $status=2;
        }elseif($isoverpay==0){
            $status=0;
        }

//echo $starttime;

        if(!empty($starttime)){
            $starttime = strtotime("{$starttime}");
            //echo $starttime;
        }

        if(!empty($endtime)){
            $endtime = strtotime("{$endtime}");
        }
        //var_dump($channelidArr);exit;
        /************************************* 翻页 ****************************************/
        $where['channelid']=array('IN',$channelidArr);
        if(!empty($starttime)&&!empty($endtime)){
           
                $where['paydate'] = array('BETWEEN',"{$starttime},{$endtime}");
                if($starttime==$endtime){
                    $where['paydate'] = $starttime;
                }
        }elseif(empty($starttime)&&!empty($endtime)){
                $starttime = date('Y-m-d',$todayTime-24*60*60);
                $where['paydate'] = array('LT',"{$endtime}");
        }elseif(!empty($starttime)&&empty($endtime)){
                $endtime = $todayTime;
                $where['paydate'] = array('BETWEEN',"{$starttime},{$endtime}");
        }elseif(empty($starttime)&&empty($endtime)){
                $starttime = $todayTime-24*60*60;
                $endtime = $todayTime;

                $where['paydate'] = array('BETWEEN',"{$starttime},{$endtime}");
                //var_dump($where['buytime']);exit;
        }
        if(!empty($dailiname)){

            $where2['channelid'] = $dailiname;
            
            $cinfo = M('distribution_channels')->where($where2)->find();
            if($channelid == $cinfo['pid']){
                $where['channelid']=$dailiname;
            }
                                
        }
        //var_dump($where);exit;
        //$where['buytime']=array('BETWEEN',"{$beforeTime},{$todayTime}");
        $where['status']=$status;
        $count = M('distribution_payment')->where($where)->group('channelid,FROM_UNIXTIME(paydate,"%Y-%m-%d")')->select();
        //echo M()->getLastSql();exit;
        //var_dump($count);exit;
      //
        $count=count($count);
        //echo $count;
        //echo $pageSize;
        $page = new AjaxPage($count,$pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;
        //var_dump($page);
        //$data['channelname']=$this->field('channelname')->where(array('channelid'=>array('IN',$channelidArr)))->select();
        $data['data']=M('distribution_payment')
            ->field('paymoney,proportion,status,channelid,paydate,asktime,askmoney')
            ->where(array('status'=>$status,'channelid'=>$where['channelid'],'paydate'=>array('BETWEEN',"{$starttime},{$endtime}")))
            ->group('channelid,FROM_UNIXTIME(paydate,"%Y-%m-%d")')
            ->order('paydate DESC')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
            
            //var_dump($data);exit;
          
            //echo M()->getLastSql();
            //echo $page->listRows;
            //var_dump($data['data']);exit;
        return $data;

    }

    /*
     * 获取渠道待结算信息
     * */
    public function getRemainMoney($channelid,$ischannel=0,$issum=0,$pageSize=15){
        header('content-type:text/html;charset=utf-8');
        $todayTime=strtotime(date('Y-m-d'));
        $beforeTime=$todayTime-30*24*60*60;
        if($ischannel==0 || $issum==1){
            $channelids=$this->field('channelid')
                ->where(array('channelid'=>$channelid,'pid'=>$channelid,'_logic'=>'OR'))
                ->select();
            foreach($channelids as $val){
                $channelidArr[]=$val['channelid'];
            }
        }else{
            $channelidArr[]=$channelid;
        }
        //var_dump($channelidArr);exit;
        /************************************* 翻页 ****************************************/
        $where['channelid']=array('IN',$channelidArr);
        $where['buytime']=array('BETWEEN',"{$beforeTime},{$todayTime}");
        $where['payflag']=1;
        $count = M('distribution_pay_paylog')->where($where)->group('FROM_UNIXTIME(buytime,"%Y-%m-%d")')->select();
        //var_dump($count);
      //
        $count=count($count);
        $page = new \Think\Page($count,$pageSize);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        //$data['channelname']=$this->field('channelname')->where(array('channelid'=>array('IN',$channelidArr)))->select();
        $where2['payflag']=1;
        $where2['channelid']=array('IN',$channelidArr);
        $where2['buytime']=array('BETWEEN',"{$beforeTime},{$todayTime}");

        $data['data']=M('distribution_pay_paylog')
            ->field('count(money) as count,channelid,buytime,sum(money) as summoney')
            ->where($where2)
            ->group('FROM_UNIXTIME(buytime,"%Y-%m-%d")')
            ->order('buytime DESC')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
            //echo M()->getLastSql();
            //echo $page->nowPage;
            //var_dump($data['data']);
        return $data;
    }

	
	  /**
     * 获取渠道微信公众号配置信息
     */
    public function getWxInfo($channelid='')
    {
        //如果$channelid为空就从cookie获取
        $channelid=empty($channelid)?cookie('channelid'):$channelid;
        $channelWxModel=M('distribution_channel_wx');
        $data=$channelWxModel->where(array('channelid'=>$channelid))->find();//获取渠道微信公众号信息
        return $data;

    }

	
	
	
    /**
     * 添加平台用于表别渠道分发途径
     */
    public function addPt()
    {
        //获取当前渠道id
       $channelid=cookie('channelid');
       $ptModel=M('distribution_channel_pt');
        $_POST['channelid']=$channelid;
        //如果没有设置章节数就默认当前渠道的
        if(empty($_POST['readchaptercount'])){
            $channel=$this->find($channelid);
            $_POST['readchaptercount']=$channel['readchaptercount'];
        }
        $_POST['addtime']=time();
        $data=$ptModel->add(I('post.'));
        if($data){
            //添加成功后更新当前渠道成本
            $channelcost=$this->field('cost')->find($channelid);
            $channelcost=$channelcost['cost']+I('ptcost');
            $cost['cost']=$channelcost;
            $this->where('channelid='.$channelid)->save($cost);
            return $data;
        }else{
            $this->error=$ptModel->getError();
            return false;
        }

    }
    
    /**
     * 渠道推广平台获取
     */

    public function getPtList($channelid='')
    {
        if($channelid==''){
            $channelid=cookie('channelid');
        }
        $ptModel=M('distribution_channel_pt');
        $payModel=D('Pay');
        $userModel=D('User');

        //分页
        $count =  $ptModel->where(array('channelid'=>$channelid))->count();
        $page = new AjaxPage($count, 10);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();

        //获取平台推广信息
        $ptlist=$ptModel->where(array('channelid'=>$channelid))->order('ptid DESC') ->limit($page->firstRow.','.$page->listRows)->select();
        foreach ($ptlist as $k=>$v){
            $ptlist[$k]['sumpay']=$payModel->getPtsumPay($v['ptid'])+0;
            $ptlist[$k]['paycount']=$payModel->getPtPayCount($v['ptid'])+0;
            $usercount=$userModel->getPtSumUserCount($v['ptid']);
            $ptlist[$k]['sumuser']=$usercount['sumuser'];
            $ptlist[$k]['sumfollow']=$usercount['sumfollow'];
			/*Daisy*/
            $article=$v['articlename'];
            $article=explode(',',$article);
            $ptlist[$k]['articleid']=$article[1];
            $ptlist[$k]['articlename']=$article[0];
            $ptdesc=$v['ptdesc'];
            $ptdesc=explode(' | ',$ptdesc);
            $ptlist[$k]['chaptername']=$ptdesc[0];
            $ptlist[$k]['chapterorder']=$ptdesc[1];
           
        }
        $data['ptlist']=$ptlist;
		/* echo'<pre>';
       var_dump($ptlist);exit; */
        return $data;
        
    }
	/* 结算单 */
	public function getPaymentInfo($time,$channelid){
        $channelids=$this->field('channelid,channelname,uid')
            ->where(array('channelid'=>$channelid,'pid'=>$channelid,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelidArr[]=$val['channelid'];
        }
        $data=M('distribution_pay_paylog')->alias('p')
            ->field('p.payid,p.paytype,p.buyname,p.channelid,p.buytime,p.money,c.uid,c.channelname,u.name')
            ->join('LEFT JOIN __DISTRIBUTION_CHANNELS__ c ON p.channelid=c.channelid')
            ->join('LEFT JOIN __DISTRIBUTION_SYSTEM_USERS__ u ON p.buyid=u.uid')
            ->where(array('p.channelid'=>array('IN',$channelidArr),'FROM_UNIXTIME(p.buytime,"%Y-%m-%d")'=>$time,'p.payflag'=>1))
            ->select();
        return $data;
	}
	
	/*
     * 获取渠道昨日充值金额
     * */
    public function yesterdaySumPay($channelid){
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $channelidArr=$this->getchannelidArr($channelid);
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>array('IN',$channelidArr),'buytime'=>array('BETWEEN',"{$yesterdayTime},{$today_start}")))
            ->select();
        $yesterdaySumPay=0;
        foreach($data as $v){
            $yesterdaySumPay+=$v['money'];
        }
        return $yesterdaySumPay;
    }
	
	/*获取渠道当日充值金额*/
    /* public function getDaySumPayByChannelid($channelid){
        $today_start=strtotime(date('Y-m-d'));
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>$channelid,'buytime'=>array('egt',$today_start)))
            ->select();
        $daySumPay=0;
        foreach($data as $v){
            $daySumPay+=$v['money'];
        }
        return $daySumPay;
    } */
	
	/*
     * 获取自渠道充值金额
     * */
    /* public function getChannelSumPaylog($channelid){
        $condition['channelid'] = $channelid;
        $condition['payflag']   = 1;
        $data = M('distribution_pay_paylog')->field('money')->where($condition)->select();
        $channelSumPay=0;
        foreach($data as $v){
            $channelSumPay+=$v['money'];
        }
        return $channelSumPay;
    } */
	/*获取渠道当日充值金额*/
    public function getDaySumPayByChannelid($channelid){
        $today_start=strtotime(date('Y-m-d'));
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>$channelid,'buytime'=>array('egt',$today_start)))
            ->select();
        $daySumPay=0;
        foreach($data as $v){
            $daySumPay+=$v['money'];
        }
        $count=count($data);
        $data_A=array('todaypaylogsum'=>$daySumPay,'todaypaylogcount'=>$count);
        return $data_A;
    }
	/*
     * 获取自渠道充值金额
     * */
    public function getChannelSumPaylog($channelid){
        $condition['channelid'] = $channelid;
        $condition['payflag']   = 1;
        $data = M('distribution_pay_paylog')->where($condition)->select();
        $channelSumPay=0;
        foreach($data as $v){
            $channelSumPay+=$v['money'];
        }
        $count=count($data);
        $data_A=array('paylogsum'=>$channelSumPay,'paylogcount'=>$count);
        return $data_A;
    }

    /**
     * @param $pchannlelist
     * @return array
     * 代理列表ajax
     */
    public function getChanneInfolListCombine($pchannlelist)
    {

        $data=array();
        foreach ($pchannlelist as $k => $v) {
            $daySumPay=$this->getDaySumPayByChannelid($v['channelid']);
            $sumPay=$this->getChannelSumPaylog($v['channelid']);
            $v['paylogsum'] = $sumPay['paylogsum'];
            $v['paylogcount']=$sumPay['paylogcount'];
            $v['todaypaylogsum'] = $daySumPay['todaypaylogsum'];
            $v['todaypaylogcount'] = $daySumPay['todaypaylogcount'];
            //edit by muyi 增加显示渠道用户登录名
            $user=M('system_users')->field('uname')->find($v['uid']);
            $v['uname']=$user['uname'];
            /* $v['usersum'] =$this->getChannelSumuser($v['channelid']);
            $v['todayusersum'] = $this->getTodayChannelSumuser($v['channelid']);
            $v['followusersum']=$this->getChannelSumFollowuser($v['channelid']);
            $v['todayfollowusersum']=$this->getTodayChannelSumFollowuser($v['channelid']); */

            $data[$k]=$v;
        }

        return $data;
    }
}

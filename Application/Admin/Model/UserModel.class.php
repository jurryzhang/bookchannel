<?php
/**
 * creat by muyi 2017/05/09
 */
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
    protected $tableName='distribution_system_users';

    /**
     * @param $uid
     * @return mixed
     *根据用户ID获取用户名
     */
    public function getNameById($uid)
    {
        $data=$this->field('name')->find($uid);
        return $data['name'];
    }

    /**
     * @param $uid
     * @return int
     * 获取用户总的充值金额
     */
    public function getUserSummoney($uid)
    {
        $where=array(
            'buyid'=>$uid,
            'payflag'=>1
        );
        $paylist=M('distribution_pay_paylog')->field('money')->where($where)->select();
        $sumpay=0;
        foreach ($paylist as $v){
            $sumpay+=$v['money'];
            }
         return $sumpay;
    }


    /**
     * 获取平台引导人数和关注人数
     */
    public function getPtSumUserCount($ptid)
    {
       
        $count['sumuser']=$this->where(array('ptid'=>$ptid))->count();
        $count['sumfollow']=$this->where(array('ptid'=>$ptid,'isfollow'=>1))->count(); 
		

        return$count;
    }
	/*
     * 获取用户余额
     * */
    public function getBalanceByuid($uid){
        $balance=$this->field('egold')->where(array('uid'=>$uid))->find();
        return $balance;
    }
	
	
	 /**
     *根据用户id获取用户名
     */

    public function getUnameByID($uid)
    {
        $data=$this->field('uname,name')->find($uid);
        return $data;
    }

    /**
     * 获取相应公众号级别的所有用户信息
     */

    public function getUserListByfromid($fromid)
    {
        if(empty($fromid)){
            $fromid=cookie('channelid');
        }
        $schannelid=D('Channel')->getSchannelid($fromid);
        $schannelid[]=$fromid;
        $schannelid=implode(',',$schannelid);

        $userlist=$this->where('channelid in ('.$schannelid.')')->select();
        return $userlist;
    }

    /**
     * 获取相应公众号级别的所有关注用户的用户名
     */

    public function getUserUnameListByfromid($fromid)
    {
        if(empty($fromid)){
            $fromid=cookie('channelid');
        }
        $schannelid=D('Channel')->getSchannelid($fromid);
        $schannelid[]=$fromid;
        $schannelid=implode(',',$schannelid);

        $userUnameList=$this->field('uname,name')->where('channelid in ('.$schannelid.') AND isfollow =1')->select();

        return $userUnameList;
    }
	
	/**
     * 今日签到人数
     */
    public function getdaySignCount($channelid='')
    {

        $today=strtotime(date('Y-m-d',time()));
        if(empty($channelid)){
            $signcount=$this->where('signtime >'.$today)->count();
        }else{

            $schannelid=D('Channel')->getSchannelid($channelid);
            $schannelid[]=$channelid;
            $schannelid=implode(',',$schannelid);
            //var_dump('signtime >'.$today.' AND channelid in('.$schannelid.')');exit;
            $signcount=$this->where('signtime >'.$today.' AND channelid in('.$schannelid.')')->count();
        }
        return $signcount;
    }
/**************************start用户统计***********************************************************************************************************/
    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 所有用户
     */
    public function getSumUser($channelid,$ischannel=0,$condition=array())
    {
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        $data=$this->where($condition)->count();

        return $data;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 所有已关注用户
     */
    public function getSumUserFocus($channelid,$ischannel=0,$condition=array())
    {
        $condition['isfollow']=1;
        $sumUserFocus=$this->getSumUser($channelid,$ischannel,$condition);
        return $sumUserFocus;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 本月新增用户
     */
    public function getMonthUser($channelid, $ischannel = 0, $condition = array())
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['regdate']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthUser=$this->getSumUser($channelid,$ischannel,$condition);
        return $monthUser;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 本月新增关注用户
     */
    public function getMonthUserFocus($channelid, $ischannel = 0)
    {
        $condition['isfollow']=1;
        $monthUserFocus=$this->getMonthUser($channelid,$ischannel,$condition);
        return $monthUserFocus;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 昨日新增用户
     */
    public function getYesterdayUser($channelid, $ischannel = 0, $condition = array())
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['regdate']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yesterdayUser=$this->getSumUser($channelid,$ischannel,$condition);
        return $yesterdayUser;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 昨日新增关注用户
     */
    public function getYesterdayUserFocus($channelid, $ischannel = 0)
    {
        $condition['isfollow']=1;
        $yesterdayUserFocus=$this->getYesterdayUser($channelid,$ischannel,$condition);
        return $yesterdayUserFocus;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 当日新增用户
     */
    public function getDayUser($channelid, $ischannel = 0, $condition = array())
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['regdate']=array('egt',$today_start);
        $daySumUser=$this->getSumUser($channelid,$ischannel,$condition);
        return $daySumUser;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 当日新增关注用户
     */
    public function getDayUserFocus($channelid, $ischannel = 0)
    {
        $condition['isfollow']=1;
        $dayUserFocus=$this->getDayUser($channelid,$ischannel,$condition);
        return $dayUserFocus;
    }


    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @param int $sex
     * @return mixed
     * 所有用户性别分类
     */
    public function getSumUserSex($channelid,$ischannel=0,$condition=array(),$sex=0)
    {
        if($sex==1){
            $condition['sex']=1;
        }elseif($sex==2){
            $condition['sex']=2;
        }else{
            $condition['sex']=0;
        }
        $data=$this->getSumUser($channelid,$ischannel,$condition);
        return $data;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param int $sex
     * @return mixed
     * 本月用户性别分类
     */
    public function getMonthUserSex($channelid, $ischannel = 0, $sex = 0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['regdate']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthUserSex=$this->getSumUserSex($channelid,$ischannel,$condition,$sex);
        return $monthUserSex;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @param int $sex
     * @return mixed
     * 昨日用户性别分类
     */
    public function getyesterdayUserSex($channelid, $ischannel = 0, $sex = 0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['regdate']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $monthUserSex=$this->getSumUserSex($channelid,$ischannel,$condition,$sex);
        return $monthUserSex;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @param int $sex
     * @return mixed
     * 当日用户性别分类
     */
    public function getDayUserSex($channelid, $ischannel = 0, $sex = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['regdate']=array('egt',$today_start);
        $dayUserSex=$this->getSumUserSex($channelid,$ischannel,$condition,$sex);
        return $dayUserSex;
    }


/*SELECT u.*,p.* FROM jieqi_distribution_system_users AS u LEFT JOIN jieqi_distribution_pay_paylog AS p ON u.uid=p.buyid WHERE p.payflag=1 AND u.isfollow=1 GROUP BY u.uid*/
    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     *所有已付费的用户
     */
    public function getSumUserPay($channelid, $ischannel = 0, $condition = array())
    {
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        
		/*$condition['p.payflag']=1;
         $condition['u.isfollow']=1;
        $data=$this->alias('u')
            ->field('u.uid,u.uname,u.name,u.regdate,u.isfollow,p.payflag,p.buyid,p.buyname')
            ->join('LEFT JOIN __DISTRIBUTION_PAY_PAYLOG__ p ON u.uid=p.buyid')
            ->where($condition)
            ->group('u.uid')
            ->select(); */
		
		$condition['isfollow']=1;
		$uidData=$this->field('uid')->where($condition)->select();

        foreach ($uidData as $k=>$v) {
            $uidData[$k]=$v['uid'];
        }
        $where['buyid']=array('IN',$uidData);
        $where['payflag']=1;
        $data=M('distribution_pay_paylog')->field('buyid')->where($where)->group('buyid')->select();
        if(!$data){
            
            $count = 0;
        }else{

            $count=count($data);
        }
        
        return $count;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 本月已付费用户
     */
    public function getMonthUserPay($channelid, $ischannel = 0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['regdate']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthUserPay=$this->getSumUserPay($channelid,$ischannel,$condition);
        return $monthUserPay;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 昨日已付费用户
     */
    public function getYesterdayUserPay($channelid, $ischannel = 0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['regdate']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yesterdayUserPay=$this->getSumUserPay($channelid,$ischannel,$condition);
        return $yesterdayUserPay;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 当日已付费用户
     */
    public function getDayUserPay($channelid, $ischannel = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['regdate']=array('egt',$today_start);
        $dayUserPay=$this->getSumUserPay($channelid,$ischannel,$condition);
        return $dayUserPay;
    }


    /**
     * @param $channelid
     * @param int $ischannel
     * @return array
     * 当日新增用户统计
     */
    public function getDayUserInfo($channelid, $ischannel = 0)
    {
        $data=array();

        $data['dayUser']=$this->getDayUser($channelid,$ischannel);                                       /*当日新增用户*/
        $data['dayUserFocus']=$this->getDayUserFocus($channelid,$ischannel);                             /*当日新增关注用户*/
        $data['dayUserSex1']=$this->getDayUserSex($channelid,$ischannel,1);                          /*当日用户性别分类1*/
        $data['dayUserSex2']=$this->getDayUserSex($channelid,$ischannel,2);                          /*当日用户性别分类2*/
        $data['dayUserSex0']=$this->getDayUserSex($channelid,$ischannel,0);                          /*当日用户性别分类0*/
        $data['dayUserPay']=$this->getDayUserPay($channelid, $ischannel);                                /*当日已付费用户*/

        return $data;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return array
     * 用户统计
     */
    public function getUserInfo($channelid, $ischannel = 0)
    {
        $data=array();

        $dayUserInfo=$this->getDayUserInfo($channelid, $ischannel);

        $data['sumUser']=$this->getSumUser($channelid,$ischannel);                                       /*所有用户*/
        $data['sumUser']=$data['sumUser']-$dayUserInfo['dayUser'];
        $data['sumUserFocus']=$this->getSumUserFocus($channelid,$ischannel);                             /*所有已关注用户*/
        $data['sumUserFocus']=$data['sumUserFocus']-$dayUserInfo['dayUserFocus'];
        $data['sumUserSex1']=$this->getSumUserSex($channelid,$ischannel,'',1);              /*所有用户性别分类1*/
        $data['sumUserSex1']=$data['sumUserSex1']-$dayUserInfo['dayUserSex1'];
        $data['sumUserSex2']=$this->getSumUserSex($channelid,$ischannel,'',2);              /*所有用户性别分类2*/
        $data['sumUserSex2']=$data['sumUserSex2']-$dayUserInfo['dayUserSex2'];
        $data['sumUserSex0']=$this->getSumUserSex($channelid,$ischannel,'',0);              /*所有用户性别分类0*/
        $data['sumUserSex0']=$data['sumUserSex0']-$dayUserInfo['dayUserSex0'];
        $data['sumUserPay']=$this->getSumUserPay($channelid,$ischannel);                                 /*所有已付费的用户*/
        $data['sumUserPay']=$data['sumUserPay']-$dayUserInfo['dayUserPay'];

        $data['monthUser']=$this->getMonthUser($channelid,$ischannel);                                   /*本月新增用户*/
        $data['monthUser']=$data['monthUser']-$dayUserInfo['dayUser'];
        $data['monthUserFocus']=$this->getMonthUserFocus($channelid,$ischannel);                         /*本月新增关注用户*/
        $data['monthUserFocus']=$data['monthUserFocus']-$dayUserInfo['dayUserFocus'];
        $data['monthUserSex1']=$this->getMonthUserSex($channelid,$ischannel,1);                      /*本月用户性别分类1*/
        $data['monthUserSex1']=$data['monthUserSex1']-$dayUserInfo['dayUserSex1'];
        $data['monthUserSex2']=$this->getMonthUserSex($channelid,$ischannel,2);                      /*本月用户性别分类2*/
        $data['monthUserSex2']=$data['monthUserSex2']-$dayUserInfo['dayUserSex2'];
        $data['monthUserSex0']=$this->getMonthUserSex($channelid,$ischannel,0);                      /*本月用户性别分类0*/
        $data['monthUserSex0']=$data['monthUserSex0']-$dayUserInfo['dayUserSex0'];
        $data['monthUserPay']=$this->getMonthUserPay($channelid, $ischannel);                            /*本月已付费用户*/
        $data['monthUserPay']=$data['monthUserPay']-$dayUserInfo['dayUserPay'];

        $data['yesterdayUser']=$this->getYesterdayUser($channelid,$ischannel);                           /*昨日新增用户*/
        $data['yesterdayUserFocus']=$this->getYesterdayUserFocus($channelid,$ischannel);                 /*昨日新增关注用户*/
        $data['yesterdayUserSex1']=$this->getYesterdayUserSex($channelid,$ischannel,1);              /*昨日用户性别分类1*/
        $data['yesterdayUserSex2']=$this->getYesterdayUserSex($channelid,$ischannel,2);              /*昨日用户性别分类2*/
        $data['yesterdayUserSex0']=$this->getYesterdayUserSex($channelid,$ischannel,0);              /*昨日用户性别分类0*/
        $data['yesterdayUserPay']=$this->getYesterdayUserPay($channelid,$ischannel);                     /*昨日已付费用户*/

        /*$data['dayUser']=$this->getDayUser($channelid,$ischannel);*/                                   /*当日新增用户*/
        /*$data['dayUserFocus']=$this->getDayUserFocus($channelid,$ischannel);*/                         /*当日新增关注用户*/
        /*$data['dayUserSex1']=$this->getDayUserSex($channelid,$ischannel,1);*/                          /*当日用户性别分类1*/
        /*$data['dayUserSex2']=$this->getDayUserSex($channelid,$ischannel,2);*/                          /*当日用户性别分类2*/
        /*$data['dayUserSex0']=$this->getDayUserSex($channelid,$ischannel,0);*/                          /*当日用户性别分类0*/
        /*$data['dayUserPay']=$this->getDayUserPay($channelid, $ischannel);*/                            /*当日已付费用户*/

        $data['today']=date("Ymd",time());
        $file='./userInfo/statistics_'.$channelid.'.txt';
        $str=json_encode($data);
        file_put_contents($file,$str);

        return $data;
    }


/**************************end*************************************************************************************************************/

	/**
     * @param $uid 用户id
     * @param $contentstr   要发送的内容
     * 发送客服消息
     */

    public function sendKefuInfo($uid,$contentstr)
    {
        //获取当前用户的信息和公众号来源
        if(!empty($uid)){
           $user= $this->field('uname,channelid')->find($uid);
           $channelModel=D('Channel');
           $channel=$channelModel->field('pid')->find($user['channelid']);
           if($channel['pid']>0){
               $fromid=$channel['pid'];
           }else{
               $fromid=$user['channelid'];
           }

        }
        $channelWxModel = M('distribution_channel_wx');
        $wxinfo = $channelWxModel->where(array('channelid' =>$fromid))->find();
        //拼装发送给用户的信息
        $contentstr=trim($contentstr);

        $info='{
                    "touser":"'.$user['uname'].'",
                    "msgtype":"text",
                    "text":
                    {
                         "content":"'.$contentstr.'"
                    }
                }';

        $sendUrl='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$wxinfo['atoken'];

        //给用户发送信息
        request($sendUrl, true, "post", $info);
    }
	
	
}
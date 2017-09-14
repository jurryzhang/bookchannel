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

    public function search($where=array(),$pageSize = 15)
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
        $data['data'] = $this->field('a.*,b.paidmoney,b.remainmoney,c.pname')
            ->alias('a')
            ->join('LEFT JOIN __DISTRIBUTION_PAY_LOG__ b ON a.channelid=b.channelid
                    LEFT JOIN __DISTRIBUTION_CHANNEL_INFO__ c ON a.uid=c.uid')
            ->where($where)
            ->group('a.channelid')
            ->limit($page->firstRow.','.$page->listRows)->select();

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

        if($count>0){
            $pchannel=$this->getChannelinfo();
            $_POST['pid']=$pchannel['channelid'];
            $_POST['proportion']=$pchannel['proportion'];
            $_POST['posttime']=time();
            if(empty($_POST['readchaptercount'])){
                $_POST['readchaptercount']=$pchannel['readchaptercount'];
            }
            if(empty($_POST['channeltype'])){
                $_POST['channeltype']='weixin';
            }
            //生成密钥
            $_POST['secretkey']   = substr(md5($_POST['channelname'] . time() . $_POST['channeltype']),8,16);
           $res= $this->add($_POST);
           //添加成功后添加充值记录表,用于后期统计充值记录
            if($res){
                $payLogData['channelid']   = $res;
                $payLogData['channelname'] = $_POST['channelname'];
                $payLogData['paidmoney']   = 0;
                $payLogData['remainmoney']  = 0;
                M('distribution_pay_log')->add($payLogData);
                return true;
            }else{
                return false;
            }
        }else{
            $this->error='没有权限,请联系管理员!';
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
        $where=array('a.pid'=>$pchannelid);
        $schannel=$this->search($where);		
        $sid=array();
        foreach ($schannel['data'] as $v){
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
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $count=M('DistributionSystemUsers')
            ->where(array('channelid'=>array('IN',$channelid),'regdate'=>array('egt',$today_start),'isfollow'=>1))
            ->count();
        return $count;
    }
    //累计关注
    public function getAllFocus($where=array()){
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $count=M('DistributionSystemUsers')
            ->where(array('channelid'=>array('IN',$channelid),'isfollow'=>1))
            ->count();;
        return $count;
    }
    //当日充值
    public function getDaySumPay($where=array()){
        $today_start=strtotime(date('Y-m-d'));
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>array('IN',$channelid),'buytime'=>array('egt',$today_start)))
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
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $data=M('DistributionPayPaylog')->field('money')
                ->where(array('payflag'=>1,'channelid'=>array('IN',$channelid),'buytime'=>array('BETWEEN',"{$thismonth_start},{$thismonth_end}")))
                ->select();
        $monthSumPay=0;
        foreach($data as $val){
            $monthSumPay+=$val['money'];
        }
        return $monthSumPay;
    }
    //累计充值
    public function getSumPay($where=array()){
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'channelid'=>array('IN',$channelid)))
            ->select();
        $sumPay=0;
        foreach($data as $val){
            $sumPay+=$val['money'];
        }
        return $sumPay;
    }
    //累计成本
    public function getCost($where=array()){
        $channelids=$this
            ->field('channelid')
            ->where(array('channelid'=>$where,'pid'=>$where,'_logic'=>'OR'))
            ->select();
        foreach($channelids as $val){
            $channelid[]=$val['channelid'];
        }
        $data=M('DistributionPayPaylog')->alias('p')
            ->field('c.*,p.*')
            ->join('RIGHT JOIN __DISTRIBUTION_CHANNELS__ c ON c.channelid=p.channelid')
            ->where(array('c.channelid'=>array('IN',$channelid)))
            ->select();
        $cost=0;
        foreach($data as $val){
            $cost+=$val['cost'];
        }
        return $cost;
    }

}
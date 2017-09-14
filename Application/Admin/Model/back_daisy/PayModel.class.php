<?php
/**
 * creat by muyi 2017/05/09
 *充值模型
 */
namespace Admin\Model;
use Think\Model;
class PayModel extends Model{
    protected $tableName='distribution_pay_paylog';


    public function search($where=array(),$pageSize = 15)
    {
        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new \Think\Page($count, $pageSize,$parameter);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;
        /************************************** 取数据 ******************************************/
        $data['data'] = $this->field('a.*')
            ->alias('a')
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)->select();

        return $data;
    }

    public function getDaySumpay()
    {
        $data=$this->getDayPaylist();
        $sumpay=0;
        foreach ($data as $v){
            $sumpay+=$v['money'];
        }
        return $sumpay;

    }

    public function getDayPaylist()
    {
        $todayTime = strtotime(date('Y-m-d'));
        $where=array('buytime >'.$todayTime.' AND payflag = 1');
        $data=$this->search($where,PHP_INT_MAX);
		
        return $data['data'];
    }
	/*
	 * 本月充值
	 * */
    public function getMonthSumPay(){
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $data=$this->field('money')
                ->where(array('payflag'=>1,'buytime'=>array('BETWEEN',"{$thismonth_start},{$thismonth_end}")))
                ->select();
        $monthSumPay=0;
        foreach($data as $val){
            $monthSumPay+=$val['money'];
        }
        return $monthSumPay;
    }
	/*
	 * 累计充值
	 * */
    public function getSumPay(){
        $data=$this->field('money')->where(array('payflag'=>1))->select();
        $sumPay=0;
        foreach($data as $val){
            $sumPay+=$val['money'];
        }
        return $sumPay;
    }
    /*
     * 累计成本
     * */
    public function getCost(){
        #select c.*,p.* from jieqi_distribution_channels c left join jieqi_distribution_pay_paylog p on c.channelid=p.channelid
        $data=$this->alias('p')
            ->field('c.*,p.*')
            ->join('RIGHT JOIN __DISTRIBUTION_CHANNELS__ c ON c.channelid=p.channelid')
            ->select();
        $cost=0;
        foreach($data as $val){
            $cost+=$val['cost'];
        }
        return $cost;
    }
    /*
     * 昨日充值
     * */
    public function getyesterdaySumPay(){
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $data=M('DistributionPayPaylog')->field('money')
            ->where(array('payflag'=>1,'buytime'=>array('BETWEEN',"{$yesterdayTime},{$today_start}")))
            ->select();
        $yesterdaySumPay=0;
        foreach($data as $v){
            $yesterdaySumPay+=$v['money'];
        }
        return $yesterdaySumPay;
    }
	
	
    /**
     * @param $ptid
     * 获取平台总的充值总数
     */
    public function getPtsumPay($ptid)
    {
        //$ptid=1;
        $sumpay=$this->where(array('ptid'=>$ptid,'payflag'=>1))->sum('money');

        return$sumpay;
    }

    /**
     * @param $ptid
     * @return mixed
     * 获取平台充值笔数
     */

    public function getPtPayCount($ptid)
    {
        $count=$this->where(array('ptid'=>$ptid,'payflag'=>1))->count();

        return $count;
    }
	
	/**
     * 获取当日充值笔数
     */
    /*public function getDayPayCount($channelid,$ischannel=0){
        $today_start=strtotime(date('Y-m-d'));
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        $condition['payflag']=1;
        $condition['buytime']=array('egt',$today_start);

        $count=M('DistributionPayPaylog')->where($condition)->count();

        return $count;
    }*/

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 获取当日充值笔数完成与未完成公用方法
     */
    public function getDayPayCountCommom($channelid,$ischannel=0,$condition=array())
    {
        $today_start=strtotime(date('Y-m-d'));
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        $condition['buytime']=array('egt',$today_start);

        $count=M('DistributionPayPaylog')->where($condition)->count();

        return $count;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取当日充值完成笔数
     */
    public function getDayPayCount($channelid,$ischannel=0){
        $condition['payflag']=1;
        return $this->getDayPayCountCommom($channelid,$ischannel,$condition);
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取当日充值未完成笔数
     */
    public function getDayUnpayCount($channelid, $ischannel = 0)
    {
        $condition['payflag']=0;
        return $this->getDayPayCountCommom($channelid,$ischannel,$condition);
    }


    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 获取昨日充值成功与未成功公用方法
     */
    public function getyesterdayPayCountCommon($channelid,$ischannel=0,$condition=array()){
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        $condition['buytime']=array('BETWEEN',"{$yesterdayTime},{$today_start}");

        $count=M('DistributionPayPaylog')->where($condition)->count();

        return $count;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取昨日充值成功笔数
     */
    public function getyesterdayPayCount($channelid,$ischannel=0)
    {
        $condition['payflag']=1;
        return $this->getyesterdayPayCountCommon($channelid,$ischannel,$condition);
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取昨日充值未成功笔数
     */
    public function getyesterdayUnpayCount($channelid,$ischannel=0)
    {
        $condition['payflag']=0;
        return $this->getyesterdayPayCountCommon($channelid,$ischannel,$condition);
    }
	
	/**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 获取本月充值完成与未完成公用方法
     */
	public function getMonthPayCountCommon($channelid,$ischannel=0,$condition=array()){
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }

        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");

        $count=M('DistributionPayPaylog')->where($condition)->count();

        return $count;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取本月充值完成笔数
     */
    public function getMonthPayCount($channelid, $ischannel = 0)
    {
        $condition['payflag']=1;
        return $this->getMonthPayCountCommon($channelid,$ischannel,$condition);
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取本月未充值完成笔数
     */
    public function getMonthUnpayCount($channelid, $ischannel = 0)
    {
        $condition['payflag']=0;
        return $this->getMonthPayCountCommon($channelid,$ischannel,$condition);
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 获取累计充值完成与未完成公用方法
     */
    public function getSumPayCountCommon($channelid,$ischannel=0,$condition=array()){
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }

        $count=M('DistributionPayPaylog')->where($condition)->count();

        return $count;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取累计充值完成笔数
     */
    public function getSumPayCount($channelid,$ischannel=0)
    {
        $condition['payflag']=1;
        return $this->getSumPayCountCommon($channelid,$ischannel,$condition);
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 获取累计充值未完成笔数
     */
    public function getSumUnpayCount($channelid,$ischannel=0)
    {
        $condition['payflag']=0;
        return $this->getSumPayCountCommon($channelid,$ischannel,$condition);
    }
	
	/**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return int
     * 获取累计充值人数
     */
	public function getSumPayPeopleNum($channelid,$ischannel=0,$condition=array()){
	    if(empty($channelid)){
	        $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        $condition['payflag']=1;
        //$num=M('DistributionPayPaylog')->where($condition)->group('buyid')->count();
        $num=M('DistributionPayPaylog')->field('count(buyid)')->where($condition)->group('buyid')->select();
        $num=count($num);

        return $num;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return int
     * 获取本月充值人数
     */
	public function getMonthPayPeopleNum($channelid,$ischannel=0,$condition=array()){
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
	    return $this->getSumPayPeopleNum($channelid,$ischannel,$condition);
    }
	
	
	
}
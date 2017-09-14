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
	
/*********************************start*********************************************************************************************/
    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 总充值公用方法
     */
    public function getSumPayPublic($channelid,$ischannel=0,$condition=array())
    {
        if(empty($channelid)){
            $channelid=cookie('channelid');
        }
        $channelidArr=D('Channel')->getchannelidArr($channelid);
        if($ischannel){
            $condition['channelid']=array('IN',$channelidArr);
        }
        $data=$this->field('money')->where($condition)->select();

        return $data;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 总充值金额
     */
    public function getSumPay($channelid,$ischannel=0,$condition=array())
    {
        $condition['payflag']=1;
        $data=$this->getSumPayPublic($channelid,$ischannel,$condition);
        $sumPay=0;
        foreach($data as $val){
            $sumPay+=$val['money'];
        }
        $count=count($data);
        $pay['sum']=$sumPay;
        $pay['count']=$count;
        return $pay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 本月充值总金额
     */
    public function getMonthSumPay($channelid,$ischannel=0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthPay=$this->getSumPay($channelid,$ischannel,$condition);
        return $monthPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 昨日充值总金额
     */
    public function getYesterdaySumPay($channelid,$ischannel=0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['buytime']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yesterdayPay=$this->getSumPay($channelid,$ischannel,$condition);
        return $yesterdayPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 当日充值总金额
     */
    public function getCurdaySumPay($channelid, $ischannel = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['buytime']=array('egt',$today_start);
        $dayPay=$this->getSumPay($channelid,$ischannel,$condition);
        return $dayPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 普通充值总金额
     */
    public function getCommonSumPay($channelid, $ischannel = 0,$condition=array())
    {
        $condition['money']=array('neq',365);
        $commonPay=$this->getSumPay($channelid,$ischannel,$condition);
        return $commonPay;
    }

    /**
     * @param $channelid
     * @param $ischannel
     * @return mixed
     * 本月普通充值总金额
     */
    public function getMonthCommonSumPay($channelid, $ischannel = 0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthCommonPay=$this->getCommonSumPay($channelid,$ischannel,$condition);
        return $monthCommonPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 昨日普通充值总金额
     */
    public function getYeaterdayCommonSumPay($channelid, $ischannel = 0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['buytime']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yesterdayCommonPay=$this->getCommonSumPay($channelid,$ischannel,$condition);
        return $yesterdayCommonPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 当日普通充值总金额
     */
    public function getDayCommonPay($channelid, $ischannel = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['buytime']=array('egt',$today_start);
        $daySumCommonPay=$this->getCommonSumPay($channelid,$ischannel,$condition);
        return $daySumCommonPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return int
     * 年费充值总金额
     */
    public function getYearSumPay($channelid, $ischannel = 0,$condition=array())
    {
        $condition['money']=array('eq',365);
        $sumYearPay=$this->getSumPay($channelid,$ischannel,$condition);
        return $sumYearPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return int
     * 本月年费充值总金额
     */
    public function getMonthSumYearPay($channelid, $ischannel = 0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthYearPay=$this->getYearSumPay($channelid,$ischannel,$condition);
        return $monthYearPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return int
     * 昨日年费充值总金额
     */
    public function getYesterdaySumYearpay($channelid, $ischannel = 0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['buytime']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yeaterdayYearPay=$this->getYearSumPay($channelid,$ischannel,$condition);
        return $yeaterdayYearPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return int
     * 当日年费充值总金额
     */
    public function getDaySumYearpay($channelid, $ischannel = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['buytime']=array('egt',$today_start);
        $dayYearPay=$this->getYearSumPay($channelid,$ischannel,$condition);
        return $dayYearPay;
    }


    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 未完成总充值金额
     */
    public function getSumUnPay($channelid,$ischannel=0,$condition=array())
    {
        $condition['payflag']=0;
        $data=$this->getSumPayPublic($channelid,$ischannel,$condition);
        $sumPay=0;
        foreach($data as $val){
            $sumPay+=$val['money'];
        }
        $count=count($data);
        $pay['sum']=$sumPay;
        $pay['count']=$count;
        return $pay;
    }
    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return mixed
     * 普通充值未完成
     */
    public function getCommonUnPay($channelid, $ischannel = 0,$condition=array())
    {
        $condition['money']=array('neq',365);
        $commonPay=$this->getSumUnPay($channelid,$ischannel,$condition);
        return $commonPay;
    }
    /**
     * @param $channelid
     * @param $ischannel
     * @return mixed
     * 本月普通充值未完成
     */
    public function getMonthCommonUnPay($channelid, $ischannel = 0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthCommonPay=$this->getCommonUnPay($channelid,$ischannel,$condition);
        return $monthCommonPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 昨日普通充值未完成
     */
    public function getYeaterdayCommonUnPay($channelid, $ischannel = 0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['buytime']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yesterdayCommonPay=$this->getCommonUnPay($channelid,$ischannel,$condition);
        return $yesterdayCommonPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return mixed
     * 当日普通充值未完成
     */
    public function getDayCommonUnPay($channelid, $ischannel = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['buytime']=array('egt',$today_start);
        $daySumCommonPay=$this->getCommonUnPay($channelid,$ischannel,$condition);
        return $daySumCommonPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @param array $condition
     * @return int
     * 年费充值未完成
     */
    public function getYearUnPay($channelid, $ischannel = 0,$condition=array())
    {
        $condition['money']=array('eq',365);
        $sumYearPay=$this->getSumUnPay($channelid,$ischannel,$condition);
        return $sumYearPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return int
     * 本月年费充值未完成
     */
    public function getMonthYearUnPay($channelid, $ischannel = 0)
    {
        $thismonth_start=strtotime(date('Y-m-1'));
        $thismonth_end=strtotime(date('Y-m-t 23:59:59'));
        $condition['buytime']=array('BETWEEN',"{$thismonth_start},{$thismonth_end}");
        $monthYearPay=$this->getYearUnPay($channelid,$ischannel,$condition);
        return $monthYearPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return int
     * 昨日年费充值未完成
     */
    public function getYesterdayYearUnPay($channelid, $ischannel = 0)
    {
        $today_start=strtotime(date('Y-m-d'));
        $yesterdayTime=$today_start-24*60*60;
        $condition['buytime']=array('BETWEEN',"{$yesterdayTime},{$today_start}");
        $yeaterdayYearPay=$this->getYearUnPay($channelid,$ischannel,$condition);
        return $yeaterdayYearPay;
    }

    /**
     * @param $channelid
     * @param int $ischannel
     * @return int
     * 当日年费充值未完成
     */
    public function getDayYearUnPay($channelid, $ischannel = 0)
    {
        $today_start = strtotime(date('Y-m-d'));
        $condition['buytime']=array('egt',$today_start);
        $dayYearPay=$this->getYearUnPay($channelid,$ischannel,$condition);
        return $dayYearPay;
    }

    /**
     * @param 
     * @param 
     * @return int
     * 同乐支付总额
     */

    public function getSumTonglePay(){
        $condition['paytype'] = 'tonglepay';
        $condition['payflag'] = 1;
        $sumPay = M('distribution_pay_paylog')->where($condition)->sum('money');
        //var_dump($sumPay);exit;
        return $sumPay;
    }

/********************************end************************************************************************************************************/
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
     * @return array
     * 当日充值统计
     */
    public function dayPayInfo($channelid, $ischannel = 0)
    {
        $data=array();

        $daySumpay=$this->getCurdaySumPay($channelid,$ischannel);                       /*当日充值总金额*/
        $data['daypaySum']=$daySumpay['sum'];
        $data['dayPayCount']=$daySumpay['count'];

        $dayCommonPay=$this->getDayCommonPay($channelid,$ischannel);                    /*当日普通充值总金额*/
        $data['dayCommonPaySum']=$dayCommonPay['sum'];
        $data['dayCommonPayCount']=$dayCommonPay['count'];

        $daySumYearpay=$this->getDaySumYearpay($channelid,$ischannel);                  /*当日年费充值总金额*/
        $data['dayYearPaySum']=$daySumYearpay['sum'];
        $data['dayYearpayCount']=$daySumYearpay['count'];

        $dayCommonUnPay=$this->getDayCommonUnPay($channelid,$ischannel);                /*当日普通充值未完成笔数*/
        $data['dayCommonUnPayCount']=$dayCommonUnPay['count'];

        $dayYearUnPay=$this->getDayYearUnPay($channelid,$ischannel);                    /*当日年费充值未完成笔数*/
        $data['dayYearUnPayCount']=$dayYearUnPay['count'];

        return $data;
    }


    /**
     * @param $channelid
     * @param int $ischannel
     * @return array
     * 充值统计(不含当日)
     */
    public function sumPayInfo($channelid, $ischannel = 0)
    {
        $data=array();

        $dayPayInfo=$this->dayPayInfo($channelid,$ischannel);

        $sumPay=$this->getSumPay($channelid,$ischannel);                                /*总充值金额(不含当日)*/
        $data['sumPay']=$sumPay['sum']-$dayPayInfo['daypaySum'];
        $data['sumPayCount']=$sumPay['count']-$dayPayInfo['dayPayCount'];

        $monthSumpay=$this->getMonthSumPay($channelid,$ischannel);                      /*本月充值总金额(不含当日)*/
        $data['monthPaySum']=$monthSumpay['sum']-$dayPayInfo['daypaySum'];
        $data['monthPayCount']=$monthSumpay['count']-$dayPayInfo['daypaySum'];

        $yeaterdaySumpay=$this->getYesterdaySumPay($channelid,$ischannel);              /*昨日充值总金额*/
        $data['yeaterdayPaySum']=$yeaterdaySumpay['sum'];
        $data['yeaterdayPayCount']=$yeaterdaySumpay['count'];

        /*$daySumpay=$this->getCurdaySumPay($channelid,$ischannel); */                      /*当日充值总金额*/
        /*$data['daypaySum']=$daySumpay['sum'];
        $data['dayPayCount']=$daySumpay['count'];*/

        $commonSumpay=$this->getCommonSumPay($channelid,$ischannel);                    /*普通充值总金额(不含当日)*/
        $data['commonPaySum']=$commonSumpay['sum']-$dayPayInfo['dayCommonPaySum'];
        $data['commonPayCount']=$commonSumpay['count']-$dayPayInfo['dayCommonPayCount'];

        $monthCommonSumpay=$this->getMonthCommonSumPay($channelid,$ischannel);          /*本月普通充值总金额(不含当日)*/
        $data['monthCommonPaySum']=$monthCommonSumpay['sum']-$dayPayInfo['dayCommonPaySum'];
        $data['monthCommonPayCount']=$monthCommonSumpay['count']-$dayPayInfo['dayCommonPayCount'];

        $yeaterdayCommonSumpay=$this->getYeaterdayCommonSumPay($channelid,$ischannel);  /*昨日普通充值总金额*/
        $data['yeaterdayCommonPaySum']=$yeaterdayCommonSumpay['sum'];
        $data['yeaterdayCommonPayCount']=$yeaterdayCommonSumpay['count'];

        /*$dayCommonPay=$this->getDayCommonPay($channelid,$ischannel);*/                    /*当日普通充值总金额*/
        /*$data['dayCommonPaySum']=$dayCommonPay['sum'];
        $data['dayCommonPayCount']=$dayCommonPay['count'];*/

        $yearSumPay=$this->getYearSumPay($channelid,$ischannel);                        /*年费充值总金额(不含当日)*/
        $data['yearPaySum']=$yearSumPay['sum']-$dayPayInfo['dayYearPaySum'];
        $data['yearPayCount']=$yearSumPay['count']-$dayPayInfo['dayYearpayCount'];

        $monthSumYearPay=$this->getMonthSumYearPay($channelid,$ischannel);              /*本月年费充值总金额(不含当日)*/
        $data['monthYearPaySum']=$monthSumYearPay['sum']-$dayPayInfo['dayYearPaySum'];
        $data['monthYearPayCount']=$monthSumYearPay['count']-$dayPayInfo['dayYearpayCount'];

        $yesterdaySumYearpay=$this->getYesterdaySumYearpay($channelid,$ischannel);      /*昨日年费充值总金额*/
        $data['yesterdayYearPaySum']=$yesterdaySumYearpay['sum'];
        $data['yesterdayYearPayCount']=$yesterdaySumYearpay['count'];

        /*$daySumYearpay=$this->getDaySumYearpay($channelid,$ischannel);*/                  /*当日年费充值总金额*/
        /*$data['dayYearPaySum']=$daySumYearpay['sum'];
        $data['dayYearpayCount']=$daySumYearpay['count'];*/

        $commonUnPay=$this->getCommonUnPay($channelid,$ischannel);                      /*普通充值未完成笔数(不含当日)*/
        $data['commonUnPayCount']=$commonUnPay['count']-$dayPayInfo['dayCommonUnPayCount'];

        $monthCommonUnPay=$this->getMonthCommonUnPay($channelid,$ischannel);            /*本月普通充值未完成笔数(不含当日)*/
        $data['monthCommonUnPayCount']=$monthCommonUnPay['count']-$dayPayInfo['dayCommonUnPayCount'];

        $yeaterdayCommonUnPay=$this->getYeaterdayCommonUnPay($channelid,$ischannel);    /*昨日普通充值未完成笔数*/
        $data['yeaterdayCommonUnPayCount']=$yeaterdayCommonUnPay['count'];

        /*$dayCommonUnPay=$this->getDayCommonUnPay($channelid,$ischannel);*/                /*当日普通充值未完成笔数*/
        /*$data['dayCommonUnPayCount']=$dayCommonUnPay['count'];*/

        $yearUnPay=$this->getYearUnPay($channelid,$ischannel);                          /*年费充值未完成笔数(不含当日)*/
        $data['yearUnPayCount']=$yearUnPay['count']-$dayPayInfo['dayYearUnPayCount'];

        $monthYearUnPay=$this->getMonthYearUnPay($channelid,$ischannel);                /*本月年费充值未完成笔数(不含当日)*/
        $data['monthYearUnPayCount']=$monthYearUnPay['count']-$dayPayInfo['dayYearUnPayCount'];

        $yesterdayYearUnPay=$this->getYesterdayYearUnPay($channelid,$ischannel);        /*昨日年费充值未完成笔数*/
        $data['yesterdayYearUnPayCount']=$yesterdayYearUnPay['count'];

        /*$dayYearUnPay=$this->getDayYearUnPay($channelid,$ischannel);*/                    /*当日年费充值未完成笔数*/
        /*$data['dayYearUnPayCount']=$dayYearUnPay['count'];*/

        $data['sumPayPeopleNum']=$this->getSumPayPeopleNum($channelid,$ischannel);
        $data['monthPayPeopleNum']=$this->getMonthPayPeopleNum($channelid,$ischannel);

        
        $data['today']=date("Ymd",time());
        $file='./paylogInfo/statistics_'.$channelid.'.txt';
        $str=json_encode($data);
        file_put_contents($file,$str);

        return $data;
    }
	
	
	
}
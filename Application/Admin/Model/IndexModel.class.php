<?php
namespace Admin\Model;
use Think\Model;
class IndexModel extends Model{
    protected $tableName='distribution_system_users';
    public function getCurDayReader(){
        $today_start=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $today_end=mktime(0,0,0,date('m'),date('d')+1,date('Y'));
       /* $time=strtotime(date("Y-m-d"));
        $time1=strtotime(date("Y-m-d"))+24*60*60;*/
        $data=$this
            ->where(array('regdate'=>array('BETWEEN',"{$today_start},{$today_end}")))
            ->count();
        return $data;
    }
    public function getCurDayFocus(){
        $today_start=strtotime(date("Y-m-d"));
        $today_end=strtotime(date("Y-m-d"))+24*60*60;
        $data=$this
            ->where(array('regdate'=>array('BETWEEN',"{$today_start},{$today_end}"),'isfollow'=>1))
            ->count();
        return $data;
    }
    public function getAllReader(){
        $data=$this->count();
        return $data;
    }
    public function getAllFocus(){
        $data=$this
            ->where(array('isfollow'=>1))
            ->count();
        return $data;
    }

}
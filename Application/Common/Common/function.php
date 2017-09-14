<?php
/**
 * 企业审查系统
 * ============================================================================
 * * 版权所有 河南趣读信息科技有限公司，并保留所有权利。
 *
 * Burn创作，未经授权，不得进行任何形式的转载及发布
 * ----------------------------------------------------------------------------
 * ============================================================================
 *
 * 基本函数
 *
 */

/**
 * 对str字符串进行加密，并返回加密过后的字符串
 * @param unknown $str 加密后的字符串
 */
function encrypt($str)
{
    return md5($str);
}

/***
 * 定义一个获取客户端IP
 * @return string
 */
function getIP()
{
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknow";
    }

    return $ip;
}

/**
 * @param $arr
 * @param $key_name
 * @return array
 * 将数据库中查出的列表以指定的 id 作为数组的键名
 */
function convert_arr_key($arr, $key_name)
{
    $arr2 = array();

    foreach ($arr as $key => $val) {
        $arr2[$val[$key_name]] = $val;
    }

    return $arr2;
}

/**
 * 面包屑导航  用于后台管理
 * 根据当前的控制器名称 和 action 方法
 */
function getLeftNavigate($input)
{
    $navigate = include APP_PATH . 'Common/Conf/' . $input . 'menu.php';

    return $navigate;
}

/**
 * 面包屑导航  用于后台管理
 * 根据当前的控制器名称 和 action 方法
 */
function getLeftMenu($input)
{
    $menuList = include APP_PATH . 'Common/Conf/' . $input . 'menu.php';

    return $menuList;
}

/**
 * 面包屑导航  用于后台管理
 * 根据当前的控制器名称 和 action 方法
 */
function getNavigate()
{
    $navigate = include APP_PATH . 'Common/Conf/navigate.php';

    $location = strtolower('Home/' . CONTROLLER_NAME);//将字符串转化为小写

// 	echo 'url = ' . $location .' / ' . ACTION_NAME . '<br />';

    $arr = array
    (
        '首页' => U('Home/Index/welcome'),
        $navigate[$location]['name'] => U($location . "/" . ACTION_NAME),
        $navigate[$location]['action'][ACTION_NAME] => U($location . "/" . ACTION_NAME),
    );

    return $arr;
}

/**
 * 数字转换为中文
 * @param  string|integer|float $num 目标数字
 * @param  integer $mode 模式[true:金额（默认）,false:普通数字表示]
 * @param  boolean $sim 使用小写（默认）
 * @return string
 */
function number2chinese($num, $mode = true, $sim = true)
{
    if (!is_numeric($num)) {
        return '含有非数字非小数点字符！';
    }

    $char = $sim ? array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九')
        : array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
    $unit = $sim ? array('', '十', '百', '千', '', '万', '亿', '兆')
        : array('', '拾', '佰', '仟', '', '萬', '億', '兆');
    $retval = $mode ? '元' : '点';

    //小数部分
    if (strpos($num, '.')) {
        list($num, $dec) = explode('.', $num);
        $dec = strval(round($dec, 2));

        if ($mode) {
            $retval .= "{$char[$dec['0']]}角{$char[$dec['1']]}分";
        } else {
            for ($i = 0, $c = strlen($dec); $i < $c; $i++) {
                $retval .= $char[$dec[$i]];
            }
        }
    }

    //整数部分
    $str = $mode ? strrev(intval($num)) : strrev($num);

    for ($i = 0, $c = strlen($str); $i < $c; $i++) {
        $out[$i] = $char[$str[$i]] != '零' ? $char[$str[$i]] : '';

        if ($mode) {
            $out[$i] .= $str[$i] != '0' ? $unit[$i % 4] : '';

            if ($i > 1 and $str[$i] + $str[$i - 1] == 0) {
                $out[$i] = '';
            }

            if ($i % 4 == 0) {
                $out[$i] .= $unit[4 + floor($i / 4)];
            }
        }
    }

    $str = join('', array_reverse($out)) . '元';

    return $str;
}

/**
 * 数字转换为中文
 * @param  string|integer|float $num 目标数字
 * @param  integer $mode 模式[true:金额（默认）,false:普通数字表示]
 * @param  boolean $sim 使用小写（默认）
 * @return string
 */
function numberToChinese($num)
{
    if (!is_numeric($num)) {
        return $num;
    }

    //整数部分
    $str = strrev($num);

    $id = 0;

    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] != '0') {
            break;
        } else {
            $id++;
        }
    }

    if ($id >= 4 && id < 8) {
        $str = strrev(substr($str, 4)) . '万元';
    } elseif ($id >= 8) {
        $str = strrev(substr($str, 8)) . '亿元';
    }

    return $str;
}

/*
 * 删除同一键的相同值，返回为同一键值的数据
 */
function removeSameKeyOfSameValue($inputArray, $key)
{
    foreach ($inputArray as $item) {
        if (!in_array($item[$key], $oldValue)) {
            $res[][$key] = $item[$key];

            $oldValue[] = $item[$key];
        }
    }

    return $res;
}

/**
 * 查看在数据库中时候有该企业ID，存在返回数量，不存在，返回0
 *
 * @param $dateBaseName 数据库表名
 * @param $payerID      payers_id
 */
function countInDateBase($dateBaseName, $payerID)
{
    $count = M($dateBaseName)->where(array('payers_id' => $payerID))->count();

    return $count;
}

function printVar($input, $str)
{
    echo '<br><br>' . $str . ' = ';

    dump($input);

    echo '<br><br>';
}

//判断是否属手机
//代码看上去很多，其实就是数组里面显得多而乱，不要被表面现象所吓倒哦！
function is_mobile()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
    $is_mobile = false;

    foreach ($mobile_agents as $device) {
        //这里把值遍历一遍，用于查找是否有上述字符串出现过
        if (stristr($user_agent, $device)) {
            //stristr 查找访客端信息是否在上述数组中，不存在即为PC端。
            $is_mobile = true;
            break;
        }
    }

    return $is_mobile;
}

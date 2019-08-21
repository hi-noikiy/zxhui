<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/30 17:38:06] -->
 */
defined('IN_IA') or exit('Access Denied');

function getInsertDataForSettingHome(){
    global $_W, $_GPC;

    $mtype = $_GPC['mtype'];
    $title = $_GPC['title'];
    $title2 = $_GPC['title2'];
    $btitle = $_GPC['btitle'];
    $bimg = $_GPC['bimg'];
    $blink = $_GPC['blink'];
    $class_ngi = $_GPC['class_ngi'];
    $psize = $_GPC['psize'];
    $psize2 = $_GPC['psize2'];
    $class2_ngi = $_GPC['class2_ngi'];
    $video = $_GPC['video'];
    $bgimg = $_GPC['bgimg'];
    $m_pinyin = m('pinyin');

    if (!empty($title)) {
        $data = array();
        $j = 0;

        foreach ($title as $key => $val) {
            $i = $m_pinyin->getPinyin(trim($val), 'diy');

            if (array_key_exists($i, $data)) {
                $i .= $j;
                ++$j;
            }

            $temp_tp_type = trim($mtype[$key]);
            $data[$i]['mtype'] = trim($temp_tp_type);
            $data[$i]['title'] = trim($val);

            if(!empty($class_ngi[$key])){
                $data[$i]['class'] = m('common')->getId(trim($class_ngi[$key]));
            }

            switch($temp_tp_type){
                case 'banner':
                    $banner = array();
                    for($b = 0; $b < count($bimg[$key]); $b++){
                        $banner[] = array(
                            'btitle' => trim($btitle[$key][$b]),
                            'bimg' => trim($bimg[$key][$b]),
                            'blink' => trim($blink[$key][$b])
                        );
                    }
                    $data[$i]['banner'] = $banner;
                    break;
                case 'product':
                    $data[$i]['psize'] = intval($psize[$key]);
                    break;
                case 'video':
                    $data[$i]['video'] = trim($video[$key]);
                    $data[$i]['bgimg'] = trim($bgimg[$key]);
                    break;
                case 'pas':
                    $data[$i]['title2'] = trim($title2[$key]);
                    $data[$i]['psize2'] = intval($psize2[$key]);
                    $data[$i]['class2'] = m('common')->getId(trim($class2_ngi[$key]));
                    break;
            }

        }
    }

    return $data;
}
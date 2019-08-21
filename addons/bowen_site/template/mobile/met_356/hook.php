<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/10/08 10:50:06] -->
 */
defined('IN_IA') or exit('Access Denied');

function getInsertDataForSettingHome(){
    global $_W, $_GPC;

    $mtype = $_GPC['mtype'];
    $title = $_GPC['title'];
    $subtitle = $_GPC['subtitle'];
    $btitle = $_GPC['btitle'];
    $bimg = $_GPC['bimg'];
    $blink = $_GPC['blink'];
    $class_ngi = $_GPC['class_ngi'];
    $article_ngi = $_GPC['article_ngi'];
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
                    $data[$i]['subtitle'] = trim($subtitle[$key]);
                    break;
                case 'richtext':
                    $data[$i]['article'] = m('common')->getId(trim($article_ngi[$key]));
                    break;
                case 'news':
                    $data[$i]['subtitle'] = trim($subtitle[$key]);
                    break;
                case 'joint':
                    $data[$i]['subtitle'] = trim($subtitle[$key]);
                    break;
            }

        }
    }

    return $data;
}
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
    $btitle = $_GPC['btitle'];
    $bimg = $_GPC['bimg'];
    $blink = $_GPC['blink'];
    $title = $_GPC['title'];
    $title_en = $_GPC['title_en'];
    $class_ngi = $_GPC['class_ngi'];
    $product_btn1_text = $_GPC['product_btn1_text'];
    $product_btn1_link = $_GPC['product_btn1_link'];
    $product_btn2_text = $_GPC['product_btn2_text'];
    $product_btn2_link = $_GPC['product_btn2_link'];
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
            if(!empty($title_en[$key])){
                $data[$i]['title_en'] = trim($title_en[$key]);
            }
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
                    $data[$i]['product_btn1_text'] = trim($product_btn1_text[$key]);
                    $data[$i]['product_btn1_link'] = trim($product_btn1_link[$key]);
                    $data[$i]['product_btn2_text'] = trim($product_btn2_text[$key]);
                    $data[$i]['product_btn2_link'] = trim($product_btn2_link[$key]);
                    break;
                case 'show':
                    $data[$i]['bgimg'] = trim($bgimg[$key]);
                    break;
            }

        }
    }
    $data['the_product_class'] = m('common')->getId(trim($_GPC['the_product_class_ngi']));
    return $data;
}
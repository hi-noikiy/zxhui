<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
require_once EWEI_SHOPV2_PATH."vendor/phpquery/phpQuery.php";//导入phpQuery库

class Api_EweiShopV2Page extends PluginWebPage {

    function main() {
        global $_W, $_GPC;
        $data = m('common')->getPluginset('taobao');
        if(!cv('taobao.main')||!cv('taobao.jingdong')||!cv('taobao.one688')||!cv('taobao.taobaocsv')||empty($data['taobao_status'])){
            show_json(0);//err
        }else{
            show_json(1);//suc
        }
    }


    function upload(){
        global $_W, $_GPC;

        $type = intval($_GPC['type']);//类型 1淘宝 2天猫 3阿里巴巴 4京东
        $pageSource=trim($_GPC['page_source']);//页面源代码
        $cath_id=intval($_GPC['catch_id']);//抓取产品id
        $catch_url=trim($_GPC['catch_url']);//抓取产品地址
        switch ($type)
        {
            case 1:
                $this->api_taobao($cath_id,$catch_url,$pageSource);
                break;
            case 2:
                $this->api_tmall($cath_id,$catch_url,$pageSource);
                break;

            case 3:
                $this->api_alibaba($cath_id,$catch_url,$pageSource);
                break;

            case 4:
                $this->api_jd($cath_id,$catch_url,$pageSource);
                break;

            default:
                show_json(0);
                break;
        }
    }

    private function api_taobao($cath_id=0,$catch_url='',$pageSource=''){
        global $_W;
        $merchid=$_W['merchid'];
        if(!empty($pageSource)){
            $pageSource=html_entity_decode($pageSource);
            phpQuery::newDocument($pageSource);//输入入参数为html
            //替换标签中的src
            foreach(pq('img') as $img){
                if($img->getAttribute('data-ks-lazyload')!=''){
                    pq($img)->attr('src', $img->getAttribute('data-ks-lazyload'));
                    pq($img)->removeAttr('data-ks-lazyload');
                }
            }

            $map=array();
            preg_match('/skuMap\s+\:\s+(.+)/', $pageSource, $res);
            if (empty($res[1]))
            {
                $hasoption =0;

            }else{
                $hasoption =1;
                $map = json_decode($res[1], true);
            }

            $thumb_url = array();
            foreach (pq("#J_UlThumb li") as $li) {
                $v=pq('img',$li)->attr('src');
                if (substr($v, 0, 2) == "//") {
                    $v = "http://" . substr($v, 2);
                }
                $thumb_url[] = $this->save_image($v, 1);
            }
            $thumb = $thumb_url[0];
            unset($thumb_url[0]);

            $priceRange = explode('-', pq('#J_StrPrice .tb-rmb-num')->text());
            $minprice = floatval($priceRange[0]);
            $maxprice = empty($priceRange[1]) ? floatval($priceRange[0]) : floatval($priceRange[1]);

            $detail['content']=pq("#J_DivItemDesc")->html();
            $detail['content'] = $this->contentpasswh($detail['content']);
            //存储详情图

            preg_match_all("/<img.*?src=[\\\'| \\\"](.*?(?:[\.gif|\.jpg]?))[\\\'|\\\"].*?[\/]?>/", $detail['content'], $imgs);
            if (isset($imgs[1])) {
                foreach ($imgs[1] as $img) {
                    $catchimg = $img;
                    if (substr($catchimg, 0, 2) == "//") {
                        $img = "http://" . substr($img, 2);
                    }
                    $im = array(
                        "catchimg" => $catchimg,
                        "system" => $this->save_image($img, true)
                    );
                    $images[] = $im;
                }
            }
            if (isset($images)) {
                foreach ($images as $img) {
                    if (!empty($img['system'])) {
                        if (!empty($img['system'])) {
                            $detail['content'] = str_replace($img['catchimg'], $img['system'], $detail['content']);
                        }
                    }

                }
            }
            $detail['content'] = m('common')->html_to_images($detail['content']);

            $data = array(
                'uniacid' => $_W['uniacid'],
                'thumb' => $thumb,
                'thumb_url' => serialize($thumb_url),
                'title' => trim(pq('#J_Title h3')->text()),
                'status' => 0,
                'marketprice' => $maxprice,
                'originalprice' => $minprice,
                'minprice' => $minprice,
                'maxprice' => $maxprice,
                'hasoption' => $hasoption,
                'createtime' => time(),
                'total' => 0,
                'content' => $detail['content'],
                'merchid' => $merchid,
                'cates' => '',
                'checked' => empty($merchid) ? 0 : 1,
                'newgoods' => 1
            );
            //多商户商品是否免审核
            if (!empty($merchid)) {
                if (empty($_W['merch_user']['goodschecked'])) {
                    $data['checked'] = 1;
                } else {
                    $data['checked'] = 0;
                }
            }

            pdo_insert('ewei_shop_goods', $data);
            $goodsid = pdo_insertid();
            if (empty($goodsid)){
                show_json(0, '抓取失败');
            }

            //参数
            $value = array();
            foreach (pq('.attributes-list li') as $li) {
                if (pq($li)->text() != '') {
                    $specArr = explode(':', pq($li)->text());
                    $value[$specArr[0]] = $specArr[1];
                }
            }

            foreach ($value as $key => $val) {
                pdo_insert('ewei_shop_goods_param', array('goodsid' => $goodsid, 'uniacid' => $_W['uniacid'], 'title' => $key, 'value' => $val));
            }

            //规格
            $spec_list=array();
            $div=pq('#J_isku div');
            foreach(pq('dl',$div) as $dl){
                foreach (pq('dd',$dl) as $dd){
                    foreach (pq('ul',$dd) as $ul){
                        $spec_item=array();
                        foreach (pq('li',$ul) as $li){
                            if(pq('a span',$li)->text()!='' && pq($li)->attr('data-value')!=''){
                                $spec_item[pq($li)->attr('data-value')]=pq('a span',$li)->text();

                            }
                        }
                        $spec_list[pq('ul',$dd)->attr('data-property')]['spec_item']=$spec_item;
                    }
                }
            }

            if (!empty($hasoption) && !empty($spec_list)) {
                //规格处理
                foreach ($spec_list as $k => $v) {
                    pdo_insert('ewei_shop_goods_spec', array('uniacid' => $_W['uniacid'], 'goodsid' => $goodsid, 'title' => $k));
                    $specId = pdo_insertid();

                    foreach ($v['spec_item'] as $key => $val) {
                        $title = $val;
                        $thumb = '';
                        pdo_insert('ewei_shop_goods_spec_item', array('specid' => $specId, 'title' => $title, 'thumb' => empty($thumb) ? '' : $thumb, 'show' => 1));
                        $specs_item_id = pdo_insertid();
                        $specss[$key]['id'] = $specs_item_id;
                        $specss[$key]['name']=$val;
                    }
                }

                //处理选项
                foreach ($map as $k=>$v) {

                    $specArr = explode(';', $k);
                    foreach ($specArr as $specid){

                        if(empty($specid)){
                            continue;
                        }

                        if (!empty($specss[$specid]['id'])) {
                            $specs_id[] = $specss[$specid]['id'];
                            $specs_title[]=$specss[$specid]['name'];
                        }
                    }

                    $specs = implode('_', $specs_id);
                    $specstitle = implode('+', $specs_title);
                    unset($specs_id);
                    unset($specs_title);

                    $option['marketprice'] = empty($v['price'])?'0':floatval($v['price']);
                    $option['stock'] = 0;//库存
                    $option['goodsid'] = $goodsid;
                    $option['specs']=$specs;
                    $option['title']=$specstitle;
                    pdo_insert('ewei_shop_goods_option', $option);
                }
            }
            plog('api.upload', '客户端淘宝抓取宝贝 id:' . $cath_id);
            show_json(1, '抓取成功');
        }else{
            show_json( 0);
        }
    }

    private function api_tmall($cath_id=0,$catch_url='',$pageSource=''){
        global $_W;
        $merchid=$_W['merchid'];
        if(!empty($pageSource)){
            $pageSource=html_entity_decode($pageSource);
            preg_match('/var\s_DATA_Detail\s=\s(.+);<\/script>/', $pageSource, $res);
            if (empty($res[1]))
            {
                show_json(0, '商品获取失败');
            }
            $json1 = json_decode($res[1], true);
            phpQuery::newDocument($pageSource);//输入入参数为html
            //替换标签中的src
            foreach(pq('img') as $img){
                if($img->getAttribute('data-ks-lazyload')!=''){
                    pq($img)->attr('src', $img->getAttribute('data-ks-lazyload'));
                    pq($img)->removeAttr('data-ks-lazyload');
                }
                if($img->getAttribute('data-src')!=''){
                    pq($img)->attr('src', $img->getAttribute('data-src'));
                    pq($img)->removeAttr('data-src');
                }
            }
            $detail['content']=pq("#p-desc .container")->html();

            $thumb_url = array();
            foreach ($json1['item']['images'] as $v) {
                if (substr($v, 0, 2) == "//") {
                    $v = "http://" . substr($v, 2);
                }
                $thumb_url[] = $this->save_image($v, 1);
            }
            $thumb = $thumb_url[0];
            unset($thumb_url[0]);

            $minprice = floatval($json1['mock']['price']['price']['priceText']);
            $maxprice =floatval($json1['mock']['price']['price']['priceText']);
            $hasoption =empty($json1['skuBase']['props']) ? 0 : 1;
            $param=$json1['props']['groupProps'][0]['基本信息'];

            $detail['content'] = $this->contentpasswh($detail['content']);
            //存储详情图

            preg_match_all("/<img.*?src=[\\\'| \\\"](.*?(?:[\.gif|\.jpg]?))[\\\'|\\\"].*?[\/]?>/", $detail['content'], $imgs);
            if (isset($imgs[1])) {
                foreach ($imgs[1] as $img) {
                    $catchimg = $img;
                    if (substr($catchimg, 0, 2) == "//") {
                        $img = "http://" . substr($img, 2);
                    }
                    $im = array(
                        "catchimg" => $catchimg,
                        "system" => $this->save_image($img, true)
                    );
                    $images[] = $im;
                }
            }
            if (isset($images)) {
                foreach ($images as $img) {
                    if (!empty($img['system'])) {
                        if (!empty($img['system'])) {
                            $detail['content'] = str_replace($img['catchimg'], $img['system'], $detail['content']);
                        }
                    }

                }
            }
            $detail['content'] = m('common')->html_to_images($detail['content']);

            $data = array(
                'uniacid' => $_W['uniacid'],
                'thumb' => $thumb,
                'thumb_url' => serialize($thumb_url),
                'title' => $json1['item']['title'],
                'status' => 0,
                'marketprice' => $maxprice,
                'originalprice' => $minprice,
                'minprice' => $minprice,
                'maxprice' => $maxprice,
                'hasoption' => $hasoption,
                'createtime' => time(),
                'total' => 0,
                'content' => $detail['content'],
                'merchid' => $merchid,
                'cates' => '',
                'checked' => empty($merchid) ? 0 : 1,
                'newgoods' => 1
            );
            //多商户商品是否免审核
            if (!empty($merchid)) {
                if (empty($_W['merch_user']['goodschecked'])) {
                    $data['checked'] = 1;
                } else {
                    $data['checked'] = 0;
                }
            }

            pdo_insert('ewei_shop_goods', $data);
            $goodsid = pdo_insertid();
            if (empty($goodsid)){
                show_json(0, '抓取失败');
            }

            //参数
            $value = array();
            foreach ($param as $val) {
                foreach ($val as $k=>$v){
                    if (!empty($v)) {
                        $value[$k] = $v;
                    }
                }
            }

            foreach ($value as $key => $val) {
                pdo_insert('ewei_shop_goods_param', array('goodsid' => $goodsid, 'uniacid' => $_W['uniacid'], 'title' => $key, 'value' => $val));
            }

            //规格
            if ($hasoption) {
                //规格处理
                foreach ($json1['skuBase']['props'] as $k => $v) {
                    $spec = $v['name'];
                    pdo_insert('ewei_shop_goods_spec', array('uniacid' => $_W['uniacid'], 'goodsid' => $goodsid, 'title' => $spec));
                    $specId = pdo_insertid();

                    foreach ($v['values'] as $key => $val) {
                        $title = $val['name'];
                        $thumb = $this->save_image($val['image'],1);
                        pdo_insert('ewei_shop_goods_spec_item', array('specid' => $specId, 'title' => $title, 'thumb' => empty($thumb) ? '' : $thumb, 'show' => 1));
                        $specs_item_id = pdo_insertid();
                        $specss[$v['pid'].':'.$val['vid']]['id'] = $specs_item_id;
                        $specss[$v['pid'].':'.$val['vid']]['name']=$title;
                    }
                }


                //处理选项
                $map = $json1['skuBase']['skus'];
                foreach ($map as $v) {

                    $specArr = explode(';', $v['propPath']);
                    foreach ($specArr as $specid){
                        if (!empty($specss[$specid]['id'])) {
                            $specs_id[] = $specss[$specid]['id'];
                            $specs_title[]=$specss[$specid]['name'];
                        }
                    }

                    $specs = implode('_', $specs_id);
                    $specstitle = implode('+', $specs_title);
                    unset($specs_id);
                    unset($specs_title);

                    $marketprice=$json1['mock']['skuCore']['sku2info'][$v['skuId']]['price']['priceText'];
                    $option['marketprice'] = empty($marketprice)?'0':$marketprice;
                    $option['stock'] = 0;//库存
                    $option['goodsid'] = $goodsid;
                    $option['specs']=$specs;
                    $option['title']=$specstitle;
                    pdo_insert('ewei_shop_goods_option', $option);
                }
            }
            plog('api.upload', '客户端天猫抓取宝贝 id:' . $cath_id);
            show_json(1, '抓取成功');
        }else{
            show_json( 0);
        }
    }

    private function api_alibaba($cath_id=0,$catch_url='',$pageSource=''){
        global $_W;

        $merchid=$_W['merchid'];
        if(!empty($pageSource)){
            $pageSource=html_entity_decode($pageSource);
            preg_match('/window\.wingxViewData=window\.wingxViewData\|\|{};window\.wingxViewData\[0\]=(.+)<\/script>/', $pageSource, $res);
            if (empty($res))
            {
                show_json(0, '商品获取失败');
            }
            $json1 = json_decode($res[1], true);
            phpQuery::newDocument($pageSource);//输入入参数为html
            //替换标签中的src
            foreach(pq('img') as $img){
                if($img->getAttribute('data-lazyload-src')!=''){
                    pq($img)->attr('src', $img->getAttribute('data-lazyload-src'));
                    pq($img)->removeAttr('data-lazyload-src');
                }
                //移除被隐藏的img元素
                if(pq($img)->attr('none')===""){
                    pq($img)->attr('src', '');
                }
            }
            $detail['content']=pq("#J_Detail_Description_Container")->html();

            $thumb_url = array();
            foreach ($json1['imageList'] as $k => $v) {
                $thumb_url[] = $this->save_image($v['originalImageURI'], 1);
            }
            $thumb = $thumb_url[0];
            unset($thumb_url[0]);
            $priceRange = explode('-', $json1['priceDisplay']);
            $minprice = floatval($priceRange[0]);
            $maxprice = empty($priceRange[1]) ? floatval($priceRange[0]) : floatval($priceRange[1]);
            $hasoption = empty($json1['skuProps']) ? 0 : 1;
            $param = $json1['productFeatureList'];
            $detail['content'] = $this->contentpasswh($detail['content']);

            //存储详情图
            preg_match_all("/<img.*?src=[\\\'| \\\"](.*?(?:[\.gif|\.jpg]?))[\\\'|\\\"].*?[\/]?>/", $detail['content'], $imgs);
            if (isset($imgs[1])) {
                foreach ($imgs[1] as $img) {
                    $catchimg = $img;
                    if (substr($catchimg, 0, 2) == "//") {
                        $img = "http://" . substr($img, 2);
                    }
                    $im = array(
                        "catchimg" => $catchimg,
                        "system" => $this->save_image($img, true)
                    );
                    $images[] = $im;
                }
            }

            if (isset($images)) {
                foreach ($images as $img) {
                    if (!empty($img['system'])) {
                        if (!empty($img['system'])) {
                            $detail['content'] = str_replace($img['catchimg'], $img['system'], $detail['content']);
                        }
                    }

                }
            }
            $detail['content'] = m('common')->html_to_images($detail['content']);

            $data = array(
                'uniacid' => $_W['uniacid'],
                'thumb' => $thumb,
                'thumb_url' => serialize($thumb_url),
                'title' => $json1['subject'],
                'status' => 0,
                'marketprice' => $maxprice,
                'originalprice' => $minprice,
                'minprice' => $minprice,
                'maxprice' => $maxprice,
                'hasoption' => $hasoption,
                'createtime' => time(),
                'total' => $json1['canBookedAmount'],
                'content' => $detail['content'],
                'merchid' => $merchid,
                'cates' => '',
                'checked' => empty($merchid) ? 0 : 1,
                'newgoods' => 1
            );
            //多商户商品是否免审核
            if (!empty($merchid)) {
                if (empty($_W['merch_user']['goodschecked'])) {
                    $data['checked'] = 1;
                } else {
                    $data['checked'] = 0;
                }
            }

            pdo_insert('ewei_shop_goods', $data);
            $goodsid = pdo_insertid();
            if (empty($goodsid)){
                show_json(0, '抓取失败');
            }

            //参数
            $value = array();
            foreach ($param as $k => $v) {
                if (!empty($v['name']) && !empty($v['value'])) {
                    $unit = empty($v['unit']) ? '' : $v['unit'];
                    $value[$v['name']] = $v['value'] . $unit;
                }
            }
            foreach ($value as $key => $val) {
                pdo_insert('ewei_shop_goods_param', array('goodsid' => $goodsid, 'uniacid' => $_W['uniacid'], 'title' => $key, 'value' => $val));
            }

            //规格
            if ($hasoption) {
                //规格处理
                foreach ($json1['skuProps'] as $k => $v) {
                    $spec = $v['prop'];
                    pdo_insert('ewei_shop_goods_spec', array('uniacid' => $_W['uniacid'], 'goodsid' => $goodsid, 'title' => $spec));
                    $specId = pdo_insertid();

                    foreach ($v['value'] as $key => $val) {
                        $thumb = $this->save_image($val['imageUrl'],1);
                        $title = $val['name'];
                        pdo_insert('ewei_shop_goods_spec_item', array('specid' => $specId, 'title' => $val['name'], 'thumb' => empty($thumb) ? '' : $thumb, 'show' => 1));
                        $specs = pdo_insertid();
                        $specsid[$k][$key][$title] = $specs;
                    }
                }
                //处理选项
                $map = $json1['skuMap'];
                foreach ($map as $k => $v) {
                    $specArr = explode('&gt;', $k);
                    foreach ($specsid as $key => $item) {
                        foreach ($item as $v1) {
                            if (!empty($v1[$specArr[$key]])) {
                                $sss[] = $v1[$specArr[$key]];
                            }
                        }
                    }
                    $option['specs'] = implode('_', $sss);
                    unset($sss);

                    $option['title'] = str_replace('&gt;', '+', $k);//规格title
                    if (!empty($v['price'])) {
                        $option['marketprice'] = $v['price'];
                    } elseif (!empty($v['discountPrice'])) {
                        $option['marketprice'] = $v['discountPrice'];
                    } elseif (!empty($json1['discountPriceRanges'])) {
                        $option['marketprice'] = $json1['discountPriceRanges'][0]['price'];
                    } else {
                        $option['marketprice'] = 0;
                    }
                    $option['stock'] = $v['canBookCount'];//库存
                    $option['goodsid'] = $goodsid;
                    if (!empty($v['price'])) {
                        $option['productprice'] = $v['price'];
                    } elseif (!empty($v['discountPrice'])) {
                        $option['productprice'] = $v['discountPrice'];
                    } elseif (!empty($json1['discountPriceRanges'])) {
                        $option['productprice'] = $json1['discountPriceRanges'][0]['price'];
                    } else {
                        $option['productprice'] = 0;
                    }
                    pdo_insert('ewei_shop_goods_option', $option);
                }
            }
            plog('api.upload', '客户端1688抓取宝贝 id:' . $cath_id);
            show_json(1, '抓取成功');
        }else{
            show_json( 0);
        }
    }

    private function api_jd($cath_id=0,$catch_url='',$pageSource=''){
        global $_W;
        $merchid=$_W['merchid'];
        if(!empty($pageSource)){
            $pageSource=html_entity_decode($pageSource);
            phpQuery::newDocument($pageSource);//输入入参数为html
            //替换标签中的src
            foreach(pq('img') as $img){
                if($img->getAttribute('data-lazyload')!=''){
                    pq($img)->attr('src', $img->getAttribute('data-lazyload'));
                    pq($img)->removeAttr('data-lazyload');
                }
            }

            $thumb_url = array();
            foreach (pq("#spec-list ul li") as $li) {
                $v=pq('img',$li)->attr('src');
                if (substr($v, 0, 2) == "//") {
                    $v = "http://" . substr($v, 2);
                }
                //替换路径
                $v=str_replace("n5/s54x54_","n1/s350x449_",$v);
                $v=str_replace("n5/s50x64_","n1/s350x449_",$v);
                $v=str_replace("/n5/","/n1/",$v);
                $thumb_url[] = $this->save_image($v, 1);
            }
            $thumb = $thumb_url[0];
            unset($thumb_url[0]);

            $minprice = floatval(pq('.summary-price-wrap .p-price .price')->text());
            $maxprice = floatval(pq('.summary-price-wrap .p-price .price')->text());

            $detail['content']=pq('#J-detail-content')->html();
            $detail['content'] = $this->contentpasswh($detail['content']);

            //存储详情图 background
            preg_match_all("/background-image:url\((.*?(?:[\.gif|\.jpg]?))\)/", $detail['content'], $bgimgs);
            if(isset($bgimgs[1]) && !empty($bgimgs[1])){
                $detail['content']='';
                foreach ($bgimgs[1] as $img){
                    if (substr($img, 0, 2) == "//") {
                        $img = "http://" . substr($img, 2);
                    }
                    $detail['content'].='<img src="'.$this->save_image($img, true).'">';
                }
            }else{
                //存储详情图<img>
                preg_match_all("/<img.*?src=[\\\'| \\\"](.*?(?:[\.gif|\.jpg]?))[\\\'|\\\"].*?[\/]?>/", $detail['content'], $imgs);
                if (isset($imgs[1])) {
                    foreach ($imgs[1] as $img) {
                        $catchimg = $img;
                        if (substr($catchimg, 0, 2) == "//") {
                            $img = "http://" . substr($img, 2);
                        }
                        $im = array(
                            "catchimg" => $catchimg,
                            "system" => $this->save_image($img, true)
                        );
                        $images[] = $im;
                    }
                }
                if (isset($images)) {
                    foreach ($images as $img) {
                        if (!empty($img['system'])) {
                            if (!empty($img['system'])) {
                                $detail['content'] = str_replace($img['catchimg'], $img['system'], $detail['content']);
                            }
                        }

                    }
                }
            }
            $detail['content'] = m('common')->html_to_images($detail['content']);
            $data = array(
                'uniacid' => $_W['uniacid'],
                'thumb' => $thumb,
                'thumb_url' => serialize($thumb_url),
                'title' => trim(pq('.itemInfo-wrap .sku-name')->text()),
                'status' => 0,
                'marketprice' => $maxprice,
                'originalprice' => $minprice,
                'minprice' => $minprice,
                'maxprice' => $maxprice,
                'hasoption' => 0,
                'createtime' => time(),
                'total' => 0,
                'content' => $detail['content'],
                'merchid' => $merchid,
                'cates' => '',
                'checked' => empty($merchid) ? 0 : 1,
                'newgoods' => 1
            );
            //多商户商品是否免审核
            if (!empty($merchid)) {
                if (empty($_W['merch_user']['goodschecked'])) {
                    $data['checked'] = 1;
                } else {
                    $data['checked'] = 0;
                }
            }

            pdo_insert('ewei_shop_goods', $data);
            $goodsid = pdo_insertid();
            if (empty($goodsid)){
                show_json(0, '抓取失败');
            }

            //参数
            $value = array();
            foreach (pq('.p-parameter .parameter2 li') as $li) {
                if (pq($li)->text() != '') {
                    $specArr = explode('：', pq($li)->text());
                    $value[$specArr[0]] = $specArr[1];
                }
            }

            foreach ($value as $key => $val) {
                pdo_insert('ewei_shop_goods_param', array('goodsid' => $goodsid, 'uniacid' => $_W['uniacid'], 'title' => $key, 'value' => $val));
            }
            plog('api.upload', '客户端京东抓取宝贝 id:' . $cath_id);
            show_json(1, '抓取成功');
        }else{
            show_json( 0);
        }
    }




    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //详情图片去掉宽高
    function contentpasswh($content)
    {
        $content = preg_replace('/(?:width)=(\'|").*?\\1/', ' width="100%"', $content);
        $content = preg_replace('/(?:height)=(\'|").*?\\1/', ' ', $content);

        $content = preg_replace('/(?:max-width:\s*\d*\.?\d*(px|rem|em))/', '', $content);
        $content = preg_replace('/(?:max-height:\s*\d*\.?\d*(px|rem|em))/', '', $content);

        $content = preg_replace('/(?:min-width:\s*\d*\.?\d*(px|rem|em))/', ' ', $content);
        $content = preg_replace('/(?:min-height:\s*\d*\.?\d*(px|rem|em))/', ' ', $content);
        return $content;
    }

    //保存远程服务器图片
    function save_image($url, $iscontent)
    {
        global $_W;
        load()->func('communication');

        if(strpos($url,'.jpg')){
            $url=substr($url,0,strpos($url,'.jpg')+4);
        }
        if(strpos($url,'.png')){
            $url=substr($url,0,strpos($url,'.png')+4);
        }
        if(strpos($url,'.gif')){
            $url=substr($url,0,strpos($url,'.gif')+4);
        }
        if(strpos($url,'.jpeg')){
            $url=substr($url,0,strpos($url,'.jpeg')+5);
        }

        $ext = strrchr($url, ".");
        if ($ext != ".jpeg" && $ext != ".gif" && $ext != ".jpg" && $ext != ".png") {
            return $url;
        }
        if (trim($url) == '') {
            return $url;
        }

        $filename = random(32) . $ext;
        $save_dir = ATTACHMENT_ROOT . 'images/' . $_W['uniacid'] . '/' . date('Y') . '/' . date('m') . '/';

        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            return $url;
        }

        $img = ihttp_get($url);
        if (is_error($img)) {
            return "";
        }

        $img = $img['content'];
        if (strlen($img) != 0) {
            file_put_contents($save_dir . $filename, $img);
            $imgdir = 'images/' . $_W['uniacid'] . '/' . date('Y') . '/' . date('m') . '/';
            $saveurl = save_media($imgdir . $filename, true);
            return $saveurl;
        } else {
            return '';
        }

    }

}

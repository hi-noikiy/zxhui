<?php
if( !defined("IN_IA") )
{
    exit( "Access Denied" );
}
require(EWEI_SHOPV2_PLUGIN . "merch/core/inc/page_merch.php");
class Details_EweiShopV2Page extends MerchWebPage{
    public function main(){
        global $_W;
        global $_GPC;
        $status = $_GPC["status"];
        $orderid = intval($_GPC["orderid"]);
        $params = array( ":orderid" => $orderid );
        $order = pdo_fetch("SELECT o.*,g.title,g.category,op.title as optiontitle,g.groupsprice,g.singleprice,g.goodsnum,g.thumb,g.thumb_url,g.id as gid FROM " . tablename("ewei_shop_groups_order") . " as o\r\n\t\t\t\t    left join " . tablename("ewei_shop_groups_goods") . " as g on g.id = o.goodid\r\n\t\t\t\t\tleft join " . tablename("ewei_shop_groups_goods_option") . " as op on op.specs = o.specs\r\n\t\t\t\tWHERE o.id = :orderid ", $params);
        $order = set_medias($order, "thumb");
        if( 0 < $order["more_spec"] && empty($order["optiontitle"]) )
        {
            $data = pdo_fetch("select option_name from " . tablename("ewei_shop_groups_order_goods") . " where groups_order_id = " . $order["id"] . " ");
            $order["optiontitle"] = $data["option_name"];
        }
        $member = m("member")->getMember($order["openid"], true);
        if( $order["verifytype"] == 0 )
        {
            $verify = pdo_fetch("select * from " . tablename("ewei_shop_groups_verify") . " where orderid = " . $order["id"] . " ");
            if( !empty($verify["verifier"]) )
            {
                $saler = m("member")->getMember($verify["verifier"]);
                $saler["salername"] = pdo_fetchcolumn("select salername from " . tablename("ewei_shop_saler") . " where openid=:openid and uniacid=:uniacid limit 1 ", array( ":uniacid" => $_W["uniacid"], ":openid" => $verify["verifier"] ));
            }
            if( !empty($order["storeid"]) )
            {
                $store = pdo_fetch("select * from " . tablename("ewei_shop_store") . " where id=:storeid limit 1 ", array( ":storeid" => $verify["storeid"] ));
            }
        }
        else
        {
            if( $order["verifytype"] == 1 )
            {
                $verifyinfo = pdo_fetchall("select v.*,sm.id as salerid,sm.nickname as salernickname,s.salername,store.storename from " . tablename("ewei_shop_groups_verify") . " as v\r\n\t\t\t\t\tleft join " . tablename("ewei_shop_saler") . " s on s.openid = v.verifier and s.uniacid = v.uniacid\r\n\t\t\t\t\tleft join " . tablename("ewei_shop_member") . " sm on sm.openid = s.openid and sm.uniacid = s.uniacid\r\n\t\t\t\t\tleft join " . tablename("ewei_shop_store") . " store on store.id = v.storeid and store.uniacid = v.uniacid\r\n\t\t\t\t\twhere v.uniacid = :uniacid and v.orderid = :orderid ", array( ":orderid" => $orderid, ":uniacid" => $_W["uniacid"] ));
            }
        }
        if( !empty($order["address"]) )
        {
            $user = unserialize($order["address"]);
            $user["address"] = $user["province"] . "," . $user["city"] . "," . $user["area"] . "," . $user["street"] . "," . $user["address"];
            $item["addressdata"] = array( "realname" => $user["realname"], "mobile" => $user["mobile"], "address" => $user["address"] );
        }
        else
        {
            $user = iunserializer($order["addressid"]);
            if( !is_array($user) )
            {
                $user = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_member_address") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $order["addressid"], ":uniacid" => $_W["uniacid"] ));
            }
            $user["address"] = $user["province"] . "," . $user["city"] . "," . $user["area"] . "," . $user["street"] . "," . $user["address"];
            $item["addressdata"] = array( "realname" => $user["realname"], "mobile" => $user["mobile"], "address" => $user["address"] );
        }
        if( p("diyform") && !empty($order["diyformid"]) )
        {
            $orderdiyformid = $order["diyformid"];
            if( !empty($orderdiyformid) )
            {
                $order_fields = iunserializer($order["diyformfields"]);
                $order_data = iunserializer($order["diyformdata"]);
            }
        }
        include($this->template());
    }
}


?>
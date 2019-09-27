<?php
if( !defined("IN_IA") )
{
    exit( "Access Denied" );
}
require(EWEI_SHOPV2_PLUGIN . "merch/core/inc/page_merch.php");
class Changeaddress_EweiShopV2Page extends MerchWebPage
{
    public function main(){
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        $area_set = m("util")->get_area_config_set();
        $new_area = intval($area_set["new_area"]);
        $address_street = intval($area_set["address_street"]);
        if( empty($item["addressid"]) )
        {
            $user = unserialize($item["carrier"]);
        }
        else
        {
            $user = iunserializer($item["address"]);
            if( !is_array($user) )
            {
                $user = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_member_address") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $item["addressid"], ":uniacid" => $_W["uniacid"] ));
            }
            $address_info = $user["address"];
            $user_address = $user["address"];
            $user["address"] = $user["province"] . " " . $user["city"] . " " . $user["area"] . " " . $user["street"] . " " . $user["address"];
            $item["addressdata"] = $oldaddress = array( "realname" => $user["realname"], "mobile" => $user["mobile"], "address" => $user["address"] );
        }
        if( $_W["ispost"] )
        {
            $realname = $_GPC["realname"];
            $mobile = $_GPC["mobile"];
            $province = $_GPC["province"];
            $city = $_GPC["city"];
            $area = $_GPC["area"];
            $street = $_GPC["street"];
            $changead = intval($_GPC["changead"]);
            $address = trim($_GPC["address"]);
            if( !empty($id) )
            {
                if( empty($realname) )
                {
                    $ret = "请填写收件人姓名！";
                    show_json(0, $ret);
                }
                if( empty($mobile) )
                {
                    $ret = "请填写收件人手机！";
                    show_json(0, $ret);
                }
                if( $province == "请选择省份" )
                {
                    $ret = "请选择省份！";
                    show_json(0, $ret);
                }
                if( empty($address) )
                {
                    $ret = "请填写详细地址！";
                    show_json(0, $ret);
                }
                $item = pdo_fetch("SELECT id, orderno, address FROM " . tablename("ewei_shop_groups_order") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $id, ":uniacid" => $_W["uniacid"] ));
                $address_array = iunserializer($item["address"]);
                $address_array["realname"] = $realname;
                $address_array["mobile"] = $mobile;
                if( $changead )
                {
                    $address_array["province"] = $province;
                    $address_array["city"] = $city;
                    $address_array["area"] = $area;
                    $address_array["street"] = $street;
                    $address_array["address"] = $address;
                }
                else
                {
                    $address_array["province"] = $user["province"];
                    $address_array["city"] = $user["city"];
                    $address_array["area"] = $user["area"];
                    $address_array["street"] = $user["street"];
                    $address_array["address"] = $user_address;
                }
                $address_array = iserializer($address_array);
                pdo_update("ewei_shop_groups_order", array( "address" => $address_array ), array( "id" => $id, "uniacid" => $_W["uniacid"] ));
                plog("groups.order.changeaddress", "修改收货地址 ID: " . $item["id"] . " 订单号: " . $item["orderno"] . " <br>原地址: 收件人: " . $oldaddress["realname"] . " 手机号: " . $oldaddress["mobile"] . " 收件地址: " . $oldaddress["address"] . "<br>新地址: 收件人: " . $realname . " 手机号: " . $mobile . " 收件地址: " . $province . " " . $city . " " . $area . " " . $address);
                show_json(1);
            }
        }
        include($this->template());
    }
    protected function opData()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        $item = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_groups_order") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $id, ":uniacid" => $_W["uniacid"] ));
        if( empty($item) )
        {
            if( $_W["isajax"] )
            {
                show_json(0, "未找到订单!");
            }
            $this->message("未找到订单!", "", "error");
        }
        return array( "id" => $id, "item" => $item );
    }
}

?>
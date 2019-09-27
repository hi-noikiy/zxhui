<?php
if( !defined("IN_IA") )
{
    exit( "Access Denied" );
}
require(EWEI_SHOPV2_PLUGIN . "merch/core/inc/page_merch.php");
class Remarksaler_EweiShopV2Page extends MerchWebPage
{
    public function main(){
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        if( $_W["ispost"] )
        {
            pdo_update("ewei_shop_groups_order", array( "remark" => $_GPC["remark"] ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));
            plog("groups.order.remarksaler", "订单备注 ID: " . $item["id"] . " 订单号: " . $item["orderno"] . " 备注内容: " . $_GPC["remark"]);
            show_json(1);
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
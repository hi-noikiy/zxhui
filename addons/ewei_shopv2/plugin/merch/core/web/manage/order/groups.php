<?php
if( !defined("IN_IA") )
{
    exit( "Access Denied" );
}
require(EWEI_SHOPV2_PLUGIN . "merch/core/inc/page_merch.php");
class Groups_EweiShopV2Page extends MerchWebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $status = $_GPC["status"];
        $merchid = $_W['merchid'];
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 10;
        $condition = " and o.uniacid=:uniacid   ";
        $params = array( ":uniacid" => $_W["uniacid"] );
        if( intval($status) == 1 )
        {
            $condition .= " and o.status = :status and (o.success = :success or o.is_team = :is_team) ";
            $params[":status"] = 1;
            $params[":success"] = 1;
            $params[":is_team"] = 0;
        }
        else
        {
            if( intval($status) == 2 )
            {
                $condition .= " and o.status = :status ";
                $params[":status"] = 2;
            }
            else
            {
                if( intval($status) == 3 )
                {
                    $condition .= " and o.status = :status ";
                    $params[":status"] = 0;
                }
                else
                {
                    if( intval($status) == 4 )
                    {
                        $condition .= " and o.status = :status ";
                        $params[":status"] = 3;
                    }
                    else
                    {
                        if( intval($status) == 5 )
                        {
                            $condition .= " and o.status = :status ";
                            $params[":status"] = -1;
                        }
                    }
                }
            }
        }
        if( empty($starttime) || empty($endtime) )
        {
            $starttime = strtotime("-1 month");
            $endtime = time();
        }
        $searchtime = trim($_GPC["searchtime"]);
        if( !empty($searchtime) )
        {
            $condition .= " and o." . $searchtime . "time > " . strtotime($_GPC["time"]["start"]) . " and o." . $searchtime . "time < " . strtotime($_GPC["time"]["end"]) . " ";
            $starttime = strtotime($_GPC["time"]["start"]);
            $endtime = strtotime($_GPC["time"]["end"]);
        }
        if( !empty($_GPC["paytype"]) )
        {
            $_GPC["paytype"] = trim($_GPC["paytype"]);
            $condition .= " and o.pay_type = :paytype";
            $params[":paytype"] = $_GPC["paytype"];
        }
        if( !empty($_GPC["searchfield"]) && !empty($_GPC["keyword"]) )
        {
            $searchfield = trim(strtolower($_GPC["searchfield"]));
            $_GPC["keyword"] = trim($_GPC["keyword"]);
            $params[":keyword"] = $_GPC["keyword"];
            if( $searchfield == "orderno" )
            {
                $condition .= " AND locate(:keyword,o.orderno)>0 ";
            }
            else
            {
                if( $searchfield == "member" )
                {
                    $condition .= " AND (locate(:keyword,m.realname)>0 or locate(:keyword,m.mobile)>0 or locate(:keyword,m.nickname)>0)";
                }
                else
                {
                    if( $searchfield == "address" )
                    {
                        $condition .= " AND ( locate(:keyword,a.realname)>0 or locate(:keyword,a.mobile)>0) ";
                    }
                    else
                    {
                        if( $searchfield == "expresssn" )
                        {
                            $condition .= " AND locate(:keyword,o.expresssn)>0";
                        }
                        else
                        {
                            if( $searchfield == "goodstitle" )
                            {
                                $condition .= " and locate(:keyword,g.title)>0 ";
                            }
                            else
                            {
                                if( $searchfield == "goodssn" )
                                {
                                    $condition .= " and locate(:keyword,g.goodssn)>0 ";
                                }
                            }
                        }
                    }
                }
            }
        }
        if( empty($_GPC["export"]) )
        {
            $page = "LIMIT " . ($pindex - 1) * $psize . "," . $psize;
        }
        $list = pdo_fetchall("SELECT o.id,o.orderno,o.status,o.expresssn,o.paytime,o.addressid,o.express,o.remark,o.is_team,o.pay_type,o.isverify,o.refundtime,o.price,o.creditmoney,o.refundstate,o.refundid,o.message,\r\n\t\t\t\to.freight,o.discount,o.creditmoney,o.createtime,o.success,o.deleted,o.address,o.message,o.openid,g.thumb_url,og.option_name as optionname,\r\n\t\t\t\tg.title,g.category,g.goodsnum,g.thumb,g.groupsprice,g.singleprice,g.price as gprice,g.goodssn,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea,a.address as aaddress\r\n\t\t\t\tFROM " . tablename("ewei_shop_groups_order") . " as o\r\n\t\t\t\tleft join " . tablename("ewei_shop_groups_goods") . " as g on g.id = o.goodid\r\n\t\t\t\tleft join " . tablename("ewei_shop_member") . " m on m.openid=o.openid and m.uniacid =  o.uniacid\r\n\t\t\t\tleft join " . tablename("ewei_shop_member_address") . " a on a.id=o.addressid\r\n\t\t\t\tleft join " . tablename("ewei_shop_groups_order_goods") . " as og on og.groups_order_id = o.id\r\n\t\t\t\tWHERE 1 and g.merchid=".$merchid . $condition . " GROUP BY o.id  ORDER BY o.createtime DESC " . $page, $params);
        foreach( $list as $key => $value )
        {
            if( !empty($value["address"]) )
            {
                $user = unserialize($value["address"]);
                $list[$key]["addressdata"] = array( "realname" => $user["realname"], "mobile" => $user["mobile"], "province" => $user["province"], "city" => $user["city"], "area" => $user["area"], "street" => $user["street"], "address" => $user["address"] );
            }
            else
            {
                $user = iunserializer($value["addressid"]);
                if( !is_array($user) )
                {
                    $user = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_member_address") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $value["addressid"], ":uniacid" => $_W["uniacid"] ));
                }
                $list[$key]["addressdata"] = array( "realname" => $user["realname"], "mobile" => $user["mobile"], "province" => $user["province"], "city" => $user["city"], "area" => $user["area"], "street" => $user["street"], "address" => $user["address"] );
            }
        }
        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename("ewei_shop_groups_order") . " as o\r\n\t\t\t\tleft join " . tablename("ewei_shop_groups_goods") . " as g on g.id = o.goodid\r\n\t\t\t\tleft join " . tablename("ewei_shop_member") . " m on m.openid=o.openid and m.uniacid =  o.uniacid\r\n\t\t\t\tleft join " . tablename("ewei_shop_member_address") . " a on a.id=o.addressid\r\n\t\t\t\tWHERE 1 " . $condition . " ", $params);
        $pager = pagination2($total, $pindex, $psize);
        $paytype = array( "credit" => "余额支付", "wechat" => "微信支付", "other" => "其他支付" );
        $paystatus = array( "未付款", "已付款", "待收货", "已完成", -1 => "已取消", 4 => "待发货" );
        if( $_GPC["export"] == 1 )
        {
            plog("groups.order.export", "导出订单");
            $columns = array( array( "title" => "订单编号", "field" => "orderno", "width" => 24 ), array( "title" => "粉丝昵称", "field" => "nickname", "width" => 12 ), array( "title" => "会员姓名", "field" => "mrealname", "width" => 12 ), array( "title" => "openid", "field" => "openid", "width" => 30 ), array( "title" => "会员手机手机号", "field" => "amobile", "width" => 15 ), array( "title" => "收货姓名(或自提人)", "field" => "arealname", "width" => 15 ), array( "title" => "联系电话", "field" => "amobile", "width" => 12 ), array( "title" => "收货地址", "field" => "aprovince", "width" => 12 ), array( "title" => "", "field" => "acity", "width" => 12 ), array( "title" => "", "field" => "aarea", "width" => 12 ), array( "title" => "", "field" => "street", "width" => 15 ), array( "title" => "", "field" => "aaddress", "width" => 20 ), array( "title" => "商品名称", "field" => "title", "width" => 30 ), array( "title" => "商品编码", "field" => "goodssn", "width" => 15 ), array( "title" => "商品规格", "field" => "optionname", "width" => 30 ), array( "title" => "团购价", "field" => "groupsprice", "width" => 12 ), array( "title" => "单购价", "field" => "singleprice", "width" => 12 ), array( "title" => "原价", "field" => "price", "width" => 12 ), array( "title" => "商品数量", "field" => "goods_total", "width" => 15 ), array( "title" => "商品小计", "field" => "goodsprice", "width" => 12 ), array( "title" => "积分抵扣", "field" => "credit", "width" => 12 ), array( "title" => "积分抵扣金额", "field" => "creditmoney", "width" => 12 ), array( "title" => "运费", "field" => "freight", "width" => 12 ), array( "title" => "应收款", "field" => "amount", "width" => 12 ), array( "title" => "支付方式", "field" => "pay_type", "width" => 12 ), array( "title" => "状态", "field" => "status", "width" => 12 ), array( "title" => "下单时间", "field" => "createtime", "width" => 24 ), array( "title" => "付款时间", "field" => "paytime", "width" => 24 ), array( "title" => "发货时间", "field" => "sendtime", "width" => 24 ), array( "title" => "完成时间", "field" => "finishtime", "width" => 24 ), array( "title" => "快递公司", "field" => "expresscom", "width" => 24 ), array( "title" => "快递单号", "field" => "expresssn", "width" => 24 ), array( "title" => "买家备注", "field" => "message", "width" => 36 ), array( "title" => "卖家备注", "field" => "remark", "width" => 36 ) );
            $exportlist = array( );
            foreach( $list as $key => $value )
            {
                $r["orderno"] = $value["orderno"];
                $r["nickname"] = str_replace("=", "", $value["nickname"]);
                $r["mrealname"] = $value["mrealname"];
                $r["openid"] = $value["openid"];
                $r["mmobile"] = $value["mmobile"];
                $r["arealname"] = $value["addressdata"]["realname"];
                $r["amobile"] = $value["addressdata"]["mobile"];
                $r["aprovince"] = $value["addressdata"]["province"];
                $r["acity"] = $value["addressdata"]["city"];
                $r["aarea"] = $value["addressdata"]["area"];
                $r["street"] = $value["addressdata"]["street"];
                $r["aaddress"] = $value["addressdata"]["address"];
                $r["pay_type"] = $paytype["" . $value["pay_type"] . ""];
                $r["freight"] = $value["freight"];
                $r["groupsprice"] = $value["groupsprice"];
                $r["singleprice"] = $value["singleprice"];
                $r["price"] = $value["price"];
                $r["credit"] = (!empty($value["credit"]) ? "-" . $value["credit"] : 0);
                $r["creditmoney"] = (!empty($value["creditmoney"]) ? "-" . $value["creditmoney"] : 0);
                $r["goodsprice"] = $value["groupsprice"] * 1;
                $r["status"] = ($value["status"] == 1 && $value["status"] == 1 ? $paystatus[4] : $paystatus["" . $value["status"] . ""]);
                $r["createtime"] = date("Y-m-d H:i:s", $value["createtime"]);
                $r["paytime"] = (!empty($value["paytime"]) ? date("Y-m-d H:i:s", $value["paytime"]) : "");
                $r["sendtime"] = (!empty($value["sendtime"]) ? date("Y-m-d H:i:s", $value["sendtime"]) : "");
                $r["finishtime"] = (!empty($value["finishtime"]) ? date("Y-m-d H:i:s", $value["finishtime"]) : "");
                $r["expresscom"] = $value["expresscom"];
                $r["expresssn"] = $value["expresssn"];
                $r["amount"] = $value["groupsprice"] * 1 - $value["creditmoney"] + $value["freight"];
                $r["message"] = $value["message"];
                $r["remark"] = $value["remark"];
                $r["title"] = $value["title"];
                $r["goodssn"] = $value["goodssn"];
                $r["optionname"] = $value["optionname"];
                $r["goods_total"] = 1;
                $exportlist[] = $r;
            }
            unset($r);
            m("excel")->export($exportlist, array( "title" => "订单数据-" . date("Y-m-d-H-i", time()), "columns" => $columns ));
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
    public function delete()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        $item = pdo_fetch("SELECT id,isverify,refundid  FROM " . tablename("ewei_shop_groups_order") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $id, ":uniacid" => $_W["uniacid"] ));
        if( empty($item) )
        {
            show_json(0, "抱歉，订单不存在或是已经被删除！");
        }
        pdo_delete("ewei_shop_groups_order", array( "id" => $id, "uniacid" => $_W["uniacid"] ));
        if( 0 < $item["isverify"] )
        {
            pdo_delete("ewei_shop_groups_verify", array( "orderid" => $id, "uniacid" => $_W["uniacid"] ));
        }
        if( 0 < $item["refundid"] )
        {
            pdo_delete("ewei_shop_groups_order_refund", array( "orderid" => $id, "uniacid" => $_W["uniacid"] ));
        }
        plog("groups.order.delete", "删除拼团订单 ID: " . $id . " 标题: " . $item["name"] . " ");
        show_json(1);
    }
    public function pay($a = array( ), $b = array( ))
    {
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        if( 1 < $item["status"] )
        {
            show_json(0, "订单已付款，不需重复付款！");
        }
        if( !empty($item["virtual"]) && c("virtual") )
        {
            c("virtual")->pay($item);
        }
        else
        {
            pdo_update("ewei_shop_groups_order", array( "status" => 1, "pay_type" => "other", "paytime" => time(), "starttime" => time() ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));
            p("groups")->sendTeamMessage($item["id"]);
        }
        plog("groups.order.pay", "订单确认付款 ID: " . $item["id"] . " 订单号: " . $item["orderno"]);
        show_json(1);
    }
    public function send()
    {
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        if( empty($item["addressid"]) )
        {
            show_json(0, "无收货地址，无法发货！");
        }
        if( $item["pay_type"] == "" || $item["status"] == 0 )
        {
            show_json(0, "订单未付款，无法发货！");
        }
        if( $_W["ispost"] )
        {
            if( !empty($_GPC["isexpress"]) && empty($_GPC["expresssn"]) )
            {
                show_json(0, "请输入快递单号！");
            }
            if( !empty($item["transid"]) )
            {
            }
            pdo_update("ewei_shop_groups_order", array( "status" => 2, "express" => trim($_GPC["express"]), "expresscom" => trim($_GPC["expresscom"]), "expresssn" => trim($_GPC["expresssn"]), "sendtime" => time() ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));
            if( !empty($item["refundid"]) )
            {
                $refund = pdo_fetch("select * from " . tablename("ewei_shop_groups_order_refund") . " where id=:id limit 1", array( ":id" => $item["refundid"] ));
                if( !empty($refund) )
                {
                    pdo_update("ewei_shop_groups_order_refund", array( "status" => -1, "endtime" => $time ), array( "id" => $item["refundid"] ));
                    pdo_update("ewei_shop_groups_order", array( "refundstate" => 0 ), array( "id" => $item["id"] ));
                }
            }
            $this->model->sendTeamMessage($item["id"]);
            plog("groups.order.send", "订单发货 ID: " . $item["id"] . " 订单号: " . $item["ordersn"] . " <br/>快递公司: " . $_GPC["expresscom"] . " 快递单号: " . $_GPC["expresssn"]);
            show_json(1);
        }
        $address = iunserializer($item["address"]);
        if( !is_array($address) )
        {
            $address = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_member_address") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $item["addressid"], ":uniacid" => $_W["uniacid"] ));
        }
        $express_list = m("express")->getExpressList();
        include($this->template());
    }
    public function sendcancel()
    {
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        if( $item["status"] != 2 )
        {
            show_json(0, "订单未发货，不需取消发货！");
        }
        if( $_W["ispost"] )
        {
            if( !empty($item["transid"]) )
            {
            }
            $remark = trim($_GPC["remark"]);
            if( !empty($item["remarksend"]) )
            {
                $remark = $item["remarksend"] . "\r\n" . $remark;
            }
            pdo_update("ewei_shop_groups_order", array( "status" => 1, "sendtime" => 0, "remarksend" => $remark ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));
            plog("groups.order.sendcancel", "订单取消发货 ID: " . $item["id"] . " 订单号: " . $item["orderno"] . " 原因: " . $remark);
            show_json(1);
        }
        include($this->template());
    }
    public function changeexpress()
    {
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        $edit_flag = 1;
        if( $_W["ispost"] )
        {
            $express = $_GPC["express"];
            $expresscom = $_GPC["expresscom"];
            $expresssn = trim($_GPC["expresssn"]);
            if( empty($id) )
            {
                $ret = "参数错误！";
                show_json(0, $ret);
            }
            if( !empty($expresssn) )
            {
                $change_data = array( );
                $change_data["express"] = $express;
                $change_data["expresscom"] = $expresscom;
                $change_data["expresssn"] = $expresssn;
                pdo_update("ewei_shop_groups_order", $change_data, array( "id" => $id, "uniacid" => $_W["uniacid"] ));
                plog("groups.order.changeexpress", "修改快递状态 ID: " . $item["id"] . " 订单号: " . $item["orderno"] . " 快递公司: " . $expresscom . " 快递单号: " . $expresssn);
                show_json(1);
            }
            else
            {
                show_json(0, "请填写快递单号！");
            }
        }
        $address = iunserializer($item["address"]);
        if( !is_array($address) )
        {
            $address = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_member_address") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $item["addressid"], ":uniacid" => $_W["uniacid"] ));
        }
        $express_list = m("express")->getExpressList();
        include($this->template("groups/order/send"));
    }
    public function finish()
    {
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        pdo_update("ewei_shop_groups_order", array( "status" => 3, "finishtime" => time() ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));
        p("groups")->sendTeamMessage($item["id"]);
        plog("groups.order.finish", "订单完成 ID: " . $item["id"] . " 订单号: " . $item["orderno"]);
        show_json(1);
    }
    public function enabled()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC["id"]);
        if( empty($id) )
        {
            $id = (is_array($_GPC["ids"]) ? implode(",", $_GPC["ids"]) : 0);
        }
        $items = pdo_fetchall("SELECT id,name FROM " . tablename("ewei_shop_groups_order") . " WHERE id in( " . $id . " ) AND uniacid=" . $_W["uniacid"]);
        foreach( $items as $item )
        {
            pdo_update("ewei_shop_groups_order", array( "enabled" => intval($_GPC["enabled"]) ), array( "id" => $item["id"] ));
            plog("groups.order.edit", ("修改订单商品<br/>ID: " . $item["id"] . "<br/>标题: " . $item["name"] . "<br/>状态: " . $_GPC["enabled"] == 1 ? "显示" : "隐藏"));
        }
        show_json(1, array( "url" => referer() ));
    }
    public function ajaxorder()
    {
        global $_GPC;
        $day = (int) $_GPC["day"];
        $orderPrice = $this->selectOrderPrice($day);
        $orderPrice["avg"] = (empty($orderPrice["count_avg"]) ? 0 : number_format($orderPrice["price"] / $orderPrice["count_avg"], 2));
        $orderPrice["price"] = number_format($orderPrice["price"], 2);
        $orderPrice["count"] = number_format($orderPrice["count"]);
        unset($orderPrice["fetchall"]);
        echo json_encode($orderPrice);
    }
    protected function selectOrderPrice($day = 0)
    {
        global $_W;
        $day = (int) $day;
        if( $day == 1 )
        {
            $createtime1 = strtotime(date("Y-m-d", time() - 3600 * 24));
            $createtime2 = strtotime(date("Y-m-d", time()));
        }
        else
        {
            if( 1 < $day )
            {
                $createtime1 = strtotime(date("Y-m-d", time() - $day * 3600 * 24));
                $createtime2 = strtotime(date("Y-m-d", time() + 3600 * 24));
            }
            else
            {
                $createtime1 = strtotime(date("Y-m-d", time()));
                $createtime2 = strtotime(date("Y-m-d", time() + 3600 * 24));
            }
        }
        $sql = "select id,price,freight,starttime,openid,creditmoney from " . tablename("ewei_shop_groups_order") . " where uniacid = :uniacid and status > 0 and paytime between :createtime1 and :createtime2 ";
        $param = array( ":uniacid" => $_W["uniacid"], ":createtime1" => $createtime1, ":createtime2" => $createtime2 );
        $pdo_res = pdo_fetchall($sql, $param);
        $price = 0;
        foreach( $pdo_res as $key => $value )
        {
            $price += floatval($value["price"] - $value["creditmoney"] + $value["freight"]);
        }
        $new1 = "";
        if( !empty($pdo_res) )
        {
            foreach( $pdo_res as $k => $na )
            {
                $new[$k] = serialize($na["openid"]);
            }
            $uniq = array_unique($new);
            foreach( $uniq as $k => $ser )
            {
                $new1[$k] = unserialize($ser);
            }
        }
        $result = array( "price" => $price, "count" => count($pdo_res), "count_avg" => count($new1), "fetchall" => $pdo_res );
        return $result;
    }
    public function ajaxteam()
    {
        global $_GPC;
        $success = intval($_GPC["success"]);
        $orderPrice = $this->selectTeamPrice($success);
        $orderPrice["price"] = number_format($orderPrice["price"], 2);
        $orderPrice["count"] = number_format($orderPrice["count"]);
        unset($orderPrice["fetchall"]);
        echo json_encode($orderPrice);
    }
    protected function selectteamPrice($success = 0)
    {
        global $_W;
        $success = intval($success);
        $sql = "select id,price,freight,starttime from " . tablename("ewei_shop_groups_order") . " where uniacid = :uniacid and paytime > 0 and is_team = 1 and heads = :heads and success = :success ";
        $param = array( ":uniacid" => $_W["uniacid"], ":success" => $success, ":heads" => 1 );
        $pdo_res = pdo_fetchall($sql, $param);
        $price = 0;
        foreach( $pdo_res as $key => $value )
        {
            $price += floatval($value["price"] + $value["freight"]);
        }
        $result = array( "price" => $price, "count" => count($pdo_res), "fetchall" => $pdo_res );
        return $result;
    }
    public function close()
    {
        global $_W;
        global $_GPC;
        $opdata = $this->opData();
        extract($opdata);
        if( $item["status"] == -1 )
        {
            show_json(0, "订单已关闭，无需重复关闭！");
        }
        else
        {
            if( 1 <= $item["status"] )
            {
                show_json(0, "订单已付款，不能关闭！");
            }
        }
        if( $_W["ispost"] )
        {
            if( !empty($item["transid"]) )
            {
            }
            $time = time();
            if( 0 < $item["refundstate"] && !empty($item["refundid"]) )
            {
                $change_refund = array( );
                $change_refund["refundstatus"] = -1;
                $change_refund["refundtime"] = $time;
                pdo_update("ewei_shop_groups_order_refund", $change_refund, array( "id" => $item["refundid"], "uniacid" => $_W["uniacid"] ));
            }
            pdo_update("ewei_shop_groups_order", array( "status" => -1, "refundstate" => 0, "canceltime" => $time, "remarkclose" => trim($_GPC["remark"]) ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));
            plog("groups.order.close", "订单关闭 ID: " . $item["id"] . " 订单号: " . $item["orderno"]);
            show_json(1);
        }
        include($this->template());
    }
    public function ajaxgettotals()
    {
        $totals = $this->model->getTotals();
        $result = (empty($totals) ? array( ) : $totals);
        show_json(1, $result);
    }
}
?>
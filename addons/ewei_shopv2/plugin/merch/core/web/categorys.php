<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
class Categorys_EweiShopV2Page extends PluginWebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		if( $_W["ispost"] && !empty($_GPC["datas"]) ) 
		{
			$datas = json_decode(html_entity_decode($_GPC["datas"]), true);
			if( !is_array($datas) ) 
			{
				show_json(0, "类目保存失败，请重试!");
			}
			$cateids = array( );
			$displayorder = count($datas);
			foreach( $datas as $row ) 
			{
				$cateids[] = $row["id"];
				pdo_update("ewei_smerchants_category", array( "parentid" => 0, "displayorder" => $displayorder, "level" => 1 ), array( "id" => $row["id"] ));
				if( $row["children"] && is_array($row["children"]) ) 
				{
					$displayorder_child = count($row["children"]);
					foreach( $row["children"] as $child ) 
					{
						$cateids[] = $child["id"];
						pdo_query("update " . tablename("ewei_smerchants_category") . " set  parentid=:parentid,displayorder=:displayorder,level=2 where id=:id", array( ":displayorder" => $displayorder_child, ":parentid" => $row["id"], ":id" => $child["id"] ));
						$displayorder_child--;
						if( $child["children"] && is_array($child["children"]) ) 
						{
							$displayorder_third = count($child["children"]);
							foreach( $child["children"] as $third ) 
							{
								$cateids[] = $third["id"];
								pdo_query("update " . tablename("ewei_smerchants_category") . " set  parentid=:parentid,displayorder=:displayorder,level=3 where id=:id", array( ":displayorder" => $displayorder_third, ":parentid" => $child["id"], ":id" => $third["id"] ));
								$displayorder_third--;
								if( $third["children"] && is_array($third["children"]) ) 
								{
									$displayorder_fourth = count($third["children"]);
									foreach( $child["children"] as $fourth ) 
									{
										$cateids[] = $fourth["id"];
										pdo_query("update " . tablename("ewei_smerchants_category") . " set  parentid=:parentid,displayorder=:displayorder,level=3 where id=:id", array( ":displayorder" => $displayorder_third, ":parentid" => $third["id"], ":id" => $fourth["id"] ));
										$displayorder_fourth--;
									}
								}
							}
						}
					}
				}
				$displayorder--;
			}
			if( !empty($cateids) ) 
			{
				pdo_query("delete from " . tablename("ewei_smerchants_category") . " where id not in (" . implode(",", $cateids) . ") and uniacid=:uniacid", array( ":uniacid" => $_W["uniacid"] ));
			}
			//plog("smerchants.category.edit", "批量修改类目的层级及排序");
			//m("shop")->getCategory(true);
			//m("shop")->getAllCategory(true);
			show_json(1);
		}
		$children = array( );
		$category = pdo_fetchall("SELECT * FROM " . tablename("ewei_smerchants_category") . " WHERE uniacid = '" . $_W["uniacid"] . "' ORDER BY parentid ASC, displayorder DESC");
		foreach( $category as $index => $row ) 
		{

        $types = pdo_fetch('select id,merchname from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $row['merch_id'], ':uniacid' => $_W['uniacid']));

        $category[$index]['merchname'] = $types['merchname'];
			
            if( !empty($row["parentid"]) ) 
			{
				$children[$row["parentid"]][] = $row;
				unset($category[$index]);
			}
		}
		include($this->template());
	}
	public function add() 
	{
		$this->post();
	}
	public function edit() 
	{
		$this->post();
	}
	protected function post() 
	{
		global $_W;
		global $_GPC;
		$parentid = intval($_GPC["parentid"]);
		$id = intval($_GPC["id"]);
		if( !empty($id) ) 
		{
			$item = pdo_fetch("SELECT * FROM " . tablename("ewei_smerchants_category") . " WHERE id = '" . $id . "' limit 1");
			$parentid = $item["parentid"];
		}
		else 
		{
			$item = array( "displayorder" => 0 );
		}
		if( !empty($parentid) ) 
		{
			$parent = pdo_fetch("SELECT id, parentid, name FROM " . tablename("ewei_smerchants_category") . " WHERE id = '" . $parentid . "' limit 1");
			if( empty($parent) ) 
			{
				$this->message("抱歉，上级类目不存在或是已经被删除！", webUrl("smerchants/category/add"), "error");
			}
			if( !empty($parent["parentid"]) ) 
			{
				$parent1 = pdo_fetch("SELECT id, name FROM " . tablename("ewei_smerchants_category") . " WHERE id = '" . $parent["parentid"] . "' limit 1");
			}
		}
		if( empty($parent) ) 
		{
			$level = 1;
		}
		else 
		{
			if( empty($parent["parentid"]) ) 
			{
				$level = 2;
			}
			else 
			{
				$level = 3;
			}
		}
		if( !empty($item) ) 
		{
			$item["url"] = mobileUrl("smerchants", array( "cate" => $item["id"] ), 1);
			$item["qrcode"] = m("qrcode")->createQrcode($item["url"]);
		}
		if( $_W["ispost"] ) 
		{

        	if (empty($_GPC['advimg'])) {
				show_json(0, '品牌LOGO图片不能为空');
			}

			$data = array( 
            "uniacid" => $_W["uniacid"], 
            "name" => trim($_GPC["catename"]), 
            "merch_id"=>intval($_GPC["merchid"]),
            "enabled" => intval($_GPC["enabled"]), 
            "displayorder" => intval($_GPC["displayorder"]), 
            "isrecommand" => intval($_GPC["isrecommand"]), 
            "ishome" => intval($_GPC["ishome"]), 
            "description" => $_GPC["description"], 
            "parentid" => intval($parentid), 
            "thumb" => save_media($_GPC["thumb"]), 
            "advimg" => save_media($_GPC["advimg"]), 
            "advurl" => trim($_GPC["advurl"]), "level" => $level 
            );
			if( !empty($id) ) 
			{
				unset($data["parentid"]);
				pdo_update("ewei_smerchants_category", $data, array( "id" => $id ));
				load()->func("file");
				file_delete($_GPC["thumb_old"]);
				plog("smerchants.category.edit", "修改类目 ID: " . $id);
			}
			else 
			{
            $merch_id = pdo_fetch("SELECT * FROM " . tablename("ewei_smerchants_category") . " WHERE merch_id = '" . $_GPC["merchid"] . "' limit 1");

            if($merch_id) 
            {
                show_json(0, "此商家已创建过品牌!");
            }
				pdo_insert("ewei_smerchants_category", $data);
				$id = pdo_insertid();
				plog("smerchants.category.add", "添加类目 ID: " . $id);
			}
			//m("shop")->getCategory(true);
			//m("shop")->getAllCategory(true);
			show_json(1, array( "url" => webUrl("merch/categorys") ));
		}
        $merchres = pdo_fetch('select id,merchname from ' . tablename('ewei_shop_merch_user') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $item['merch_id'], ':uniacid' => $_W['uniacid']));
		include($this->template());
	}
	public function delete() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC["id"]);
		$item = pdo_fetch("SELECT id, name, parentid FROM " . tablename("ewei_smerchants_category") . " WHERE id = '" . $id . "'");
		if( empty($item) ) 
		{
			$this->message("抱歉，类目不存在或是已经被删除！", webUrl("merch/categorys", array( "op" => "display" )), "error");
		}
		pdo_delete("ewei_smerchants_category", array( "id" => $id, "parentid" => $id ), "OR");
		plog("smerchants.category.delete", "删除类目 ID: " . $id . " 类目名称: " . $item["name"]);
		//m("shop")->getCategory(true);
		show_json(1, array( "url" => referer() ));
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
		$items = pdo_fetchall("SELECT id,name FROM " . tablename("ewei_smerchants_category") . " WHERE id in( " . $id . " ) AND uniacid=" . $_W["uniacid"]);
		foreach( $items as $item ) 
		{
			pdo_update("ewei_smerchants_category", array( "enabled" => intval($_GPC["enabled"]) ), array( "id" => $item["id"] ));
			plog("smerchants.category.edit", ("修改类目状态<br/>ID: " . $item["id"] . "<br/>类目名称: " . $item["name"] . "<br/>状态: " . $_GPC["enabled"] == 1 ? "显示" : "隐藏"));
		}
		m("shop")->getCategory(true);
		show_json(1, array( "url" => referer() ));
	}
	public function query() 
	{
		global $_W;
		global $_GPC;
		$kwd = trim($_GPC["keyword"]);
		$params = array( );
		$params[":uniacid"] = $_W["uniacid"];
		$condition = " and enabled=1 and uniacid=:uniacid";
		if( !empty($kwd) ) 
		{
			$condition .= " AND `name` LIKE :keyword";
			$params[":keyword"] = "%" . $kwd . "%";
		}
		$ds = pdo_fetchall("SELECT * FROM " . tablename("ewei_smerchants_category") . " WHERE 1 " . $condition . " order by displayorder desc,id desc", $params);
		$ds = set_medias($ds, array( "thumb", "advimg" ));
		if( $_GPC["suggest"] ) 
		{
			exit( json_encode(array( "value" => $ds )) );
		}
		include($this->template());
	}
}
?>

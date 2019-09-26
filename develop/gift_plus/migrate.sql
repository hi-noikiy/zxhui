-- 2019-09-17 12:40:49

ALTER TABLE `ims_ewei_shop_goods` ADD `package_price` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '套餐价' AFTER `originalprice`;
ALTER TABLE `ims_ewei_shop_goods` ADD `gift_price` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品结算价' AFTER `package_price`;

CREATE TABLE `ims_ewei_shop_gift_plus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `activity` tinyint(3) NOT NULL DEFAULT 1,
  `orderprice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `goodsid` varchar(255) NOT NULL,
  `giftgoodsid` varchar(255) NOT NULL,
  `starttime` int(11) NOT NULL DEFAULT 0,
  `endtime` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(3) NOT NULL DEFAULT 0,
  `displayorder` int(11) NOT NULL DEFAULT 0,
  `share_title` varchar(255) NOT NULL,
  `share_icon` varchar(255) NOT NULL,
  `share_desc` text NOT NULL,
  `merchant_id` int(11) NOT NULL DEFAULT 0 COMMENT '商户ID'
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='超级赠品表' ROW_FORMAT=COMPACT;

-- 2019-09-22 13:46:11
ALTER TABLE `ims_ewei_shop_order_goods` ADD `is_gift_plus` tinyint(3) NOT NULL DEFAULT 0 COMMENT '是否为超级赠品' AFTER `belongto`;

-- 2019-09-25 13:41:48
ALTER TABLE `ims_ewei_shop_order` ADD `is_gift_plus` tinyint(3) NOT NULL DEFAULT 0 COMMENT '是否包含超级赠品' AFTER `costprice`;

-- 2019-09-25 15:33:14
ALTER TABLE `ims_ewei_shop_order_goods` ADD `gift_price` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品结算价' AFTER `is_gift_plus`;
ALTER TABLE `ims_ewei_shop_order_goods` ADD `gift_price_cost` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品成本价' AFTER `gift_price`;
ALTER TABLE `ims_ewei_shop_order_goods` ADD `gift_price_market` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品成本价' AFTER `gift_price_cost`;

-- 2019-09-26 12:57:15
ALTER TABLE `ims_ewei_shop_order` ADD `gift_plus_price` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品结算价' AFTER `is_gift_plus`;
ALTER TABLE `ims_ewei_shop_order` ADD `gift_plus_cost` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品成本价' AFTER `gift_plus_price`;
ALTER TABLE `ims_ewei_shop_order` ADD `gift_plus_market` DECIMAL(10,2) NULL DEFAULT '0.00' COMMENT '赠品成本价' AFTER `gift_plus_cost`;

-- 2019-09-26 15:11:35
ALTER TABLE `ims_ewei_shop_order_goods` ADD `gift_plus_merchid` int(11) NOT NULL DEFAULT 0 COMMENT '赠品使用商户' AFTER `gift_price_market`;

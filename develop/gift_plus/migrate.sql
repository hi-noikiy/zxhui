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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='超级赠品表' ROW_FORMAT=COMPACT;

-- 2019-09-22 13:46:11
ALTER TABLE `ims_ewei_shop_order_goods` ADD `is_gift_plus` tinyint(3) NOT NULL DEFAULT 0 COMMENT '是否为超级赠品' AFTER `belongto`;
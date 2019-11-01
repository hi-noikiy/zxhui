-- 商品推送
-- 2019-11-01 15:18:12
ALTER TABLE `ims_ewei_shop_goods` ADD `push_rule` text NULL DEFAULT '' COMMENT '商品推送规则' AFTER `isshow`;
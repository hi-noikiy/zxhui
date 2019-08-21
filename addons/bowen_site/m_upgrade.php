<?php 
pdo_query("CREATE TABLE IF NOT EXISTS `ims_bowen_site_articles` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`firstclass` int(11),
`secondclass` int(11),
`thirdclass` int(11),
`themes` varchar(50),
`banner` text(),
`sign` varchar(25),
`icon` text(),
`title` varchar(100),
`subtitle` varchar(200),
`author` varchar(30),
`description` varchar(500),
`thumb` text(),
`images` text(),
`content` text(),
`tag` varchar(254),
`good` int(100),
`reading` int(100),
`value` text(),
`tourl` text(),
`status` tinyint(1),
`istranslate` tinyint(1),
`displayorder` int(10),
`updatetime` int(10),
`createtime` int(10),
`content2` text(),
`content3` text(),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_classes` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`topid` int(11),
`parid` int(11),
`level` tinyint(1),
`title` varchar(30),
`subtitle` varchar(200),
`description` text(),
`sign` varchar(10),
`themes` varchar(10),
`thumb` text(),
`tourl` text(),
`value` text(),
`status` tinyint(1),
`displayorder` int(10),
`createtime` int(10),
`icon` text(),
`images` text(),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_diyform_data` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`dfid` int(11),
`openid` varchar(50),
`fields` text(),
`data` text(),
`status` tinyint(1),
`remark` varchar(255),
`createtime` int(10),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_diyform_template` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`cid` int(11),
`title` varchar(100),
`fields` text(),
`iscache` tinyint(1),
`status` tinyint(1),
`updatetime` int(10),
`createtime` int(10),
`description` text(),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_domain` (
`id` int(10) NOT NULL  AUTO_INCREMENT,
`domain` varchar(50),
`uniacid` int(11),
`tourl` text(),
`endtime` int(10),
`remark` varchar(250),
`status` tinyint(1),
`createtime` int(10),
`displayorder` int(3),
`ishttps` tinyint(1),
`compatible_site_welcome_module` varchar(50),
`type` tinyint(1),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_msg_sign` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`type` tinyint(3),
`taskid` int(11),
`openid` varchar(50),
`nickname` varchar(100),
`param` text(),
`status` tinyint(1),
`donetime` int(10),
`createtime` int(10),
`log` varchar(255),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_navs` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`topid` int(11),
`parid` int(11),
`level` tinyint(1),
`type` varchar(10),
`title` varchar(10),
`sign` varchar(10),
`url` text(),
`value` text(),
`status` tinyint(1),
`displayorder` int(10),
`target` varchar(7),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_notice` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`sign` varchar(30),
`template_id` varchar(50),
`status` tinyint(3),
`updatetime` int(10),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_notice_set` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`uniacid` int(11),
`taskid` int(11),
`openid` varchar(50),
`nickname` varchar(50),
`param` text(),
`createtime` int(10),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_pcsite_domain` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`domain` varchar(50),
`owner_uid` int(10),
`status` tinyint(1),
`remark` varchar(255),
`createtime` int(10),
`displayorder` int(3),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_plugin` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`category` varchar(255),
`name` varchar(100),
`title` varchar(50),
`thumb` text(),
`author` varchar(20),
`desc` varchar(255),
`version` varchar(10),
`status` tinyint(1),
`rolelevel` tinyint(1),
`displayorder` int(11),
`createtime` int(10),
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_bowen_site_sys_copyright` (
`id` int(11) NOT NULL  AUTO_INCREMENT,
`type` tinyint(1),
`value` varchar(255),
`content` text(),
`param` text(),
`updatetime` int(10),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'firstclass')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `firstclass` int(11);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'secondclass')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `secondclass` int(11);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'thirdclass')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `thirdclass` int(11);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'themes')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `themes` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'banner')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `banner` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `sign` varchar(25);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `icon` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'title')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `title` varchar(100);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'subtitle')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `subtitle` varchar(200);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'author')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `author` varchar(30);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'description')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `description` varchar(500);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'thumb')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `thumb` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'images')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `images` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'content')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `content` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'tag')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `tag` varchar(254);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'good')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `good` int(100);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'reading')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `reading` int(100);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'value')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `value` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'tourl')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `tourl` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'istranslate')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `istranslate` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `displayorder` int(10);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `updatetime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'content2')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `content2` text();");
 }
}
if(pdo_tableexists('bowen_site_articles')) {
 if(!pdo_fieldexists('bowen_site_articles',  'content3')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_articles')." ADD `content3` text();");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'topid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `topid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'parid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `parid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'level')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `level` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'title')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `title` varchar(30);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'subtitle')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `subtitle` varchar(200);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'description')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `description` text();");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `sign` varchar(10);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'themes')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `themes` varchar(10);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'thumb')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `thumb` text();");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'tourl')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `tourl` text();");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'value')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `value` text();");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `displayorder` int(10);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'icon')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `icon` text();");
 }
}
if(pdo_tableexists('bowen_site_classes')) {
 if(!pdo_fieldexists('bowen_site_classes',  'images')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_classes')." ADD `images` text();");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'dfid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `dfid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `openid` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'fields')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `fields` text();");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'data')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `data` text();");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `remark` varchar(255);");
 }
}
if(pdo_tableexists('bowen_site_diyform_data')) {
 if(!pdo_fieldexists('bowen_site_diyform_data',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_data')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'cid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `cid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'title')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `title` varchar(100);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'fields')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `fields` text();");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'iscache')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `iscache` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `updatetime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_diyform_template')) {
 if(!pdo_fieldexists('bowen_site_diyform_template',  'description')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_diyform_template')." ADD `description` text();");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `id` int(10) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'domain')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `domain` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'tourl')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `tourl` text();");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'endtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `endtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `remark` varchar(250);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `displayorder` int(3);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'ishttps')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `ishttps` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'compatible_site_welcome_module')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `compatible_site_welcome_module` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_domain')) {
 if(!pdo_fieldexists('bowen_site_domain',  'type')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_domain')." ADD `type` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'type')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `type` tinyint(3);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'taskid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `taskid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `openid` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'nickname')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `nickname` varchar(100);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'param')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `param` text();");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'donetime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `donetime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_msg_sign')) {
 if(!pdo_fieldexists('bowen_site_msg_sign',  'log')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_msg_sign')." ADD `log` varchar(255);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'topid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `topid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'parid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `parid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'level')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `level` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'type')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `type` varchar(10);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'title')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `title` varchar(10);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `sign` varchar(10);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'url')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `url` text();");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'value')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `value` text();");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `displayorder` int(10);");
 }
}
if(pdo_tableexists('bowen_site_navs')) {
 if(!pdo_fieldexists('bowen_site_navs',  'target')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_navs')." ADD `target` varchar(7);");
 }
}
if(pdo_tableexists('bowen_site_notice')) {
 if(!pdo_fieldexists('bowen_site_notice',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_notice')) {
 if(!pdo_fieldexists('bowen_site_notice',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_notice')) {
 if(!pdo_fieldexists('bowen_site_notice',  'sign')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice')." ADD `sign` varchar(30);");
 }
}
if(pdo_tableexists('bowen_site_notice')) {
 if(!pdo_fieldexists('bowen_site_notice',  'template_id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice')." ADD `template_id` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_notice')) {
 if(!pdo_fieldexists('bowen_site_notice',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice')." ADD `status` tinyint(3);");
 }
}
if(pdo_tableexists('bowen_site_notice')) {
 if(!pdo_fieldexists('bowen_site_notice',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice')." ADD `updatetime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'uniacid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `uniacid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'taskid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `taskid` int(11);");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'openid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `openid` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'nickname')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `nickname` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'param')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `param` text();");
 }
}
if(pdo_tableexists('bowen_site_notice_set')) {
 if(!pdo_fieldexists('bowen_site_notice_set',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_notice_set')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'domain')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `domain` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'owner_uid')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `owner_uid` int(10);");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'remark')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `remark` varchar(255);");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_pcsite_domain')) {
 if(!pdo_fieldexists('bowen_site_pcsite_domain',  'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_pcsite_domain')." ADD `displayorder` int(3);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'category')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `category` varchar(255);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'name')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `name` varchar(100);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'title')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `title` varchar(50);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'thumb')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `thumb` text();");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'author')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `author` varchar(20);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'desc')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `desc` varchar(255);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'version')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `version` varchar(10);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'status')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `status` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'rolelevel')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `rolelevel` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `displayorder` int(11);");
 }
}
if(pdo_tableexists('bowen_site_plugin')) {
 if(!pdo_fieldexists('bowen_site_plugin',  'createtime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_plugin')." ADD `createtime` int(10);");
 }
}
if(pdo_tableexists('bowen_site_sys_copyright')) {
 if(!pdo_fieldexists('bowen_site_sys_copyright',  'id')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_sys_copyright')." ADD `id` int(11) NOT NULL  AUTO_INCREMENT;");
 }
}
if(pdo_tableexists('bowen_site_sys_copyright')) {
 if(!pdo_fieldexists('bowen_site_sys_copyright',  'type')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_sys_copyright')." ADD `type` tinyint(1);");
 }
}
if(pdo_tableexists('bowen_site_sys_copyright')) {
 if(!pdo_fieldexists('bowen_site_sys_copyright',  'value')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_sys_copyright')." ADD `value` varchar(255);");
 }
}
if(pdo_tableexists('bowen_site_sys_copyright')) {
 if(!pdo_fieldexists('bowen_site_sys_copyright',  'content')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_sys_copyright')." ADD `content` text();");
 }
}
if(pdo_tableexists('bowen_site_sys_copyright')) {
 if(!pdo_fieldexists('bowen_site_sys_copyright',  'param')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_sys_copyright')." ADD `param` text();");
 }
}
if(pdo_tableexists('bowen_site_sys_copyright')) {
 if(!pdo_fieldexists('bowen_site_sys_copyright',  'updatetime')) {
  pdo_query("ALTER TABLE ".tablename('bowen_site_sys_copyright')." ADD `updatetime` int(10);");
 }
}

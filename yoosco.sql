# Host: localhost  (Version: 5.5.53)
# Date: 2019-08-12 19:13:18
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "createinstance"
#

DROP TABLE IF EXISTS `createinstance`;
CREATE TABLE `createinstance` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) DEFAULT '' COMMENT '订单ID',
  `signId` varchar(255) DEFAULT '' COMMENT '实例编号',
  `accountId` varchar(255) DEFAULT '' COMMENT '客户在腾讯云的账号ID',
  `userName` varchar(255) DEFAULT '' COMMENT '微擎账号',
  `openId` varchar(255) DEFAULT '' COMMENT '客户的识别(若未接入开放平台,则为空)',
  `productId` varchar(255) DEFAULT '' COMMENT '云市场产品ID',
  `requestId` varchar(255) DEFAULT '' COMMENT '接口请求的ID',
  `productInfo_productName` varchar(255) DEFAULT '' COMMENT '购买产品名称',
  `productInfo_isTrial` varchar(255) DEFAULT '' COMMENT '是否为试用,true:是,false:否',
  `productInfo_spec` varchar(255) DEFAULT '' COMMENT '产品规格,是试用时为空',
  `productInfo_timeSpan` varchar(255) DEFAULT '' COMMENT '购买时长,是试用时为空',
  `productInfo_timeUnit` varchar(255) DEFAULT '' COMMENT '购买时长单位(y,m,d,h,t.分别代表年,月,日,时,次),是试用时为空',
  `email` varchar(255) DEFAULT '' COMMENT '客户邮箱:服务商创建商品时,勾选"需要客户授权邮箱"',
  `mobile` varchar(255) DEFAULT '' COMMENT '客户手机:服务商创建商品时,勾选"需要客户授权手机"',
  `good_type` int(11) DEFAULT '0' COMMENT '0,微擎,1,新',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='实例创建通知表';

#
# Data for table "createinstance"
#

/*!40000 ALTER TABLE `createinstance` DISABLE KEYS */;
/*!40000 ALTER TABLE `createinstance` ENABLE KEYS */;

#
# Structure for table "destroyinstance"
#

DROP TABLE IF EXISTS `destroyinstance`;
CREATE TABLE `destroyinstance` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) DEFAULT '' COMMENT '订单ID',
  `accountId` varchar(255) DEFAULT '' COMMENT '客户在腾讯云的账号ID',
  `openId` varchar(255) DEFAULT '' COMMENT '客户的识别(若未接入开放平台,则为空)',
  `productId` varchar(255) DEFAULT '' COMMENT '云市场产品ID',
  `requestId` varchar(255) DEFAULT '' COMMENT '接口请求的ID',
  `signId` varchar(255) DEFAULT '' COMMENT '实例标识Id',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='实例销毁通知';

#
# Data for table "destroyinstance"
#

/*!40000 ALTER TABLE `destroyinstance` DISABLE KEYS */;
/*!40000 ALTER TABLE `destroyinstance` ENABLE KEYS */;

#
# Structure for table "discountcoderecording"
#

DROP TABLE IF EXISTS `discountcoderecording`;
CREATE TABLE `discountcoderecording` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(255) DEFAULT '' COMMENT '订单号',
  `code` varchar(255) DEFAULT '' COMMENT '优惠码',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='优惠码记录';

#
# Data for table "discountcoderecording"
#

/*!40000 ALTER TABLE `discountcoderecording` DISABLE KEYS */;
INSERT INTO `discountcoderecording` VALUES (1,'3213213213123','1232131312312313','2019-08-11 18:48:20');
/*!40000 ALTER TABLE `discountcoderecording` ENABLE KEYS */;

#
# Structure for table "goods"
#

DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` varchar(11) NOT NULL DEFAULT '' COMMENT '商品id',
  `good_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `good_type` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型 0,微擎,1,新',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商品列表';

#
# Data for table "goods"
#

/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,'1','测试1',1),(2,'2','测试2',2);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;

#
# Structure for table "modifyinstance"
#

DROP TABLE IF EXISTS `modifyinstance`;
CREATE TABLE `modifyinstance` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) DEFAULT '' COMMENT '订单ID',
  `accountId` varchar(255) DEFAULT '' COMMENT '客户在腾讯云的账号ID',
  `openId` varchar(255) DEFAULT '' COMMENT '客户的识别(若未接入开放平台,则为空)',
  `productId` varchar(255) DEFAULT '' COMMENT '云市场产品ID',
  `requestId` varchar(255) DEFAULT '' COMMENT '接口请求的ID',
  `signId` varchar(255) DEFAULT '' COMMENT '实例标识Id',
  `spec` varchar(255) DEFAULT '' COMMENT '实例新规格',
  `timeSpan` varchar(255) DEFAULT '' COMMENT '时长',
  `timeUnit` varchar(255) DEFAULT '' COMMENT '时长单位',
  `instanceExpireTime` varchar(255) DEFAULT '' COMMENT '实例到期时间',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='实例配置变更通知';

#
# Data for table "modifyinstance"
#

/*!40000 ALTER TABLE `modifyinstance` DISABLE KEYS */;
/*!40000 ALTER TABLE `modifyinstance` ENABLE KEYS */;

#
# Structure for table "preferencecode"
#

DROP TABLE IF EXISTS `preferencecode`;
CREATE TABLE `preferencecode` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT '' COMMENT '优惠码',
  `UseObjects` varchar(255) DEFAULT '' COMMENT '使用对象',
  `Repeatability` varchar(255) DEFAULT '' COMMENT '重复性',
  `PreferentialMode` varchar(255) DEFAULT '' COMMENT '优惠方式',
  `TermOfValidity` varchar(255) DEFAULT '' COMMENT '有效期',
  `state` varchar(255) DEFAULT '' COMMENT '状态',
  `create_time` varchar(255) DEFAULT '' COMMENT '生成日期',
  `create_user` varchar(255) DEFAULT '' COMMENT '生成员工',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='优惠码';

#
# Data for table "preferencecode"
#

/*!40000 ALTER TABLE `preferencecode` DISABLE KEYS */;
INSERT INTO `preferencecode` VALUES (1,'uJAAj0q4A42k','店铺套餐','一次性使用','1元','永久','可用','8/11/2019 18:07','仵博'),(2,'KHs2ZGpSSQaC','店铺套餐','一次性使用','1元','永久','可用','8/11/2019 18:06','仵博'),(3,'n57mHA1aH87f','所有对象','一次性使用','1元','永久','已使用','8/8/2019 15:11','超级管理员');
/*!40000 ALTER TABLE `preferencecode` ENABLE KEYS */;

#
# Structure for table "renewinstance"
#

DROP TABLE IF EXISTS `renewinstance`;
CREATE TABLE `renewinstance` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) DEFAULT '' COMMENT '订单ID',
  `accountId` varchar(255) DEFAULT '' COMMENT '客户在腾讯云的账号ID',
  `openId` varchar(255) DEFAULT '' COMMENT '客户的识别(若未接入开放平台,则为空)',
  `productId` varchar(255) DEFAULT '' COMMENT '云市场产品ID',
  `requestId` varchar(255) DEFAULT '' COMMENT '接口请求的ID',
  `signId` varchar(255) DEFAULT '' COMMENT '实例标识Id',
  `instanceExpireTime` varchar(255) DEFAULT '' COMMENT '新的实例到期时间(yyyy-MM-dd HH:mm:ss)',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='实例续费通知';

#
# Data for table "renewinstance"
#

/*!40000 ALTER TABLE `renewinstance` DISABLE KEYS */;
/*!40000 ALTER TABLE `renewinstance` ENABLE KEYS */;

#
# Structure for table "setmeal"
#

DROP TABLE IF EXISTS `setmeal`;
CREATE TABLE `setmeal` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `setmeal_name` varchar(255) DEFAULT '' COMMENT '套餐名字',
  `setmeal_price` varchar(255) DEFAULT '' COMMENT '价格(年)',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='套餐表';

#
# Data for table "setmeal"
#

/*!40000 ALTER TABLE `setmeal` DISABLE KEYS */;
INSERT INTO `setmeal` VALUES (1,'基础版','1000'),(2,'高级版','2000'),(3,'旗舰版','3000');
/*!40000 ALTER TABLE `setmeal` ENABLE KEYS */;

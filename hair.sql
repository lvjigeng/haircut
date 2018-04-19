/*
Navicat MySQL Data Transfer

Source Server         : aly
Source Server Version : 50625
Source Host           : 120.79.143.204:3306
Source Database       : hair

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2018-04-03 18:56:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '活动标题',
  `content` text NOT NULL COMMENT '活动内容',
  `start` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始日期',
  `end` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布日期',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('2', '充值1000送300', '新年优惠活动开启了,在活动期间充值1000送300,走过路过不能错过', '1519833600', '1527696000', '1519873527');
INSERT INTO `article` VALUES ('4', '充值1000送300', '新年优惠活动开启了,在活动期间充值1000送300,走过路过不能错过', '1519833600', '1527696000', '1519881713');
INSERT INTO `article` VALUES ('5', '春季大酬宾', '春季大酬宾', '1519833600', '1522425600', '1519898577');
INSERT INTO `article` VALUES ('6', '会员充值优惠', '会员充值优惠会员充值优惠会员充值优惠', '1519833600', '1532966400', '1519898895');
INSERT INTO `article` VALUES ('8', '111', '<p>111111</p>', '1520006400', '1521043200', '1520152538');

-- ----------------------------
-- Table structure for codes
-- ----------------------------
DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `code_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '代金券',
  `code` varchar(255) NOT NULL COMMENT '代码',
  `user_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `money` decimal(10,2) NOT NULL COMMENT '代金券金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态  0未使用  1已使用',
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of codes
-- ----------------------------
INSERT INTO `codes` VALUES ('3', 'a22eaec2a5', '2', '0.00', '1');
INSERT INTO `codes` VALUES ('4', 'af8d116945', '3', '0.00', '1');
INSERT INTO `codes` VALUES ('5', '8736fcb493', '1', '0.00', '1');
INSERT INTO `codes` VALUES ('6', 'af99d04dd4', '2', '200.00', '0');
INSERT INTO `codes` VALUES ('7', 'a2af5adde1', '3', '200.00', '0');
INSERT INTO `codes` VALUES ('8', 'f0fb2c2065', '4', '200.00', '0');

-- ----------------------------
-- Table structure for goodorder
-- ----------------------------
DROP TABLE IF EXISTS `goodorder`;
CREATE TABLE `goodorder` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单主键id',
  `order_num` char(255) NOT NULL COMMENT '订单号  随机生成',
  `username` varchar(255) NOT NULL COMMENT '收货人姓名',
  `telephone` bigint(20) unsigned NOT NULL COMMENT '收货电话',
  `address` varchar(255) NOT NULL COMMENT '收货地址',
  `time` int(10) unsigned NOT NULL COMMENT '服务时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1:发货中 0:未完成  1:完成',
  `assess` varchar(255) DEFAULT '' COMMENT '用户评价',
  `comment` varchar(255) DEFAULT '' COMMENT '用户评论',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goodorder
-- ----------------------------
INSERT INTO `goodorder` VALUES ('1', '189888888885a9b9b2575ff2', '李白', '18988888888', '成都', '1520147237', '1', '', '');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品主键id',
  `goods_name` varchar(50) NOT NULL COMMENT '商品名',
  `goods_integral` int(11) NOT NULL COMMENT '兑换积分',
  `img` varchar(255) NOT NULL COMMENT '商品图,保存路径',
  `num` int(11) NOT NULL COMMENT '库存',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('1', '跑车', '28888', './Uploads/goods_img/2018-03-02/image_5a98e4cdbeb0d_150x150.jpg', '3');
INSERT INTO `goods` VALUES ('2', '洗发水', '299', './Uploads/goods_img/2018-03-02/image_5a98e4e0065a1_150x150.jpg', '178');
INSERT INTO `goods` VALUES ('3', '吹风机', '155', './Uploads/goods_img/2018-03-02/image_5a98e4ea79f6c_150x150.jpg', '35');
INSERT INTO `goods` VALUES ('4', '梳子', '155', './Uploads/goods_img/2018-03-02/image_5a98e4f33e400_150x150.jpg', '50');
INSERT INTO `goods` VALUES ('5', '法拉利', '99999', './Uploads/goods_img/2018-03-02/image_5a98ce9558608_150x150.jpg', '1');
INSERT INTO `goods` VALUES ('7', '宝马', '7777', './Uploads/goods_img/2018-03-02/image_5a98d95f58735_150x150.jpg', '3');
INSERT INTO `goods` VALUES ('8', '霸王', '288', './Uploads/goods_img/2018-03-03/image_5a9a3e5754bf2_150x150.jpg', '99');

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '部门',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES ('2', '烫染组');
INSERT INTO `group` VALUES ('3', '洗头组');
INSERT INTO `group` VALUES ('7', '剪发组');
INSERT INTO `group` VALUES ('8', '接待组');

-- ----------------------------
-- Table structure for histories
-- ----------------------------
DROP TABLE IF EXISTS `histories`;
CREATE TABLE `histories` (
  `history_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned NOT NULL COMMENT '会员id',
  `member_id` int(10) unsigned NOT NULL COMMENT '员工id',
  `type` tinyint(3) unsigned NOT NULL COMMENT '消费/充值   0消费  1充值',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `handsel_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '赠送金额',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '余额',
  `content` varchar(10) NOT NULL DEFAULT '' COMMENT '消费内容',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消费时间',
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of histories
-- ----------------------------
INSERT INTO `histories` VALUES ('1', '1', '2', '1', '1000.00', '300.00', '1300.00', '', '1520132679');
INSERT INTO `histories` VALUES ('2', '2', '2', '1', '500.00', '200.00', '700.00', '', '1520132688');
INSERT INTO `histories` VALUES ('3', '3', '2', '1', '2000.00', '800.00', '2800.00', '', '1520132695');
INSERT INTO `histories` VALUES ('4', '4', '2', '1', '400.00', '0.00', '400.00', '', '1520132706');
INSERT INTO `histories` VALUES ('5', '1', '8', '0', '100.00', '100.00', '1300.00', '', '1520133250');
INSERT INTO `histories` VALUES ('6', '1', '2', '0', '100.00', '100.00', '1300.00', '', '1520133590');
INSERT INTO `histories` VALUES ('7', '1', '2', '0', '300.00', '60.00', '1060.00', '', '1520147212');
INSERT INTO `histories` VALUES ('8', '1', '2', '1', '100.00', '0.00', '1160.00', '', '1520155742');

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `realname` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` tinyint(1) unsigned NOT NULL COMMENT '性别  0: 女   1: 男',
  `telephone` bigint(11) NOT NULL COMMENT '电话',
  `group_id` tinyint(3) unsigned NOT NULL COMMENT '部门id',
  `last_login_time` int(10) unsigned DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` bigint(255) DEFAULT '0' COMMENT '最后登录ip',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是管理员  0: 不是  1: 是',
  `photo` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `is_server` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否服务  0未服务 1服务',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES ('2', 'admin', '202cb962ac59075b964b07152d234b70', '店长', '1', '6161623215', '2', '1522717337', '2874713153', '1', './Uploads/members_photo/2018-02-28/image_5a967dec232f9_100x100.jpg', '2');
INSERT INTO `members` VALUES ('8', 'zhangsan', '202cb962ac59075b964b07152d234b70', '张三', '1', '18988888888', '2', '0', '0', '1', './Uploads/members_photo/2018-03-04/image_5a9b9292a203b_100x100.jpg', '1');
INSERT INTO `members` VALUES ('9', 'lisi', '202cb962ac59075b964b07152d234b70', '李四', '1', '1896666666', '3', '0', '0', '0', './Uploads/members_photo/2018-03-04/image_5a9b92c6e095c_100x100.jpg', '0');
INSERT INTO `members` VALUES ('11', '11', '6512bd43d9caa6e02c990b0a82652dca', '11', '1', '1111', '3', '0', '0', '1', '', '0');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `phone` bigint(20) unsigned NOT NULL COMMENT '电话',
  `realname` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `barber` int(10) unsigned NOT NULL COMMENT '预约美发师',
  `content` varchar(255) DEFAULT '' COMMENT '备注',
  `date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '预约日期',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态  -1拒绝  0未处理  1成功',
  `reply` varchar(255) DEFAULT '' COMMENT '回复',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('3', '111111', '李白', '9', '111', '1521129600', '0', '');

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `plan_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '套餐',
  `name` varchar(255) NOT NULL COMMENT '套餐名称',
  `desc` varchar(255) DEFAULT NULL COMMENT '套餐描述',
  `money` decimal(10,2) unsigned NOT NULL COMMENT '套餐金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0未上线  1上线',
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES ('1', '卡斯营养发膜', '赠送电磁烫染', '299.00', '1');
INSERT INTO `plans` VALUES ('2', '易美思烫发', '回赠288', '688.00', '1');
INSERT INTO `plans` VALUES ('3', '欧莱雅烫发', '回赠308', '688.00', '1');
INSERT INTO `plans` VALUES ('4', '俏梦染发', '俏梦染发俏梦染发俏梦染发俏梦染发', '188.00', '1');
INSERT INTO `plans` VALUES ('5', '欧莱雅降色', '欧莱雅降色', '388.00', '1');
INSERT INTO `plans` VALUES ('6', '海藻还原', '海藻还原海藻还原', '288.00', '1');
INSERT INTO `plans` VALUES ('7', 'koe胶原蛋白排毒', 'koe胶原蛋白排毒koe胶原蛋白排毒', '688.00', '1');
INSERT INTO `plans` VALUES ('8', '女儿香排毒', '女儿香排毒女儿香排毒', '288.00', '1');

-- ----------------------------
-- Table structure for recharge
-- ----------------------------
DROP TABLE IF EXISTS `recharge`;
CREATE TABLE `recharge` (
  `recharge_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '充值表主键',
  `recharge_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `handsel_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '赠送金额',
  PRIMARY KEY (`recharge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of recharge
-- ----------------------------
INSERT INTO `recharge` VALUES ('1', '500.00', '200.00');
INSERT INTO `recharge` VALUES ('2', '1000.00', '300.00');
INSERT INTO `recharge` VALUES ('5', '2000.00', '800.00');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `realname` varchar(20) NOT NULL COMMENT '姓名',
  `sex` tinyint(1) unsigned NOT NULL COMMENT '性别  0:女   1:男',
  `telephone` bigint(11) unsigned NOT NULL COMMENT '电话',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `vip_rank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'vip等级  0普通会员 1 青铜会员 2白银会员 3黄金会员 4铂金会员 5砖石会员',
  `photo` varchar(255) DEFAULT '' COMMENT '头像',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员积分',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'libai', '202cb962ac59075b964b07152d234b70', '李白', '1', '18988888888', '', '1160.00', '2', './Uploads/user_photo/2018-03-04/image_5a9b60fe2d8c0_100x100.jpg', '1');
INSERT INTO `users` VALUES ('2', 'sushi', '202cb962ac59075b964b07152d234b70', '苏轼', '1', '13966666666', '', '700.00', '1', './Uploads/user_photo/2018-03-04/image_5a9b61c3d12bd_100x100.jpg', '0');
INSERT INTO `users` VALUES ('3', 'wangwei', '202cb962ac59075b964b07152d234b70', '王维', '1', '1583333333', '', '2800.00', '3', './Uploads/user_photo/2018-03-04/image_5a9b61f23f1e9_100x100.jpg', '0');
INSERT INTO `users` VALUES ('4', 'baijuyi', '202cb962ac59075b964b07152d234b70', '白居易', '1', '1585555555', '', '400.00', '0', './Uploads/user_photo/2018-03-04/image_5a9b622ee3112_100x100.jpg', '0');
INSERT INTO `users` VALUES ('5', 'tufu', '202cb962ac59075b964b07152d234b70', '杜甫', '1', '15923568945', '', '0.00', '0', 'Public/Admin/images/head.jpg', '0');
INSERT INTO `users` VALUES ('6', 'xiaomin', '202cb962ac59075b964b07152d234b70', '小明', '1', '15888888888', '', '0.00', '0', 'Public/Admin/images/head.jpg', '0');

-- ----------------------------
-- Table structure for vip
-- ----------------------------
DROP TABLE IF EXISTS `vip`;
CREATE TABLE `vip` (
  `vip_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '折扣表主键',
  `vip_rank` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'vip等级',
  `discount` float(3,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '折扣 0不打折 0.9 表示9折 0.8表示8折',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'vip充值金额条件',
  PRIMARY KEY (`vip_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vip
-- ----------------------------
INSERT INTO `vip` VALUES ('1', '0', '1.0', '0.00');
INSERT INTO `vip` VALUES ('2', '1', '0.9', '500.00');
INSERT INTO `vip` VALUES ('3', '2', '0.8', '1000.00');
INSERT INTO `vip` VALUES ('4', '3', '0.7', '2000.00');
INSERT INTO `vip` VALUES ('5', '4', '0.6', '5000.00');
INSERT INTO `vip` VALUES ('6', '5', '0.5', '10000.00');

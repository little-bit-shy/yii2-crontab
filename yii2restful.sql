/*
Navicat MySQL Data Transfer

Source Server         : 47.52.238.192
Source Server Version : 50640
Source Host           : 47.52.238.192:3306
Source Database       : yii2restful

Target Server Type    : MYSQL
Target Server Version : 50640
File Encoding         : 65001

Date: 2018-07-06 15:52:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yii2_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_assignment`;
CREATE TABLE `yii2_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `yii2_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yii2_auth_assignment
-- ----------------------------
INSERT INTO `yii2_auth_assignment` VALUES ('ordinaryUser', '39', '1530783401');
INSERT INTO `yii2_auth_assignment` VALUES ('root', '1', '1522555776');
INSERT INTO `yii2_auth_assignment` VALUES ('root', '2', '1530775732');

-- ----------------------------
-- Table structure for yii2_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_item`;
CREATE TABLE `yii2_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `yii2_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yii2_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yii2_auth_item
-- ----------------------------
INSERT INTO `yii2_auth_item` VALUES ('/*', '2', '全部', null, null, '1530862609', '1530862619');
INSERT INTO `yii2_auth_item` VALUES ('/debug/*', '2', '/debug/*', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/default/*', '2', '/debug/default/*', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/default/db-explain', '2', '/debug/default/db-explain', null, null, '1522390662', '1522390662');
INSERT INTO `yii2_auth_item` VALUES ('/debug/default/download-mail', '2', '/debug/default/download-mail', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/default/index', '2', '/debug/default/index', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/default/toolbar', '2', '/debug/default/toolbar', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/default/view', '2', '/debug/default/view', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/user/*', '2', '/debug/user/*', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/user/reset-identity', '2', '/debug/user/reset-identity', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/debug/user/set-identity', '2', '/debug/user/set-identity', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/*', '2', '/gii/*', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/default/*', '2', '/gii/default/*', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/default/action', '2', '/gii/default/action', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/default/diff', '2', '/gii/default/diff', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/default/index', '2', '/gii/default/index', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/default/preview', '2', '/gii/default/preview', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/gii/default/view', '2', '/gii/default/view', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/site/*', '2', '/site/*', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/site/captcha', '2', '/site/captcha', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/site/error', '2', '/site/error', null, null, '1522201146', '1522201146');
INSERT INTO `yii2_auth_item` VALUES ('/v1/*', '2', 'V1模块', null, null, '1521525747', '1521619641');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/*', '2', '权限管理', null, null, '1521525747', '1521619650');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-permissions', '2', '添加权限', null, null, '1520165332', '1520236587');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-role', '2', '添加角色', null, null, '1521808974', '1522052471');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-role-permissions', '2', '添加角色权限', null, null, '1521808974', '1522052489');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-user', '2', '添加用户', null, null, '1530780543', '1530780588');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-user-role', '2', '为用户分配角色', null, null, '1522503205', '1522504084');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-lists', '2', '获取所有权限', null, null, '1520215567', '1521619697');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-lists-with-level', '2', '获取有层次结构的权限', null, null, '1521007674', '1521619678');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-lists-with-role', '2', '获取角色拥有的权限', null, null, '1521007674', '1521619716');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-role-with-user', '2', '获取指定用户的所有角色', null, null, '1522503264', '1522504160');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/delete-role-permissions', '2', '删除角色权限', null, null, '1521808974', '1522052501');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/delete-user-role', '2', '删除指定用户的某个角色', null, null, '1522503258', '1522504142');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/index', '2', '权限列表', null, null, '1520215567', '1520236625');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/project-directory', '2', '项目结构', null, null, '1520165332', '1520236637');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/remove-permissions', '2', '移除权限', null, null, '1520165332', '1520236664');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/update-permissions', '2', '修改权限', null, null, '1520165332', '1520423740');
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/user-lists', '2', '获取用户列表', null, null, '1522503205', '1522504171');
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/*', '2', '基本操作', null, null, '1521525747', '1521619728');
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/all-permissions', '2', '获取当前用户已有权限', null, null, '1522066042', '1530775704');
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/captcha', '2', '获取验证码', null, null, '1521007674', '1521619742');
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/login', '2', '用户登录', null, null, '1521007674', '1521619750');
INSERT INTO `yii2_auth_item` VALUES ('/v1/user-copy/*', '2', '某某某', null, null, '1521525747', '1521619769');
INSERT INTO `yii2_auth_item` VALUES ('/v1/user-copy/create', '2', '添加数据', null, null, '1521007674', '1522052434');
INSERT INTO `yii2_auth_item` VALUES ('/v1/user-copy/index', '2', '列表数据', null, null, '1521007674', '1522052446');
INSERT INTO `yii2_auth_item` VALUES ('/v1/user-copy/view', '2', '详细数据', null, null, '1521007674', '1522052453');
INSERT INTO `yii2_auth_item` VALUES ('ordinaryUser', '1', '普通用户', null, null, '1519288590', '1530860464');
INSERT INTO `yii2_auth_item` VALUES ('root', '1', '超级管理员', null, 0x733A32373A22E89299E5A49AE683B3E58EBBE593AAE5B0B1E58EBBE593AA2E2E2E223B, '1522066042', '1530860469');

-- ----------------------------
-- Table structure for yii2_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_item_child`;
CREATE TABLE `yii2_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yii2_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yii2_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yii2_auth_item_child
-- ----------------------------
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/default/db-explain');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/default/download-mail');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/default/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/default/toolbar');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/default/view');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/user/reset-identity');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/debug/user/set-identity');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/gii/default/action');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/gii/default/diff');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/gii/default/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/gii/default/preview');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/gii/default/view');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/site/captcha');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/site/error');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-role-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-user-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-lists');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-lists-with-level');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-lists-with-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-role-with-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/delete-role-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/delete-user-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/project-directory');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/remove-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/update-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/user-lists');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/*');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/all-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/site/all-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/captcha');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/site/captcha');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/login');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/site/login');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/user-copy/*');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/user-copy/create');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/user-copy/create');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/user-copy/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/user-copy/index');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/user-copy/view');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/user-copy/view');

-- ----------------------------
-- Table structure for yii2_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_rule`;
CREATE TABLE `yii2_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yii2_auth_rule
-- ----------------------------
INSERT INTO `yii2_auth_rule` VALUES ('\\v1\\rules\\AuthorRule', 0x4F3A31393A2276315C72756C65735C417574686F7252756C65223A333A7B733A343A226E616D65223B733A32303A225C76315C72756C65735C417574686F7252756C65223B733A393A22637265617465644174223B693A313532303231373038303B733A393A22757064617465644174223B693A313532303231373038303B7D, '1520217080', '1520217080');

-- ----------------------------
-- Table structure for yii2_user
-- ----------------------------
DROP TABLE IF EXISTS `yii2_user`;
CREATE TABLE `yii2_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `phone` char(12) DEFAULT NULL COMMENT '手机',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `head` varchar(255) DEFAULT NULL COMMENT '头像',
  `access_token` varchar(255) DEFAULT NULL COMMENT 'access-token',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  `last_login_ip` char(20) DEFAULT NULL COMMENT '最近登录ip',
  `last_login_at` int(11) DEFAULT NULL COMMENT '最近登陆时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `yii2restful_yii2_user_username` (`username`),
  UNIQUE KEY `yii2restful_yii2_user_access_token` (`access_token`) USING BTREE COMMENT 'access_token',
  UNIQUE KEY `yii2restful_yii2_user_phone` (`phone`),
  UNIQUE KEY `yii2restful_yii2_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of yii2_user
-- ----------------------------
INSERT INTO `yii2_user` VALUES ('1', '15918793994', 'root', 'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3448484253,3685836170&fm=27&gp=0.jpg', 'ELF_USKHgyi-n6za3H9A0QvcV14oiClF', '$2y$13$Gmkbp4uYHbUivaxE7x3M0.LRzJUiDMKWCWUAKD763S/vbzJeIt8xe', '1533356676@qq.com', '1479371680', '1479371680', '120.85.87.54', '1530782990');
INSERT INTO `yii2_user` VALUES ('2', null, 'admin', 'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3448484253,3685836170&fm=27&gp=0.jpg', 'Z77WMycirTQAYJXptVVA3Atsycbvv4c-', '$2y$13$gqyTZRup/.lisGkogBT5benIucbEZ4yweD11JKWjHASA4hl9a7oau', '3095764452@qq.com', '1479371663', '1479371680', '45.249.246.173', '1530799644');
INSERT INTO `yii2_user` VALUES ('39', null, 'test', null, 'YTi1n2F41A1PR0CJFgLTOEwrFoE3jIGu', '$2y$13$.WmbK4IQ1Oj3TUIWIsdokee83OsZFjdWQq/t6910kudzVBb5kIOpi', null, '1530780629', '1530780629', '45.249.246.173', '1530799628');

-- ----------------------------
-- Table structure for yii2_user_copy
-- ----------------------------
DROP TABLE IF EXISTS `yii2_user_copy`;
CREATE TABLE `yii2_user_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `phone` char(12) DEFAULT NULL COMMENT '手机',
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `head` varchar(255) DEFAULT NULL COMMENT '头像',
  `access_token` varchar(255) DEFAULT NULL COMMENT 'access-token',
  `auth_key` varchar(32) DEFAULT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) DEFAULT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  `last_login_ip` char(20) DEFAULT NULL COMMENT '最近登录ip',
  `last_login_at` int(11) DEFAULT NULL COMMENT '最近登陆时间',
  `oauth2` varchar(255) DEFAULT 'self' COMMENT 'oauth2',
  `oauth2_id` int(11) DEFAULT NULL COMMENT 'oauth2_id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `yii2restful_yii2_user_oauth2_oauth2_id` (`oauth2`,`oauth2_id`) USING BTREE COMMENT 'oauth2唯一索引',
  UNIQUE KEY `yii2restful_yii2_user_access_token` (`access_token`) USING BTREE COMMENT 'access_token',
  UNIQUE KEY `yii2restful_yii2_user_phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of yii2_user_copy
-- ----------------------------
INSERT INTO `yii2_user_copy` VALUES ('1', '1', 'root', '', '1', '6lgGBSosfvH0c9_nZZP8DY6YiI4ycwDx', '$2y$13$Gmkbp4uYHbUivaxE7x3M0.LRzJUiDMKWCWUAKD763S/vbzJeIt8xe', null, '1533356676@qq.com', '1479371680', '1479371680', null, null, 'self', null);
INSERT INTO `yii2_user_copy` VALUES ('2', '2', 'admin', null, '2', 'pA7DChvN6X22MWjc6W_9TYALKiduyftD', '$2y$13$gqyTZRup/.lisGkogBT5benIucbEZ4yweD11JKWjHASA4hl9a7oau', null, '3095764452@qq.com', '1479371663', '1479371680', null, null, 'self', null);
INSERT INTO `yii2_user_copy` VALUES ('9', '', 'little-bit-shy', 'https://avatars.githubusercontent.com/u/12792446?v=3', '9', null, null, null, null, '1484897023', '1479371680', null, null, 'github', '12792446');
INSERT INTO `yii2_user_copy` VALUES ('10', '15918793994', null, null, 'y0gZlbBXGxOo4K--4_4jDNa_Byw2I-8V', null, '$2y$13$MpWF3HZWwe1CrcvpbwDLR.k2bRnr9VyvKCPYGaNjv8..S8Z.rkliS', null, null, '1485158903', '1485158903', '127.0.0.1', '1485160819', 'self', null);
INSERT INTO `yii2_user_copy` VALUES ('12', '15918793991', 'fUrXC2rT', null, '6l4nL9fP7X7EXTw5ecedHjUhH9Kv12iv', null, '$2y$13$nLc17UBNeDhaRu5bFnJr8uAh2vyOt1/xYMmIVAuUNeLVmose7MkKm', null, null, '1485160893', '1485160893', null, null, 'self', null);
INSERT INTO `yii2_user_copy` VALUES ('13', '15918793992', 'mK0wLev6', null, 'inORraxmoIqYOaaDL9qe6MqBZaf-C9Pl', null, '$2y$13$HghCFt1JWLsduv5bLQ13w.z/6W3Fzgz70qmgypNEFKlJH9P8b3xOy', null, null, '1485161033', '1485161033', null, null, 'self', null);
INSERT INTO `yii2_user_copy` VALUES ('14', '15918793993', 'BWko4Fiu', null, '0SqyoC7enijE3sDlTAVy1jmP8D9Krb2P', null, '$2y$13$fAbDXAo6MJ/uGCPeUcdExeQDQvZBYlCsfa23UUkS8lzv3/NufI2Lm', null, null, '1485161050', '1485161050', null, null, 'self', null);
SET FOREIGN_KEY_CHECKS=1;

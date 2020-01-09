/*
 Navicat Premium Data Transfer

 Source Server         : 本地开发
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : 192.168.1.123:3306
 Source Schema         : crontab

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 09/01/2020 15:32:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for yii2_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_assignment`;
CREATE TABLE `yii2_auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `auth_assignment_user_id_idx`(`user_id`) USING BTREE,
  CONSTRAINT `yii2_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_auth_assignment
-- ----------------------------
INSERT INTO `yii2_auth_assignment` VALUES ('ordinaryUser', '2', 1543913735);
INSERT INTO `yii2_auth_assignment` VALUES ('ordinaryUser', '39', 1530783401);
INSERT INTO `yii2_auth_assignment` VALUES ('root', '1', 1522555776);

-- ----------------------------
-- Table structure for yii2_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_item`;
CREATE TABLE `yii2_auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  CONSTRAINT `yii2_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yii2_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_auth_item
-- ----------------------------
INSERT INTO `yii2_auth_item` VALUES ('/*', 2, '/*', NULL, NULL, 1543285939, 1543285939);
INSERT INTO `yii2_auth_item` VALUES ('/v1/*', 2, 'V1模块', NULL, NULL, 1521525747, 1521619641);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/*', 2, '权限管理', NULL, NULL, 1521525747, 1521619650);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-permissions', 2, '添加权限', NULL, NULL, 1520165332, 1520236587);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-role', 2, '添加角色', NULL, NULL, 1521808974, 1522052471);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-role-permissions', 2, '添加角色权限', NULL, NULL, 1521808974, 1522052489);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-role-role', 2, '为角色分配角色', NULL, NULL, 1578301003, 1578301036);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-user', 2, '添加用户', NULL, NULL, 1530780543, 1530780588);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/add-user-role', 2, '为用户分配角色', NULL, NULL, 1522503205, 1522504084);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-lists', 2, '获取所有权限', NULL, NULL, 1520215567, 1521619697);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-lists-with-level', 2, '获取有层次结构的权限', NULL, NULL, 1521007674, 1521619678);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-lists-with-role', 2, '获取角色拥有的权限', NULL, NULL, 1521007674, 1521619716);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-role-with-role', 2, '返回角色下的所有角色列表数据', NULL, NULL, 1578301003, 1578301082);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/all-role-with-user', 2, '获取指定用户的所有角色', NULL, NULL, 1522503264, 1522504160);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/delete-role-permissions', 2, '删除角色权限', NULL, NULL, 1521808974, 1522052501);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/delete-role-role', 2, '删除为角色分配的角色', NULL, NULL, 1578301003, 1578301090);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/delete-user-role', 2, '删除指定用户的某个角色', NULL, NULL, 1522503258, 1522504142);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/index', 2, '权限列表', NULL, NULL, 1520215567, 1520236625);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/project-directory', 2, '项目结构', NULL, NULL, 1520165332, 1520236637);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/remove-permissions', 2, '移除权限', NULL, NULL, 1520165332, 1520236664);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/reset-psw-user', 2, '密码重置', NULL, NULL, 1543913588, 1543913607);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/update-permissions', 2, '修改权限', NULL, NULL, 1520165332, 1520423740);
INSERT INTO `yii2_auth_item` VALUES ('/v1/auth-item/user-lists', 2, '获取用户列表', NULL, NULL, 1522503205, 1522504171);
INSERT INTO `yii2_auth_item` VALUES ('/v1/execute-task/*', 2, '执行任务', NULL, NULL, 1542943133, 1543913617);
INSERT INTO `yii2_auth_item` VALUES ('/v1/execute-task/index', 2, '任务列表', NULL, NULL, 1542943133, 1543913635);
INSERT INTO `yii2_auth_item` VALUES ('/v1/execute-task/view', 2, '任务详情', NULL, NULL, 1542943133, 1543913626);
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/*', 2, '基本操作', NULL, NULL, 1521525747, 1521619728);
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/all-permissions', 2, '获取当前用户已有权限', NULL, NULL, 1522066042, 1530775704);
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/captcha', 2, '获取验证码', NULL, NULL, 1521007674, 1521619742);
INSERT INTO `yii2_auth_item` VALUES ('/v1/site/login', 2, '用户登录', NULL, NULL, 1521007674, 1521619750);
INSERT INTO `yii2_auth_item` VALUES ('/v1/task/*', 2, '任务管理', NULL, NULL, 1541054856, 1541055008);
INSERT INTO `yii2_auth_item` VALUES ('/v1/task/create', 2, '任务添加', NULL, NULL, 1541054856, 1541055017);
INSERT INTO `yii2_auth_item` VALUES ('/v1/task/delete', 2, '删除任务', NULL, NULL, 1542943133, 1543913646);
INSERT INTO `yii2_auth_item` VALUES ('/v1/task/index', 2, '任务列表', NULL, NULL, 1541054856, 1541054995);
INSERT INTO `yii2_auth_item` VALUES ('/v1/task/update', 2, '任务修改', NULL, NULL, 1541054856, 1541054986);
INSERT INTO `yii2_auth_item` VALUES ('/v1/task/view', 2, '任务详情', NULL, NULL, 1541054856, 1541054972);
INSERT INTO `yii2_auth_item` VALUES ('ordinaryUser', 1, '普通用户', NULL, NULL, 1519288590, 1530860464);
INSERT INTO `yii2_auth_item` VALUES ('root', 1, '超级管理员', NULL, 0x733A32373A22E89299E5A49AE683B3E58EBBE593AAE5B0B1E58EBBE593AA2E2E2E223B, 1522066042, 1530860469);

-- ----------------------------
-- Table structure for yii2_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_item_child`;
CREATE TABLE `yii2_auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `yii2_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yii2_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_auth_item_child
-- ----------------------------
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-role-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-role-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/add-user-role');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/all-lists');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-lists');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/all-lists-with-level');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-lists-with-level');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/all-lists-with-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-lists-with-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-role-with-role');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/all-role-with-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/all-role-with-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/delete-role-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/delete-role-role');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/delete-user-role');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/index');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/project-directory');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/project-directory');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/remove-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/reset-psw-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/reset-psw-user');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/update-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/auth-item/user-lists');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/auth-item/user-lists');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/execute-task/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/execute-task/index');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/execute-task/view');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/execute-task/view');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/*');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/all-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/site/all-permissions');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/captcha');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/site/captcha');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/site/login');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/site/login');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/task/create');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/task/delete');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/task/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/task/index');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/task/update');
INSERT INTO `yii2_auth_item_child` VALUES ('ordinaryUser', '/v1/task/view');
INSERT INTO `yii2_auth_item_child` VALUES ('root', '/v1/task/view');

-- ----------------------------
-- Table structure for yii2_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `yii2_auth_rule`;
CREATE TABLE `yii2_auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_auth_rule
-- ----------------------------
INSERT INTO `yii2_auth_rule` VALUES ('\\v1\\rules\\AuthorRule', 0x4F3A31393A2276315C72756C65735C417574686F7252756C65223A333A7B733A343A226E616D65223B733A32303A225C76315C72756C65735C417574686F7252756C65223B733A393A22637265617465644174223B693A313532303231373038303B733A393A22757064617465644174223B693A313532303231373038303B7D, 1520217080, 1520217080);

-- ----------------------------
-- Table structure for yii2_execute_task
-- ----------------------------
DROP TABLE IF EXISTS `yii2_execute_task`;
CREATE TABLE `yii2_execute_task`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '需要执行的命令',
  `start_time` datetime(0) NULL DEFAULT NULL COMMENT '任务计划执行时间',
  `execute_time` datetime(0) NULL DEFAULT NULL COMMENT '任务实际执行时间',
  `complete_time` datetime(0) NULL DEFAULT NULL COMMENT '任务实际完成时间',
  `status` enum('1','2','3','4') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '执行状态 1/准备中 2/执行中 3/任务失败 4/已完成',
  `result` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '任务输出',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '数据创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '数据修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `asfapf17g12yguyf1g11gf12`(`start_time`, `status`) USING BTREE,
  INDEX `2141221xd12f12f1f12gv1g21`(`command`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 961 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_execute_task
-- ----------------------------
INSERT INTO `yii2_execute_task` VALUES (841, 'echo \'测试\'', '2020-01-09 07:32:00', '2020-01-09 07:32:00', NULL, '2', NULL, '2020-01-09 07:30:59', '2020-01-09 07:32:00');
INSERT INTO `yii2_execute_task` VALUES (842, 'echo \'测试\'', '2020-01-09 07:32:01', '2020-01-09 07:32:01', NULL, '2', NULL, '2020-01-09 07:30:59', '2020-01-09 07:32:01');
INSERT INTO `yii2_execute_task` VALUES (843, 'echo \'测试\'', '2020-01-09 07:32:02', '2020-01-09 07:32:02', NULL, '2', NULL, '2020-01-09 07:30:59', '2020-01-09 07:32:02');
INSERT INTO `yii2_execute_task` VALUES (844, 'echo \'测试\'', '2020-01-09 07:32:03', '2020-01-09 07:32:03', NULL, '2', NULL, '2020-01-09 07:30:59', '2020-01-09 07:32:03');
INSERT INTO `yii2_execute_task` VALUES (845, 'echo \'测试\'', '2020-01-09 07:32:04', '2020-01-09 07:32:04', NULL, '2', NULL, '2020-01-09 07:30:59', '2020-01-09 07:32:04');
INSERT INTO `yii2_execute_task` VALUES (846, 'echo \'测试\'', '2020-01-09 07:32:05', '2020-01-09 07:32:05', NULL, '2', NULL, '2020-01-09 07:30:59', '2020-01-09 07:32:05');
INSERT INTO `yii2_execute_task` VALUES (847, 'echo \'测试\'', '2020-01-09 07:32:06', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (848, 'echo \'测试\'', '2020-01-09 07:32:07', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (849, 'echo \'测试\'', '2020-01-09 07:32:08', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (850, 'echo \'测试\'', '2020-01-09 07:32:09', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (851, 'echo \'测试\'', '2020-01-09 07:32:10', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (852, 'echo \'测试\'', '2020-01-09 07:32:11', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (853, 'echo \'测试\'', '2020-01-09 07:32:12', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (854, 'echo \'测试\'', '2020-01-09 07:32:13', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (855, 'echo \'测试\'', '2020-01-09 07:32:14', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (856, 'echo \'测试\'', '2020-01-09 07:32:15', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (857, 'echo \'测试\'', '2020-01-09 07:32:16', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (858, 'echo \'测试\'', '2020-01-09 07:32:17', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (859, 'echo \'测试\'', '2020-01-09 07:32:18', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (860, 'echo \'测试\'', '2020-01-09 07:32:19', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (861, 'echo \'测试\'', '2020-01-09 07:32:20', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (862, 'echo \'测试\'', '2020-01-09 07:32:21', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (863, 'echo \'测试\'', '2020-01-09 07:32:22', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (864, 'echo \'测试\'', '2020-01-09 07:32:23', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (865, 'echo \'测试\'', '2020-01-09 07:32:24', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (866, 'echo \'测试\'', '2020-01-09 07:32:25', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (867, 'echo \'测试\'', '2020-01-09 07:32:26', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (868, 'echo \'测试\'', '2020-01-09 07:32:27', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (869, 'echo \'测试\'', '2020-01-09 07:32:28', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (870, 'echo \'测试\'', '2020-01-09 07:32:29', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (871, 'echo \'测试\'', '2020-01-09 07:32:30', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (872, 'echo \'测试\'', '2020-01-09 07:32:31', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (873, 'echo \'测试\'', '2020-01-09 07:32:32', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (874, 'echo \'测试\'', '2020-01-09 07:32:33', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (875, 'echo \'测试\'', '2020-01-09 07:32:34', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (876, 'echo \'测试\'', '2020-01-09 07:32:35', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (877, 'echo \'测试\'', '2020-01-09 07:32:36', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (878, 'echo \'测试\'', '2020-01-09 07:32:37', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (879, 'echo \'测试\'', '2020-01-09 07:32:38', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (880, 'echo \'测试\'', '2020-01-09 07:32:39', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (881, 'echo \'测试\'', '2020-01-09 07:32:40', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (882, 'echo \'测试\'', '2020-01-09 07:32:41', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (883, 'echo \'测试\'', '2020-01-09 07:32:42', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (884, 'echo \'测试\'', '2020-01-09 07:32:43', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (885, 'echo \'测试\'', '2020-01-09 07:32:44', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (886, 'echo \'测试\'', '2020-01-09 07:32:45', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (887, 'echo \'测试\'', '2020-01-09 07:32:46', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (888, 'echo \'测试\'', '2020-01-09 07:32:47', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (889, 'echo \'测试\'', '2020-01-09 07:32:48', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (890, 'echo \'测试\'', '2020-01-09 07:32:49', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (891, 'echo \'测试\'', '2020-01-09 07:32:50', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (892, 'echo \'测试\'', '2020-01-09 07:32:51', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (893, 'echo \'测试\'', '2020-01-09 07:32:52', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (894, 'echo \'测试\'', '2020-01-09 07:32:53', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (895, 'echo \'测试\'', '2020-01-09 07:32:54', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (896, 'echo \'测试\'', '2020-01-09 07:32:55', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (897, 'echo \'测试\'', '2020-01-09 07:32:56', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (898, 'echo \'测试\'', '2020-01-09 07:32:57', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (899, 'echo \'测试\'', '2020-01-09 07:32:58', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (900, 'echo \'测试\'', '2020-01-09 07:32:59', NULL, NULL, '1', NULL, '2020-01-09 07:30:59', '2020-01-09 07:30:59');
INSERT INTO `yii2_execute_task` VALUES (901, 'echo \'测试\'', '2020-01-09 07:33:00', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (902, 'echo \'测试\'', '2020-01-09 07:33:01', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (903, 'echo \'测试\'', '2020-01-09 07:33:02', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (904, 'echo \'测试\'', '2020-01-09 07:33:03', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (905, 'echo \'测试\'', '2020-01-09 07:33:04', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (906, 'echo \'测试\'', '2020-01-09 07:33:05', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (907, 'echo \'测试\'', '2020-01-09 07:33:06', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (908, 'echo \'测试\'', '2020-01-09 07:33:07', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (909, 'echo \'测试\'', '2020-01-09 07:33:08', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (910, 'echo \'测试\'', '2020-01-09 07:33:09', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (911, 'echo \'测试\'', '2020-01-09 07:33:10', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (912, 'echo \'测试\'', '2020-01-09 07:33:11', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (913, 'echo \'测试\'', '2020-01-09 07:33:12', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (914, 'echo \'测试\'', '2020-01-09 07:33:13', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (915, 'echo \'测试\'', '2020-01-09 07:33:14', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (916, 'echo \'测试\'', '2020-01-09 07:33:15', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (917, 'echo \'测试\'', '2020-01-09 07:33:16', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (918, 'echo \'测试\'', '2020-01-09 07:33:17', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (919, 'echo \'测试\'', '2020-01-09 07:33:18', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (920, 'echo \'测试\'', '2020-01-09 07:33:19', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (921, 'echo \'测试\'', '2020-01-09 07:33:20', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (922, 'echo \'测试\'', '2020-01-09 07:33:21', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (923, 'echo \'测试\'', '2020-01-09 07:33:22', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (924, 'echo \'测试\'', '2020-01-09 07:33:23', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (925, 'echo \'测试\'', '2020-01-09 07:33:24', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (926, 'echo \'测试\'', '2020-01-09 07:33:25', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (927, 'echo \'测试\'', '2020-01-09 07:33:26', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (928, 'echo \'测试\'', '2020-01-09 07:33:27', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (929, 'echo \'测试\'', '2020-01-09 07:33:28', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (930, 'echo \'测试\'', '2020-01-09 07:33:29', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (931, 'echo \'测试\'', '2020-01-09 07:33:30', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (932, 'echo \'测试\'', '2020-01-09 07:33:31', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (933, 'echo \'测试\'', '2020-01-09 07:33:32', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (934, 'echo \'测试\'', '2020-01-09 07:33:33', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (935, 'echo \'测试\'', '2020-01-09 07:33:34', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (936, 'echo \'测试\'', '2020-01-09 07:33:35', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (937, 'echo \'测试\'', '2020-01-09 07:33:36', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (938, 'echo \'测试\'', '2020-01-09 07:33:37', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (939, 'echo \'测试\'', '2020-01-09 07:33:38', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (940, 'echo \'测试\'', '2020-01-09 07:33:39', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (941, 'echo \'测试\'', '2020-01-09 07:33:40', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (942, 'echo \'测试\'', '2020-01-09 07:33:41', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (943, 'echo \'测试\'', '2020-01-09 07:33:42', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (944, 'echo \'测试\'', '2020-01-09 07:33:43', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (945, 'echo \'测试\'', '2020-01-09 07:33:44', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (946, 'echo \'测试\'', '2020-01-09 07:33:45', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (947, 'echo \'测试\'', '2020-01-09 07:33:46', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (948, 'echo \'测试\'', '2020-01-09 07:33:47', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (949, 'echo \'测试\'', '2020-01-09 07:33:48', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (950, 'echo \'测试\'', '2020-01-09 07:33:49', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (951, 'echo \'测试\'', '2020-01-09 07:33:50', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (952, 'echo \'测试\'', '2020-01-09 07:33:51', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (953, 'echo \'测试\'', '2020-01-09 07:33:52', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (954, 'echo \'测试\'', '2020-01-09 07:33:53', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (955, 'echo \'测试\'', '2020-01-09 07:33:54', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (956, 'echo \'测试\'', '2020-01-09 07:33:55', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (957, 'echo \'测试\'', '2020-01-09 07:33:56', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (958, 'echo \'测试\'', '2020-01-09 07:33:57', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (959, 'echo \'测试\'', '2020-01-09 07:33:58', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');
INSERT INTO `yii2_execute_task` VALUES (960, 'echo \'测试\'', '2020-01-09 07:33:59', NULL, NULL, '1', NULL, '2020-01-09 07:31:59', '2020-01-09 07:31:59');

-- ----------------------------
-- Table structure for yii2_task
-- ----------------------------
DROP TABLE IF EXISTS `yii2_task`;
CREATE TABLE `yii2_task`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `command` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '需要执行的命令',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `rule` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '规则',
  `switch` enum('1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '开关 1/开 2/关',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '数据创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '数据修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `2141212fc1vgv13311g13`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_task
-- ----------------------------
INSERT INTO `yii2_task` VALUES (11, 'df -h', '查看内存', '*/60 * * * * *', '2', '2018-11-01 02:53:14', '2020-01-09 07:28:27');
INSERT INTO `yii2_task` VALUES (12, 'date', '查看日期', '*/60 * * * * *', '2', '2018-11-01 04:06:29', '2020-01-09 07:28:34');
INSERT INTO `yii2_task` VALUES (13, 'curl https://www.baidu.com', '百度数据', '*/1 * * * * *', '2', '2020-01-07 11:20:28', '2020-01-09 07:28:55');
INSERT INTO `yii2_task` VALUES (14, 'curl https://www.huya.com', '虎牙数据', '*/1 * * * * *', '2', '2020-01-07 11:23:21', '2020-01-09 07:29:02');
INSERT INTO `yii2_task` VALUES (15, 'echo \'测试\'', '测试', '*/1 * * * * *', '1', '2020-01-09 01:45:56', '2020-01-09 07:29:09');

-- ----------------------------
-- Table structure for yii2_user
-- ----------------------------
DROP TABLE IF EXISTS `yii2_user`;
CREATE TABLE `yii2_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `phone` char(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `head` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'access-token',
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '加密密码',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `last_login_ip` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最近登录ip',
  `last_login_at` int(11) NULL DEFAULT NULL COMMENT '最近登陆时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `yii2restful_yii2_user_username`(`username`) USING BTREE,
  UNIQUE INDEX `yii2restful_yii2_user_access_token`(`access_token`) USING BTREE COMMENT 'access_token',
  UNIQUE INDEX `yii2restful_yii2_user_phone`(`phone`) USING BTREE,
  UNIQUE INDEX `yii2restful_yii2_user_email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_user
-- ----------------------------
INSERT INTO `yii2_user` VALUES (1, '15918793994', 'root', NULL, 'OdV7kAoASOIh4MvI82-kpA0B_GPVUXHB', '$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K', '1533356676@qq.com', 1479371680, 1543913718, '192.168.1.254', 1578546310);
INSERT INTO `yii2_user` VALUES (2, NULL, 'admin', NULL, 'oTzzQgxVfMMqs1JdvPhiKeO8e3O5XpAZ', '$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K', '3095764452@qq.com', 1479371663, 1479371680, '127.0.0.1', 1543913755);
INSERT INTO `yii2_user` VALUES (39, NULL, 'test', NULL, '9MYR7KpG3Mkc-ZFckWv_T-oIDiOQeqZL', '$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K', NULL, 1530780629, 1530780629, '120.85.87.197', 1543286683);

-- ----------------------------
-- Table structure for yii2_user_copy
-- ----------------------------
DROP TABLE IF EXISTS `yii2_user_copy`;
CREATE TABLE `yii2_user_copy`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `phone` char(12) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `head` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'access-token',
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `last_login_ip` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '最近登录ip',
  `last_login_at` int(11) NULL DEFAULT NULL COMMENT '最近登陆时间',
  `oauth2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'self' COMMENT 'oauth2',
  `oauth2_id` int(11) NULL DEFAULT NULL COMMENT 'oauth2_id',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `yii2restful_yii2_user_oauth2_oauth2_id`(`oauth2`, `oauth2_id`) USING BTREE COMMENT 'oauth2唯一索引',
  UNIQUE INDEX `yii2restful_yii2_user_access_token`(`access_token`) USING BTREE COMMENT 'access_token',
  UNIQUE INDEX `yii2restful_yii2_user_phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_user_copy
-- ----------------------------
INSERT INTO `yii2_user_copy` VALUES (1, '1', 'root', '', '1', '6lgGBSosfvH0c9_nZZP8DY6YiI4ycwDx', '$2y$13$Gmkbp4uYHbUivaxE7x3M0.LRzJUiDMKWCWUAKD763S/vbzJeIt8xe', NULL, '1533356676@qq.com', 1479371680, 1479371680, NULL, NULL, 'self', NULL);
INSERT INTO `yii2_user_copy` VALUES (2, '2', 'admin', NULL, '2', 'pA7DChvN6X22MWjc6W_9TYALKiduyftD', '$2y$13$gqyTZRup/.lisGkogBT5benIucbEZ4yweD11JKWjHASA4hl9a7oau', NULL, '3095764452@qq.com', 1479371663, 1479371680, NULL, NULL, 'self', NULL);
INSERT INTO `yii2_user_copy` VALUES (9, '', 'little-bit-shy', 'https://avatars.githubusercontent.com/u/12792446?v=3', '9', NULL, NULL, NULL, NULL, 1484897023, 1479371680, NULL, NULL, 'github', 12792446);
INSERT INTO `yii2_user_copy` VALUES (10, '15918793994', NULL, NULL, 'y0gZlbBXGxOo4K--4_4jDNa_Byw2I-8V', NULL, '$2y$13$MpWF3HZWwe1CrcvpbwDLR.k2bRnr9VyvKCPYGaNjv8..S8Z.rkliS', NULL, NULL, 1485158903, 1485158903, '127.0.0.1', 1485160819, 'self', NULL);
INSERT INTO `yii2_user_copy` VALUES (12, '15918793991', 'fUrXC2rT', NULL, '6l4nL9fP7X7EXTw5ecedHjUhH9Kv12iv', NULL, '$2y$13$nLc17UBNeDhaRu5bFnJr8uAh2vyOt1/xYMmIVAuUNeLVmose7MkKm', NULL, NULL, 1485160893, 1485160893, NULL, NULL, 'self', NULL);
INSERT INTO `yii2_user_copy` VALUES (13, '15918793992', 'mK0wLev6', NULL, 'inORraxmoIqYOaaDL9qe6MqBZaf-C9Pl', NULL, '$2y$13$HghCFt1JWLsduv5bLQ13w.z/6W3Fzgz70qmgypNEFKlJH9P8b3xOy', NULL, NULL, 1485161033, 1485161033, NULL, NULL, 'self', NULL);
INSERT INTO `yii2_user_copy` VALUES (14, '15918793993', 'BWko4Fiu', NULL, '0SqyoC7enijE3sDlTAVy1jmP8D9Krb2P', NULL, '$2y$13$fAbDXAo6MJ/uGCPeUcdExeQDQvZBYlCsfa23UUkS8lzv3/NufI2Lm', NULL, NULL, 1485161050, 1485161050, NULL, NULL, 'self', NULL);

SET FOREIGN_KEY_CHECKS = 1;

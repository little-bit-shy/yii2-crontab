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

 Date: 06/01/2020 18:02:22
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
  `status` enum('1','2','3','4') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '执行状态 1/准备中 2/执行中 3/任务失败 4/已完成',
  `result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '任务输出',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '数据创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '数据修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `asfapf17g12yguyf1g11gf12`(`start_time`, `status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1544612 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_execute_task
-- ----------------------------
INSERT INTO `yii2_execute_task` VALUES (1544403, 'df -h', '2018-11-23 03:22:20', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544404, 'df -h', '2018-11-23 03:22:21', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544405, 'df -h', '2018-11-23 03:22:22', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544406, 'df -h', '2018-11-23 03:22:23', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544407, 'df -h', '2018-11-23 03:22:24', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544408, 'df -h', '2018-11-23 03:22:25', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544409, 'df -h', '2018-11-23 03:22:26', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544410, 'df -h', '2018-11-23 03:22:27', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544411, 'df -h', '2018-11-23 03:22:28', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544412, 'df -h', '2018-11-23 03:22:29', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544413, 'df -h', '2018-11-23 03:22:30', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544414, 'df -h', '2018-11-23 03:22:31', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544415, 'df -h', '2018-11-23 03:22:32', NULL, '3', NULL, '2018-11-23 03:20:35', '2018-12-04 09:04:54');
INSERT INTO `yii2_execute_task` VALUES (1544416, 'df -h', '2018-12-04 09:08:32', '2018-12-04 09:08:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:07:31', '2018-12-04 09:08:33');
INSERT INTO `yii2_execute_task` VALUES (1544417, 'df -h', '2018-12-04 09:08:52', '2018-12-04 09:08:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:07:31', '2018-12-04 09:08:52');
INSERT INTO `yii2_execute_task` VALUES (1544418, 'df -h', '2018-12-04 09:09:12', '2018-12-04 09:09:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:07:31', '2018-12-04 09:09:12');
INSERT INTO `yii2_execute_task` VALUES (1544419, 'df -h', '2018-12-04 09:09:32', '2018-12-04 09:09:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:08:31', '2018-12-04 09:09:32');
INSERT INTO `yii2_execute_task` VALUES (1544420, 'df -h', '2018-12-04 09:09:52', '2018-12-04 09:09:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:08:31', '2018-12-04 09:09:52');
INSERT INTO `yii2_execute_task` VALUES (1544421, 'df -h', '2018-12-04 09:10:12', '2018-12-04 09:10:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:08:31', '2018-12-04 09:10:12');
INSERT INTO `yii2_execute_task` VALUES (1544422, 'df -h', '2018-12-04 09:10:32', '2018-12-04 09:10:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:09:31', '2018-12-04 09:10:32');
INSERT INTO `yii2_execute_task` VALUES (1544423, 'df -h', '2018-12-04 09:10:52', '2018-12-04 09:10:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:09:31', '2018-12-04 09:10:52');
INSERT INTO `yii2_execute_task` VALUES (1544424, 'df -h', '2018-12-04 09:11:12', '2018-12-04 09:11:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:09:31', '2018-12-04 09:11:12');
INSERT INTO `yii2_execute_task` VALUES (1544425, 'df -h', '2018-12-04 09:11:32', '2018-12-04 09:11:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:10:31', '2018-12-04 09:11:32');
INSERT INTO `yii2_execute_task` VALUES (1544426, 'df -h', '2018-12-04 09:11:52', '2018-12-04 09:11:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:10:31', '2018-12-04 09:11:52');
INSERT INTO `yii2_execute_task` VALUES (1544427, 'df -h', '2018-12-04 09:12:12', '2018-12-04 09:12:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:10:31', '2018-12-04 09:12:12');
INSERT INTO `yii2_execute_task` VALUES (1544428, 'df -h', '2018-12-04 09:12:32', '2018-12-04 09:12:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:11:31', '2018-12-04 09:12:32');
INSERT INTO `yii2_execute_task` VALUES (1544429, 'df -h', '2018-12-04 09:12:52', '2018-12-04 09:12:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:11:31', '2018-12-04 09:12:52');
INSERT INTO `yii2_execute_task` VALUES (1544430, 'df -h', '2018-12-04 09:13:12', '2018-12-04 09:13:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:11:31', '2018-12-04 09:13:12');
INSERT INTO `yii2_execute_task` VALUES (1544431, 'df -h', '2018-12-04 09:13:32', '2018-12-04 09:13:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:12:31', '2018-12-04 09:13:32');
INSERT INTO `yii2_execute_task` VALUES (1544432, 'df -h', '2018-12-04 09:13:52', '2018-12-04 09:13:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:12:31', '2018-12-04 09:13:52');
INSERT INTO `yii2_execute_task` VALUES (1544433, 'df -h', '2018-12-04 09:14:12', '2018-12-04 09:14:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:12:31', '2018-12-04 09:14:12');
INSERT INTO `yii2_execute_task` VALUES (1544434, 'df -h', '2018-12-04 09:14:32', '2018-12-04 09:14:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:13:31', '2018-12-04 09:14:32');
INSERT INTO `yii2_execute_task` VALUES (1544435, 'df -h', '2018-12-04 09:14:52', '2018-12-04 09:14:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:13:31', '2018-12-04 09:14:52');
INSERT INTO `yii2_execute_task` VALUES (1544436, 'df -h', '2018-12-04 09:15:12', '2018-12-04 09:15:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:13:31', '2018-12-04 09:15:12');
INSERT INTO `yii2_execute_task` VALUES (1544437, 'df -h', '2018-12-04 09:15:32', '2018-12-04 09:15:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:14:31', '2018-12-04 09:15:32');
INSERT INTO `yii2_execute_task` VALUES (1544438, 'df -h', '2018-12-04 09:15:52', '2018-12-04 09:15:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:14:31', '2018-12-04 09:15:52');
INSERT INTO `yii2_execute_task` VALUES (1544439, 'df -h', '2018-12-04 09:16:12', '2018-12-04 09:16:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:14:31', '2018-12-04 09:16:12');
INSERT INTO `yii2_execute_task` VALUES (1544440, 'df -h', '2018-12-04 09:16:32', '2018-12-04 09:16:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:15:31', '2018-12-04 09:16:32');
INSERT INTO `yii2_execute_task` VALUES (1544441, 'df -h', '2018-12-04 09:16:52', '2018-12-04 09:16:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:15:31', '2018-12-04 09:16:52');
INSERT INTO `yii2_execute_task` VALUES (1544442, 'df -h', '2018-12-04 09:17:12', '2018-12-04 09:17:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:15:31', '2018-12-04 09:17:12');
INSERT INTO `yii2_execute_task` VALUES (1544443, 'df -h', '2018-12-04 09:17:32', '2018-12-04 09:17:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:16:31', '2018-12-04 09:17:32');
INSERT INTO `yii2_execute_task` VALUES (1544444, 'df -h', '2018-12-04 09:17:52', '2018-12-04 09:17:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:16:31', '2018-12-04 09:17:52');
INSERT INTO `yii2_execute_task` VALUES (1544445, 'df -h', '2018-12-04 09:18:12', '2018-12-04 09:18:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:16:31', '2018-12-04 09:18:12');
INSERT INTO `yii2_execute_task` VALUES (1544446, 'df -h', '2018-12-04 09:18:32', '2018-12-04 09:18:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:17:31', '2018-12-04 09:18:32');
INSERT INTO `yii2_execute_task` VALUES (1544447, 'df -h', '2018-12-04 09:18:52', '2018-12-04 09:18:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:17:31', '2018-12-04 09:18:52');
INSERT INTO `yii2_execute_task` VALUES (1544448, 'df -h', '2018-12-04 09:19:12', '2018-12-04 09:19:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:17:31', '2018-12-04 09:19:12');
INSERT INTO `yii2_execute_task` VALUES (1544449, 'df -h', '2018-12-04 09:19:32', '2018-12-04 09:19:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:18:31', '2018-12-04 09:19:32');
INSERT INTO `yii2_execute_task` VALUES (1544450, 'df -h', '2018-12-04 09:19:52', '2018-12-04 09:19:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:18:31', '2018-12-04 09:19:52');
INSERT INTO `yii2_execute_task` VALUES (1544451, 'df -h', '2018-12-04 09:20:12', '2018-12-04 09:20:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:18:31', '2018-12-04 09:20:12');
INSERT INTO `yii2_execute_task` VALUES (1544452, 'df -h', '2018-12-04 09:20:32', '2018-12-04 09:20:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:19:31', '2018-12-04 09:20:32');
INSERT INTO `yii2_execute_task` VALUES (1544453, 'df -h', '2018-12-04 09:20:52', '2018-12-04 09:20:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:19:31', '2018-12-04 09:20:52');
INSERT INTO `yii2_execute_task` VALUES (1544454, 'df -h', '2018-12-04 09:21:12', '2018-12-04 09:21:12', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:19:31', '2018-12-04 09:21:12');
INSERT INTO `yii2_execute_task` VALUES (1544455, 'df -h', '2018-12-04 09:21:32', '2018-12-04 09:21:32', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:20:31', '2018-12-04 09:21:32');
INSERT INTO `yii2_execute_task` VALUES (1544456, 'df -h', '2018-12-04 09:21:52', '2018-12-04 09:21:52', '4', 'Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ', '2018-12-04 09:20:31', '2018-12-04 09:21:52');
INSERT INTO `yii2_execute_task` VALUES (1544457, 'df -h', '2018-12-04 09:22:12', NULL, '3', NULL, '2018-12-04 09:20:31', '2018-12-04 09:23:58');
INSERT INTO `yii2_execute_task` VALUES (1544458, 'df -h', '2018-12-04 09:22:32', NULL, '3', NULL, '2018-12-04 09:21:31', '2018-12-04 09:23:58');
INSERT INTO `yii2_execute_task` VALUES (1544459, 'df -h', '2018-12-04 09:22:52', NULL, '3', NULL, '2018-12-04 09:21:31', '2018-12-04 09:23:58');
INSERT INTO `yii2_execute_task` VALUES (1544460, 'df -h', '2018-12-04 09:23:12', NULL, '3', NULL, '2018-12-04 09:21:31', '2018-12-04 09:24:58');
INSERT INTO `yii2_execute_task` VALUES (1544461, 'df -h', '2018-12-04 09:23:59', NULL, '3', NULL, '2018-12-04 09:22:58', '2018-12-04 09:25:58');
INSERT INTO `yii2_execute_task` VALUES (1544462, 'df -h', '2018-12-04 09:24:19', NULL, '3', NULL, '2018-12-04 09:22:58', '2018-12-04 09:25:58');
INSERT INTO `yii2_execute_task` VALUES (1544463, 'df -h', '2018-12-04 09:24:39', NULL, '3', NULL, '2018-12-04 09:22:58', '2018-12-04 09:25:58');
INSERT INTO `yii2_execute_task` VALUES (1544464, 'df -h', '2018-12-04 09:24:59', NULL, '3', NULL, '2018-12-04 09:23:58', '2020-01-06 09:38:00');
INSERT INTO `yii2_execute_task` VALUES (1544465, 'df -h', '2018-12-04 09:25:59', NULL, '3', NULL, '2018-12-04 09:24:58', '2020-01-06 09:38:00');
INSERT INTO `yii2_execute_task` VALUES (1544466, 'df -h', '2018-12-04 09:26:59', NULL, '3', NULL, '2018-12-04 09:25:59', '2020-01-06 09:38:00');
INSERT INTO `yii2_execute_task` VALUES (1544467, 'df -h', '2020-01-06 09:40:00', NULL, '3', NULL, '2020-01-06 09:38:00', '2020-01-06 09:41:01');
INSERT INTO `yii2_execute_task` VALUES (1544468, 'df -h', '2020-01-06 09:41:00', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:42:01');
INSERT INTO `yii2_execute_task` VALUES (1544469, 'echo \'11111111\'', '2020-01-06 09:41:00', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:42:01');
INSERT INTO `yii2_execute_task` VALUES (1544470, 'echo \'11111111\'', '2020-01-06 09:41:01', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544471, 'echo \'11111111\'', '2020-01-06 09:41:02', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544472, 'echo \'11111111\'', '2020-01-06 09:41:03', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544473, 'echo \'11111111\'', '2020-01-06 09:41:04', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544474, 'echo \'11111111\'', '2020-01-06 09:41:05', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544475, 'echo \'11111111\'', '2020-01-06 09:41:06', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544476, 'echo \'11111111\'', '2020-01-06 09:41:07', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544477, 'echo \'11111111\'', '2020-01-06 09:41:08', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544478, 'echo \'11111111\'', '2020-01-06 09:41:09', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544479, 'echo \'11111111\'', '2020-01-06 09:41:10', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544480, 'echo \'11111111\'', '2020-01-06 09:41:11', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544481, 'echo \'11111111\'', '2020-01-06 09:41:12', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544482, 'echo \'11111111\'', '2020-01-06 09:41:13', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544483, 'echo \'11111111\'', '2020-01-06 09:41:14', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544484, 'echo \'11111111\'', '2020-01-06 09:41:15', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544485, 'echo \'11111111\'', '2020-01-06 09:41:16', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544486, 'echo \'11111111\'', '2020-01-06 09:41:17', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544487, 'echo \'11111111\'', '2020-01-06 09:41:18', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544488, 'echo \'11111111\'', '2020-01-06 09:41:19', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544489, 'echo \'11111111\'', '2020-01-06 09:41:20', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544490, 'echo \'11111111\'', '2020-01-06 09:41:21', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544491, 'echo \'11111111\'', '2020-01-06 09:41:22', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544492, 'echo \'11111111\'', '2020-01-06 09:41:23', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544493, 'echo \'11111111\'', '2020-01-06 09:41:24', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544494, 'echo \'11111111\'', '2020-01-06 09:41:25', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544495, 'echo \'11111111\'', '2020-01-06 09:41:26', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544496, 'echo \'11111111\'', '2020-01-06 09:41:27', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544497, 'echo \'11111111\'', '2020-01-06 09:41:28', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544498, 'echo \'11111111\'', '2020-01-06 09:41:29', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544499, 'echo \'11111111\'', '2020-01-06 09:41:30', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544500, 'echo \'11111111\'', '2020-01-06 09:41:31', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544501, 'echo \'11111111\'', '2020-01-06 09:41:32', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544502, 'echo \'11111111\'', '2020-01-06 09:41:33', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544503, 'echo \'11111111\'', '2020-01-06 09:41:34', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544504, 'echo \'11111111\'', '2020-01-06 09:41:35', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544505, 'echo \'11111111\'', '2020-01-06 09:41:36', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544506, 'echo \'11111111\'', '2020-01-06 09:41:37', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544507, 'echo \'11111111\'', '2020-01-06 09:41:38', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544508, 'echo \'11111111\'', '2020-01-06 09:41:39', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544509, 'echo \'11111111\'', '2020-01-06 09:41:40', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544510, 'echo \'11111111\'', '2020-01-06 09:41:41', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544511, 'echo \'11111111\'', '2020-01-06 09:41:42', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544512, 'echo \'11111111\'', '2020-01-06 09:41:43', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544513, 'echo \'11111111\'', '2020-01-06 09:41:44', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544514, 'echo \'11111111\'', '2020-01-06 09:41:45', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544515, 'echo \'11111111\'', '2020-01-06 09:41:46', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544516, 'echo \'11111111\'', '2020-01-06 09:41:47', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544517, 'echo \'11111111\'', '2020-01-06 09:41:48', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544518, 'echo \'11111111\'', '2020-01-06 09:41:49', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544519, 'echo \'11111111\'', '2020-01-06 09:41:50', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544520, 'echo \'11111111\'', '2020-01-06 09:41:51', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544521, 'echo \'11111111\'', '2020-01-06 09:41:52', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544522, 'echo \'11111111\'', '2020-01-06 09:41:53', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544523, 'echo \'11111111\'', '2020-01-06 09:41:54', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544524, 'echo \'11111111\'', '2020-01-06 09:41:55', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544525, 'echo \'11111111\'', '2020-01-06 09:41:56', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544526, 'echo \'11111111\'', '2020-01-06 09:41:57', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544527, 'echo \'11111111\'', '2020-01-06 09:41:58', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544528, 'echo \'11111111\'', '2020-01-06 09:41:59', NULL, '3', NULL, '2020-01-06 09:39:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544529, 'df -h', '2020-01-06 09:42:00', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544530, 'echo \'11111111\'', '2020-01-06 09:42:00', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:43:01');
INSERT INTO `yii2_execute_task` VALUES (1544531, 'echo \'11111111\'', '2020-01-06 09:42:01', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544532, 'echo \'11111111\'', '2020-01-06 09:42:02', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544533, 'echo \'11111111\'', '2020-01-06 09:42:03', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544534, 'echo \'11111111\'', '2020-01-06 09:42:04', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544535, 'echo \'11111111\'', '2020-01-06 09:42:05', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544536, 'echo \'11111111\'', '2020-01-06 09:42:06', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544537, 'echo \'11111111\'', '2020-01-06 09:42:07', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544538, 'echo \'11111111\'', '2020-01-06 09:42:08', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544539, 'echo \'11111111\'', '2020-01-06 09:42:09', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544540, 'echo \'11111111\'', '2020-01-06 09:42:10', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544541, 'echo \'11111111\'', '2020-01-06 09:42:11', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544542, 'echo \'11111111\'', '2020-01-06 09:42:12', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544543, 'echo \'11111111\'', '2020-01-06 09:42:13', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544544, 'echo \'11111111\'', '2020-01-06 09:42:14', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544545, 'echo \'11111111\'', '2020-01-06 09:42:15', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544546, 'echo \'11111111\'', '2020-01-06 09:42:16', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544547, 'echo \'11111111\'', '2020-01-06 09:42:17', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544548, 'echo \'11111111\'', '2020-01-06 09:42:18', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544549, 'echo \'11111111\'', '2020-01-06 09:42:19', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544550, 'echo \'11111111\'', '2020-01-06 09:42:20', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544551, 'echo \'11111111\'', '2020-01-06 09:42:21', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544552, 'echo \'11111111\'', '2020-01-06 09:42:22', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544553, 'echo \'11111111\'', '2020-01-06 09:42:23', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544554, 'echo \'11111111\'', '2020-01-06 09:42:24', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544555, 'echo \'11111111\'', '2020-01-06 09:42:25', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544556, 'echo \'11111111\'', '2020-01-06 09:42:26', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544557, 'echo \'11111111\'', '2020-01-06 09:42:27', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544558, 'echo \'11111111\'', '2020-01-06 09:42:28', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544559, 'echo \'11111111\'', '2020-01-06 09:42:29', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544560, 'echo \'11111111\'', '2020-01-06 09:42:30', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544561, 'echo \'11111111\'', '2020-01-06 09:42:31', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544562, 'echo \'11111111\'', '2020-01-06 09:42:32', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544563, 'echo \'11111111\'', '2020-01-06 09:42:33', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544564, 'echo \'11111111\'', '2020-01-06 09:42:34', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544565, 'echo \'11111111\'', '2020-01-06 09:42:35', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544566, 'echo \'11111111\'', '2020-01-06 09:42:36', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544567, 'echo \'11111111\'', '2020-01-06 09:42:37', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544568, 'echo \'11111111\'', '2020-01-06 09:42:38', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544569, 'echo \'11111111\'', '2020-01-06 09:42:39', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544570, 'echo \'11111111\'', '2020-01-06 09:42:40', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544571, 'echo \'11111111\'', '2020-01-06 09:42:41', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544572, 'echo \'11111111\'', '2020-01-06 09:42:42', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544573, 'echo \'11111111\'', '2020-01-06 09:42:43', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544574, 'echo \'11111111\'', '2020-01-06 09:42:44', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544575, 'echo \'11111111\'', '2020-01-06 09:42:45', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544576, 'echo \'11111111\'', '2020-01-06 09:42:46', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544577, 'echo \'11111111\'', '2020-01-06 09:42:47', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544578, 'echo \'11111111\'', '2020-01-06 09:42:48', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544579, 'echo \'11111111\'', '2020-01-06 09:42:49', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544580, 'echo \'11111111\'', '2020-01-06 09:42:50', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544581, 'echo \'11111111\'', '2020-01-06 09:42:51', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544582, 'echo \'11111111\'', '2020-01-06 09:42:52', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544583, 'echo \'11111111\'', '2020-01-06 09:42:53', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544584, 'echo \'11111111\'', '2020-01-06 09:42:54', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544585, 'echo \'11111111\'', '2020-01-06 09:42:55', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544586, 'echo \'11111111\'', '2020-01-06 09:42:56', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544587, 'echo \'11111111\'', '2020-01-06 09:42:57', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544588, 'echo \'11111111\'', '2020-01-06 09:42:58', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544589, 'echo \'11111111\'', '2020-01-06 09:42:59', NULL, '3', NULL, '2020-01-06 09:40:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544590, 'df -h', '2020-01-06 09:43:00', NULL, '3', NULL, '2020-01-06 09:41:00', '2020-01-06 09:44:01');
INSERT INTO `yii2_execute_task` VALUES (1544591, 'df -h', '2020-01-06 09:44:00', NULL, '3', NULL, '2020-01-06 09:42:00', '2020-01-06 09:45:01');
INSERT INTO `yii2_execute_task` VALUES (1544592, 'df -h', '2020-01-06 09:45:00', '2020-01-06 09:45:00', '2', NULL, '2020-01-06 09:43:00', '2020-01-06 09:45:00');
INSERT INTO `yii2_execute_task` VALUES (1544593, 'df -h', '2020-01-06 09:46:00', NULL, '3', NULL, '2020-01-06 09:44:00', '2020-01-06 09:47:01');
INSERT INTO `yii2_execute_task` VALUES (1544594, 'df -h', '2020-01-06 09:47:00', NULL, '3', NULL, '2020-01-06 09:45:00', '2020-01-06 09:48:01');
INSERT INTO `yii2_execute_task` VALUES (1544595, 'df -h', '2020-01-06 09:48:00', NULL, '3', NULL, '2020-01-06 09:46:00', '2020-01-06 09:49:01');
INSERT INTO `yii2_execute_task` VALUES (1544596, 'df -h', '2020-01-06 09:49:00', NULL, '3', NULL, '2020-01-06 09:47:00', '2020-01-06 09:50:01');
INSERT INTO `yii2_execute_task` VALUES (1544597, 'df -h', '2020-01-06 09:50:00', NULL, '3', NULL, '2020-01-06 09:48:00', '2020-01-06 09:51:01');
INSERT INTO `yii2_execute_task` VALUES (1544598, 'df -h', '2020-01-06 09:51:00', NULL, '3', NULL, '2020-01-06 09:49:00', '2020-01-06 09:52:01');
INSERT INTO `yii2_execute_task` VALUES (1544599, 'df -h', '2020-01-06 09:52:00', NULL, '3', NULL, '2020-01-06 09:50:00', '2020-01-06 09:53:01');
INSERT INTO `yii2_execute_task` VALUES (1544600, 'df -h', '2020-01-06 09:53:00', NULL, '3', NULL, '2020-01-06 09:51:00', '2020-01-06 09:54:01');
INSERT INTO `yii2_execute_task` VALUES (1544601, 'df -h', '2020-01-06 09:54:00', NULL, '3', NULL, '2020-01-06 09:52:00', '2020-01-06 09:55:01');
INSERT INTO `yii2_execute_task` VALUES (1544602, 'df -h', '2020-01-06 09:55:00', NULL, '3', NULL, '2020-01-06 09:53:00', '2020-01-06 09:56:01');
INSERT INTO `yii2_execute_task` VALUES (1544603, 'df -h', '2020-01-06 09:56:00', NULL, '3', NULL, '2020-01-06 09:54:00', '2020-01-06 09:57:01');
INSERT INTO `yii2_execute_task` VALUES (1544604, 'df -h', '2020-01-06 09:57:00', NULL, '3', NULL, '2020-01-06 09:55:00', '2020-01-06 09:58:01');
INSERT INTO `yii2_execute_task` VALUES (1544605, 'df -h', '2020-01-06 09:58:00', NULL, '3', NULL, '2020-01-06 09:56:00', '2020-01-06 09:59:01');
INSERT INTO `yii2_execute_task` VALUES (1544606, 'df -h', '2020-01-06 09:59:00', NULL, '3', NULL, '2020-01-06 09:57:00', '2020-01-06 10:00:01');
INSERT INTO `yii2_execute_task` VALUES (1544607, 'df -h', '2020-01-06 10:00:00', NULL, '3', NULL, '2020-01-06 09:58:00', '2020-01-06 10:01:01');
INSERT INTO `yii2_execute_task` VALUES (1544608, 'df -h', '2020-01-06 10:01:00', NULL, '3', NULL, '2020-01-06 09:59:00', '2020-01-06 10:02:01');
INSERT INTO `yii2_execute_task` VALUES (1544609, 'df -h', '2020-01-06 10:02:00', NULL, '1', NULL, '2020-01-06 10:00:00', '2020-01-06 10:00:00');
INSERT INTO `yii2_execute_task` VALUES (1544610, 'df -h', '2020-01-06 10:03:00', NULL, '1', NULL, '2020-01-06 10:01:00', '2020-01-06 10:01:00');
INSERT INTO `yii2_execute_task` VALUES (1544611, 'df -h', '2020-01-06 10:04:00', NULL, '1', NULL, '2020-01-06 10:02:00', '2020-01-06 10:02:00');

-- ----------------------------
-- Table structure for yii2_task
-- ----------------------------
DROP TABLE IF EXISTS `yii2_task`;
CREATE TABLE `yii2_task`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `command` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '需要执行的命令',
  `rule` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '规则',
  `switch` enum('1','2') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '开关 1/开 2/关',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '数据创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '数据修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yii2_task
-- ----------------------------
INSERT INTO `yii2_task` VALUES (11, 'df -h', '*/60 * * * * *', '1', '2018-11-01 02:53:14', '2018-12-04 09:23:24');
INSERT INTO `yii2_task` VALUES (12, 'echo \'11111111\'', '*/1 * * * * *', '2', '2018-11-01 04:06:29', '2020-01-06 09:40:43');

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
INSERT INTO `yii2_user` VALUES (1, '15918793994', 'root', 'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3448484253,3685836170&fm=27&gp=0.jpg', '5u9mYlWvrpXLAWj1JtFAxUAG4SWsuATI', '$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K', '1533356676@qq.com', 1479371680, 1543913718, '192.168.1.254', 1578300098);
INSERT INTO `yii2_user` VALUES (2, NULL, 'admin', 'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3448484253,3685836170&fm=27&gp=0.jpg', 'oTzzQgxVfMMqs1JdvPhiKeO8e3O5XpAZ', '$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K', '3095764452@qq.com', 1479371663, 1479371680, '127.0.0.1', 1543913755);
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

-- MySQL dump 10.13  Distrib 5.6.42, for Linux (x86_64)
--
-- Host: localhost    Database: yii2restful
-- ------------------------------------------------------
-- Server version	5.6.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `yii2_auth_assignment`
--

DROP TABLE IF EXISTS `yii2_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yii2_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `yii2_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_auth_assignment`
--

LOCK TABLES `yii2_auth_assignment` WRITE;
/*!40000 ALTER TABLE `yii2_auth_assignment` DISABLE KEYS */;
INSERT INTO `yii2_auth_assignment` VALUES ('ordinaryUser','2',1543913735),('ordinaryUser','39',1530783401),('root','1',1522555776);
/*!40000 ALTER TABLE `yii2_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_auth_item`
--

DROP TABLE IF EXISTS `yii2_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_auth_item`
--

LOCK TABLES `yii2_auth_item` WRITE;
/*!40000 ALTER TABLE `yii2_auth_item` DISABLE KEYS */;
INSERT INTO `yii2_auth_item` VALUES ('/*',2,'/*',NULL,NULL,1543285939,1543285939),('/debug/*',2,'/debug/*',NULL,NULL,1522201146,1522201146),('/debug/default/*',2,'/debug/default/*',NULL,NULL,1522201146,1522201146),('/debug/default/db-explain',2,'/debug/default/db-explain',NULL,NULL,1522390662,1522390662),('/debug/default/download-mail',2,'/debug/default/download-mail',NULL,NULL,1522201146,1522201146),('/debug/default/index',2,'/debug/default/index',NULL,NULL,1522201146,1522201146),('/debug/default/toolbar',2,'/debug/default/toolbar',NULL,NULL,1522201146,1522201146),('/debug/default/view',2,'/debug/default/view',NULL,NULL,1522201146,1522201146),('/debug/user/*',2,'/debug/user/*',NULL,NULL,1522201146,1522201146),('/debug/user/reset-identity',2,'/debug/user/reset-identity',NULL,NULL,1522201146,1522201146),('/debug/user/set-identity',2,'/debug/user/set-identity',NULL,NULL,1522201146,1522201146),('/gii/*',2,'/gii/*',NULL,NULL,1522201146,1522201146),('/gii/default/*',2,'/gii/default/*',NULL,NULL,1522201146,1522201146),('/gii/default/action',2,'/gii/default/action',NULL,NULL,1522201146,1522201146),('/gii/default/diff',2,'/gii/default/diff',NULL,NULL,1522201146,1522201146),('/gii/default/index',2,'/gii/default/index',NULL,NULL,1522201146,1522201146),('/gii/default/preview',2,'/gii/default/preview',NULL,NULL,1522201146,1522201146),('/gii/default/view',2,'/gii/default/view',NULL,NULL,1522201146,1522201146),('/site/*',2,'/site/*',NULL,NULL,1522201146,1522201146),('/site/captcha',2,'/site/captcha',NULL,NULL,1522201146,1522201146),('/site/error',2,'/site/error',NULL,NULL,1522201146,1522201146),('/v1/*',2,'V1模块',NULL,NULL,1521525747,1521619641),('/v1/auth-item/*',2,'权限管理',NULL,NULL,1521525747,1521619650),('/v1/auth-item/add-permissions',2,'添加权限',NULL,NULL,1520165332,1520236587),('/v1/auth-item/add-role',2,'添加角色',NULL,NULL,1521808974,1522052471),('/v1/auth-item/add-role-permissions',2,'添加角色权限',NULL,NULL,1521808974,1522052489),('/v1/auth-item/add-user',2,'添加用户',NULL,NULL,1530780543,1530780588),('/v1/auth-item/add-user-role',2,'为用户分配角色',NULL,NULL,1522503205,1522504084),('/v1/auth-item/all-lists',2,'获取所有权限',NULL,NULL,1520215567,1521619697),('/v1/auth-item/all-lists-with-level',2,'获取有层次结构的权限',NULL,NULL,1521007674,1521619678),('/v1/auth-item/all-lists-with-role',2,'获取角色拥有的权限',NULL,NULL,1521007674,1521619716),('/v1/auth-item/all-role-with-user',2,'获取指定用户的所有角色',NULL,NULL,1522503264,1522504160),('/v1/auth-item/delete-role-permissions',2,'删除角色权限',NULL,NULL,1521808974,1522052501),('/v1/auth-item/delete-user-role',2,'删除指定用户的某个角色',NULL,NULL,1522503258,1522504142),('/v1/auth-item/index',2,'权限列表',NULL,NULL,1520215567,1520236625),('/v1/auth-item/project-directory',2,'项目结构',NULL,NULL,1520165332,1520236637),('/v1/auth-item/remove-permissions',2,'移除权限',NULL,NULL,1520165332,1520236664),('/v1/auth-item/reset-psw-user',2,'密码重置',NULL,NULL,1543913588,1543913607),('/v1/auth-item/update-permissions',2,'修改权限',NULL,NULL,1520165332,1520423740),('/v1/auth-item/user-lists',2,'获取用户列表',NULL,NULL,1522503205,1522504171),('/v1/execute-task/*',2,'执行任务',NULL,NULL,1542943133,1543913617),('/v1/execute-task/index',2,'任务列表',NULL,NULL,1542943133,1543913635),('/v1/execute-task/view',2,'任务详情',NULL,NULL,1542943133,1543913626),('/v1/site/*',2,'基本操作',NULL,NULL,1521525747,1521619728),('/v1/site/all-permissions',2,'获取当前用户已有权限',NULL,NULL,1522066042,1530775704),('/v1/site/captcha',2,'获取验证码',NULL,NULL,1521007674,1521619742),('/v1/site/login',2,'用户登录',NULL,NULL,1521007674,1521619750),('/v1/task/*',2,'任务管理',NULL,NULL,1541054856,1541055008),('/v1/task/create',2,'任务添加',NULL,NULL,1541054856,1541055017),('/v1/task/delete',2,'删除任务',NULL,NULL,1542943133,1543913646),('/v1/task/index',2,'任务列表',NULL,NULL,1541054856,1541054995),('/v1/task/update',2,'任务修改',NULL,NULL,1541054856,1541054986),('/v1/task/view',2,'任务详情',NULL,NULL,1541054856,1541054972),('/v1/user-copy/*',2,'某某某',NULL,NULL,1521525747,1521619769),('/v1/user-copy/create',2,'添加数据',NULL,NULL,1521007674,1522052434),('/v1/user-copy/index',2,'列表数据',NULL,NULL,1521007674,1522052446),('/v1/user-copy/view',2,'详细数据',NULL,NULL,1521007674,1522052453),('ordinaryUser',1,'普通用户',NULL,NULL,1519288590,1530860464),('root',1,'超级管理员',NULL,'s:27:\"蒙多想去哪就去哪...\";',1522066042,1530860469);
/*!40000 ALTER TABLE `yii2_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_auth_item_child`
--

DROP TABLE IF EXISTS `yii2_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yii2_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yii2_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yii2_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_auth_item_child`
--

LOCK TABLES `yii2_auth_item_child` WRITE;
/*!40000 ALTER TABLE `yii2_auth_item_child` DISABLE KEYS */;
INSERT INTO `yii2_auth_item_child` VALUES ('root','/debug/default/db-explain'),('root','/debug/default/download-mail'),('root','/debug/default/index'),('root','/debug/default/toolbar'),('root','/debug/default/view'),('root','/debug/user/reset-identity'),('root','/debug/user/set-identity'),('root','/gii/default/action'),('root','/gii/default/diff'),('root','/gii/default/index'),('root','/gii/default/preview'),('root','/gii/default/view'),('root','/site/captcha'),('root','/site/error'),('root','/v1/auth-item/add-permissions'),('root','/v1/auth-item/add-role'),('root','/v1/auth-item/add-role-permissions'),('root','/v1/auth-item/add-user'),('root','/v1/auth-item/add-user-role'),('ordinaryUser','/v1/auth-item/all-lists'),('root','/v1/auth-item/all-lists'),('ordinaryUser','/v1/auth-item/all-lists-with-level'),('root','/v1/auth-item/all-lists-with-level'),('ordinaryUser','/v1/auth-item/all-lists-with-role'),('root','/v1/auth-item/all-lists-with-role'),('ordinaryUser','/v1/auth-item/all-role-with-user'),('root','/v1/auth-item/all-role-with-user'),('root','/v1/auth-item/delete-role-permissions'),('root','/v1/auth-item/delete-user-role'),('ordinaryUser','/v1/auth-item/index'),('root','/v1/auth-item/index'),('ordinaryUser','/v1/auth-item/project-directory'),('root','/v1/auth-item/project-directory'),('root','/v1/auth-item/remove-permissions'),('ordinaryUser','/v1/auth-item/reset-psw-user'),('root','/v1/auth-item/reset-psw-user'),('root','/v1/auth-item/update-permissions'),('ordinaryUser','/v1/auth-item/user-lists'),('root','/v1/auth-item/user-lists'),('ordinaryUser','/v1/execute-task/index'),('root','/v1/execute-task/index'),('ordinaryUser','/v1/execute-task/view'),('root','/v1/execute-task/view'),('ordinaryUser','/v1/site/*'),('ordinaryUser','/v1/site/all-permissions'),('root','/v1/site/all-permissions'),('ordinaryUser','/v1/site/captcha'),('root','/v1/site/captcha'),('ordinaryUser','/v1/site/login'),('root','/v1/site/login'),('root','/v1/task/create'),('root','/v1/task/delete'),('ordinaryUser','/v1/task/index'),('root','/v1/task/index'),('root','/v1/task/update'),('ordinaryUser','/v1/task/view'),('root','/v1/task/view'),('ordinaryUser','/v1/user-copy/*'),('ordinaryUser','/v1/user-copy/create'),('root','/v1/user-copy/create'),('ordinaryUser','/v1/user-copy/index'),('root','/v1/user-copy/index'),('ordinaryUser','/v1/user-copy/view'),('root','/v1/user-copy/view');
/*!40000 ALTER TABLE `yii2_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_auth_rule`
--

DROP TABLE IF EXISTS `yii2_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yii2_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_auth_rule`
--

LOCK TABLES `yii2_auth_rule` WRITE;
/*!40000 ALTER TABLE `yii2_auth_rule` DISABLE KEYS */;
INSERT INTO `yii2_auth_rule` VALUES ('\\v1\\rules\\AuthorRule','O:19:\"v1\\rules\\AuthorRule\":3:{s:4:\"name\";s:20:\"\\v1\\rules\\AuthorRule\";s:9:\"createdAt\";i:1520217080;s:9:\"updatedAt\";i:1520217080;}',1520217080,1520217080);
/*!40000 ALTER TABLE `yii2_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_execute_task`
--

DROP TABLE IF EXISTS `yii2_execute_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yii2_execute_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `command` varchar(255) NOT NULL COMMENT '需要执行的命令',
  `start_time` datetime DEFAULT NULL COMMENT '任务计划执行时间',
  `execute_time` datetime DEFAULT NULL COMMENT '任务实际执行时间',
  `status` enum('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '执行状态 1/准备中 2/执行中 3/任务失败 4/已完成',
  `result` varchar(255) DEFAULT NULL COMMENT '任务输出',
  `create_time` datetime DEFAULT NULL COMMENT '数据创建时间',
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改时间',
  PRIMARY KEY (`id`),
  KEY `asfapf17g12yguyf1g11gf12` (`start_time`,`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1544467 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_execute_task`
--

LOCK TABLES `yii2_execute_task` WRITE;
/*!40000 ALTER TABLE `yii2_execute_task` DISABLE KEYS */;
INSERT INTO `yii2_execute_task` VALUES (1544403,'df -h','2018-11-23 03:22:20',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544404,'df -h','2018-11-23 03:22:21',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544405,'df -h','2018-11-23 03:22:22',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544406,'df -h','2018-11-23 03:22:23',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544407,'df -h','2018-11-23 03:22:24',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544408,'df -h','2018-11-23 03:22:25',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544409,'df -h','2018-11-23 03:22:26',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544410,'df -h','2018-11-23 03:22:27',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544411,'df -h','2018-11-23 03:22:28',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544412,'df -h','2018-11-23 03:22:29',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544413,'df -h','2018-11-23 03:22:30',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544414,'df -h','2018-11-23 03:22:31',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544415,'df -h','2018-11-23 03:22:32',NULL,'3',NULL,'2018-11-23 03:20:35','2018-12-04 09:04:54'),(1544416,'df -h','2018-12-04 09:08:32','2018-12-04 09:08:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:07:31','2018-12-04 09:08:33'),(1544417,'df -h','2018-12-04 09:08:52','2018-12-04 09:08:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:07:31','2018-12-04 09:08:52'),(1544418,'df -h','2018-12-04 09:09:12','2018-12-04 09:09:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:07:31','2018-12-04 09:09:12'),(1544419,'df -h','2018-12-04 09:09:32','2018-12-04 09:09:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:08:31','2018-12-04 09:09:32'),(1544420,'df -h','2018-12-04 09:09:52','2018-12-04 09:09:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:08:31','2018-12-04 09:09:52'),(1544421,'df -h','2018-12-04 09:10:12','2018-12-04 09:10:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:08:31','2018-12-04 09:10:12'),(1544422,'df -h','2018-12-04 09:10:32','2018-12-04 09:10:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:09:31','2018-12-04 09:10:32'),(1544423,'df -h','2018-12-04 09:10:52','2018-12-04 09:10:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:09:31','2018-12-04 09:10:52'),(1544424,'df -h','2018-12-04 09:11:12','2018-12-04 09:11:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:09:31','2018-12-04 09:11:12'),(1544425,'df -h','2018-12-04 09:11:32','2018-12-04 09:11:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:10:31','2018-12-04 09:11:32'),(1544426,'df -h','2018-12-04 09:11:52','2018-12-04 09:11:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:10:31','2018-12-04 09:11:52'),(1544427,'df -h','2018-12-04 09:12:12','2018-12-04 09:12:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:10:31','2018-12-04 09:12:12'),(1544428,'df -h','2018-12-04 09:12:32','2018-12-04 09:12:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:11:31','2018-12-04 09:12:32'),(1544429,'df -h','2018-12-04 09:12:52','2018-12-04 09:12:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:11:31','2018-12-04 09:12:52'),(1544430,'df -h','2018-12-04 09:13:12','2018-12-04 09:13:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:11:31','2018-12-04 09:13:12'),(1544431,'df -h','2018-12-04 09:13:32','2018-12-04 09:13:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:12:31','2018-12-04 09:13:32'),(1544432,'df -h','2018-12-04 09:13:52','2018-12-04 09:13:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:12:31','2018-12-04 09:13:52'),(1544433,'df -h','2018-12-04 09:14:12','2018-12-04 09:14:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:12:31','2018-12-04 09:14:12'),(1544434,'df -h','2018-12-04 09:14:32','2018-12-04 09:14:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:13:31','2018-12-04 09:14:32'),(1544435,'df -h','2018-12-04 09:14:52','2018-12-04 09:14:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:13:31','2018-12-04 09:14:52'),(1544436,'df -h','2018-12-04 09:15:12','2018-12-04 09:15:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:13:31','2018-12-04 09:15:12'),(1544437,'df -h','2018-12-04 09:15:32','2018-12-04 09:15:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:14:31','2018-12-04 09:15:32'),(1544438,'df -h','2018-12-04 09:15:52','2018-12-04 09:15:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:14:31','2018-12-04 09:15:52'),(1544439,'df -h','2018-12-04 09:16:12','2018-12-04 09:16:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:14:31','2018-12-04 09:16:12'),(1544440,'df -h','2018-12-04 09:16:32','2018-12-04 09:16:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:15:31','2018-12-04 09:16:32'),(1544441,'df -h','2018-12-04 09:16:52','2018-12-04 09:16:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:15:31','2018-12-04 09:16:52'),(1544442,'df -h','2018-12-04 09:17:12','2018-12-04 09:17:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:15:31','2018-12-04 09:17:12'),(1544443,'df -h','2018-12-04 09:17:32','2018-12-04 09:17:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:16:31','2018-12-04 09:17:32'),(1544444,'df -h','2018-12-04 09:17:52','2018-12-04 09:17:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:16:31','2018-12-04 09:17:52'),(1544445,'df -h','2018-12-04 09:18:12','2018-12-04 09:18:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:16:31','2018-12-04 09:18:12'),(1544446,'df -h','2018-12-04 09:18:32','2018-12-04 09:18:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:17:31','2018-12-04 09:18:32'),(1544447,'df -h','2018-12-04 09:18:52','2018-12-04 09:18:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:17:31','2018-12-04 09:18:52'),(1544448,'df -h','2018-12-04 09:19:12','2018-12-04 09:19:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:17:31','2018-12-04 09:19:12'),(1544449,'df -h','2018-12-04 09:19:32','2018-12-04 09:19:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:18:31','2018-12-04 09:19:32'),(1544450,'df -h','2018-12-04 09:19:52','2018-12-04 09:19:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:18:31','2018-12-04 09:19:52'),(1544451,'df -h','2018-12-04 09:20:12','2018-12-04 09:20:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:18:31','2018-12-04 09:20:12'),(1544452,'df -h','2018-12-04 09:20:32','2018-12-04 09:20:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:19:31','2018-12-04 09:20:32'),(1544453,'df -h','2018-12-04 09:20:52','2018-12-04 09:20:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:19:31','2018-12-04 09:20:52'),(1544454,'df -h','2018-12-04 09:21:12','2018-12-04 09:21:12','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:19:31','2018-12-04 09:21:12'),(1544455,'df -h','2018-12-04 09:21:32','2018-12-04 09:21:32','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:20:31','2018-12-04 09:21:32'),(1544456,'df -h','2018-12-04 09:21:52','2018-12-04 09:21:52','4','Filesystem      Size  Used Avail Use% Mounted on\noverlay          99G   11G   83G  12% /\ntmpfs           920M     0  920M   0% /dev\ntmpfs           920M     0  920M   0% /sys/fs/cgroup\n/dev/vda1        99G   11G   83G  12% /www\nshm              64M     0 ','2018-12-04 09:20:31','2018-12-04 09:21:52'),(1544457,'df -h','2018-12-04 09:22:12',NULL,'3',NULL,'2018-12-04 09:20:31','2018-12-04 09:23:58'),(1544458,'df -h','2018-12-04 09:22:32',NULL,'3',NULL,'2018-12-04 09:21:31','2018-12-04 09:23:58'),(1544459,'df -h','2018-12-04 09:22:52',NULL,'3',NULL,'2018-12-04 09:21:31','2018-12-04 09:23:58'),(1544460,'df -h','2018-12-04 09:23:12',NULL,'3',NULL,'2018-12-04 09:21:31','2018-12-04 09:24:58'),(1544461,'df -h','2018-12-04 09:23:59',NULL,'3',NULL,'2018-12-04 09:22:58','2018-12-04 09:25:58'),(1544462,'df -h','2018-12-04 09:24:19',NULL,'3',NULL,'2018-12-04 09:22:58','2018-12-04 09:25:58'),(1544463,'df -h','2018-12-04 09:24:39',NULL,'3',NULL,'2018-12-04 09:22:58','2018-12-04 09:25:58'),(1544464,'df -h','2018-12-04 09:24:59',NULL,'1',NULL,'2018-12-04 09:23:58','2018-12-04 09:23:58'),(1544465,'df -h','2018-12-04 09:25:59',NULL,'1',NULL,'2018-12-04 09:24:58','2018-12-04 09:24:58'),(1544466,'df -h','2018-12-04 09:26:59',NULL,'1',NULL,'2018-12-04 09:25:59','2018-12-04 09:25:59');
/*!40000 ALTER TABLE `yii2_execute_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_task`
--

DROP TABLE IF EXISTS `yii2_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yii2_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `command` varchar(255) NOT NULL COMMENT '需要执行的命令',
  `rule` varchar(30) DEFAULT NULL COMMENT '规则',
  `switch` enum('1','2') NOT NULL DEFAULT '1' COMMENT '开关 1/开 2/关',
  `create_time` datetime DEFAULT NULL COMMENT '数据创建时间',
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_task`
--

LOCK TABLES `yii2_task` WRITE;
/*!40000 ALTER TABLE `yii2_task` DISABLE KEYS */;
INSERT INTO `yii2_task` VALUES (11,'df -h','*/60 * * * * *','1','2018-11-01 02:53:14','2018-12-04 09:23:24'),(12,'echo \'11111111\'','* * * * * *','2','2018-11-01 04:06:29','2018-11-23 03:36:48');
/*!40000 ALTER TABLE `yii2_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_user`
--

DROP TABLE IF EXISTS `yii2_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_user`
--

LOCK TABLES `yii2_user` WRITE;
/*!40000 ALTER TABLE `yii2_user` DISABLE KEYS */;
INSERT INTO `yii2_user` VALUES (1,'15918793994','root','https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3448484253,3685836170&fm=27&gp=0.jpg','iy-gXakj1PlEJKFrHDO-TG_ijCBlXg1a','$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K','1533356676@qq.com',1479371680,1543913718,'127.0.0.1',1543992696),(2,NULL,'admin','https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3448484253,3685836170&fm=27&gp=0.jpg','oTzzQgxVfMMqs1JdvPhiKeO8e3O5XpAZ','$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K','3095764452@qq.com',1479371663,1479371680,'127.0.0.1',1543913755),(39,NULL,'test',NULL,'9MYR7KpG3Mkc-ZFckWv_T-oIDiOQeqZL','$2y$13$CPOoVtkOvJYgMvimV/AkxOQ0M5tJOnIOJVpf/D4HOONb6Q/2ysZ1K',NULL,1530780629,1530780629,'120.85.87.197',1543286683);
/*!40000 ALTER TABLE `yii2_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yii2_user_copy`
--

DROP TABLE IF EXISTS `yii2_user_copy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yii2_user_copy`
--

LOCK TABLES `yii2_user_copy` WRITE;
/*!40000 ALTER TABLE `yii2_user_copy` DISABLE KEYS */;
INSERT INTO `yii2_user_copy` VALUES (1,'1','root','','1','6lgGBSosfvH0c9_nZZP8DY6YiI4ycwDx','$2y$13$Gmkbp4uYHbUivaxE7x3M0.LRzJUiDMKWCWUAKD763S/vbzJeIt8xe',NULL,'1533356676@qq.com',1479371680,1479371680,NULL,NULL,'self',NULL),(2,'2','admin',NULL,'2','pA7DChvN6X22MWjc6W_9TYALKiduyftD','$2y$13$gqyTZRup/.lisGkogBT5benIucbEZ4yweD11JKWjHASA4hl9a7oau',NULL,'3095764452@qq.com',1479371663,1479371680,NULL,NULL,'self',NULL),(9,'','little-bit-shy','https://avatars.githubusercontent.com/u/12792446?v=3','9',NULL,NULL,NULL,NULL,1484897023,1479371680,NULL,NULL,'github',12792446),(10,'15918793994',NULL,NULL,'y0gZlbBXGxOo4K--4_4jDNa_Byw2I-8V',NULL,'$2y$13$MpWF3HZWwe1CrcvpbwDLR.k2bRnr9VyvKCPYGaNjv8..S8Z.rkliS',NULL,NULL,1485158903,1485158903,'127.0.0.1',1485160819,'self',NULL),(12,'15918793991','fUrXC2rT',NULL,'6l4nL9fP7X7EXTw5ecedHjUhH9Kv12iv',NULL,'$2y$13$nLc17UBNeDhaRu5bFnJr8uAh2vyOt1/xYMmIVAuUNeLVmose7MkKm',NULL,NULL,1485160893,1485160893,NULL,NULL,'self',NULL),(13,'15918793992','mK0wLev6',NULL,'inORraxmoIqYOaaDL9qe6MqBZaf-C9Pl',NULL,'$2y$13$HghCFt1JWLsduv5bLQ13w.z/6W3Fzgz70qmgypNEFKlJH9P8b3xOy',NULL,NULL,1485161033,1485161033,NULL,NULL,'self',NULL),(14,'15918793993','BWko4Fiu',NULL,'0SqyoC7enijE3sDlTAVy1jmP8D9Krb2P',NULL,'$2y$13$fAbDXAo6MJ/uGCPeUcdExeQDQvZBYlCsfa23UUkS8lzv3/NufI2Lm',NULL,NULL,1485161050,1485161050,NULL,NULL,'self',NULL);
/*!40000 ALTER TABLE `yii2_user_copy` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-07  7:34:46

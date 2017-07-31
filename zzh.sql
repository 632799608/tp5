/*
Navicat MySQL Data Transfer

Source Server         : phpstudy
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : zzh

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-07-30 23:29:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for auth_permission
-- ----------------------------
DROP TABLE IF EXISTS `auth_permission`;
CREATE TABLE `auth_permission` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `is_menu` int(1) DEFAULT NULL COMMENT '是否是菜单 0：否 1：是',
  `icon` varchar(30) NOT NULL COMMENT '图标',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `path` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_permission
-- ----------------------------
INSERT INTO `auth_permission` VALUES ('1', '0', 'admin/index/index', '主页', '1', 'fa fa-android', '1', '1', '', '0', '1', '1', '0', '1501423982');
INSERT INTO `auth_permission` VALUES ('2', '0', 'admin/manage', '系统', '1', 'fa fa-cog', '1', '1', '', '0', '200', '1', '0', '1501423892');
INSERT INTO `auth_permission` VALUES ('3', '2', 'admin/role/index', '角色管理', '1', 'fa fa-user-secret', '1', '1', '', '0-2', '1', '1', '0', '1501424032');
INSERT INTO `auth_permission` VALUES ('4', '2', 'admin/permission/index', '权限列表', '1', 'fa fa-bars', '1', '1', '', '0-2', '2', '1', '0', '1501424048');
INSERT INTO `auth_permission` VALUES ('5', '4', 'admin/permission/create', '添加权限视图', '0', '', '1', '1', '', '0-2-4', '1', '0', '0', '1466686168');
INSERT INTO `auth_permission` VALUES ('6', '4', 'admin/permission/store', '添加权限操作', '0', '', '1', '1', '', '0-2-4', '1', '0', '0', '1466686168');
INSERT INTO `auth_permission` VALUES ('7', '4', 'admin/permission/edit', '编辑权限视图', '0', '', '1', '1', '', '0-2-4', '2', '0', '0', '1466686416');
INSERT INTO `auth_permission` VALUES ('8', '4', 'admin/permission/update', '编辑权限操作', '0', '', '1', '1', '', '0-2-4', '1', '0', '0', '1466686168');
INSERT INTO `auth_permission` VALUES ('9', '4', 'admin/permission/delete', '删除权限', '0', '', '1', '1', '', '0-2-4', '0', '0', '1466911172', '1466911172');
INSERT INTO `auth_permission` VALUES ('11', '0', 'admin/user/logout', '退出登录', '0', '', '1', '1', '', '0', '0', '0', '0', '0');
INSERT INTO `auth_permission` VALUES ('12', '3', 'admin/role/create', '添加角色视图', '0', '', '1', '1', '', '0-2-3', '0', '0', '0', '0');
INSERT INTO `auth_permission` VALUES ('13', '3', 'admin/role/edit', '编辑角色视图', '0', '', '1', '1', '', '0-2-3', '0', '0', '0', '0');
INSERT INTO `auth_permission` VALUES ('14', '3', 'admin/role/store', '添加角色操作', '0', '', '1', '1', '', '0-2-3', '0', '0', '0', '0');
INSERT INTO `auth_permission` VALUES ('15', '3', 'admin/role/update', '编辑角色操作', '0', '', '1', '1', '', '0-2-3', '0', '0', '0', '0');
INSERT INTO `auth_permission` VALUES ('16', '3', 'admin/role/delete', '删除角色', '0', '', '1', '1', '', '0-2-3', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for auth_role
-- ----------------------------
DROP TABLE IF EXISTS `auth_role`;
CREATE TABLE `auth_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  `description` text COMMENT '描述',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_role
-- ----------------------------
INSERT INTO `auth_role` VALUES ('1', '管理员', '1', '2,3,12,13,14,15,16,4,5,6,7,8,9,1', '管理员', '0', '1501422933');
INSERT INTO `auth_role` VALUES ('6', '初级管理员', '1', '6,1,2,13,3,4,', '初级管理员', '1466910557', '1474193271');
INSERT INTO `auth_role` VALUES ('7', 'test', '1', '2,3,12,13,14,15,16,4,5,6,7,8,9,', '', '1501412554', '0');
INSERT INTO `auth_role` VALUES ('12', '444', '1', '1,11,', '44', '1501418675', '0');

-- ----------------------------
-- Table structure for auth_user
-- ----------------------------
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL DEFAULT '' COMMENT '用户手机',
  `reg_ip` varchar(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户状态',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of auth_user
-- ----------------------------
INSERT INTO `auth_user` VALUES ('1', 'admin', 'MDAwMDAwMDAwMIS1f96yqLeX', '296720094@qq.com', '18053449656', '0', '1501424062', '127.0.0.1', '1', '0', '1501424062');
INSERT INTO `auth_user` VALUES ('3', 'test123', 'MDAwMDAwMDAwMIS1f96yqLeX', '', '', '127.0.0.1', '1474193287', '2130706433', '1', '1466910101', '1474193287');
INSERT INTO `auth_user` VALUES ('12', 'test', 'MDAwMDAwMDAwMIS1f96yqLeX', '', '', '127.0.0.1', '0', '0', '1', '1474193837', '1474193837');

-- ----------------------------
-- Table structure for auth_user_role
-- ----------------------------
DROP TABLE IF EXISTS `auth_user_role`;
CREATE TABLE `auth_user_role` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_user_role
-- ----------------------------
INSERT INTO `auth_user_role` VALUES ('1', '1');
INSERT INTO `auth_user_role` VALUES ('12', '6');

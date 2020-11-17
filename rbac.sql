/*
 Navicat Premium Data Transfer

 Source Server         : hwj
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : rbac

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 17/11/2020 15:29:33
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  INDEX `idx-auth_assignment-user_id`(`user_id`) USING BTREE,
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('二级管理员', '7', 1605493589);
INSERT INTO `auth_assignment` VALUES ('管理员', '6', 1605493429);

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('default/default/default', 2, '菜单管理', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/admin-menu', 2, '后台菜单', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/admin-menu-add', 2, '增加', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/admin-menu-del', 2, '删除', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/admin-menu-edit-status', 2, '状态', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/del-all', 2, '批量删除', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/edit-sort', 2, '修改排序', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/frontend-menu', 2, '前台菜单', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/frontend-menu-add', 2, '增加', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('menu/frontend-menu-del', 2, '删除', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('role/index', 2, 'RBAC', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('user/backend-index', 2, '管理员用户', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('user/frontend-index', 2, '前台用户', NULL, NULL, 1605493322, 1605493322);
INSERT INTO `auth_item` VALUES ('二级管理员', 1, '负责用户管理的管理员', NULL, NULL, 1605493343, 1605493343);
INSERT INTO `auth_item` VALUES ('管理员', 1, '超级管理员创建的管理员', NULL, NULL, 1605493322, 1605493322);

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('二级管理员', 'default/default/default');
INSERT INTO `auth_item_child` VALUES ('管理员', 'default/default/default');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/admin-menu');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/admin-menu-add');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/admin-menu-del');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/admin-menu-edit-status');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/del-all');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/edit-sort');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/frontend-menu');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/frontend-menu-add');
INSERT INTO `auth_item_child` VALUES ('管理员', 'menu/frontend-menu-del');
INSERT INTO `auth_item_child` VALUES ('管理员', 'role/index');
INSERT INTO `auth_item_child` VALUES ('二级管理员', 'user/backend-index');
INSERT INTO `auth_item_child` VALUES ('管理员', 'user/backend-index');
INSERT INTO `auth_item_child` VALUES ('二级管理员', 'user/frontend-index');
INSERT INTO `auth_item_child` VALUES ('管理员', 'user/frontend-index');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` blob NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for jurisdiction
-- ----------------------------
DROP TABLE IF EXISTS `jurisdiction`;
CREATE TABLE `jurisdiction`  (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `menu_id` int(11) NOT NULL COMMENT '菜单id'
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of jurisdiction
-- ----------------------------
INSERT INTO `jurisdiction` VALUES (0, 11);
INSERT INTO `jurisdiction` VALUES (0, 10);
INSERT INTO `jurisdiction` VALUES (0, 9);
INSERT INTO `jurisdiction` VALUES (0, 8);
INSERT INTO `jurisdiction` VALUES (0, 7);
INSERT INTO `jurisdiction` VALUES (0, 6);
INSERT INTO `jurisdiction` VALUES (0, 5);
INSERT INTO `jurisdiction` VALUES (0, 4);
INSERT INTO `jurisdiction` VALUES (0, 3);
INSERT INTO `jurisdiction` VALUES (0, 2);
INSERT INTO `jurisdiction` VALUES (0, 1);
INSERT INTO `jurisdiction` VALUES (1044, 22);
INSERT INTO `jurisdiction` VALUES (1044, 21);
INSERT INTO `jurisdiction` VALUES (1044, 20);
INSERT INTO `jurisdiction` VALUES (1044, 18);
INSERT INTO `jurisdiction` VALUES (1044, 19);
INSERT INTO `jurisdiction` VALUES (1044, 3);
INSERT INTO `jurisdiction` VALUES (1044, 23);
INSERT INTO `jurisdiction` VALUES (1044, 17);
INSERT INTO `jurisdiction` VALUES (0, 25);
INSERT INTO `jurisdiction` VALUES (0, 24);
INSERT INTO `jurisdiction` VALUES (0, 23);
INSERT INTO `jurisdiction` VALUES (0, 22);
INSERT INTO `jurisdiction` VALUES (0, 21);
INSERT INTO `jurisdiction` VALUES (0, 20);
INSERT INTO `jurisdiction` VALUES (0, 19);
INSERT INTO `jurisdiction` VALUES (0, 18);
INSERT INTO `jurisdiction` VALUES (0, 17);
INSERT INTO `jurisdiction` VALUES (1044, 7);
INSERT INTO `jurisdiction` VALUES (1044, 6);
INSERT INTO `jurisdiction` VALUES (1044, 5);
INSERT INTO `jurisdiction` VALUES (1044, 4);
INSERT INTO `jurisdiction` VALUES (1044, 2);
INSERT INTO `jurisdiction` VALUES (1044, 1);
INSERT INTO `jurisdiction` VALUES (1044, 24);
INSERT INTO `jurisdiction` VALUES (1044, 8);
INSERT INTO `jurisdiction` VALUES (1044, 9);
INSERT INTO `jurisdiction` VALUES (1044, 10);
INSERT INTO `jurisdiction` VALUES (1044, 11);
INSERT INTO `jurisdiction` VALUES (1045, 8);
INSERT INTO `jurisdiction` VALUES (1045, 9);
INSERT INTO `jurisdiction` VALUES (1045, 10);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路径',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `parent_id` int(11) NOT NULL COMMENT '父id',
  `tree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '结构树',
  `level` int(11) NOT NULL COMMENT '水平',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '图标',
  `sort` int(4) NOT NULL DEFAULT 0 COMMENT '排序',
  `flag` tinyint(4) NOT NULL DEFAULT 10 COMMENT '标识\r\n1  : 前台菜单\r\n10: 后台菜单',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态\r\n-1:删除\r\n0 :隐藏\r\n1 :显示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 'default/default/default', '菜单管理', 0, '|_ _ ', 1, '&#xe62a;', 999, 10, 1);
INSERT INTO `menu` VALUES (2, 'menu/admin-menu', '后台菜单', 1, '|_ _ _ _ ', 2, '', 999, 10, 1);
INSERT INTO `menu` VALUES (3, 'menu/frontend-menu', '前台菜单', 1, '|_ _ _ _ ', 2, '', 999, 10, 1);
INSERT INTO `menu` VALUES (4, 'menu/admin-menu-add', '增加', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (5, 'menu/admin-menu-add', '编辑', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (6, 'menu/admin-menu-del', '删除', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (7, 'menu/admin-menu-edit-status', '状态', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (8, 'default/default/default', '用户管理', 0, '|_ _ ', 1, '&#xe613;', 999, 10, 1);
INSERT INTO `menu` VALUES (9, 'user/frontend-index', '前台用户', 8, '|_ _ _ _ ', 2, '', 999, 10, 1);
INSERT INTO `menu` VALUES (10, 'user/backend-index', '管理员用户', 8, '|_ _ _ _ ', 2, '', 999, 10, 1);
INSERT INTO `menu` VALUES (11, 'role/index', 'RBAC', 0, '|_ _ ', 1, '&#xe628;', 999, 10, 1);
INSERT INTO `menu` VALUES (19, 'menu/frontend-menu-add', '增加', 3, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (17, 'menu/edit-sort', '修改排序', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (18, 'menu/edit-sort', '修改排序', 3, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (20, 'menu/frontend-menu-add', '编辑', 3, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (21, 'menu/frontend-menu-del', '删除', 3, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (22, 'menu/admin-menu-edit-status', '状态', 3, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (23, 'menu/del-all', '批量删除', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (24, 'menu/del-all', '批量删除', 3, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (25, '/index/index/index', '一级菜单', 0, '|_ _ ', 1, 'ddd', 999, 10, -1);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', 1603329526);
INSERT INTO `migration` VALUES ('m130524_201442_init', 1603329539);
INSERT INTO `migration` VALUES ('m190124_110200_add_verification_token_column_to_user_table', 1603329539);
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', 1605144910);
INSERT INTO `migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1605144910);
INSERT INTO `migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', 1605144910);
INSERT INTO `migration` VALUES ('m200409_110543_rbac_update_mssql_trigger', 1605144910);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色名称',
  `describe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `parent_id` int(11) NOT NULL DEFAULT 1 COMMENT '父id',
  `tree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '树形菜单',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态\r\n-1:删除\r\n0 :禁用\r\n1 :启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1046 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (0, '超级管理员', '超级管理员', 0, '', 1);
INSERT INTO `role` VALUES (1045, '二级管理员', '负责用户管理的管理员', 1044, '|_ _ _ _ ', 1);
INSERT INTO `role` VALUES (1044, '管理员', '超级管理员创建的管理员', 0, '|_ _ ', 1);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `identity` tinyint(4) NOT NULL COMMENT '1用户\r\n2管理员',
  `status` smallint(6) NOT NULL DEFAULT 10 COMMENT '删除0\r\n禁用9\r\n启用10',
  `head_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '头像',
  `role_id` int(11) NOT NULL DEFAULT 999 COMMENT '角色id',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '修改时间',
  `last_login_time` int(11) NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `verification_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', 'SyV0SIQBOFlu7rsmBufwmKhw1t0koAMQ', '$2y$13$q798pdrp4xXW1kEX./vcEemFCnksqed29OiEJI3lU9i/999cXAG9W', NULL, 'admin123@qq.com', 2, 10, NULL, 0, 1605492257, 1605577337, 1605577337, '127.0.0.1', 'IQ4-JiXX4cmdNUQW15nZ21t4XNZDlXHX_1605492257');
INSERT INTO `user` VALUES (6, 'admin123', '5vUNbDgRItHDUV-T82JjPcECR4JJVgpf', '$2y$13$lhaWVE1.fhYZCqljIDC70.3oNTf7HTrDBg5ZIw8YZpl8nu8KES/XC', NULL, 'admin@qq.com', 2, 10, '/uploads/2020/11/16/8c04e26e57dd7e25217676e0343c0aa5.jpg', 1044, 1605493429, 1605493452, 1605493452, '127.0.0.1', 'Zl_j7WzWH6j3LbNnZdpg4xA_yHBKhkQH_1605493429');
INSERT INTO `user` VALUES (7, 'admin111', 'aw1NIViqDQyRvvm2Bgt2f2RdiXnvtLaI', '$2y$13$9y6bu9gN4QuZcqdgYKxRiOYrJaMD.WTzIWmdfp473Sm7Vuc3zEFf2', NULL, 'admin111@qq.com', 2, 10, '/uploads/2020/11/16/e015ed7746d0c688252f152f2e3dc187.jpg', 1045, 1605493589, 1605493601, 1605493601, '127.0.0.1', 'lK5ciZmE8_NEJjyTyMy5rNE_0Dp3xRmR_1605493589');

SET FOREIGN_KEY_CHECKS = 1;

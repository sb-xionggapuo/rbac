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

 Date: 30/10/2020 17:55:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
INSERT INTO `jurisdiction` VALUES (12, 2);
INSERT INTO `jurisdiction` VALUES (12, 1);
INSERT INTO `jurisdiction` VALUES (1, 3);
INSERT INTO `jurisdiction` VALUES (1, 7);
INSERT INTO `jurisdiction` VALUES (1, 6);
INSERT INTO `jurisdiction` VALUES (1, 5);
INSERT INTO `jurisdiction` VALUES (1, 4);
INSERT INTO `jurisdiction` VALUES (1, 2);
INSERT INTO `jurisdiction` VALUES (1, 1);
INSERT INTO `jurisdiction` VALUES (12, 7);
INSERT INTO `jurisdiction` VALUES (12, 6);
INSERT INTO `jurisdiction` VALUES (12, 5);
INSERT INTO `jurisdiction` VALUES (12, 4);
INSERT INTO `jurisdiction` VALUES (12, 3);

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
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, '/default/default/default', '菜单管理', 0, '|_ _ ', 1, '', 999, 10, 1);
INSERT INTO `menu` VALUES (2, 'menu/admin-menu', '后台菜单', 1, '|_ _ _ _ ', 2, '', 999, 10, 1);
INSERT INTO `menu` VALUES (3, 'menu/frontend-menu', '前台菜单', 1, '|_ _ _ _ ', 2, '', 999, 10, 1);
INSERT INTO `menu` VALUES (4, 'menu/admin-menu-add', '增加', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (5, 'menu/admin-menu-add', '编辑', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (6, 'menu/admin-menu-del', '删除', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);
INSERT INTO `menu` VALUES (7, 'menu/admin-menu-edit-status', '状态', 2, '|_ _ _ _ _ _ ', 3, '', 999, 10, 1);

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
) ENGINE = MyISAM AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1, '测试角色', '管理员', 0, '|_ _ ', 1);
INSERT INTO `role` VALUES (2, '子角色', '管理员分配的角色', 1, '|_ _ _ _ ', 1);
INSERT INTO `role` VALUES (0, '超级管理员', '超级管理员', 0, '', 1);
INSERT INTO `role` VALUES (3, '子角色2', '子角色2', 1, '|_ _ _ _ ', 1);
INSERT INTO `role` VALUES (4, '孙子角色', '孙子角色', 2, '|_ _ _ _ _ _ ', 1);

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
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '修改时间',
  `last_login_time` int(11) NOT NULL DEFAULT 0 COMMENT '最后登录时间',
  `last_login_ip` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `verification_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `password_reset_token`(`password_reset_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'admin', '', '$2y$13$QrcLrQ8jYssJQJlsIHgFyO6JMeHUjW43jvTSMuQLqJE8v.8e0X1jK', NULL, 'admin@qq.com', 2, 10, 1603331046, 1604020183, 1604020183, '127.0.0.1', NULL);
INSERT INTO `user` VALUES (2, 'test1', 'UOfM9tOF6-dvgdvU9tVphW6unA-Xw9pn', '$2y$13$bIHKtCrM6HkNuTVmdzPSUO4fJl.FGN3JSBq3SZVT3odgYdtAbnN1.', NULL, 'test1@qq.com', 1, 10, 1603331294, 1603703727, 1603703727, '127.0.0.1', 'Nzrbk6E71ICTcLRe82B-c6zrfo-MwZYv_1603331294');
INSERT INTO `user` VALUES (3, 'test2', 'BvfqDumkqTJmLTqNx34l_YQzP_CG1wxe', '$2y$13$K83dCCiOmZobT2v1VJ8i5eUsguVAvtb4Tg7nSG9FBA3qUVZZN3nSO', NULL, 'test2@qq.com', 1, 10, 1603333570, 1603336716, 1603336716, '127.0.0.1', 'EkWPVBsOHHGior0k_jws560X5TSky8Uy_1603333570');
INSERT INTO `user` VALUES (4, 'test3', 'Z8eVInPwTu5tLGSUsHM7F9s3DFEvVWlC', '$2y$13$HcpPlozrebTIKrBo0zS8EuVKI2anUbgO7KXLmxSrXYLV.esUIp4dO', NULL, 'test3@qq.com', 1, 10, 1603337009, 1603337074, 1603337074, '127.0.0.1', 'kYPvMIDRe99kt6Z30D52g6J9iL--2EQi_1603337009');

SET FOREIGN_KEY_CHECKS = 1;

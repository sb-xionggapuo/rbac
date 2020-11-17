-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE `auth_assignment`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE `auth_item`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE `auth_item_child`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`) USING BTREE,
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE `auth_rule`
-- -------------------------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE `jurisdiction`
-- -------------------------------------------
DROP TABLE IF EXISTS `jurisdiction`;
CREATE TABLE IF NOT EXISTS `jurisdiction` (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `menu_id` int(11) NOT NULL COMMENT '菜单id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

-- -------------------------------------------
-- TABLE `menu`
-- -------------------------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '路径',
  `title` varchar(255) NOT NULL COMMENT '名称',
  `parent_id` int(11) NOT NULL COMMENT '父id',
  `tree` varchar(255) NOT NULL COMMENT '结构树',
  `level` int(11) NOT NULL COMMENT '水平',
  `icon` varchar(255) DEFAULT '' COMMENT '图标',
  `sort` int(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `flag` tinyint(4) NOT NULL DEFAULT '10' COMMENT '标识\r\n1  : 前台菜单\r\n10: 后台菜单',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态\r\n-1:删除\r\n0 :隐藏\r\n1 :显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------
-- TABLE `migration`
-- -------------------------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------
-- TABLE `role`
-- -------------------------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '角色名称',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '角色描述',
  `parent_id` int(11) NOT NULL DEFAULT '1' COMMENT '父id',
  `tree` varchar(255) NOT NULL DEFAULT '' COMMENT '树形菜单',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态\r\n-1:删除\r\n0 :禁用\r\n1 :启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------
-- TABLE `user`
-- -------------------------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identity` tinyint(4) NOT NULL COMMENT '1用户\r\n2管理员',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '删除0\r\n禁用9\r\n启用10',
  `head_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '头像',
  `role_id` int(11) NOT NULL DEFAULT '999' COMMENT '角色id',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '修改时间',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE DATA auth_assignment
-- -------------------------------------------
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('二级管理员','5','1605252014');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('管理员','4','1605248235');;;
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES
('管理员','6','1605492027');;;
-- -------------------------------------------
-- TABLE DATA auth_item
-- -------------------------------------------
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('default/default/default','2','菜单管理','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('index/inde2','2','菜单2','','','1605248730','1605248730');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('index/index3','2','菜单','','','1605248730','1605248730');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('menu/admin-menu','2','后台菜单','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('menu/admin-menu-add','2','增加','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('menu/admin-menu-del','2','删除','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('menu/admin-menu-edit-status','2','状态','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('menu/frontend-menu','2','前台菜单','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('role/index','2','RBAC','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('user/backend-index','2','管理员用户','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('user/frontend-index','2','前台用户','','','1605248152','1605248152');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('二级管理员','1','二级管理员描述','','','1605251689','1605251689');;;
INSERT INTO `auth_item` (`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) VALUES
('管理员','1','超级管理员添加的管理员','','','1605248152','1605248152');;;
-- -------------------------------------------
-- TABLE DATA auth_item_child
-- -------------------------------------------
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('二级管理员','default/default/default');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','default/default/default');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('二级管理员','menu/admin-menu');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','menu/admin-menu');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('二级管理员','menu/admin-menu-add');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','menu/admin-menu-add');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','menu/admin-menu-del');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('二级管理员','menu/admin-menu-edit-status');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','menu/admin-menu-edit-status');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('二级管理员','menu/frontend-menu');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','menu/frontend-menu');;;
INSERT INTO `auth_item_child` (`parent`,`child`) VALUES
('管理员','role/index');;;
-- -------------------------------------------
-- TABLE DATA auth_rule
-- -------------------------------------------
-- -------------------------------------------
-- TABLE DATA jurisdiction
-- -------------------------------------------
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','11');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','10');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','9');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','8');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','7');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','6');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','5');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','4');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','3');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','2');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','1');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1043','3');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1043','7');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1043','5');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','11');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','3');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','7');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','6');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','5');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','25');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','24');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','23');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','22');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','21');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','20');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','19');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','18');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('0','17');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1043','4');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1043','2');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1043','1');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','4');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','2');;;
INSERT INTO `jurisdiction` (`role_id`,`menu_id`) VALUES
('1042','1');;;
-- -------------------------------------------
-- TABLE DATA menu
-- -------------------------------------------
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('1','default/default/default','菜单管理','0','|_ _ ','1','&#xe62a;','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('2','menu/admin-menu','后台菜单','1','|_ _ _ _ ','2','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('3','menu/frontend-menu','前台菜单','1','|_ _ _ _ ','2','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('4','menu/admin-menu-add','增加','2','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('5','menu/admin-menu-add','编辑','2','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('6','menu/admin-menu-del','删除','2','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('7','menu/admin-menu-edit-status','状态','2','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('8','default/default/default','用户管理','0','|_ _ ','1','&#xe613;','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('9','user/frontend-index','前台用户','8','|_ _ _ _ ','2','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('10','user/backend-index','管理员用户','8','|_ _ _ _ ','2','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('11','role/index','RBAC','0','|_ _ ','1','&#xe628;','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('19','menu/frontend-menu-add','增加','3','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('17','menu/edit-sort','修改排序','2','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('18','menu/edit-sort','修改排序','3','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('20','menu/frontend-menu-add','编辑','3','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('21','menu/frontend-menu-del','删除','3','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('22','menu/admin-menu-edit-status','状态','3','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('23','menu/del-all','批量删除','2','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('24','menu/del-all','批量删除','3','|_ _ _ _ _ _ ','3','','999','10','1');;;
INSERT INTO `menu` (`id`,`name`,`title`,`parent_id`,`tree`,`level`,`icon`,`sort`,`flag`,`status`) VALUES
('25','/index/index/index','一级菜单','0','|_ _ ','1','ddd','999','10','-1');;;
-- -------------------------------------------
-- TABLE DATA migration
-- -------------------------------------------
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m000000_000000_base','1603329526');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m130524_201442_init','1603329539');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m190124_110200_add_verification_token_column_to_user_table','1603329539');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m140506_102106_rbac_init','1605144910');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m170907_052038_rbac_add_index_on_auth_assignment_user_id','1605144910');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m180523_151638_rbac_updates_indexes_without_prefix','1605144910');;;
INSERT INTO `migration` (`version`,`apply_time`) VALUES
('m200409_110543_rbac_update_mssql_trigger','1605144910');;;
-- -------------------------------------------
-- TABLE DATA role
-- -------------------------------------------
INSERT INTO `role` (`id`,`name`,`describe`,`parent_id`,`tree`,`status`) VALUES
('0','超级管理员','超级管理员','0','','1');;;
INSERT INTO `role` (`id`,`name`,`describe`,`parent_id`,`tree`,`status`) VALUES
('1043','二级管理员','二级管理员描述','1042','|_ _ _ _ ','1');;;
INSERT INTO `role` (`id`,`name`,`describe`,`parent_id`,`tree`,`status`) VALUES
('1042','管理员','超级管理员添加的管理员','0','|_ _ ','1');;;
-- -------------------------------------------
-- TABLE DATA user
-- -------------------------------------------
INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`identity`,`status`,`head_image`,`role_id`,`created_at`,`updated_at`,`last_login_time`,`last_login_ip`,`verification_token`) VALUES
('1','admin','8vK-W9liJ_FJOjnAUiUg7vXP_rQ4UPGx','$2y$13$T4QuL/qmJKBxSYGN74fNBeoW1P3EQda24odiYVH.KXg59rmoHX2h6','','admin@qq.com','2','10','/uploads/2020/11/09/9b93d6c2de0f638bf69039795262d38b.jpg','0','1603331046','1605255508','1605255508','127.0.0.1','8KvkonSQYjixEFgHjG2b-G7M6M7bngwc_1604975739');;;
INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`identity`,`status`,`head_image`,`role_id`,`created_at`,`updated_at`,`last_login_time`,`last_login_ip`,`verification_token`) VALUES
('4','backendUser','P5vJAa3sgGFmRbC9HIvsWqcsbu-hSsm3','$2y$13$dO7G8d.qbZrtrXF89xzEUupfUoH7BCbU6nutQwCidRRwiEqi8QJxG','','backendUser@qq.com','2','10','/uploads/2020/11/13/15aa3e3b2cb942ac8164ab28bf56bcfc.jpg','1042','1605248235','1605254350','1605254350','127.0.0.1','TzM6ECFO9rvAc2k4yAO-VW2rJPiEePmg_1605248235');;;
INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`identity`,`status`,`head_image`,`role_id`,`created_at`,`updated_at`,`last_login_time`,`last_login_ip`,`verification_token`) VALUES
('5','admin123','yzEU28-uzS7QyZRalrzf_TNyXmfwefqe','$2y$13$rC4n/ZuUeW3nQW.ZvAeQB.QUAOmpr2aRz0CCXjAQfOfkUYr3EPIbi','','admin123@qq.com','2','10','/uploads/2020/11/13/6d1a10424d78ad9c3c91be833f4d7e81.jpg','1043','1605252014','1605252027','1605252027','127.0.0.1','vPXbEOh0wiLokfZLTlAlXHxXT_7DCMap_1605252014');;;
INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`identity`,`status`,`head_image`,`role_id`,`created_at`,`updated_at`,`last_login_time`,`last_login_ip`,`verification_token`) VALUES
('6','test','IZs91tjuRb15fOKHxVw-XyACxsUVre_s','$2y$13$y54VRJ6YWb8TDdw0KSs6j.73r8jTYWaUFQV3ZUXxXoStNkHV2dXvW','','test@qq.com','1','10','/uploads/2020/11/16/bfc416edff99965607d07262dc69d552.jpg','1042','1605492027','1605492039','1605492039','127.0.0.1','_VwLCABAVXpwS8kA0EHe9isztRR94vJg_1605492027');;;
-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- -------------------------------------------
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------

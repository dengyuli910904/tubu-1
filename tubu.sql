/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : tubu

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-08-15 17:00:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for activities
-- ----------------------------
DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groups_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `cost_intro` text COLLATE utf8mb4_unicode_ci,
  `is_able` int(11) DEFAULT '1',
  `starttime` timestamp NULL DEFAULT NULL,
  `endtime` timestamp NULL DEFAULT NULL,
  `enrol_starttime` timestamp NULL DEFAULT NULL,
  `enrol_endtime` timestamp NULL DEFAULT NULL,
  `contacts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacts_tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` double DEFAULT '0',
  `limit_count` int(11) DEFAULT '100',
  `participation_count` int(11) DEFAULT '0',
  `apply_count` int(11) DEFAULT '0',
  `follow_count` int(11) DEFAULT '0',
  `collect_count` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT '1',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of activities
-- ----------------------------
INSERT INTO `activities` VALUES ('c7e2ced0-7d9a-11e7-bbd4-4351598c7618', null, '1', null, '深圳凤凰山一日游', null, null, '1', '2017-08-20 00:00:00', '2017-08-21 00:00:00', null, null, null, null, '0', '100', '0', '0', '0', '0', '1', null, '1', null, '2017-08-10 07:08:59', '2017-08-10 07:45:54');
INSERT INTO `activities` VALUES ('cfa4cfe0-7d9a-11e7-85fa-47ebdf7d0e65', '61f39240-7d78-11e7-9fda-f9be5fa096d7', '1', 'http://lstubu-img-app.oss-cn-shenzhen.aliyuncs.com/7bfe48af25883518a97416af608908ede5302c49f6ef-1DZ9tm_fw658.jpg', null, null, null, '1', null, null, null, null, null, null, '0', '100', '0', '0', '0', '0', '0', '活动，徒步', '1', null, '2017-08-10 07:09:12', '2017-08-10 07:09:12');

-- ----------------------------
-- Table structure for activities_follow
-- ----------------------------
DROP TABLE IF EXISTS `activities_follow`;
CREATE TABLE `activities_follow` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activities_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of activities_follow
-- ----------------------------

-- ----------------------------
-- Table structure for activitymembers
-- ----------------------------
DROP TABLE IF EXISTS `activitymembers`;
CREATE TABLE `activitymembers` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activities_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0' COMMENT '0 普通成员 1 副领队',
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_pay` int(11) NOT NULL DEFAULT '0' COMMENT '1 已支付',
  `pay_path` int(11) NOT NULL COMMENT '1正常支付，2管理员操作，3其他',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of activitymembers
-- ----------------------------

-- ----------------------------
-- Table structure for evaluations
-- ----------------------------
DROP TABLE IF EXISTS `evaluations`;
CREATE TABLE `evaluations` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activities_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `starlevel` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of evaluations
-- ----------------------------
INSERT INTO `evaluations` VALUES ('f4898950-7da5-11e7-ad92-09b20f28eb2f', 'c7e2ced0-7d9a-11e7-bbd4-4351598c7618', '1', '活动很好，内容丰富，玩得很尽兴', '3', '1', '2017-08-10 08:28:58', '2017-08-10 08:28:58');

-- ----------------------------
-- Table structure for groupmember
-- ----------------------------
DROP TABLE IF EXISTS `groupmember`;
CREATE TABLE `groupmember` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `groups_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of groupmember
-- ----------------------------
INSERT INTO `groupmember` VALUES ('481b5a40-7d95-11e7-9bbd-ddc74e3e9ba3', '0', '61f39240-7d78-11e7-9fda-f9be5fa096d7', '1', '1', '2017-08-10 06:29:37', '2017-08-10 06:33:48');

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_count` int(11) NOT NULL DEFAULT '0',
  `activities_count` int(11) NOT NULL DEFAULT '0',
  `focus_count` int(11) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT '10',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('61f39240-7d78-11e7-9fda-f9be5fa096d7', '深圳立松信息', '深圳市立松信息技术有限公司', 'http://lstubu-img-app.oss-cn-shenzhen.aliyuncs.com/7bfe48af25883518a97416af608908ede5302c49f6ef-1DZ9tm_fw658.jpg', '0', '0', '0', '深圳市宝安区怡园路5177号喜万年商务大厦305', null, '10', '1', '2017-08-10 03:02:45', '2017-08-10 03:25:36');

-- ----------------------------
-- Table structure for groups_apply
-- ----------------------------
DROP TABLE IF EXISTS `groups_apply`;
CREATE TABLE `groups_apply` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groups_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 未审核 ，1 通过 2不通过',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` int(4) DEFAULT '0' COMMENT '0 用户申请加入 1圈主邀请加入'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of groups_apply
-- ----------------------------
INSERT INTO `groups_apply` VALUES ('e9e22da0-7d93-11e7-ab5f-dfe01dd806af', '61f39240-7d78-11e7-9fda-f9be5fa096d7', '1', '1', '2017-08-10 06:19:49', '2017-08-10 06:29:37', '0');
INSERT INTO `groups_apply` VALUES ('eb610ae0-7d93-11e7-970f-8ded5b75e539', '61f39240-7d78-11e7-9fda-f9be5fa096d7', '1', '0', '2017-08-10 06:19:52', '2017-08-10 06:19:52', '0');
INSERT INTO `groups_apply` VALUES ('ec1c21c0-7d93-11e7-a462-a3ca49269d2f', '61f39240-7d78-11e7-9fda-f9be5fa096d7', '1', '0', '2017-08-10 06:19:53', '2017-08-10 06:19:53', '0');
INSERT INTO `groups_apply` VALUES ('5f1207e0-7d94-11e7-aca9-dbed5ee765c6', '61f39240-7d78-11e7-9fda-f9be5fa096d7', '2', '0', '2017-08-10 06:23:06', '2017-08-10 06:23:06', '1');

-- ----------------------------
-- Table structure for groups_follow
-- ----------------------------
DROP TABLE IF EXISTS `groups_follow`;
CREATE TABLE `groups_follow` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groups_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of groups_follow
-- ----------------------------

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '0',
  `activites_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `replay_users_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES ('127c2000-7da3-11e7-8016-2f17c0f4721b', '1', '我的留言内容', '0', 'c7e2ced0-7d9a-11e7-bbd4-4351598c7618', '2017-08-10 08:08:20', '2017-08-10 08:08:20', '', '');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2017_07_11_034834_create_news_table', '2');
INSERT INTO `migrations` VALUES ('4', '2017_07_11_035050_create_groupmember_table', '3');
INSERT INTO `migrations` VALUES ('6', '2017_07_11_034929_create_groups_table', '4');
INSERT INTO `migrations` VALUES ('7', '2017_07_11_035112_create_activities_table', '5');
INSERT INTO `migrations` VALUES ('8', '2017_07_11_035125_create_messages_table', '6');
INSERT INTO `migrations` VALUES ('9', '2017_07_11_035147_create_replaies_table', '7');
INSERT INTO `migrations` VALUES ('10', '2017_07_11_035237_create_activitymembers_table', '7');
INSERT INTO `migrations` VALUES ('11', '2017_07_11_035303_create_evaluations_table', '7');
INSERT INTO `migrations` VALUES ('12', '2017_07_11_035323_create_verifycode_table', '7');
INSERT INTO `migrations` VALUES ('13', '2017_07_11_035338_create_orders_table', '7');
INSERT INTO `migrations` VALUES ('14', '2017_07_19_132655_create_groups_follow_table', '7');
INSERT INTO `migrations` VALUES ('15', '2017_07_19_134036_create_activities_follow_table', '7');
INSERT INTO `migrations` VALUES ('16', '2017_07_19_134509_create_groups_apply_table', '7');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groups_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activities_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activities_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordernum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_valid` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for replaies
-- ----------------------------
DROP TABLE IF EXISTS `replaies`;
CREATE TABLE `replaies` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `messages_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of replaies
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headimg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pwd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '1',
  `telphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wx_openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sina_openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qq_openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `solt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('123456', 'lily', null, '1', '2017-08-07 16:36:04', null, '1', '13528483551', null, null, null, null, '1234', null, null);

-- ----------------------------
-- Table structure for verifycode
-- ----------------------------
DROP TABLE IF EXISTS `verifycode`;
CREATE TABLE `verifycode` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_valid` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of verifycode
-- ----------------------------

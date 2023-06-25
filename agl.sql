/*
Navicat MySQL Data Transfer

Source Server         : Tao
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : agl

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-06-25 17:14:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for keywords
-- ----------------------------
DROP TABLE IF EXISTS `keywords`;
CREATE TABLE `keywords` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `google_rank` int(11) NOT NULL,
  `google_searches` double NOT NULL,
  `yahoo_rank` int(11) DEFAULT NULL,
  `yahoo_searches` double DEFAULT NULL,
  `website_id` bigint(20) unsigned DEFAULT NULL,
  `is_active` mediumint(9) NOT NULL,
  `is_publish` mediumint(9) NOT NULL,
  `create_by` varchar(20) DEFAULT NULL,
  `update_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keywords_website_id_foreign` (`website_id`),
  CONSTRAINT `keywords_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of keywords
-- ----------------------------
INSERT INTO `keywords` VALUES ('3', 'thiết kế website', 'thiet-ke-website', '16', '72790', '21', '59844', '1', '1', '1', '', '', null, null);
INSERT INTO `keywords` VALUES ('4', 'lập trình website', 'lap-trinh-website', '50', '25705', '33', '5810', '1', '1', '1', '', '', null, null);
INSERT INTO `keywords` VALUES ('7', 'thiết kế website chuyên nghiệp', 'thiet-ke-website-chuyen-nghiep-1687671413', '15', '8727', '46', '32080', '3', '1', '1', null, null, '2023-06-25 05:36:53', '2023-06-25 05:36:53');
INSERT INTO `keywords` VALUES ('12', 'thiết kế logo', 'thiet-ke-logo-1687675658', '32', '78127', '12', '15604', '1', '1', '1', null, null, '2023-06-25 06:47:38', '2023-06-25 06:47:38');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('2', '2023_06_22_021847_create_websites_table', '1');
INSERT INTO `migrations` VALUES ('3', '2023_06_22_030930_create_search_tools_table', '1');
INSERT INTO `migrations` VALUES ('4', '2023_06_22_030931_create_keywords_table', '1');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for search_tools
-- ----------------------------
DROP TABLE IF EXISTS `search_tools`;
CREATE TABLE `search_tools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `is_active` mediumint(9) NOT NULL,
  `is_publish` mediumint(9) NOT NULL,
  `create_by` varchar(100) DEFAULT '',
  `update_by` varchar(100) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of search_tools
-- ----------------------------
INSERT INTO `search_tools` VALUES ('1', 'Google', 'google', '1', '1', '', '', null, null);
INSERT INTO `search_tools` VALUES ('2', 'Yahoo', 'yahoo', '1', '1', '', '', null, null);

-- ----------------------------
-- Table structure for websites
-- ----------------------------
DROP TABLE IF EXISTS `websites`;
CREATE TABLE `websites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `is_active` mediumint(9) NOT NULL,
  `is_publish` mediumint(9) NOT NULL,
  `create_by` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `update_by` varchar(100) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of websites
-- ----------------------------
INSERT INTO `websites` VALUES ('1', 'Creative Brand', 'creand', 'https://creand.net', '1', '1', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `websites` VALUES ('2', 'https://creand.xyz', 'httpscreandxyz', 'https://creand.xyz', '1', '1', null, null, '2023-06-25 04:08:16', '2023-06-25 04:08:16');
INSERT INTO `websites` VALUES ('3', 'https://rundemo.xyz', 'httpsrundemoxyz', 'https://rundemo.xyz', '1', '1', null, null, '2023-06-25 04:09:39', '2023-06-25 04:09:39');
INSERT INTO `websites` VALUES ('4', 'https://https://stackoverflow.com/questions/36034493/typeerror-e-preventdefault-is-not-a-function', 'httpshttpsstackoverflowcomquestions36034493typeerror-e-preventdefault-is-not-a-function', 'https://https://stackoverflow.com/questions/36034493/typeerror-e-preventdefault-is-not-a-function', '1', '1', '', '', '2023-06-25 09:57:24', '2023-06-25 09:57:24');

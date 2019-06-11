/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : hos

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-24 13:12:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pk_log_sys
-- ----------------------------
DROP TABLE IF EXISTS `pklog_sys`;
CREATE TABLE `pklog_sys` (
  `pklog_id` varchar(255) NOT NULL,
  `pklog_user` varchar(255) DEFAULT NULL,
  `pklog_begin` datetime DEFAULT NULL,
  `pklog_timeout` datetime DEFAULT NULL,
  `pklog_computer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pklog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=tis620;

-- ----------------------------
-- Records of pk_log_sys
-- ----------------------------

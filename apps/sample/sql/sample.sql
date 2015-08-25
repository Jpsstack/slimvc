/*
MySQL Database

Server Type    : MYSQL
Server Version : 50541
File Encoding  : 65001

Date: 2015-05-11 11:54:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `programmers`
-- ----------------------------
DROP TABLE IF EXISTS `programmers`;
CREATE TABLE `programmers` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'primary id',
  `name` varchar(50) NOT NULL COMMENT 'programmer',
  `description` varchar(100) NOT NULL DEFAULT '' COMMENT 'description',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of programmers
-- ----------------------------
INSERT INTO `programmers` VALUES ('0000000001', 'Richard Stallman', 'Free software movement, GNU, Emacs, GCC', '1431262812', '1431262812');
INSERT INTO `programmers` VALUES ('0000000002', 'Dennis Ritchie', 'C (programming language)', '1431262812', '1431262812');
INSERT INTO `programmers` VALUES ('0000000003', 'Ken Thompson', 'Unix operating system, Go', '1431262812', '1431262812');
INSERT INTO `programmers` VALUES ('0000000004', 'Linus Torvalds', 'Linux kernel, git', '1431262812', '1431262812');
INSERT INTO `programmers` VALUES ('0000000005', 'Guido van Rossum', 'Python', '1431262812', '1431262812');

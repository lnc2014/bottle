/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.6.17 : Database - bottle
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bottle` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `bottle`;

/*Table structure for table `bot_account_log` */

DROP TABLE IF EXISTS `bot_account_log`;

CREATE TABLE `bot_account_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL COMMENT '领取的金额',
  `get_time` timestamp NULL DEFAULT NULL COMMENT '领取时间',
  `type` tinyint(4) DEFAULT '1' COMMENT '1为领取记录，2为提现记录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `bot_account_log` */

insert  into `bot_account_log`(`id`,`user_id`,`price`,`get_time`,`type`) values (1,1,'256.00','2016-11-01 20:22:59',1),(2,1,'256.00','2016-11-01 20:22:59',1),(3,1,'256.00','2016-11-01 20:22:59',1),(4,1,'256.00','2016-11-01 20:22:59',1),(5,1,'256.00','2016-11-01 20:22:59',1);

/*Table structure for table `bot_admin` */

DROP TABLE IF EXISTS `bot_admin`;

CREATE TABLE `bot_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL DEFAULT '',
  `psw` varchar(250) NOT NULL DEFAULT '',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `flag` tinyint(4) DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `bot_admin` */

insert  into `bot_admin`(`id`,`user_name`,`psw`,`create_time`,`update_time`,`flag`) values (1,'admin','21232f297a57a5a743894a0e4a801fc3',NULL,NULL,1);

/*Table structure for table `bot_system` */

DROP TABLE IF EXISTS `bot_system`;

CREATE TABLE `bot_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intervals` int(12) NOT NULL DEFAULT '0' COMMENT '间隔时间，存入数据库采用秒',
  `money_max` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '领取的最大金额',
  `money_min` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '领取的最小金额',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1为有效，0为无效',
  `reg_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '注册的金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `bot_system` */

insert  into `bot_system`(`id`,`intervals`,`money_max`,`money_min`,`create_time`,`update_time`,`flag`,`reg_price`) values (1,3360,'45.00','1.00','2016-11-01 19:44:28','2016-11-01 19:44:31',1,'34.00');

/*Table structure for table `bot_user` */

DROP TABLE IF EXISTS `bot_user`;

CREATE TABLE `bot_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL DEFAULT '',
  `head_img` varchar(500) NOT NULL DEFAULT '',
  `open_id` varchar(250) NOT NULL DEFAULT '',
  `parent_id` int(11) DEFAULT '0' COMMENT '下线的user_id',
  `cash_back` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返现金额',
  `withdraw_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '提现的总金额',
  `reg_money` decimal(10,2) NOT NULL COMMENT '注册的金额',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `flag` tinyint(4) DEFAULT '1' COMMENT '是不是有效,1已经激活，2未激活',
  `order_no` varchar(250) NOT NULL DEFAULT '' COMMENT '第一次注册的时候支付的订单编号',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `bot_user` */

insert  into `bot_user`(`user_id`,`user_name`,`head_img`,`open_id`,`parent_id`,`cash_back`,`withdraw_total`,`reg_money`,`create_time`,`update_time`,`flag`,`order_no`) values (1,'李农成','','ohoNsuGpFYcqe6AWeJ9plmVAir5A',0,'25.00','25.00','25.00','2016-11-01 20:10:59',NULL,1,'sadjkajdk'),(2,'李农成','','wdwecddfdf',0,'25.00','25.00','25.00','2016-11-01 20:10:59',NULL,1,''),(3,'李农成','','wdwecddfdf',0,'25.00','25.00','25.00','2016-11-01 20:10:59',NULL,1,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

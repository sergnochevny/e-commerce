-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.34-log - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица iluvfabrix.blog_groups
DROP TABLE IF EXISTS `blog_groups`;
CREATE TABLE IF NOT EXISTS `blog_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.blog_group_posts
DROP TABLE IF EXISTS `blog_group_posts`;
CREATE TABLE IF NOT EXISTS `blog_group_posts` (
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `group_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`,`group_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.blog_posts
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL,
  `post_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'publish',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type_status_date` (`post_status`,`post_date`,`id`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=413 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.blog_post_img
DROP TABLE IF EXISTS `blog_post_img`;
CREATE TABLE IF NOT EXISTS `blog_post_img` (
  `post_id` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  KEY `blog_post_img_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.blog_post_keys_descriptions
DROP TABLE IF EXISTS `blog_post_keys_descriptions`;
CREATE TABLE IF NOT EXISTS `blog_post_keys_descriptions` (
  `post_id` int(11) NOT NULL,
  `keywords` text NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `blog_post_keys_descriptions_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_accounts
DROP TABLE IF EXISTS `fabrix_accounts`;
CREATE TABLE IF NOT EXISTS `fabrix_accounts` (
  `aid` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_organization` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_address1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_address2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_province` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_city` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_country` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_postal` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_lastname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_organization` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_address1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_address2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_city` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_province` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_country` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_postal` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_fax` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ship_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `get_newsletter` tinyint(1) unsigned DEFAULT '1',
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_counter` tinyint(11) unsigned DEFAULT '0',
  `remember` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remind` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remind_time` datetime DEFAULT NULL,
  PRIMARY KEY (`aid`),
  KEY `accounts_email` (`email`),
  KEY `accounts_remember` (`remember`),
  KEY `accounts_remind` (`remind`)
) ENGINE=InnoDB AUTO_INCREMENT=19113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_admins
DROP TABLE IF EXISTS `fabrix_admins`;
CREATE TABLE IF NOT EXISTS `fabrix_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rememberme` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_login` (`login`),
  KEY `admins_rememberme` (`rememberme`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_categories
DROP TABLE IF EXISTS `fabrix_categories`;
CREATE TABLE IF NOT EXISTS `fabrix_categories` (
  `cid` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayorder` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `cname` (`cname`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_clearance
DROP TABLE IF EXISTS `fabrix_clearance`;
CREATE TABLE IF NOT EXISTS `fabrix_clearance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_color
DROP TABLE IF EXISTS `fabrix_color`;
CREATE TABLE IF NOT EXISTS `fabrix_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `color` (`color`)
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_comments
DROP TABLE IF EXISTS `fabrix_comments`;
CREATE TABLE IF NOT EXISTS `fabrix_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `data` text,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(11) DEFAULT NULL,
  `moderated` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_countries
DROP TABLE IF EXISTS `fabrix_countries`;
CREATE TABLE IF NOT EXISTS `fabrix_countries` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_manufacturers
DROP TABLE IF EXISTS `fabrix_manufacturers`;
CREATE TABLE IF NOT EXISTS `fabrix_manufacturers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manufacturer` (`manufacturer`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_orders
DROP TABLE IF EXISTS `fabrix_orders`;
CREATE TABLE IF NOT EXISTS `fabrix_orders` (
  `oid` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) unsigned DEFAULT NULL,
  `trid` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `items` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type` tinyint(3) unsigned DEFAULT NULL,
  `shipping_cost` decimal(10,2) DEFAULT NULL,
  `on_roll` tinyint(1) unsigned DEFAULT NULL,
  `roll_cost` decimal(10,2) DEFAULT NULL,
  `express_samples` tinyint(1) unsigned DEFAULT '0',
  `on_handling` tinyint(1) unsigned DEFAULT '0',
  `handling` decimal(10,2) DEFAULT NULL,
  `shipping_discount` decimal(10,2) DEFAULT NULL,
  `coupon_discount` decimal(10,2) DEFAULT NULL,
  `total_discount` decimal(10,2) DEFAULT NULL,
  `taxes` float DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `samples_express_cost` decimal(10,2) DEFAULT '0.00',
  `samples_single_cost` decimal(10,2) DEFAULT '0.00',
  `samples_multiple_cost` decimal(10,2) DEFAULT '0.00',
  `samples_additional_cost` decimal(10,2) DEFAULT '0.00',
  `samples_products_cost` decimal(10,2) DEFAULT '0.00',
  `samples_min_qty` decimal(10,2) DEFAULT '0.00',
  `samples_max_qty` decimal(10,2) DEFAULT '0.00',
  `order_date` int(11) unsigned DEFAULT NULL,
  `status` tinyint(3) unsigned DEFAULT '0',
  `track_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `orders_aid` (`aid`),
  KEY `trid` (`trid`),
  KEY `track_code` (`track_code`),
  KEY `end_date` (`end_date`)
) ENGINE=InnoDB AUTO_INCREMENT=10978 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the completed orders';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_order_details
DROP TABLE IF EXISTS `fabrix_order_details`;
CREATE TABLE IF NOT EXISTS `fabrix_order_details` (
  `id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(11) unsigned DEFAULT NULL,
  `product_id` int(11) unsigned DEFAULT NULL,
  `product_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `is_sample` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `order_details_order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39814 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the details for the order line items';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_patterns
DROP TABLE IF EXISTS `fabrix_patterns`;
CREATE TABLE IF NOT EXISTS `fabrix_patterns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pattern` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pattern` (`pattern`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_products
DROP TABLE IF EXISTS `fabrix_products`;
CREATE TABLE IF NOT EXISTS `fabrix_products` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pnumber` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `yardage` decimal(10,2) DEFAULT NULL,
  `priceyard` decimal(10,2) DEFAULT NULL,
  `inventory` decimal(10,2) DEFAULT NULL,
  `sdesc` text COLLATE utf8_unicode_ci,
  `ldesc` text COLLATE utf8_unicode_ci,
  `image1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(10) unsigned DEFAULT NULL,
  `cid` int(10) unsigned DEFAULT NULL,
  `pvisible` smallint(5) unsigned DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specials` smallint(6) DEFAULT NULL,
  `weight_id` tinyint(1) unsigned DEFAULT NULL,
  `stock_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturerId` int(11) unsigned DEFAULT NULL,
  `metatitle` text COLLATE utf8_unicode_ci NOT NULL,
  `metadescription` text COLLATE utf8_unicode_ci NOT NULL,
  `metakeywords` text COLLATE utf8_unicode_ci NOT NULL,
  `hideprice` smallint(6) DEFAULT NULL,
  `dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `best` tinyint(4) DEFAULT '0',
  `popular` int(11) DEFAULT '0',
  `piece` int(11) NOT NULL DEFAULT '0',
  `whole` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `pname` (`pname`),
  KEY `pnumber` (`pnumber`),
  KEY `cid` (`cid`),
  KEY `manufacturerId` (`manufacturerId`)
) ENGINE=InnoDB AUTO_INCREMENT=14331 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_product_categories
DROP TABLE IF EXISTS `fabrix_product_categories`;
CREATE TABLE IF NOT EXISTS `fabrix_product_categories` (
  `pid` int(11) unsigned NOT NULL,
  `cid` int(3) unsigned NOT NULL,
  `display_order` int(10) unsigned NOT NULL DEFAULT '99999999',
  PRIMARY KEY (`pid`,`cid`),
  KEY `pid` (`pid`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the links between the products and the categories';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_product_colors
DROP TABLE IF EXISTS `fabrix_product_colors`;
CREATE TABLE IF NOT EXISTS `fabrix_product_colors` (
  `prodId` int(11) unsigned NOT NULL,
  `colorId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`prodId`,`colorId`),
  KEY `prodId` (`prodId`),
  KEY `colorId` (`colorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_product_favorites
DROP TABLE IF EXISTS `fabrix_product_favorites`;
CREATE TABLE IF NOT EXISTS `fabrix_product_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`,`pid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_product_patterns
DROP TABLE IF EXISTS `fabrix_product_patterns`;
CREATE TABLE IF NOT EXISTS `fabrix_product_patterns` (
  `prodId` int(11) unsigned NOT NULL,
  `patternId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`prodId`,`patternId`),
  KEY `prodId` (`prodId`),
  KEY `patternId` (`patternId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_product_related
DROP TABLE IF EXISTS `fabrix_product_related`;
CREATE TABLE IF NOT EXISTS `fabrix_product_related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `r_pid` int(11) NOT NULL DEFAULT '0',
  `dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`,`r_pid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_province_state
DROP TABLE IF EXISTS `fabrix_province_state`;
CREATE TABLE IF NOT EXISTS `fabrix_province_state` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_specials
DROP TABLE IF EXISTS `fabrix_specials`;
CREATE TABLE IF NOT EXISTS `fabrix_specials` (
  `sid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `discount_amount_type` tinyint(3) unsigned DEFAULT NULL,
  `discount_type` tinyint(3) unsigned DEFAULT NULL,
  `shipping_type` tinyint(3) unsigned DEFAULT '0',
  `promotion_type` tinyint(3) unsigned DEFAULT NULL,
  `required_amount` decimal(10,2) DEFAULT NULL,
  `required_type` tinyint(3) unsigned DEFAULT NULL,
  `user_type` tinyint(3) unsigned DEFAULT NULL,
  `product_type` tinyint(3) unsigned DEFAULT NULL,
  `allow_multiple` tinyint(1) unsigned DEFAULT '0',
  `date_start` int(8) unsigned DEFAULT NULL,
  `date_end` int(8) unsigned DEFAULT NULL,
  `enabled` tinyint(1) unsigned DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `countdown` tinyint(1) unsigned DEFAULT '0',
  `discount_comment1` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_comment2` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_comment3` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sid`),
  KEY `ccode` (`coupon_code`)
) ENGINE=InnoDB AUTO_INCREMENT=1043 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the information for the discounts';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_specials_products
DROP TABLE IF EXISTS `fabrix_specials_products`;
CREATE TABLE IF NOT EXISTS `fabrix_specials_products` (
  `sid` int(11) unsigned NOT NULL DEFAULT '0',
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `stype` int(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`,`stype`,`sid`),
  KEY `pid` (`pid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_specials_usage
DROP TABLE IF EXISTS `fabrix_specials_usage`;
CREATE TABLE IF NOT EXISTS `fabrix_specials_usage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(11) unsigned DEFAULT NULL,
  `oid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `oid` (`oid`)
) ENGINE=InnoDB AUTO_INCREMENT=17934 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_specials_users
DROP TABLE IF EXISTS `fabrix_specials_users`;
CREATE TABLE IF NOT EXISTS `fabrix_specials_users` (
  `sid` int(11) unsigned NOT NULL DEFAULT '0',
  `aid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`,`sid`),
  KEY `aid` (`aid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_state
DROP TABLE IF EXISTS `fabrix_state`;
CREATE TABLE IF NOT EXISTS `fabrix_state` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_taxrates
DROP TABLE IF EXISTS `fabrix_taxrates`;
CREATE TABLE IF NOT EXISTS `fabrix_taxrates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `province_state_id` int(11) unsigned DEFAULT NULL,
  `tax_rate` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.fabrix_temp_product
DROP TABLE IF EXISTS `fabrix_temp_product`;
CREATE TABLE IF NOT EXISTS `fabrix_temp_product` (
  `productId` varchar(15) DEFAULT NULL,
  `sid` varchar(50) DEFAULT NULL,
  KEY `productId` (`productId`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для функция iluvfabrix.getTransactionDetailsCount
DROP FUNCTION IF EXISTS `getTransactionDetailsCount`;
DELIMITER //
CREATE DEFINER=`root`@`%` FUNCTION `getTransactionDetailsCount`(
	`aid` INT








) RETURNS int(11)
BEGIN
	DECLARE ret INT DEFAULT 0;
	DECLARE countRow INT DEFAULT 0;
	DECLARE eDate INT DEFAULT 0;
	DECLARE bDate INT DEFAULT 0;

	SELECT UNIX_TIMESTAMP(DATE_SUB(DATE(NOW()),INTERVAL (DAY(NOW())-1) DAY)) INTO bDate;
	SELECT UNIX_TIMESTAMP(LAST_DAY(NOW())) INTO eDate;
	SELECT COUNT(oid) INTO countRow FROM fabrix_orders WHERE aid=aid AND order_date<=eDate AND order_date>=bDate;
	
	IF (NOT ISNULL(countRow)) THEN
		SET ret = countRow;
	END IF;	

	RETURN ret;
END//
DELIMITER ;

-- Дамп структуры для функция iluvfabrix.getUserType
DROP FUNCTION IF EXISTS `getUserType`;
DELIMITER //
CREATE DEFINER=`root`@`%` FUNCTION `getUserType`(
	`aid` INT


) RETURNS int(11)
BEGIN
	DECLARE ret INT DEFAULT 0;
	DECLARE iTtl INT DEFAULT 2;
	
	SELECT `getTransactionDetailsCount`(aid) INTO iTtl;
	
	IF (iTtl > 0) THEN
   	SET ret = 3;
   END IF;

	RETURN ret;
END//
DELIMITER ;

-- Дамп структуры для таблица iluvfabrix.info_messages
DROP TABLE IF EXISTS `info_messages`;
CREATE TABLE IF NOT EXISTS `info_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `f1` int(11) DEFAULT NULL,
  `f2` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `f1` (`f1`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.keywords_synonyms
DROP TABLE IF EXISTS `keywords_synonyms`;
CREATE TABLE IF NOT EXISTS `keywords_synonyms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` text NOT NULL,
  `synonyms` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `keywords` (`keywords`(255))
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.key_storage
DROP TABLE IF EXISTS `key_storage`;
CREATE TABLE IF NOT EXISTS `key_storage` (
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.page_meta
DROP TABLE IF EXISTS `page_meta`;
CREATE TABLE IF NOT EXISTS `page_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `title` text,
  `description` text,
  `keywords` text,
  PRIMARY KEY (`id`),
  KEY `controller` (`controller`),
  KEY `action` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.url_sef
DROP TABLE IF EXISTS `url_sef`;
CREATE TABLE IF NOT EXISTS `url_sef` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `sef` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `sef` (`sef`)
) ENGINE=InnoDB AUTO_INCREMENT=6989 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- --------------------------------------------------------
-- Хост:                         localhost
-- Версия сервера:               5.5.58-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица iluvfabrix.accounts
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=19226 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.admins
DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rememberme` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_login` (`login`),
  KEY `admins_rememberme` (`rememberme`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
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
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Дамп структуры для таблица iluvfabrix.collection
DROP TABLE IF EXISTS `collection`;
CREATE TABLE IF NOT EXISTS `collection` (
  `type` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`type`,`pid`),
  KEY `idx_collection_pid` (`pid`),
  KEY `idx_collection_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.collection_trigger
DROP TABLE IF EXISTS `collection_trigger`;
CREATE TABLE IF NOT EXISTS `collection_trigger` (
  `type` int(10) unsigned NOT NULL,
  `trigger` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.comments
DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `data` text,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(11) DEFAULT NULL,
  `moderated` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.countries
DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
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
-- Дамп структуры для таблица iluvfabrix.shop_categories
DROP TABLE IF EXISTS `shop_categories`;
CREATE TABLE IF NOT EXISTS `shop_categories` (
  `cid` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `displayorder` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `cname` (`cname`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_clearance
DROP TABLE IF EXISTS `shop_clearance`;
CREATE TABLE IF NOT EXISTS `shop_clearance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_color
DROP TABLE IF EXISTS `shop_color`;
CREATE TABLE IF NOT EXISTS `shop_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `color` (`color`)
) ENGINE=InnoDB AUTO_INCREMENT=373 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_manufacturers
DROP TABLE IF EXISTS `shop_manufacturers`;
CREATE TABLE IF NOT EXISTS `shop_manufacturers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manufacturer` (`manufacturer`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_orders
DROP TABLE IF EXISTS `shop_orders`;
CREATE TABLE IF NOT EXISTS `shop_orders` (
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
) ENGINE=InnoDB AUTO_INCREMENT=11061 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_order_details
DROP TABLE IF EXISTS `shop_order_details`;
CREATE TABLE IF NOT EXISTS `shop_order_details` (
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
) ENGINE=InnoDB AUTO_INCREMENT=40199 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the details for the order line items';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_patterns
DROP TABLE IF EXISTS `shop_patterns`;
CREATE TABLE IF NOT EXISTS `shop_patterns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pattern` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pattern` (`pattern`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_products
DROP TABLE IF EXISTS `shop_products`;
CREATE TABLE IF NOT EXISTS `shop_products` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pnumber` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `yardage` decimal(10,2) DEFAULT NULL,
  `priceyard` decimal(10,2) NOT NULL,
  `inventory` decimal(10,2) DEFAULT NULL,
  `sdesc` text COLLATE utf8_unicode_ci,
  `ldesc` text COLLATE utf8_unicode_ci,
  `image1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_order` int(10) unsigned DEFAULT NULL,
  `pvisible` smallint(5) unsigned NOT NULL DEFAULT '1',
  `dimensions` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specials` smallint(6) NOT NULL DEFAULT '0',
  `weight_id` tinyint(1) unsigned DEFAULT NULL,
  `stock_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturerId` int(11) unsigned DEFAULT NULL,
  `metatitle` text COLLATE utf8_unicode_ci NOT NULL,
  `metadescription` text COLLATE utf8_unicode_ci NOT NULL,
  `metakeywords` text COLLATE utf8_unicode_ci NOT NULL,
  `hideprice` smallint(6) NOT NULL DEFAULT '0',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `best` tinyint(4) NOT NULL DEFAULT '0',
  `popular` int(11) NOT NULL DEFAULT '0',
  `piece` int(11) NOT NULL DEFAULT '0',
  `whole` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `pname` (`pname`),
  KEY `pnumber` (`pnumber`),
  KEY `manufacturerId` (`manufacturerId`)
) ENGINE=InnoDB AUTO_INCREMENT=14547 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_product_categories
DROP TABLE IF EXISTS `shop_product_categories`;
CREATE TABLE IF NOT EXISTS `shop_product_categories` (
  `pid` int(11) unsigned NOT NULL,
  `cid` int(3) unsigned NOT NULL,
  `display_order` int(10) unsigned NOT NULL DEFAULT '99999999',
  PRIMARY KEY (`pid`,`cid`),
  KEY `pid` (`pid`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the links between the products and the categories';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_product_colors
DROP TABLE IF EXISTS `shop_product_colors`;
CREATE TABLE IF NOT EXISTS `shop_product_colors` (
  `prodId` int(11) unsigned NOT NULL,
  `colorId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`prodId`,`colorId`),
  KEY `prodId` (`prodId`),
  KEY `colorId` (`colorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_product_favorites
DROP TABLE IF EXISTS `shop_product_favorites`;
CREATE TABLE IF NOT EXISTS `shop_product_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`aid`,`pid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92020 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_product_patterns
DROP TABLE IF EXISTS `shop_product_patterns`;
CREATE TABLE IF NOT EXISTS `shop_product_patterns` (
  `prodId` int(11) unsigned NOT NULL,
  `patternId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`prodId`,`patternId`),
  KEY `prodId` (`prodId`),
  KEY `patternId` (`patternId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_product_related
DROP TABLE IF EXISTS `shop_product_related`;
CREATE TABLE IF NOT EXISTS `shop_product_related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `r_pid` int(11) NOT NULL DEFAULT '0',
  `dt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`,`r_pid`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1282 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_specials
DROP TABLE IF EXISTS `shop_specials`;
CREATE TABLE IF NOT EXISTS `shop_specials` (
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
) ENGINE=InnoDB AUTO_INCREMENT=1049 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores the information for the discounts';

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_specials_products
DROP TABLE IF EXISTS `shop_specials_products`;
CREATE TABLE IF NOT EXISTS `shop_specials_products` (
  `sid` int(11) unsigned NOT NULL DEFAULT '0',
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `stype` int(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`,`stype`,`sid`),
  KEY `pid` (`pid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_specials_usage
DROP TABLE IF EXISTS `shop_specials_usage`;
CREATE TABLE IF NOT EXISTS `shop_specials_usage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sid` int(11) unsigned DEFAULT NULL,
  `oid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `oid` (`oid`)
) ENGINE=InnoDB AUTO_INCREMENT=18118 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_specials_users
DROP TABLE IF EXISTS `shop_specials_users`;
CREATE TABLE IF NOT EXISTS `shop_specials_users` (
  `sid` int(11) unsigned NOT NULL DEFAULT '0',
  `aid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`,`sid`),
  KEY `aid` (`aid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.shop_taxrates
DROP TABLE IF EXISTS `shop_taxrates`;
CREATE TABLE IF NOT EXISTS `shop_taxrates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `province_state_id` int(11) unsigned DEFAULT NULL,
  `tax_rate` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица iluvfabrix.state
DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4343 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

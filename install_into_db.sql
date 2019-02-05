CREATE TABLE IF NOT EXISTS `d_categories` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `descr` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `private` int(1) NOT NULL DEFAULT '0' COMMENT 'If 1, only viewable by registered users',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Categories for files that can be downloaded';

CREATE TABLE IF NOT EXISTS `d_files` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `cid` int(4) NOT NULL COMMENT 'Category ID',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Author of download',
  `descr` text COLLATE utf8_unicode_ci NOT NULL,
  `iconname` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Default.png',
  `filename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `filesize` int(16) NOT NULL COMMENT 'In bytes',
  `private` int(1) NOT NULL DEFAULT '0' COMMENT 'If 1, only viewable by registered users, if 2 visible but only downloadable if licensed',
  `pid` int(4) NOT NULL DEFAULT '0' COMMENT 'ID of product required for download, only used if private is 2',
  `dlcount` int(8) NOT NULL DEFAULT '0' COMMENT 'Number of downloads',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of files that can be downloaded';

CREATE TABLE IF NOT EXISTS `d_licenses` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL COMMENT 'Licensee ID',
  `pid` int(4) NOT NULL COMMENT 'ID of product licensed',
  `lic_key` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'License key',
  `assigned` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Site or machine license is assigned to.',
  `expiry` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Expiration date of license. 0 = Never.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of licenses issued';

CREATE TABLE IF NOT EXISTS `d_products` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Short name of product',
  `descr` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `lic_duration` int(4) NOT NULL DEFAULT '0' COMMENT 'License duration in days. 0 = Never.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of products that can be licensed';

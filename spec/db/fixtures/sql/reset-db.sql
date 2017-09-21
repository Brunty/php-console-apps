DROP TABLE IF EXISTS `Tasks`;
CREATE TABLE `Tasks` (
  `id` char(36) NOT NULL DEFAULT '',
  `name` text,
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `complete` tinyint(1) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

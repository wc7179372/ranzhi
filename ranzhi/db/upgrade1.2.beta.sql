DROP TABLE IF EXISTS oa_block;
CREATE TABLE `sys_block` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `app` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `source` varchar(20) NOT NULL,
  `block` varchar(20) NOT NULL,
  `params` text NOT NULL,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `grid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY account (`account`, `app`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `sys_entry` ADD `buildin` tinyint(1) NOT NULL DEFAULT '0' AFTER `code`,
ADD `integration` tinyint(1) NOT NULL DEFAULT '1' AFTER `buildin`;
ALTER TABLE `sys_entry` ADD `abbr` char(2) COLLATE 'utf8_general_ci' NOT NULL AFTER `name`;

ALTER TABEL crm_contact ADD fax char(20) NOT NULL;

ALTER TABLE crm_contract CHANGE `amount` `amount` decimal(12,2) NOT NULL;
ALTER TABLE crm_order    CHANGE `plan``plan` decimal(12,2) NOT NULL;
ALTER TABLE crm_order    CHNAGE `real` `real` decimal(12,2) NOT NULL;
ALTER TABLE cash_trade   CHANGE `money` `money` decimal(12,2) NOT NULL;
ALTER TABLE cash_balance CHANGE `money` `money` decimal(12,2) NOT NULL;
ALTER TABLE sys_task     CHANGE `estimate` `estimate` decimal(12,2) NOT NULL;
ALTER TABLE sys_task     CHANGE `consumed` `consumed` decimal(12,2) NOT NULL;
ALTER TABLE sys_task     CHANGE `left` `left` decimal(12,2) NOT NULL;
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seo', 'seo', 'SEO', '', '{"route":"admin_default","module":"seo","controller":"manage"}', 'core_admin_main_plugins', '', 999),
('seo_admin_main_manage', 'seo', 'Manage SEO', '', '{"route":"admin_default","module":"seo","controller":"manage"}', 'seo_admin_main', '', 1)
;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_seo_pages`
--

DROP TABLE IF EXISTS `engine4_seo_pages`;
CREATE TABLE IF NOT EXISTS `engine4_seo_pages` (
  `page_id` varchar(50) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `faucet_title` text NOT NULL,
  `faucet_url` text NOT NULL,
  `tx_display_limit` varchar(10) NOT NULL,
  `faucet_amount` varchar(50) NOT NULL,
  `pay_every` varchar(50) NOT NULL,
  `blockchain_guid` text NOT NULL,
  `blockchain_first` text NOT NULL,
  `blockchain_second` text NOT NULL,
  `blockchain_keyaddress` text NOT NULL,
  `yocaptcha_status` text NOT NULL,
  `yocaptcha_public` text NOT NULL,
  `yocaptcha_private` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `settings` (`id`, `username`, `password`, `faucet_title`, `faucet_url`, `tx_display_limit`, `faucet_amount`, `pay_every`, `blockchain_guid`, `blockchain_first`, `blockchain_second`, `blockchain_keyaddress`, `yocaptcha_status`, `yocaptcha_public`, `yocaptcha_private`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'zellus Bitcoin Faucet', 'http://website.com', '5', '0.0001', 'hourly', '', '', '', '', 'inactive', '', '');

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `paid` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `txid` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


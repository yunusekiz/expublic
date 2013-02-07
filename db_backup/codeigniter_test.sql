-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 07 Şub 2013, 12:25:41
-- Sunucu sürümü: 5.5.25a
-- PHP Sürümü: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `codeigniter_test`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about_us`
--

CREATE TABLE IF NOT EXISTS `about_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `about` text NOT NULL,
  `vision` text NOT NULL,
  `mission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `about_us`
--

INSERT INTO `about_us` (`id`, `about`, `vision`, `mission`) VALUES
(1, 'hakkimizda ornek metni 3', 'vizyonumuz ornek metni 3', 'misyonumuz ornek metni 3');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `about_us_view_alias`
--
CREATE TABLE IF NOT EXISTS `about_us_view_alias` (
`id` int(11)
,`hakkimizda` text
,`vizyonumuz` text
,`misyonumuz` text
);
-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`id`, `email`, `pass`) VALUES
(1, 'admin@expublic.com', '12345');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `big_slider`
--

CREATE TABLE IF NOT EXISTS `big_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_title` text NOT NULL,
  `big_image_path` text NOT NULL,
  `thumb_image_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `fax` text NOT NULL,
  `email` text NOT NULL,
  `facebook` text NOT NULL,
  `twitter` text NOT NULL,
  `gplus` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `contact`
--

INSERT INTO `contact` (`id`, `address`, `phone`, `fax`, `email`, `facebook`, `twitter`, `gplus`) VALUES
(1, '0', '0', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `contact_view_alias`
--
CREATE TABLE IF NOT EXISTS `contact_view_alias` (
`id` int(11)
,`adres` text
,`telefon` text
,`faks` text
,`email` text
,`facebook` text
,`twitter` text
,`gplus` text
);
-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_date` varchar(225) NOT NULL,
  `news_detail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Tablo döküm verisi `news`
--

INSERT INTO `news` (`id`, `news_date`, `news_detail`) VALUES
(11, 'yeni haber tarihi_1', 'yeni haber detayi_1'),
(12, 'yeni haber tarihi_2', 'yeni haber detayi_2'),
(13, 'yeni haber tarihi_3', 'yeni haber detayi_3');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `news_view_alias`
--
CREATE TABLE IF NOT EXISTS `news_view_alias` (
`id` int(11)
,`haber_tarihi` varchar(225)
,`haber_detayi` text
);
-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reference_category`
--

CREATE TABLE IF NOT EXISTS `reference_category` (
  `ref_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_category_name` varchar(225) NOT NULL,
  PRIMARY KEY (`ref_category_id`),
  UNIQUE KEY `ref_category_name` (`ref_category_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=119 ;

--
-- Tablo döküm verisi `reference_category`
--

INSERT INTO `reference_category` (`ref_category_id`, `ref_category_name`) VALUES
(117, 'yeni_referans_kategorisi_1'),
(118, 'yeni_referans_kategorisi_2');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reference_image`
--

CREATE TABLE IF NOT EXISTS `reference_image` (
  `images_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` int(11) NOT NULL,
  `path_big_full` text NOT NULL,
  `path_thumb_full` text NOT NULL,
  PRIMARY KEY (`images_id`),
  KEY `ref_id` (`ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Tablo döküm verisi `reference_image`
--

INSERT INTO `reference_image` (`images_id`, `ref_id`, `path_big_full`, `path_thumb_full`) VALUES
(26, 29, 'C:/xampp/htdocs/www/codeigniter_test/assets/images/reference_images/13.jpg', 'C:/xampp/htdocs/www/codeigniter_test/assets/images/reference_images/thumb/13_thumb.jpg'),
(27, 30, 'C:/xampp/htdocs/www/codeigniter_test/assets/images/reference_images/1.jpg', 'C:/xampp/htdocs/www/codeigniter_test/assets/images/reference_images/thumb/1_thumb.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reference_text_field`
--

CREATE TABLE IF NOT EXISTS `reference_text_field` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_category_id` int(11) NOT NULL,
  `ref_name` varchar(225) NOT NULL,
  `ref_date` varchar(30) NOT NULL,
  `ref_title` text NOT NULL,
  `ref_detail` text NOT NULL,
  PRIMARY KEY (`ref_id`),
  UNIQUE KEY `ref_name` (`ref_name`),
  KEY `ref_category_id` (`ref_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Tablo döküm verisi `reference_text_field`
--

INSERT INTO `reference_text_field` (`ref_id`, `ref_category_id`, `ref_name`, `ref_date`, `ref_title`, `ref_detail`) VALUES
(29, 117, 'yeni referans basligi_1', '31-12-2012', 'yeni referans basligi_1', 'yeni referans_detayi_1'),
(30, 118, 'yeni referans basligi_2', '31-12-2012', 'yeni referans basligi_2', 'yeni referans_detayi_2');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `reference_view`
--
CREATE TABLE IF NOT EXISTS `reference_view` (
`ref_category` varchar(225)
,`ref_name` varchar(225)
,`ref_date` varchar(30)
,`ref_title` text
,`ref_detail` text
,`ref_image_big` text
,`ref_image_thumb` text
);
-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `reference_view_alias`
--
CREATE TABLE IF NOT EXISTS `reference_view_alias` (
`kategori` varchar(225)
,`tarih` varchar(30)
,`baslik` text
,`detay` text
,`resim_buyuk` text
,`resim_kucuk` text
);
-- --------------------------------------------------------

--
-- Görünüm yapısı `about_us_view_alias`
--
DROP TABLE IF EXISTS `about_us_view_alias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `about_us_view_alias` AS select `about_us`.`id` AS `id`,`about_us`.`about` AS `hakkimizda`,`about_us`.`vision` AS `vizyonumuz`,`about_us`.`mission` AS `misyonumuz` from `about_us` where (`about_us`.`id` = 1);

-- --------------------------------------------------------

--
-- Görünüm yapısı `contact_view_alias`
--
DROP TABLE IF EXISTS `contact_view_alias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `contact_view_alias` AS select `contact`.`id` AS `id`,`contact`.`address` AS `adres`,`contact`.`phone` AS `telefon`,`contact`.`fax` AS `faks`,`contact`.`email` AS `email`,`contact`.`facebook` AS `facebook`,`contact`.`twitter` AS `twitter`,`contact`.`gplus` AS `gplus` from `contact` where (`contact`.`id` = 1);

-- --------------------------------------------------------

--
-- Görünüm yapısı `news_view_alias`
--
DROP TABLE IF EXISTS `news_view_alias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `news_view_alias` AS select `news`.`id` AS `id`,`news`.`news_date` AS `haber_tarihi`,`news`.`news_detail` AS `haber_detayi` from `news`;

-- --------------------------------------------------------

--
-- Görünüm yapısı `reference_view`
--
DROP TABLE IF EXISTS `reference_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reference_view` AS select `reference_category`.`ref_category_name` AS `ref_category`,`reference_text_field`.`ref_name` AS `ref_name`,`reference_text_field`.`ref_date` AS `ref_date`,`reference_text_field`.`ref_title` AS `ref_title`,`reference_text_field`.`ref_detail` AS `ref_detail`,`reference_image`.`path_big_full` AS `ref_image_big`,`reference_image`.`path_thumb_full` AS `ref_image_thumb` from ((`reference_category` join `reference_text_field`) join `reference_image`) where ((`reference_category`.`ref_category_id` = `reference_text_field`.`ref_category_id`) and (`reference_text_field`.`ref_id` = `reference_image`.`ref_id`));

-- --------------------------------------------------------

--
-- Görünüm yapısı `reference_view_alias`
--
DROP TABLE IF EXISTS `reference_view_alias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reference_view_alias` AS select `reference_category`.`ref_category_name` AS `kategori`,`reference_text_field`.`ref_date` AS `tarih`,`reference_text_field`.`ref_title` AS `baslik`,`reference_text_field`.`ref_detail` AS `detay`,`reference_image`.`path_big_full` AS `resim_buyuk`,`reference_image`.`path_thumb_full` AS `resim_kucuk` from ((`reference_category` join `reference_text_field`) join `reference_image`) where ((`reference_category`.`ref_category_id` = `reference_text_field`.`ref_category_id`) and (`reference_text_field`.`ref_id` = `reference_image`.`ref_id`));

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `reference_image`
--
ALTER TABLE `reference_image`
  ADD CONSTRAINT `reference_image_ibfk_1` FOREIGN KEY (`ref_id`) REFERENCES `reference_text_field` (`ref_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `reference_text_field`
--
ALTER TABLE `reference_text_field`
  ADD CONSTRAINT `reference_text_field_ibfk_1` FOREIGN KEY (`ref_category_id`) REFERENCES `reference_category` (`ref_category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 16 Şub 2013, 17:12:00
-- Sunucu sürümü: 5.5.27
-- PHP Sürümü: 5.4.7

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Tablo döküm verisi `big_slider`
--

INSERT INTO `big_slider` (`id`, `image_title`, `big_image_path`, `thumb_image_path`) VALUES
(1, 'merhaba harun abi', 'assets/theme_assets/slider_assets/photo/merhaba_harun_abi.jpg', 'assets/theme_assets/slider_assets/photo/thumb/merhaba_harun_abi_thumb.jpg'),
(6, 'merhaba harun abi', 'assets/theme_assets/slider_assets/photo/merhaba_harun_abi1.jpg', 'assets/theme_assets/slider_assets/photo/thumb/merhaba_harun_abi1_thumb.jpg');

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
(1, '02424', '02424', '02424', '0242424', '0242424', '0242424', '0');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `reference_category`
--

INSERT INTO `reference_category` (`ref_category_id`, `ref_category_name`) VALUES
(6, 'ferrari'),
(7, 'göt'),
(5, 'horse');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reference_image`
--

CREATE TABLE IF NOT EXISTS `reference_image` (
  `images_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` int(11) NOT NULL,
  `path_big_image` text NOT NULL,
  `path_thumb_image` text NOT NULL,
  PRIMARY KEY (`images_id`),
  KEY `ref_id` (`ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `reference_image`
--

INSERT INTO `reference_image` (`images_id`, `ref_id`, `path_big_image`, `path_thumb_image`) VALUES
(5, 5, 'assets/images/reference_images/yeni_referans_basligi.jpg', 'assets/images/reference_images/thumb/yeni_referans_basligi_thumb.jpg'),
(6, 6, 'assets/images/reference_images/buda_ikinci_referans_basligi.jpg', 'assets/images/reference_images/thumb/buda_ikinci_referans_basligi_thumb.jpg'),
(7, 7, 'assets/images/reference_images/buda_ikinci_referans_basligighjk.jpg', 'assets/images/reference_images/thumb/buda_ikinci_referans_basligighjk_thumb.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reference_text_field`
--

CREATE TABLE IF NOT EXISTS `reference_text_field` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_category_id` int(11) NOT NULL,
  `ref_date` varchar(30) NOT NULL,
  `ref_title` text NOT NULL,
  `ref_detail` text NOT NULL,
  PRIMARY KEY (`ref_id`),
  KEY `ref_category_id` (`ref_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `reference_text_field`
--

INSERT INTO `reference_text_field` (`ref_id`, `ref_category_id`, `ref_date`, `ref_title`, `ref_detail`) VALUES
(5, 5, '16-02-2013', 'yeni referans basligi', 'yeni referans aciklamasi'),
(6, 6, '16-02-2013', 'buda ikinci referans basligi', 'pornstarsssssssss s s'),
(7, 7, '16-02-2013', 'buda ikinci referans basligighjk', 'rtfgjhkrghjjfghj');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `reference_view`
--
CREATE TABLE IF NOT EXISTS `reference_view` (
`kategori` varchar(225)
,`tarih` varchar(30)
,`baslik` text
,`aciklama` text
,`buyuk_resim` text
,`kucuk_resim` text
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reference_view` AS select `reference_category`.`ref_category_name` AS `kategori`,`reference_text_field`.`ref_date` AS `tarih`,`reference_text_field`.`ref_title` AS `baslik`,`reference_text_field`.`ref_detail` AS `aciklama`,`reference_image`.`path_big_image` AS `buyuk_resim`,`reference_image`.`path_thumb_image` AS `kucuk_resim` from ((`reference_category` join `reference_text_field`) join `reference_image`) where ((`reference_category`.`ref_category_id` = `reference_text_field`.`ref_category_id`) and (`reference_text_field`.`ref_id` = `reference_image`.`ref_id`));

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

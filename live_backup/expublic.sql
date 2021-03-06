-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 08 Ağu 2013, 22:58:44
-- Sunucu sürümü: 5.5.25a
-- PHP Sürümü: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `expublic`
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
(1, 'hakkimizda ornek metni 4', 'vizyonumuz ornek metni 4', 'misyonumuz ornek metni 4');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Tablo döküm verisi `big_slider`
--

INSERT INTO `big_slider` (`id`, `image_title`, `big_image_path`, `thumb_image_path`) VALUES
(9, 'yeni slider ismi', 'assets/theme_assets/slider_assets/photo/yeni_slider_ismi.jpg', 'assets/theme_assets/slider_assets/photo/thumb/yeni_slider_ismi_thumb.jpg'),
(10, 'yeni slider ismi2', 'assets/theme_assets/slider_assets/photo/yeni_slider_ismi2.jpg', 'assets/theme_assets/slider_assets/photo/thumb/yeni_slider_ismi2_thumb.jpg'),
(11, 'night tokio', 'assets/theme_assets/slider_assets/photo/night_tokio.jpg', 'assets/theme_assets/slider_assets/photo/thumb/night_tokio_thumb.jpg');

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
-- Tablo için tablo yapısı `home_static_images`
--

CREATE TABLE IF NOT EXISTS `home_static_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_title` varchar(255) NOT NULL,
  `image_detail` text NOT NULL,
  `big_image_path` text NOT NULL,
  `thumb_image_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Tablo döküm verisi `home_static_images`
--

INSERT INTO `home_static_images` (`id`, `image_title`, `image_detail`, `big_image_path`, `thumb_image_path`) VALUES
(13, 'yeni resmimim adi', 'yeni resmimim detay bilgisi', 'assets/images/home_static_images/yeni_resmimim_adi.jpg', 'assets/images/home_static_images/thumb/yeni_resmimim_adi_thumb.jpg'),
(15, 'reerere', 'fyhkkpo', 'assets/images/home_static_images/reerere.jpg', 'assets/images/home_static_images/thumb/reerere_thumb.jpg'),
(16, 'mikkmkjhk', 'njnyhınolk', 'assets/images/home_static_images/mikkmkjhk.jpg', 'assets/images/home_static_images/thumb/mikkmkjhk_thumb.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `little_slider`
--

CREATE TABLE IF NOT EXISTS `little_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_title` text NOT NULL,
  `image_date` varchar(255) NOT NULL,
  `image_detail` text NOT NULL,
  `big_image_path` text NOT NULL,
  `thumb_image_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Tablo döküm verisi `little_slider`
--

INSERT INTO `little_slider` (`id`, `image_title`, `image_date`, `image_detail`, `big_image_path`, `thumb_image_path`) VALUES
(20, 'örnek resim detay bilgisi', '31/03/2013', 'örnek resim detay bilgisi', 'assets/images/little_slider_images/ornek-resim-detay-bilgisi.jpg', 'assets/images/little_slider_images/thumb/ornek-resim-detay-bilgisi_thumb.jpg'),
(21, 'bu benim yeni resmim', '07/06/2013', 'bu benim yeni resmimi detayı', 'assets/images/little_slider_images/bu-benim-yeni-resmim.jpg', 'assets/images/little_slider_images/thumb/bu-benim-yeni-resmim_thumb.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_date` varchar(225) NOT NULL,
  `news_detail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Tablo döküm verisi `news`
--

INSERT INTO `news` (`id`, `news_date`, `news_detail`) VALUES
(23, '15/02/2013', 'ikinci haber edit');

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
-- Görünüm yapısı durumu `null_reference_category`
--
CREATE TABLE IF NOT EXISTS `null_reference_category` (
`null_kategori_id` int(11)
,`null_kategori` varchar(225)
,`null_trim_kategori` varchar(225)
);
-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reference_category`
--

CREATE TABLE IF NOT EXISTS `reference_category` (
  `ref_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_category_name` varchar(225) NOT NULL,
  `ref_category_seofriendly_name` varchar(225) NOT NULL,
  PRIMARY KEY (`ref_category_id`),
  UNIQUE KEY `ref_category_name` (`ref_category_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Tablo döküm verisi `reference_category`
--

INSERT INTO `reference_category` (`ref_category_id`, `ref_category_name`, `ref_category_seofriendly_name`) VALUES
(13, 'retro style', 'retro-style'),
(14, 'yeni kategori', 'yeni-kategori');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Tablo döküm verisi `reference_image`
--

INSERT INTO `reference_image` (`images_id`, `ref_id`, `path_big_image`, `path_thumb_image`) VALUES
(26, 26, 'assets/images/reference_images/yeni-referans-basligi22.JPG', 'assets/images/reference_images/thumb/yeni-referans-basligi22_thumb.JPG');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Tablo döküm verisi `reference_text_field`
--

INSERT INTO `reference_text_field` (`ref_id`, `ref_category_id`, `ref_date`, `ref_title`, `ref_detail`) VALUES
(26, 13, '01/02/2013', 'yeni referans basligi22', 'referans aciklamasi 22');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `reference_view`
--
CREATE TABLE IF NOT EXISTS `reference_view` (
`kategori` varchar(225)
,`trim_kategori` varchar(225)
,`ref_id` int(11)
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

CREATE ALGORITHM=UNDEFINED DEFINER=`yunus`@`localhost` SQL SECURITY DEFINER VIEW `about_us_view_alias` AS select `about_us`.`id` AS `id`,`about_us`.`about` AS `hakkimizda`,`about_us`.`vision` AS `vizyonumuz`,`about_us`.`mission` AS `misyonumuz` from `about_us` where (`about_us`.`id` = 1);

-- --------------------------------------------------------

--
-- Görünüm yapısı `contact_view_alias`
--
DROP TABLE IF EXISTS `contact_view_alias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`yunus`@`localhost` SQL SECURITY DEFINER VIEW `contact_view_alias` AS select `contact`.`id` AS `id`,`contact`.`address` AS `adres`,`contact`.`phone` AS `telefon`,`contact`.`fax` AS `faks`,`contact`.`email` AS `email`,`contact`.`facebook` AS `facebook`,`contact`.`twitter` AS `twitter`,`contact`.`gplus` AS `gplus` from `contact` where (`contact`.`id` = 1);

-- --------------------------------------------------------

--
-- Görünüm yapısı `news_view_alias`
--
DROP TABLE IF EXISTS `news_view_alias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`yunus`@`localhost` SQL SECURITY DEFINER VIEW `news_view_alias` AS select `news`.`id` AS `id`,`news`.`news_date` AS `haber_tarihi`,`news`.`news_detail` AS `haber_detayi` from `news`;

-- --------------------------------------------------------

--
-- Görünüm yapısı `null_reference_category`
--
DROP TABLE IF EXISTS `null_reference_category`;

CREATE ALGORITHM=UNDEFINED DEFINER=`yunus`@`localhost` SQL SECURITY DEFINER VIEW `null_reference_category` AS select `reference_category`.`ref_category_id` AS `null_kategori_id`,`reference_category`.`ref_category_name` AS `null_kategori`,`reference_category`.`ref_category_seofriendly_name` AS `null_trim_kategori` from (`reference_category` join `reference_text_field`) where (`reference_category`.`ref_category_id` <> `reference_text_field`.`ref_category_id`);

-- --------------------------------------------------------

--
-- Görünüm yapısı `reference_view`
--
DROP TABLE IF EXISTS `reference_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`yunus`@`localhost` SQL SECURITY DEFINER VIEW `reference_view` AS select `reference_category`.`ref_category_name` AS `kategori`,`reference_category`.`ref_category_seofriendly_name` AS `trim_kategori`,`reference_text_field`.`ref_id` AS `ref_id`,`reference_text_field`.`ref_date` AS `tarih`,`reference_text_field`.`ref_title` AS `baslik`,`reference_text_field`.`ref_detail` AS `aciklama`,`reference_image`.`path_big_image` AS `buyuk_resim`,`reference_image`.`path_thumb_image` AS `kucuk_resim` from ((`reference_category` join `reference_text_field`) join `reference_image`) where ((`reference_category`.`ref_category_id` = `reference_text_field`.`ref_category_id`) and (`reference_text_field`.`ref_id` = `reference_image`.`ref_id`));

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

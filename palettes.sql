SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `palettes` (
  `num` int(11) NOT NULL,
  `id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `color_json` longtext COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `themecolor` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `palettes`
  ADD PRIMARY KEY (`num`);

ALTER TABLE `palettes`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;
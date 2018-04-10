SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `comics` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) NOT NULL,
  `issues_total` int(11) NOT NULL,
  `concluded` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DELIMITER $$
CREATE TRIGGER `comics_after_insert` AFTER INSERT ON `comics` FOR EACH ROW BEGIN

INSERT INTO `comic_settings` (comic_id, profile_id)
SELECT NEW.id, profiles.id
FROM profiles;

END
$$
DELIMITER ;

CREATE TABLE `comic_settings` (
  `id` int(11) NOT NULL,
  `comic_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `favorite` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_data` mediumblob NOT NULL,
  `thumb_data` mediumblob NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `mime` varchar(15) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `issues` (
  `id` int(11) NOT NULL,
  `comic_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `image_id` int(11) NOT NULL,
  `summary` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DELIMITER $$
CREATE TRIGGER `issues_after_insert` AFTER INSERT ON `issues` FOR EACH ROW BEGIN

INSERT INTO `issue_settings` (comic_id, issue_id, profile_id)
SELECT NEW.comic_id, NEW.id, profiles.id
FROM profiles;

END
$$
DELIMITER ;

CREATE TABLE `issue_settings` (
  `id` int(11) NOT NULL,
  `comic_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `read` tinyint(1) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `accent_color` varchar(7) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
DELIMITER $$
CREATE TRIGGER `profiles_after_insert` AFTER INSERT ON `profiles` FOR EACH ROW BEGIN

INSERT INTO `comic_settings` (comic_id, profile_id)
SELECT comics.id, NEW.id
FROM comics;

INSERT INTO `issue_settings` (comic_id, issue_id, profile_id)
SELECT issues.comic_id, issues.id, NEW.id
FROM issues;

END
$$
DELIMITER ;

CREATE TABLE `publishers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `description` text,
  `website` varchar(255) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` smallint(10) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `comics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `comic_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comic_id` (`comic_id`),
  ADD KEY `profile_id` (`profile_id`);

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comic_id` (`comic_id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `issue_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_id`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `issue_settings_ibfk_3` (`comic_id`);

ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_id` (`image_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `comics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `comic_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

ALTER TABLE `issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

ALTER TABLE `issue_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `publishers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `comics`
  ADD CONSTRAINT `comics_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

ALTER TABLE `comic_settings`
  ADD CONSTRAINT `comic_settings_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comic_settings_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

ALTER TABLE `issues`
  ADD CONSTRAINT `issues_ibfk_1` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issues_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

ALTER TABLE `issue_settings`
  ADD CONSTRAINT `issue_settings_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issue_settings_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issue_settings_ibfk_3` FOREIGN KEY (`comic_id`) REFERENCES `comics` (`id`) ON DELETE CASCADE;

ALTER TABLE `publishers`
  ADD CONSTRAINT `publishers_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

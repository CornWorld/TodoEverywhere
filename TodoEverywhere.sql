SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `idx` (
  `idx_id` varchar(16) NOT NULL,
  `usr` int(11) NOT NULL,
  `father` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `son` longtext DEFAULT NULL,
  `obj` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `idx`;
CREATE TABLE `obj` (
  `obj_id` varchar(32) NOT NULL,
  `obj_info` varchar(128) CHARACTER SET utf8mb4 DEFAULT NULL,
  `obj_val` longtext CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE TABLE `obj`;
CREATE TABLE `token` (
  `token` varchar(48) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `usr` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(1024) NOT NULL,
  `passwd` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `idx`
  ADD PRIMARY KEY (`idx_id`) USING BTREE;

ALTER TABLE `obj`
  ADD PRIMARY KEY (`obj_id`);

ALTER TABLE `token`
  ADD PRIMARY KEY (`token`);

ALTER TABLE `usr`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `usr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

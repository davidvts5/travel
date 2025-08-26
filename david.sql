-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 04:16 AM
-- Server version: 8.0.42-0ubuntu0.20.04.1
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `david`
--

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `attraction_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `budget` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `city_id` int DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`attraction_id`, `user_id`, `name`, `description`, `address`, `budget`, `city_id`, `image_url`, `is_active`, `created_at`, `updated_at`) VALUES
(623, 4, 'Christ Redeemer', 'The statue weighs 635 metric tons (625 long, 700 short tons), and is located at the peak of the 700-metre (2,300 ft) Corcovado mountain in the Tijuca National Park overlooking the city of Rio de Janeiro. This statue is the largest Art Deco–style sculpture in the world.[6] A symbol of Christianity around the world, the statue has also become a cultural icon of both Rio de Janeiro and Brazil and was voted one of the New 7 Wonders of the World.[7]', 'Alto da Boa Vista, Rio de Janeiro', '$', 633, '..\\images\\attraction_623.jpg', 1, '2025-06-30 17:08:48', '2025-08-26 02:05:46'),
(12343, 19, 'Promenade des Anglais', 'Promenade des Anglais\r\nOpis: Ikonična šetališna staza uz obalu Sredozemnog mora, savršena za šetnju, vožnju bicikla ili uživanje u pogledu.\r\n\r\nTip: Obala / šetalište', 'Promenade des Anglais 1', '$$', 512, '..\\images\\attraction_686ed6020c8637.78371216.jpg', 1, '2025-07-09 20:50:10', '2025-08-24 15:01:56'),
(78465, 4, 'Plava Fontana', 'Fontana od keramike „Žolnai“ je uz Gradsku kuću novi simbol Subotice, glavno sastajalište i odmorište ljudima i golubovima, svakog leta oaza svežine, jer na glavnom gradskom trgu snižava temperaturu za nekoliko stepeni u toku sparnih dana.\r\nFontana je izrađena od keramike „Žolnai“ iz Pečuja, 1985. godine po projektu Svetislava Ličine.', 'Korzo 123', '$', 2641, '..\\images\\attraction_68a6436b3d71c4.61755631.jpg', 1, '2025-08-20 21:51:39', '2025-08-24 11:52:45'),
(78466, 20, 'Hollywood Sign', 'Hollywood, sometimes informally called Tinseltown, is a neighborhood and district[2] in the central region of Los Angeles County, California, within the city of Los Angeles. Its name has become synonymous with the U.S. film industry and the people associated with it. Many notable film studios such as Sony Pictures, Walt Disney Studios, Paramount Pictures, Warner Bros., and Universal Pictures are located in or near Hollywood.', '6834 Hollywood Blvd, Los Angeles, California', '$$', 2640, '..\\images\\attraction_68a644eccf0cc9.18491186.jpg', 1, '2025-08-20 21:58:04', '2025-08-24 14:58:01'),
(78467, 20, 'Venice Beach', 'Venice is a neighborhood of the City of Los Angeles within the Westside region of Los Angeles County, California, United States.\r\nVenice was founded by Abbot Kinney in 1905 as a seaside resort town. It was an independent city until 1926, when it was annexed by the city of Los Angeles. Venice is known for its canals, a beach, and Ocean Front Walk, a 2+1⁄2-mile (4-kilometer) pedestrian promenade that features performers, fortune-tellers, and vendors.', '1800 Ocean Front Walk, Venice, CA 90291', '$', 2640, '..\\images\\attraction_68a6467d090dd1.93535402.jpg', 1, '2025-08-20 22:04:45', '2025-08-24 14:58:04'),
(78468, 4, 'Eiffel Tower', 'The tower is 330 metres (1,083 ft) tall,[9] about the same height as an 81-storey building, and the tallest structure in Paris. Its base is square, measuring 125 metres (410 ft) on each side. During its construction, the Eiffel Tower surpassed the Washington Monument to become by far the tallest human-made structure in the world, a title it held for 41 years until the Chrysler Building in New York City was finished in 1930. It was the first structure in the world to surpass both the 200 meters and 300 meters mark in height. Due to the addition of a broadcasting aerial at the top of the tower in 1957, it is now taller than the Chrysler Building by 5.2 metres (17 ft). Excluding transmitters, the Eiffel Tower is the second tallest free-standing structure in France after the Millau Viaduct.', '5 Avenue Anatole France, 75007 Paris', '$$', 2634, '..\\images\\attraction_68a6fb84a1d067.91315693.jpg', 1, '2025-08-21 10:57:08', '2025-08-24 14:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int NOT NULL,
  `name` varchar(24) COLLATE utf8mb4_general_ci NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `name`, `date_time`) VALUES
(1, 'Music', '2023-11-05 18:50:27'),
(2, 'Sport', '2023-11-05 18:50:27'),
(3, 'Movie', '2023-11-05 18:50:46'),
(4, 'Food', '2023-11-05 18:50:46'),
(5, 'School', '2023-11-05 19:01:38'),
(6, 'Game', '2023-11-05 19:01:43'),
(7, 'Travel', '2023-11-05 19:01:53'),
(8, 'City', '2023-11-05 19:02:25'),
(9, 'Lake', '2023-11-05 19:02:25'),
(10, 'Football', '2023-11-05 19:02:31'),
(11, 'Basketball', '2023-11-05 19:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city`, `country`, `country_id`) VALUES
(512, 'Nice', 'France', 111),
(633, 'Rio De Janeiro', 'Brazil', 11122),
(2634, 'Paris', NULL, 111),
(2640, 'Los Angeles', NULL, 11123),
(2641, 'Subotica', NULL, 11130);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `attraction_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `attraction_id`, `comment`, `rating`, `created_at`) VALUES
(1, 4, 623, 'sss', 3, '2025-08-25 18:32:44'),
(2, 4, 623, 'sss', 4, '2025-08-25 18:45:28'),
(3, 4, 78465, 'Lepo mesto', 5, '2025-08-25 18:47:13'),
(4, 4, 78465, 'Plava fontatannaaaaa', 1, '2025-08-25 18:47:35'),
(5, 4, 78467, 'Beautiful!!!', 4, '2025-08-25 18:48:09'),
(6, 4, 78465, 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Elit quisque faucibus ex sapien vitae pellentesque sem. Sem placerat in id cursus mi pretium tellus. Tellus duis convallis tempus leo eu aenean sed. Sed diam urna tempor pulvinar vivamus fringilla lacus. Lacus nec metus bibendum egestas iaculis massa nisl. Nisl malesuada lacinia integer nunc posuere ut hendrerit.', 4, '2025-08-25 18:50:52'),
(7, 2, 623, 'WILD', 5, '2025-08-25 19:15:02'),
(8, 2, 78468, 'JAKO LEPO', 2, '2025-08-25 19:50:10'),
(9, 2, 78468, 'fgjfgjfj', 5, '2025-08-25 19:52:51'),
(10, 2, 78468, 'fghfgh', 3, '2025-08-25 19:52:59'),
(11, 2, 78468, 'fghfgh', 3, '2025-08-25 19:53:01'),
(12, 2, 78468, 'fghfgh', 3, '2025-08-25 19:53:01'),
(13, 2, 78468, 'fghfgh', 3, '2025-08-25 19:53:01'),
(14, 2, 78468, 'htuyth', 2, '2025-08-25 19:55:37'),
(15, 2, 78468, 'htuyth', 2, '2025-08-25 19:55:42'),
(16, 2, 78468, 'htuyth', 2, '2025-08-25 19:55:42'),
(17, 2, 78468, 'htuyth', 2, '2025-08-25 19:55:42'),
(18, 2, 78468, 'htuyth', 2, '2025-08-25 19:55:43'),
(19, 2, 78468, 'htuyth', 2, '2025-08-25 19:55:43'),
(20, 22, 78467, 'Lepo je', 4, '2025-08-25 20:15:10'),
(21, 2, 12343, 'WWW', 2, '2025-08-25 20:32:55'),
(22, 2, 78466, 'OKEJ JE', 2, '2025-08-25 20:41:35'),
(23, 2, 78468, 'Ajfel', 5, '2025-08-25 20:44:22'),
(24, 2, 78468, 'AJfel opet', 1, '2025-08-25 20:44:30'),
(25, 22, 78465, 'Bilo je okej', 5, '2025-08-25 20:56:23'),
(26, 2, 78468, 'novi comm', 3, '2025-08-25 21:00:55'),
(27, 22, 78465, 'Aaa', 1, '2025-08-25 21:08:26'),
(28, 22, 12343, 'Virus', 1, '2025-08-25 21:15:54'),
(29, 4, 78466, 'Fff', 5, '2025-08-25 21:23:49'),
(30, 2, 623, 'jjjjjjjjjjj', 2, '2025-08-25 23:32:37'),
(31, 4, 12343, 'Najbolje mesto', 4, '2025-08-25 23:34:17'),
(32, 2, 12343, 'Lepo je', 5, '2025-08-26 01:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int NOT NULL,
  `country_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`) VALUES
(11122, 'Brazil'),
(111, 'France'),
(11130, 'Serbia'),
(11123, 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `device_logs`
--

CREATE TABLE `device_logs` (
  `id` int NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `device_type` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `os` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `browser` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device_logs`
--

INSERT INTO `device_logs` (`id`, `ip`, `device_type`, `os`, `browser`, `user_agent`, `country`, `region`, `city`, `isp`, `created_at`) VALUES
(1, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Unknown', 'Unknown', 'Unknown', 'Unknown', '2025-08-23 19:40:56'),
(2, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Unknown', 'Unknown', 'Unknown', 'Unknown', '2025-08-23 19:45:57'),
(3, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Unknown', 'Unknown', 'Unknown', 'Unknown', '2025-08-23 19:46:17'),
(4, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 19:46:43'),
(5, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 19:54:33'),
(6, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 19:54:42'),
(7, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:11:45'),
(8, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:11:53'),
(9, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:51:00'),
(10, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:51:22'),
(11, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:51:41'),
(12, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:52:14'),
(13, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:52:45'),
(14, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:53:12'),
(15, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:53:18'),
(16, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:53:23'),
(17, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:54:12'),
(18, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:54:18'),
(19, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:54:25'),
(20, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-23 23:54:52'),
(21, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 00:17:48'),
(22, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 10:46:45'),
(23, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 10:46:50'),
(24, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 10:59:16'),
(25, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 10:59:22'),
(26, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:46:56'),
(27, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:47:07'),
(28, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:47:15'),
(29, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:47:19'),
(30, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:52:05'),
(31, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:52:08'),
(32, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:52:25'),
(33, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:52:40'),
(34, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:52:46'),
(35, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:52:50'),
(36, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:53:17'),
(37, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:53:57'),
(38, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:55:00'),
(39, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:55:38'),
(40, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:55:54'),
(41, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 11:58:43'),
(42, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 14:55:14'),
(43, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 14:57:46'),
(44, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 14:58:20'),
(45, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 14:58:37'),
(46, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 14:58:50'),
(47, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 15:00:58'),
(48, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 15:01:12'),
(49, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 15:02:00'),
(50, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:03:12'),
(51, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:38:00'),
(52, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:38:15'),
(53, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:38:56'),
(54, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:39:34'),
(55, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:39:46'),
(56, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 19:40:17'),
(57, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-24 20:04:56'),
(58, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 11:34:14'),
(59, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 12:44:19'),
(60, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 12:44:30'),
(61, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 13:05:33'),
(62, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 13:05:43'),
(63, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 13:05:55'),
(64, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 14:51:32'),
(65, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:01:35'),
(66, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:31:37'),
(67, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:35:33'),
(68, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:37:52'),
(69, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:37:58'),
(70, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:38:06'),
(71, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:45:07'),
(72, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:45:34'),
(73, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:48:20'),
(74, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:50:55'),
(75, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 18:52:39'),
(76, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Unknown', 'Unknown', 'Unknown', 'Unknown', '2025-08-25 18:59:59'),
(77, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Unknown', 'Unknown', 'Unknown', 'Unknown', '2025-08-25 19:15:06'),
(78, '127.0.0.1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Unknown', 'Unknown', 'Unknown', 'Unknown', '2025-08-25 19:28:50'),
(79, '::1', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 19:29:03'),
(80, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 19:39:54'),
(81, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 19:40:01'),
(82, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 21:41:08'),
(83, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 21:42:23'),
(84, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 21:43:00'),
(85, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 21:43:08'),
(86, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 21:43:13'),
(87, '91.150.96.36', 'Mobile', 'Linux', 'Chrome', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 21:44:44'),
(88, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 22:03:14'),
(89, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 22:25:46'),
(90, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 23:12:02'),
(91, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-25 23:32:42'),
(92, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-26 00:30:30'),
(93, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-26 01:34:41'),
(94, '91.150.96.36', 'Mobile', 'Linux', 'Chrome', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-26 01:50:01'),
(95, '91.150.96.36', 'Desktop', 'Windows', 'Chrome', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'Serbia', 'Belgrade', 'Belgrade', 'TELEKOM SRBIJA a.d.', '2025-08-26 01:56:26');

-- --------------------------------------------------------

--
-- Table structure for table `email_verification_tokens`
--

CREATE TABLE `email_verification_tokens` (
  `token_id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verification_tokens`
--

INSERT INTO `email_verification_tokens` (`token_id`, `user_id`, `token`, `created_at`) VALUES
(5, 18, 'fc8eccdfa1056f88eab201334edd3de7', '2025-08-20 14:59:10'),
(7, 23, '995a441d0fa746b1736482c24701e031', '2025-08-24 17:57:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(2, 17, '7ea90935da095823913751cf3cbfe0316db66a28f8f2367fa1c3fa626147baeb', '2025-08-23 19:01:28', '2025-08-23 16:01:28'),
(4, 2, '4602f112886e32a462169bd4364e9b0803bc8a95accf19a23e0780b64d75964d', '2025-08-23 20:47:09', '2025-08-23 17:47:09'),
(5, 2, 'aeb04af7e34dbcdc201eccd1e07c4e0b939b92f2f44bb45eef877bf76a8bd6c4', '2025-08-23 20:48:57', '2025-08-23 17:48:57'),
(8, 17, '61af932b51b822321aa087279a4585cce6272aa200d5dd450f267087448f846b', '2025-08-23 21:17:29', '2025-08-23 18:17:29'),
(9, 17, 'b53c695b011d7374f0b4c5af5eca461af989f4851865bfb12325198fcc207828', '2025-08-23 21:18:50', '2025-08-23 18:18:50'),
(10, 17, '734421cd123a93faf05e6b03b2f9adc98ddd16f0d8c6fddebd50104641360e1c', '2025-08-23 21:20:51', '2025-08-23 18:20:51'),
(12, 17, '7f6fb563b3bd0645875f2b62dbe4dbe3c81fe8cbfb9f2e5fe49d1aea9805fc66', '2025-08-23 22:23:44', '2025-08-23 19:23:44'),
(13, 17, '9a2b312e5069cb2a1f8566c51e2eee8a116c48b7f134c6ed7ba64133dc7efa40', '2025-08-23 22:23:45', '2025-08-23 19:23:45'),
(14, 17, '170c3030a55715c642657b8f00ad33d1f8d33a9dcd8dc575a3e572b1278216bd', '2025-08-23 22:23:46', '2025-08-23 19:23:46'),
(15, 17, 'a31ad0e7d9a73a06ecbd7b67bd94005d5f940b7960543a48273884a7b1278436', '2025-08-23 22:24:21', '2025-08-23 19:24:21'),
(16, 17, 'fedabde690818b020fd0340c4fe3370992c63c789599be9f24518567a023f21d', '2025-08-23 22:24:22', '2025-08-23 19:24:22'),
(19, 2, 'f8109af6406f99b673049953dee9efe8a42b984849b1830799991f5f79141e7f', '2025-08-26 03:33:18', '2025-08-26 00:33:18'),
(20, 17, 'd53fe63c87c89f8f08cea08fde9cb9634504f40271d59fa2ec28ae5d49757746', '2025-08-26 03:33:51', '2025-08-26 00:33:51'),
(21, 17, 'c8ef1d355c7059a5c709469c94342536bcaf36c2827ad78d8e0abe5e5d67e669', '2025-08-26 03:35:04', '2025-08-26 00:35:04'),
(23, 17, '1499942f78ab564520393aafb9fcf4402b964b79e70eb74edd8e558b83d3f114', '2025-08-26 03:37:28', '2025-08-26 00:37:28'),
(26, 17, '9279dd2659f81a8bcb6d10bf86a5b7bf4408a826d699dbb836f06061b6508bb0', '2025-08-26 03:40:06', '2025-08-26 00:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `search_logs`
--

CREATE TABLE `search_logs` (
  `id` int NOT NULL,
  `term` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `count` int DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_logs`
--

INSERT INTO `search_logs` (`id`, `term`, `count`, `created_at`) VALUES
(1, 'd', 1, '2025-08-19 14:01:28'),
(2, 'brasil', 2, '2025-08-19 14:01:43'),
(4, 'paris', 4, '2025-08-25 21:13:52'),
(7, 't', 10, '2025-08-23 18:22:23'),
(16, 'Fontana', 1, '2025-08-19 18:28:12'),
(17, 'sa', 4, '2025-08-25 22:30:12'),
(18, 'gas', 1, '2025-08-20 19:49:55'),
(19, 'sag', 4, '2025-08-20 19:49:59'),
(23, 'sgag', 1, '2025-08-20 19:50:05'),
(24, 'car', 1, '2025-08-20 21:44:39'),
(25, 's', 5, '2025-08-25 11:21:45'),
(26, 'ss', 1, '2025-08-20 21:44:44'),
(27, 'la', 2, '2025-08-20 21:45:04'),
(29, 'brazil', 1, '2025-08-21 14:11:18'),
(31, 'c', 1, '2025-08-23 15:26:29'),
(32, 'chr', 4, '2025-08-25 20:55:21'),
(33, 'new', 1, '2025-08-23 18:22:18'),
(35, 'e', 6, '2025-08-26 01:46:43'),
(36, 'as', 1, '2025-08-24 12:14:15'),
(38, 'eiff', 6, '2025-08-24 16:12:16'),
(41, 'ef', 1, '2025-08-24 12:17:32'),
(42, 'eif', 10, '2025-08-25 20:43:58'),
(52, 'ven', 1, '2025-08-24 16:12:18'),
(54, 'a', 1, '2025-08-24 16:12:23'),
(57, 'ga', 1, '2025-08-24 19:03:19'),
(59, 'ei', 9, '2025-08-26 01:46:46'),
(62, 'ee', 1, '2025-08-25 12:39:30'),
(70, 'plava', 2, '2025-08-25 20:45:01'),
(77, 'Plav', 1, '2025-08-25 20:54:48'),
(79, 'pl', 3, '2025-08-25 23:33:31'),
(81, 'ch', 2, '2025-08-25 22:30:15'),
(82, 'f', 3, '2025-08-25 21:24:02'),
(83, 'Fo', 2, '2025-08-25 21:13:22'),
(85, 'P', 3, '2025-08-25 23:34:01'),
(92, 'se', 2, '2025-08-25 22:30:10'),
(96, 'eiffe', 1, '2025-08-25 21:14:12'),
(100, 'U', 1, '2025-08-25 21:23:59'),
(103, 'es', 1, '2025-08-25 22:02:47'),
(105, 'pla', 1, '2025-08-25 22:20:24'),
(106, 'g', 1, '2025-08-25 22:20:33'),
(111, 'ae', 1, '2025-08-25 22:30:13'),
(114, 'ei===', 1, '2025-08-25 22:38:25'),
(118, 'Wu', 1, '2025-08-25 23:52:37'),
(119, 'hh', 1, '2025-08-26 00:40:28'),
(120, 'h', 1, '2025-08-26 00:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `tour_id` int NOT NULL,
  `user_id` int NOT NULL,
  `tour_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`tour_id`, `user_id`, `tour_name`, `created_at`) VALUES
(47, 17, 'Brazil Tour', '2025-08-26 02:41:46'),
(48, 17, 'kkk', '2025-08-26 02:41:52'),
(49, 2, 'Brazil Tour', '2025-08-26 03:47:24'),
(50, 2, 'France Tour', '2025-08-26 03:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `tour_attractions`
--

CREATE TABLE `tour_attractions` (
  `tour_id` int NOT NULL,
  `attraction_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour_attractions`
--

INSERT INTO `tour_attractions` (`tour_id`, `attraction_id`) VALUES
(47, 623),
(49, 623),
(50, 12343),
(47, 78468),
(50, 78468);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','agency','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_confirmed` int NOT NULL DEFAULT '0',
  `banned` tinyint(1) DEFAULT '0',
  `attractions_enabled` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `role`, `created_at`, `is_confirmed`, `banned`, `attractions_enabled`) VALUES
(1, 'aaa', 'asgsag', 'david@gmail.com', '$2y$10$JfYz0JFHA6TbROpuDlpwJuUW8rtEAyBjKx3cJIZV6EtDnSvSoZ5xu', 'user', '2025-06-09 22:18:48', 1, 1, 1),
(2, 'David', '132', 'd@d.d', '$2y$10$AvMHvgcL41uiseyQ.sgZVOYS8orDyi6dB3FHW6hOZcwWZwQVYAlwS', 'admin', '2025-06-10 19:42:31', 1, 0, 1),
(3, 'string', 'string', 'user@example.com', '$2y$10$Zt2/3o7BSvEl4qmXXIo0Fu0PtvtDEEBxyQNbrOXvhkbHIvTbk5nNm', 'user', '2025-06-12 16:43:50', 1, 0, 1),
(4, 'Peter', 'Parker', 'c@c.c', '$2y$10$/gDIFbWTkbBfbIOmBTJ9F.Le3D3Q9VVkB9sH7riz7GiQbY0uSSGHO', 'agency', '2025-07-08 21:38:25', 1, 0, 1),
(13, 'ff@ff.ff', '123', 'ff@1f.ff', '$2y$10$e6H71xHWxhQvQexIPzPBPeB2N2d3OiaT5xiT2HxQN0iONbxIOw4yK', 'agency', '2025-07-08 21:47:28', 1, 0, 1),
(17, 'David', 'Simokovic', 'davidsimokovicvtssu@gmail.co', '$2y$10$IwqsBpPjPzLcfn0F24RGqOcvd1Nc6yvcXaG17YwltYF8pSjqcLM4q', 'user', '2025-07-08 23:08:44', 1, 0, 1),
(18, 'David', 'asgsag', 'a@a.a', '$2y$10$lKCIbihAo8ldru56upwKQOMu2zvpHtH2GSODo5LcrwJ2HQPdZdbH.', 'user', '2025-08-20 14:59:10', 0, 0, 1),
(20, 'Agencija Za Putovanja', '', 'la@hw.com', '$2y$10$JDNASQe8wcipLs/cA7Rc7.USseEI1P69/HwMaNCaojQwzn5ihPzSu', 'agency', '2025-08-20 21:57:04', 1, 0, 1),
(21, 'Agencija Coca-Cola', '', '2@2.2', '$2y$10$sN8L70Nx.4YS0/QmRI6i/e1uPG.Ckk20kalfzH1gxz1iPf0z7sPq2', 'agency', '2025-08-23 17:29:37', 1, 0, 1),
(22, 'David', 'asgsag', 'davidsimokovic13@gmail.com', '$2y$10$BJlOZLEaVa0zgBwVKbnJ2OAjJrutSURe/MwAYfkRVDx6yD2xAe0P2', 'admin', '2025-08-23 23:49:59', 1, 0, 1),
(23, 'Da', 'DA', 'f@f.f', '$2y$10$U96g5igck08VZ1OjeZjIh.CNvAXW7jXSCzfw751IsneNzFCbPg8Hu', 'user', '2025-08-24 17:57:54', 0, 0, 1),
(25, 'David', 'Simokovic', 'davidsimokovicvtssu@gmail.com', '$2y$10$N.bS/2fMNbSMUfiU9dP6neUIJIv..ljMViMEZf6Yi3YZflipBm.sO', 'user', '2025-08-26 01:37:51', 1, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`attraction_id`),
  ADD KEY `fk_attractions_city` (`city_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `fk_country` (`country_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attraction_id` (`attraction_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `country_name` (`country_name`);

--
-- Indexes for table `device_logs`
--
ALTER TABLE `device_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `search_logs`
--
ALTER TABLE `search_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `term` (`term`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tour_attractions`
--
ALTER TABLE `tour_attractions`
  ADD PRIMARY KEY (`tour_id`,`attraction_id`),
  ADD KEY `attraction_id` (`attraction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `attraction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78474;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2642;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11131;

--
-- AUTO_INCREMENT for table `device_logs`
--
ALTER TABLE `device_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  MODIFY `token_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `search_logs`
--
ALTER TABLE `search_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attractions`
--
ALTER TABLE `attractions`
  ADD CONSTRAINT `fk_attractions_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`attraction_id`) REFERENCES `attractions` (`attraction_id`) ON DELETE CASCADE;

--
-- Constraints for table `email_verification_tokens`
--
ALTER TABLE `email_verification_tokens`
  ADD CONSTRAINT `email_verification_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tour_attractions`
--
ALTER TABLE `tour_attractions`
  ADD CONSTRAINT `tour_attractions_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`tour_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_attractions_ibfk_2` FOREIGN KEY (`attraction_id`) REFERENCES `attractions` (`attraction_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 19, 2019 at 11:58 AM
-- Server version: 5.7.11-log
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cources`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(8) NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(250) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_finish` datetime DEFAULT NULL,
  `price` int(6) DEFAULT NULL,
  `direction` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `date_start`, `date_finish`, `price`, `direction`) VALUES
(1, 'PHP9', 'Nice php course', '2019-02-06 00:00:00', '2019-06-21 00:00:00', 300, 'php'),
(2, 'Frontend', 'Frontend cource (html, js, css)', '2018-03-12 00:00:00', '2019-03-09 00:00:00', 500, 'php'),
(3, 'Fs', 'Full stack development cource', NULL, NULL, 100, 'fs'),
(4, 'English1', 'English intermediate', NULL, NULL, 3500, 'english'),
(5, 'Php1', 'First php course', NULL, NULL, 0, 'php'),
(6, 'Php333', '2nd php course33', '2019-03-29 00:00:00', '2019-03-31 00:00:00', 55000, 'php33'),
(7, 'php3', '3rd php course', NULL, NULL, NULL, 'php'),
(8, 'Php5', '5 php course', NULL, NULL, 0, 'php'),
(9, 'php6', '6 php course', NULL, NULL, NULL, 'php'),
(10, 'fe1', 'frontend1', NULL, NULL, NULL, 'front end'),
(12, 'FE2', 'Frontend2', '2019-03-11 00:00:00', '2019-07-11 00:00:00', 100000, 'front end'),
(13, 'Python', 'Python course', NULL, NULL, 10000, 'machine learning'),
(14, 'HTML', ' новый курс', NULL, NULL, 0, 'FE'),
(15, 'Adsfa', 'Sadads', NULL, NULL, 322, 'asda'),
(16, 'Linux', 'OS Linux course', NULL, NULL, 0, 'OS');

-- --------------------------------------------------------

--
-- Table structure for table `course_room`
--

CREATE TABLE `course_room` (
  `id` int(8) NOT NULL,
  `course_id` int(2) DEFAULT NULL,
  `room_id` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course_room`
--

INSERT INTO `course_room` (`id`, `course_id`, `room_id`) VALUES
(1, 1, 3),
(2, 12, 1),
(3, 8, 5),
(4, 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `start`, `duration`) VALUES
(1, NULL, NULL, NULL),
(2, 2, '2019-03-10 15:00:00', '02:00:00'),
(3, NULL, NULL, NULL),
(4, 3, '2019-03-11 12:30:00', '04:00:00'),
(5, 16, NULL, NULL),
(6, 3, NULL, NULL),
(7, 8, NULL, NULL),
(8, 1, '2019-03-20 20:30:00', '04:00:00'),
(9, NULL, NULL, NULL),
(10, NULL, NULL, NULL),
(11, NULL, NULL, NULL),
(12, NULL, NULL, NULL),
(13, NULL, NULL, NULL),
(14, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(3) NOT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`) VALUES
(1, 'blue'),
(2, 'red'),
(3, 'green'),
(4, NULL),
(5, 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(8) NOT NULL,
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `birthday` datetime DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `birthday`, `email`, `phone`) VALUES
(1, 'Ivan', 'Ivanov', '2011-03-30 00:00:00', '', '099 999 66 77'),
(2, 'Petr', 'Petrov', '2000-02-16 00:00:00', 'asa@mail.ru', '055 225 55 551'),
(4, 'Anton', 'Antonov', '2019-02-09 00:00:00', 'anton@gmail.ua', '6666666667'),
(5, 'Petr', 'Petrov', '1986-01-08 00:00:00', 'petr@gmail.ua', '3333333322'),
(6, 'Dmitry', 'Dmitriev', NULL, 'dima@gmail.ua', NULL),
(7, 'Ivan', 'Ivanov', NULL, 'ivan@gmail.ua', NULL),
(8, 'Ivan', 'Иванов', '1998-09-30 00:00:00', 'sidor2@gmail.com', '9999999999'),
(9, 'Petr', '', '2010-02-10 00:00:00', 'sidor2@gmail.com', '095 382 37 75'),
(10, 'Сидор', 'пушкин', NULL, '', '33333344'),
(11, 'Anton', '', NULL, '', ''),
(12, 'Petr', '', NULL, NULL, NULL),
(13, 'Dmitry', '', NULL, '', '555'),
(14, 'Ivan', '', NULL, NULL, NULL),
(15, 'Ivan', 'Ivanov', NULL, NULL, NULL),
(16, 'Petr', 'Petrov', NULL, NULL, NULL),
(17, 'Сидор', 'Сидоров', NULL, NULL, NULL),
(18, 'Anton', 'Antonov', '2019-02-15 00:00:00', 'sidor@gmail.com', '33 3333 33'),
(19, 'Petr', 'Petrov', NULL, NULL, NULL),
(20, 'Dmitry', 'Dmitriev', NULL, NULL, NULL),
(21, 'Ivan', 'Ivanov', NULL, NULL, NULL),
(22, 'Ivan', '', NULL, NULL, NULL),
(23, 'Petr', '', NULL, '', ''),
(24, 'Сидор', '', NULL, NULL, NULL),
(25, 'Anton', '', NULL, NULL, NULL),
(26, 'Petr', '', NULL, NULL, NULL),
(27, 'Dmitry', '', NULL, NULL, NULL),
(28, 'Ivan', '', NULL, NULL, NULL),
(30, 'Ivan', 'Ivanov', NULL, NULL, '055 555 55 55'),
(31, 'Petr', 'Petrov', NULL, NULL, '055 225 55 55'),
(32, 'Сидор', 'Сидоров', NULL, 'sidor@gmail.com', '0552253335'),
(33, 'Anton', 'Antonov', NULL, 'anton@gmail.ua', NULL),
(34, 'Petr', 'Petrov', NULL, 'petr@gmail.ua', NULL),
(35, 'Dmitry', 'Dmitriev', NULL, 'dima@gmail.ua', ''),
(36, 'Ivan', 'Ivanov', NULL, 'ivan@gmail.ua', NULL),
(37, 'Ivan', '', NULL, NULL, NULL),
(38, 'Petr', '', NULL, NULL, NULL),
(39, 'Сидор', '', NULL, NULL, NULL),
(40, 'Anton', '', NULL, NULL, NULL),
(41, 'Petr', '', NULL, NULL, NULL),
(42, 'Dmitry', '', NULL, '', ''),
(43, 'Ivan', '', NULL, '', ''),
(44, 'Ivan', 'Ivanov', NULL, NULL, NULL),
(45, 'Petr', 'Petrov', '1982-02-25 00:00:00', '', 'xzxzX'),
(46, 'Сидор', 'Сидоров', NULL, NULL, NULL),
(47, 'Anton', 'Antonov', NULL, NULL, NULL),
(48, 'Petr', 'Petrov', NULL, NULL, NULL),
(49, 'Dmitry', 'Dmitriev', NULL, NULL, NULL),
(50, 'Ivan', 'Ivanov', NULL, NULL, NULL),
(51, 'Ivan', 'Порошенко', '2019-03-14 00:00:00', '', ''),
(52, 'Петро', 'Трамп', NULL, 'patrasa@mail.ru', ''),
(53, 'Сидор', '', NULL, NULL, NULL),
(54, 'Anton', '', NULL, NULL, NULL),
(55, 'Petr', '', NULL, NULL, NULL),
(56, 'Dmitry', '', NULL, NULL, NULL),
(57, 'Ivan', '', NULL, NULL, NULL),
(58, '', '', NULL, NULL, NULL),
(59, '', '', NULL, NULL, NULL),
(60, '', '', NULL, NULL, NULL),
(61, '', '', NULL, NULL, NULL),
(62, '', '', NULL, NULL, NULL),
(63, '', '', NULL, NULL, NULL),
(64, '', '', NULL, NULL, NULL),
(65, '', '', NULL, NULL, NULL),
(66, '', '', NULL, NULL, NULL),
(67, '', '', NULL, NULL, NULL),
(68, '', '', NULL, NULL, NULL),
(69, '', '', NULL, NULL, NULL),
(70, '', '', NULL, NULL, NULL),
(71, '', '', NULL, NULL, NULL),
(72, '', '', NULL, NULL, NULL),
(73, '', '', NULL, NULL, NULL),
(74, '', '', NULL, NULL, NULL),
(75, '', '', NULL, NULL, NULL),
(76, '', '', NULL, NULL, NULL),
(77, '', '', NULL, NULL, NULL),
(78, '', '', NULL, NULL, NULL),
(79, '', '', NULL, NULL, NULL),
(80, '', '', NULL, NULL, NULL),
(81, '', '', NULL, NULL, NULL),
(82, 'Ануфрий', 'Никодимов', '2005-07-15 00:00:00', 'anuf@ukr.net', '066 123 45 67'),
(83, 'Dimon', 'DMitro', NULL, '', ''),
(84, 'Никита', 'Никитенко', '2014-03-04 00:00:00', '', ''),
(85, '', '', NULL, NULL, NULL),
(86, 'Джон', 'Уик', NULL, '', ''),
(87, 'Джек', 'Лермонтов', '2014-03-07 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE `student_course` (
  `id` int(4) NOT NULL,
  `student_id` int(8) DEFAULT NULL,
  `course_id` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `student_id`, `course_id`) VALUES
(3, 2, 4),
(160, 1, 4),
(164, 10, 1),
(167, 51, 9),
(168, 23, 7),
(170, 35, 3),
(171, 52, 3),
(172, 52, 10),
(173, 52, 12),
(174, 42, 7),
(175, 42, 8),
(177, 43, 6),
(179, 43, 6),
(180, 82, 1),
(181, 82, 2),
(183, 2, 2),
(184, 11, 8),
(185, 9, 2),
(186, 9, 3),
(187, 9, 4),
(189, 9, 6),
(190, 9, 7),
(191, 9, 8),
(192, 9, 9),
(193, 9, 10),
(194, 9, 12),
(195, 1, 4),
(198, 1, 4),
(199, 1, 12),
(200, 1, 12),
(201, 2, 2),
(203, 9, 2),
(204, 9, 2),
(206, 82, 2),
(210, 2, 2),
(211, 2, 2),
(212, 9, 2),
(213, 9, 2),
(214, 82, 2),
(215, 82, 2),
(216, 2, 2),
(217, 2, 2),
(218, 2, 2),
(220, 9, 2),
(221, 9, 2),
(222, 82, 2),
(223, 82, 2),
(224, 82, 2),
(228, 2, 2),
(229, 2, 2),
(230, 9, 2),
(231, 9, 2),
(232, 82, 2),
(233, 82, 2),
(234, 2, 2),
(235, 2, 2),
(236, 2, 2),
(237, 9, 2),
(238, 9, 2),
(239, 9, 2),
(240, 82, 2),
(241, 82, 2),
(242, 82, 2),
(243, 2, 2),
(244, 2, 2),
(245, 9, 2),
(246, 9, 2),
(247, 82, 2),
(248, 82, 2),
(254, 1, 1),
(259, 2, 1),
(265, 9, 1),
(274, 18, 1),
(291, 1, 4),
(292, 1, 4),
(293, 2, 4),
(294, 2, 4),
(295, 9, 4),
(296, 9, 4),
(297, 1, 6),
(298, 1, 6),
(299, 2, 6),
(300, 2, 6),
(301, 4, 6),
(302, 4, 6),
(303, 9, 6),
(304, 19, 6),
(305, 19, 6),
(306, 23, 6),
(307, 23, 6),
(308, 24, 6),
(309, 24, 6),
(310, 43, 6),
(311, 1, 6),
(312, 1, 6),
(313, 1, 6),
(314, 1, 6),
(315, 1, 6),
(316, 1, 6),
(317, 1, 6),
(318, 2, 6),
(319, 2, 6),
(320, 2, 6),
(321, 2, 6),
(322, 2, 6),
(323, 2, 6),
(324, 2, 6),
(325, 4, 6),
(326, 4, 6),
(327, 4, 6),
(328, 4, 6),
(329, 4, 6),
(330, 4, 6),
(331, 4, 6),
(332, 9, 6),
(333, 9, 6),
(334, 9, 6),
(335, 9, 6),
(336, 9, 6),
(337, 9, 6),
(338, 9, 6),
(339, 19, 6),
(340, 19, 6),
(341, 19, 6),
(342, 19, 6),
(343, 19, 6),
(344, 19, 6),
(345, 19, 6),
(346, 23, 6),
(347, 23, 6),
(348, 23, 6),
(349, 23, 6),
(350, 23, 6),
(351, 23, 6),
(352, 23, 6),
(353, 24, 6),
(354, 24, 6),
(355, 24, 6),
(356, 24, 6),
(357, 24, 6),
(358, 24, 6),
(359, 24, 6),
(360, 43, 6),
(361, 43, 6),
(362, 43, 6),
(363, 43, 6),
(364, 43, 6),
(365, 43, 6),
(366, 43, 6),
(367, 1, 6),
(368, 1, 6),
(369, 1, 6),
(370, 1, 6),
(371, 1, 6),
(372, 1, 6),
(373, 1, 6),
(374, 2, 6),
(375, 2, 6),
(376, 2, 6),
(377, 2, 6),
(378, 2, 6),
(379, 2, 6),
(380, 2, 6),
(381, 4, 6),
(382, 4, 6),
(383, 4, 6),
(384, 4, 6),
(385, 4, 6),
(386, 4, 6),
(387, 4, 6),
(388, 9, 6),
(389, 9, 6),
(390, 9, 6),
(391, 9, 6),
(392, 9, 6),
(393, 9, 6),
(394, 9, 6),
(395, 19, 6),
(396, 19, 6),
(397, 19, 6),
(398, 19, 6),
(399, 19, 6),
(400, 19, 6),
(401, 19, 6),
(402, 23, 6),
(403, 23, 6),
(404, 23, 6),
(405, 23, 6),
(406, 23, 6),
(407, 23, 6),
(408, 23, 6),
(409, 24, 6),
(410, 24, 6),
(411, 24, 6),
(412, 24, 6),
(413, 24, 6),
(414, 24, 6),
(415, 24, 6),
(416, 43, 6),
(417, 43, 6),
(418, 43, 6),
(419, 43, 6),
(420, 43, 6),
(421, 43, 6),
(422, 43, 6),
(423, 13, 2),
(424, 83, 1),
(425, 83, 4),
(426, 83, 8),
(430, 10, 7),
(431, 10, 7),
(432, 84, 1),
(695, 5, 5),
(696, 5, 5),
(697, 5, 5),
(702, 5, 5),
(703, 5, 5),
(708, 5, 5),
(709, 5, 5),
(714, 5, 5),
(715, 5, 5),
(720, 4, 5),
(721, 4, 5),
(722, 4, 5),
(723, 5, 5),
(724, 5, 5),
(731, 4, 5),
(732, 4, 5),
(733, 4, 5),
(734, 5, 5),
(735, 5, 5),
(736, 5, 5),
(743, 4, 5),
(744, 4, 5),
(745, 4, 5),
(746, 5, 5),
(747, 5, 5),
(748, 5, 5),
(755, 4, 5),
(756, 4, 5),
(757, 4, 5),
(758, 5, 5),
(759, 5, 5),
(760, 5, 5),
(767, 4, 5),
(768, 4, 5),
(769, 4, 5),
(770, 5, 5),
(771, 5, 5),
(772, 5, 5),
(779, 4, 5),
(780, 4, 5),
(781, 4, 5),
(782, 5, 5),
(783, 5, 5),
(784, 5, 5),
(788, 4, 5),
(789, 4, 5),
(790, 4, 5),
(791, 5, 5),
(792, 5, 5),
(793, 5, 5),
(796, 4, 5),
(797, 4, 5),
(798, 5, 5),
(799, 5, 5),
(802, 4, 5),
(803, 4, 5),
(804, 5, 5),
(805, 5, 5),
(808, 4, 5),
(809, 4, 5),
(810, 5, 5),
(811, 5, 5),
(814, 4, 5),
(815, 4, 5),
(816, 5, 5),
(817, 5, 5),
(820, 4, 5),
(821, 4, 5),
(822, 5, 5),
(823, 5, 5),
(826, 4, 5),
(827, 4, 5),
(828, 5, 5),
(829, 5, 5),
(832, 4, 5),
(833, 4, 5),
(834, 5, 5),
(835, 5, 5),
(836, 1, 5),
(837, 1, 5),
(838, 1, 5),
(839, 4, 5),
(840, 4, 5),
(841, 5, 5),
(842, 5, 5),
(843, 2, 2),
(844, 2, 2),
(845, 2, 2),
(846, 9, 2),
(847, 9, 2),
(848, 9, 2),
(849, 13, 2),
(850, 13, 2),
(851, 13, 2),
(852, 79, 2),
(853, 79, 2),
(854, 79, 2),
(855, 79, 2),
(856, 80, 2),
(857, 80, 2),
(858, 80, 2),
(859, 80, 2),
(860, 81, 2),
(861, 81, 2),
(862, 81, 2),
(863, 81, 2),
(864, 82, 2),
(865, 82, 2),
(866, 82, 2),
(867, 83, 2),
(868, 83, 2),
(869, 83, 2),
(870, 83, 2),
(871, 84, 2),
(872, 84, 2),
(873, 84, 2),
(874, 84, 2),
(875, 1, 13),
(876, 82, 14),
(877, 83, 14),
(878, 84, 14),
(879, 86, 1),
(880, 45, 2),
(881, 35, 15),
(882, 86, 15),
(883, 35, 15),
(884, 86, 15),
(885, 1, 12),
(886, 1, 12),
(887, 9, 12),
(888, 9, 12),
(889, 52, 12),
(890, 52, 12),
(891, 1, 1),
(892, 1, 1),
(893, 1, 1),
(894, 1, 1),
(895, 1, 1),
(896, 1, 1),
(897, 1, 1),
(898, 1, 1),
(899, 2, 1),
(900, 2, 1),
(901, 2, 1),
(902, 2, 1),
(903, 2, 1),
(904, 2, 1),
(905, 2, 1),
(906, 2, 1),
(907, 9, 1),
(908, 9, 1),
(909, 9, 1),
(910, 9, 1),
(911, 9, 1),
(912, 9, 1),
(913, 9, 1),
(914, 9, 1),
(915, 10, 1),
(916, 10, 1),
(917, 10, 1),
(918, 10, 1),
(919, 10, 1),
(920, 10, 1),
(921, 10, 1),
(922, 10, 1),
(923, 18, 1),
(924, 18, 1),
(925, 18, 1),
(926, 18, 1),
(927, 18, 1),
(928, 18, 1),
(929, 18, 1),
(930, 18, 1),
(931, 82, 1),
(932, 82, 1),
(933, 82, 1),
(934, 82, 1),
(935, 82, 1),
(936, 82, 1),
(937, 82, 1),
(938, 82, 1),
(939, 83, 1),
(940, 83, 1),
(941, 83, 1),
(942, 83, 1),
(943, 83, 1),
(944, 83, 1),
(945, 83, 1),
(946, 83, 1),
(947, 84, 1),
(948, 84, 1),
(949, 84, 1),
(950, 84, 1),
(951, 84, 1),
(952, 84, 1),
(953, 84, 1),
(954, 84, 1),
(955, 86, 1),
(956, 86, 1),
(957, 86, 1),
(958, 86, 1),
(959, 86, 1),
(960, 86, 1),
(961, 86, 1),
(962, 86, 1),
(963, 1, 1),
(964, 1, 1),
(965, 1, 1),
(966, 1, 1),
(967, 1, 1),
(968, 1, 1),
(969, 1, 1),
(970, 1, 1),
(971, 2, 1),
(972, 2, 1),
(973, 2, 1),
(974, 2, 1),
(975, 2, 1),
(976, 2, 1),
(977, 2, 1),
(978, 2, 1),
(979, 9, 1),
(980, 9, 1),
(981, 9, 1),
(982, 9, 1),
(983, 9, 1),
(984, 9, 1),
(985, 9, 1),
(986, 9, 1),
(987, 10, 1),
(988, 10, 1),
(989, 10, 1),
(990, 10, 1),
(991, 10, 1),
(992, 10, 1),
(993, 10, 1),
(994, 10, 1),
(995, 18, 1),
(996, 18, 1),
(997, 18, 1),
(998, 18, 1),
(999, 18, 1),
(1000, 18, 1),
(1001, 18, 1),
(1002, 18, 1),
(1003, 82, 1),
(1004, 82, 1),
(1005, 82, 1),
(1006, 82, 1),
(1007, 82, 1),
(1008, 82, 1),
(1009, 82, 1),
(1010, 82, 1),
(1011, 83, 1),
(1012, 83, 1),
(1013, 83, 1),
(1014, 83, 1),
(1015, 83, 1),
(1016, 83, 1),
(1017, 83, 1),
(1018, 83, 1),
(1019, 84, 1),
(1020, 84, 1),
(1021, 84, 1),
(1022, 84, 1),
(1023, 84, 1),
(1024, 84, 1),
(1025, 84, 1),
(1026, 84, 1),
(1027, 86, 1),
(1028, 86, 1),
(1029, 86, 1),
(1030, 86, 1),
(1031, 86, 1),
(1032, 86, 1),
(1033, 86, 1),
(1034, 86, 1),
(1035, 1, 12),
(1036, 1, 12),
(1037, 9, 12),
(1038, 9, 12),
(1039, 52, 12),
(1040, 52, 12),
(1041, 1, 12),
(1042, 1, 12),
(1043, 2, 12),
(1044, 2, 12),
(1045, 2, 12),
(1046, 4, 12),
(1047, 4, 12),
(1048, 4, 12),
(1049, 5, 12),
(1050, 5, 12),
(1051, 5, 12),
(1052, 6, 12),
(1053, 6, 12),
(1054, 6, 12),
(1055, 7, 12),
(1056, 7, 12),
(1057, 7, 12),
(1058, 8, 12),
(1059, 8, 12),
(1060, 8, 12),
(1061, 9, 12),
(1062, 9, 12),
(1063, 10, 12),
(1064, 10, 12),
(1065, 10, 12),
(1066, 11, 12),
(1067, 11, 12),
(1068, 11, 12),
(1069, 12, 12),
(1070, 12, 12),
(1071, 12, 12),
(1072, 52, 12),
(1073, 52, 12),
(1074, 82, 12),
(1075, 82, 12),
(1076, 82, 12),
(1077, 83, 12),
(1078, 83, 12),
(1079, 83, 12),
(1080, 84, 12),
(1081, 84, 12),
(1082, 84, 12),
(1083, 85, 12),
(1084, 85, 12),
(1085, 85, 12),
(1086, 86, 12),
(1087, 86, 12),
(1088, 86, 12),
(1089, 9, 8),
(1090, 9, 8),
(1091, 9, 8),
(1092, 11, 8),
(1093, 11, 8),
(1094, 11, 8),
(1095, 42, 8),
(1096, 42, 8),
(1097, 42, 8),
(1098, 83, 8),
(1099, 83, 8),
(1100, 83, 8),
(1101, 57, 16),
(1102, 87, 1),
(1103, 9, 8),
(1104, 9, 8),
(1105, 9, 8),
(1106, 11, 8),
(1107, 11, 8),
(1108, 11, 8),
(1109, 42, 8),
(1110, 42, 8),
(1111, 42, 8),
(1112, 83, 8),
(1113, 83, 8),
(1114, 83, 8),
(1115, 9, 8),
(1116, 9, 8),
(1117, 9, 8),
(1118, 11, 8),
(1119, 11, 8),
(1120, 11, 8),
(1121, 42, 8),
(1122, 42, 8),
(1123, 42, 8),
(1124, 83, 8),
(1125, 83, 8),
(1126, 83, 8);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(8) NOT NULL,
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `birthday` datetime DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `last_name`, `birthday`, `email`, `phone`) VALUES
(1, 'Данил', 'М', NULL, '', ''),
(2, 'Джон', 'Макаренко', NULL, '', '099 999 88 77'),
(3, 'Гейтс', 'Бил', NULL, '', '555 55 55');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_course`
--

CREATE TABLE `teacher_course` (
  `id` int(8) NOT NULL,
  `teacher_id` int(8) DEFAULT NULL,
  `course_id` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher_course`
--

INSERT INTO `teacher_course` (`id`, `teacher_id`, `course_id`) VALUES
(2, 1, 3),
(3, 1, 4),
(11, 1, 5),
(13, 1, 5),
(14, 1, 2),
(15, 3, 2),
(16, 3, 12),
(17, 3, 13),
(18, 2, 1),
(19, 2, 13),
(20, 1, 14),
(21, 1, 12),
(22, 2, 12),
(23, 3, 8),
(24, 3, 16),
(25, 1, 8),
(26, 2, 8),
(27, 1, 8),
(28, 1, 8),
(29, 2, 8),
(30, 2, 8),
(31, 3, 8),
(32, 3, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_course_id` (`id`) USING BTREE;

--
-- Indexes for table `course_room`
--
ALTER TABLE `course_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_room_id` (`room_id`) USING BTREE,
  ADD KEY `fk_course_id` (`course_id`) USING BTREE;

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_room_id` (`id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_course`
--
ALTER TABLE `student_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id` (`student_id`),
  ADD KEY `fk_student_course_course_id` (`course_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `course_room`
--
ALTER TABLE `course_room`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `student_course`
--
ALTER TABLE `student_course`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1127;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher_course`
--
ALTER TABLE `teacher_course`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_room`
--
ALTER TABLE `course_room`
  ADD CONSTRAINT `course_room_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_course_room_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_course_room_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `fk_student_course_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

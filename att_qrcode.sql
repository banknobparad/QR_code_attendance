-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2024 at 11:59 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `att_qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `branch`, `created_at`, `updated_at`) VALUES
(1, 'สาขาวิทยาการคอมพิวเตอร์', '1', NULL, NULL),
(2, 'สาขาเทคโนโลยีสารสนเทศ', '2', NULL, NULL),
(3, 'สาขาเทคโนโลยีเครือข่ายคอมพิวเตอร์', '3', NULL, NULL),
(4, 'สาขาภูมิสารสนเทศ', '4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_03_13_163646_create_years_table', 1),
(7, '2024_03_13_163702_create_branches_table', 1),
(8, '2024_03_13_163712_create_subjects_table', 1),
(11, '2024_03_14_110606_create_subject_stus_table', 2),
(14, '2024_03_15_074158_create_stu_lists_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stu_lists`
--

CREATE TABLE `stu_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` varchar(255) DEFAULT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stu_lists`
--

INSERT INTO `stu_lists` (`id`, `teacher_id`, `student_id`, `name`, `created_at`, `updated_at`) VALUES
(28, '1', '6314631011', 'ภาวิณี ลีลาภรณ์', '2024-03-15 02:38:41', '2024-03-15 02:38:41'),
(29, '1', '6314631012', 'อรรถพล ภักดีกุล', '2024-03-15 02:38:41', '2024-03-15 02:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) DEFAULT NULL,
  `subject_id` varchar(255) DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `teacher_id`, `subject_id`, `subject_name`, `created_at`, `updated_at`) VALUES
(16, 2, '123', 'asdf', '2024-03-15 02:51:50', '2024-03-15 02:51:50'),
(17, 2, '23432', 'dsdfsd', '2024-03-15 02:52:21', '2024-03-15 02:52:21'),
(18, 2, '2344', 'sdfs', '2024-03-15 02:53:58', '2024-03-15 02:53:58'),
(19, 2, '2343222', 'sdfdf', '2024-03-15 02:54:47', '2024-03-15 02:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `subject_stus`
--

CREATE TABLE `subject_stus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) DEFAULT NULL,
  `subject_id` varchar(255) DEFAULT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_stus`
--

INSERT INTO `subject_stus` (`id`, `teacher_id`, `subject_id`, `student_id`, `name`, `created_at`, `updated_at`) VALUES
(59, 2, '2343222', '6314631010', 'กิตติพงษ์ บุญจันทร์', '2024-03-15 02:54:47', '2024-03-15 02:54:47'),
(60, 2, '2343222', '6314631013', 'ภคินี ภักดีรักษ์', '2024-03-15 02:54:47', '2024-03-15 02:54:47'),
(61, 2, '2343222', '6314631014', 'ณัฐวุฒิ ศิริโชค', '2024-03-15 02:54:47', '2024-03-15 02:54:47'),
(62, 2, '2343222', '6314631015', 'ณัฐภัสสร จันทร์ประดับ', '2024-03-15 02:54:47', '2024-03-15 02:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `year_id` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Teacher','Student') NOT NULL DEFAULT 'Student',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `student_id`, `branch_id`, `year_id`, `phone_number`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, NULL, NULL, NULL, 'administrator@gmail.com', '2024-03-13 22:51:12', '$2y$10$iKZAOROjuGhMxJYUzBCBcuua/RkEuFh5Do/SrXL1GqPHkCmCcX7Gq', 'Administrator', NULL, '2024-03-13 22:51:12', '2024-03-13 22:51:12'),
(2, 'Teacher', NULL, NULL, NULL, NULL, 'teacher@gmail.com', '2024-03-13 22:51:12', '$2y$10$UPBN/scB2ojJuQmBY5WZjOUqX/KcKbq2WtskmTCcEHD1Uj.u0rpqy', 'Teacher', NULL, '2024-03-13 22:51:12', '2024-03-13 22:51:12'),
(3, 'test', '1234627890', '1', '1', '1233367890', 'user1@user.com', '2024-03-13 22:51:37', '$2y$10$B2VFVQapfEPZ7R7Xrn/rrORZiEY.LrvjWn9iW7BWJAHcVKC0kXUjq', 'Student', NULL, '2024-03-13 22:51:37', '2024-03-13 22:51:37'),
(4, 'Autumn Towne', '8207188908', '4', '3', '4156741740', 'marilyne.purdy@example.com', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'H156TBxF7j', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(5, 'Ms. Terry', '2459709380', '3', '1', '6167835951', 'boyle.lonie@example.org', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'VUptNnjExX', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(6, 'Elvis Gutkowski', '1167305548', '3', '2', '6453358411', 'aida61@example.com', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', '3oxi4OmNlL', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(7, 'Dr. I', '4733203710', '1', '3', '4462712059', 'thompson.jerod@example.com', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'gPs6fzQyjv', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(8, 'Delta Wisozk', '8400086171', '3', '3', '5945651176', 'bode.dejon@example.net', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', '7Hlv6tzr7K', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(9, 'Miss Klocko', '1841624473', '2', '1', '1063796607', 'rath.rosamond@example.net', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'XdYyyyv5ed', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(10, 'Mr. DVM', '4845695475', '3', '3', '7576567955', 'angelita.gaylord@example.com', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'lEm1LLddQy', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(11, 'Carolina Buckridge', '6478501375', '1', '3', '9613694329', 'pfeest@example.net', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'knrI5cSz9Y', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(12, 'Jayne Kub', '5592332842', '4', '3', '5407677326', 'emiliano.von@example.com', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'zSlxGBoV9I', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(13, 'Antwan Jr.', '9575829439', '4', '4', '1607489497', 'ahudson@example.com', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'q110RoGaX3', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(14, 'Prof. Padberg', '2649624337', '2', '1', '2934495406', 'bnienow@example.org', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', '2NdL6fzjwi', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(15, 'Kara Williamson', '8887036200', '2', '2', '9463584705', 'ahmad.mante@example.org', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', 'XePZTzKXHd', '2024-03-15 03:42:37', '2024-03-15 03:42:37'),
(16, 'Faustino Lockman', '7566747787', '1', '1', '8835049059', 'richmond.lemke@example.net', '2024-03-15 03:42:37', '$2y$10$rq.fkeipaXhro/Oza5uD/uiCeX18WccQ3HUETrgskgzmczaVDj7s6', 'Student', '4wvoko7KkG', '2024-03-15 03:42:37', '2024-03-15 03:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `name`, `year`, `created_at`, `updated_at`) VALUES
(1, 'นักศึกษาชั้นปีที่ 1', '1', NULL, NULL),
(2, 'นักศึกษาชั้นปีที่ 2', '2', NULL, NULL),
(3, 'นักศึกษาชั้นปีที่ 3', '3', NULL, NULL),
(4, 'นักศึกษาชั้นปีที่ 4', '4', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_branch_unique` (`branch`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `stu_lists`
--
ALTER TABLE `stu_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stu_lists_student_id_unique` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_subject_id_unique` (`subject_id`);

--
-- Indexes for table `subject_stus`
--
ALTER TABLE `subject_stus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_stus_student_id_unique` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_student_id_unique` (`student_id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `years_year_unique` (`year`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stu_lists`
--
ALTER TABLE `stu_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subject_stus`
--
ALTER TABLE `subject_stus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

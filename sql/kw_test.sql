-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 24 Feb 2019 pada 12.59
-- Versi server: 10.1.30-MariaDB
-- Versi PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kw_test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `checklists`
--

CREATE TABLE `checklists` (
  `id` int(10) UNSIGNED NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `object_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `object_domain` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_completed` tinyint(1) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `urgency` int(11) DEFAULT NULL,
  `due` datetime DEFAULT NULL,
  `due_interval` int(11) DEFAULT NULL,
  `due_unit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `checklists`
--

INSERT INTO `checklists` (`id`, `template_id`, `object_id`, `object_domain`, `description`, `is_completed`, `completed_at`, `urgency`, `due`, `due_interval`, `due_unit`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, '1', 'contact', 'Need to verify this guy house.', NULL, NULL, 1, '2019-01-25 07:50:14', NULL, NULL, NULL, '2019-02-24 11:57:28', '2019-02-24 11:57:28'),
(2, 1, NULL, NULL, 'my checklist', NULL, NULL, NULL, '2019-02-24 14:59:13', 3, 'hour', NULL, '2019-02-24 11:59:13', '2019-02-24 11:59:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `checklist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_completed` tinyint(1) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `due` datetime DEFAULT NULL,
  `due_interval` int(11) DEFAULT NULL,
  `due_unit` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urgency` int(11) DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `items`
--

INSERT INTO `items` (`id`, `checklist_id`, `user_id`, `description`, `is_completed`, `completed_at`, `due`, `due_interval`, `due_unit`, `urgency`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Have to verify this guy house.', NULL, NULL, '2019-01-19 18:34:51', NULL, NULL, 2, NULL, '2019-02-24 11:57:46', '2019-02-24 11:57:46'),
(2, 1, 1, 'Have to verify this guy house.', NULL, NULL, '2019-01-19 18:34:51', NULL, NULL, 2, NULL, '2019-02-24 11:58:39', '2019-02-24 11:58:39'),
(3, 2, 1, 'my foo item', NULL, NULL, '2019-02-24 12:39:13', 40, 'minute', 2, NULL, '2019-02-24 11:59:13', '2019-02-24 11:59:13'),
(4, 2, 1, 'my bar item', NULL, NULL, '2019-02-24 12:29:13', 30, 'minute', 3, NULL, '2019-02-24 11:59:13', '2019-02-24 11:59:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_01_10_101732_create_users_table', 1),
(5, '2019_02_23_134551_create_checklists', 2),
(6, '2019_02_24_005207_create_items', 2),
(7, '2019_02_24_104710_create_template', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `templates`
--

CREATE TABLE `templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `templates`
--

INSERT INTO `templates` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'foo template', '2019-02-24 11:59:13', '2019-02-24 11:59:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Coba', 'coba@outlook.com', '2019-02-27 00:19:28', '$2y$12$EGFzRTB6P6SDEVxVSybi3.x3m15cZGGK4sjL7DQCHM.yasoMgi5.S', NULL, '2019-02-27 00:19:28', '2019-02-27 00:19:28');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `checklists`
--
ALTER TABLE `checklists`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `checklists`
--
ALTER TABLE `checklists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

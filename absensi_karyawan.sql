-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Jan 2026 pada 06.53
-- Versi server: 8.0.30
-- Versi PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_karyawan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_pulang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menit_lembur` int NOT NULL,
  `status` enum('hadir','izin','sakit','alpha') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hadir',
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `tanggal`, `jam_masuk`, `jam_pulang`, `menit_lembur`, `status`, `latitude`, `longitude`, `keterangan`, `dokumen`, `created_at`, `updated_at`) VALUES
(20, 9, '2026-01-12', '10:41:22', NULL, 0, 'hadir', '-7.4716826', '112.4224293', '[TERLAMBAT 161.37372851667 Menit - Potongan Rp 38.407] ', NULL, '2026-01-12 03:41:22', '2026-01-12 03:41:22'),
(25, 13, '2026-01-14', '12:04:18', NULL, 0, 'hadir', '-7.464918', '112.4234687', '[TERLAMBAT 244.3079501 Menit - Potongan Rp 58.145] ', NULL, '2026-01-14 05:04:18', '2026-01-14 05:04:18'),
(26, 14, '2026-01-14', '12:10:56', NULL, 0, 'izin', '-7.4753989', '112.417959', ' ', '1768367457_logo proactive.png', '2026-01-14 05:10:57', '2026-01-14 05:10:57'),
(27, 9, '2026-01-14', '12:12:25', NULL, 0, 'sakit', '-7.4753989', '112.417959', ' ', '1768367545_384993215edf8967edd033e8674f6abe.jpg', '2026-01-14 05:12:25', '2026-01-14 05:12:25'),
(29, 15, '2026-01-14', '13:45:14', NULL, 0, 'sakit', '-7.4647069', '112.4233423', ' ', '1768373114_333333333.PNG', '2026-01-14 06:45:14', '2026-01-14 06:45:14'),
(31, 16, '2026-01-14', '18:17:50', NULL, 0, 'hadir', '-7.454018', '112.4071712', '[TERLAMBAT 617.83485603333 Menit - Potongan Rp 147.045] ', NULL, '2026-01-14 11:17:50', '2026-01-14 11:17:50'),
(34, 13, '2026-01-15', '12:55:29', '12:55:36', 0, 'hadir', '-7.464875769945676', '112.4232936780584', '[TERLAMBAT 295.48629175 Menit - Potongan Rp 70.326] ', NULL, '2026-01-15 05:55:29', '2026-01-15 05:55:36'),
(35, 14, '2026-01-15', '12:56:33', '12:56:41', 0, 'hadir', '-7.4648338472175295', '112.42330858349833', '[TERLAMBAT 296.5649087 Menit - Potongan Rp 70.582] ', NULL, '2026-01-15 05:56:33', '2026-01-15 05:56:41'),
(36, 13, '2026-01-17', '09:58:26', NULL, 0, 'hadir', '-7.453839', '112.407005', '[TERLAMBAT 118.43490316667 Menit - Potongan Rp 28.188] ', NULL, '2026-01-17 02:58:26', '2026-01-17 02:58:26'),
(38, 14, '2026-01-17', '09:59:40', NULL, 0, 'sakit', '-7.453866125', '112.407014625', ' sakit demam', '1768618780_333333333.PNG', '2026-01-17 02:59:40', '2026-01-17 02:59:40'),
(40, 15, '2026-01-17', '10:01:29', NULL, 0, 'hadir', '-7.453839', '112.407005', '[TERLAMBAT 121.49392316667 Menit - Potongan Rp 28.916] ', NULL, '2026-01-17 03:01:29', '2026-01-17 03:01:29'),
(41, 17, '2026-01-17', '10:02:44', NULL, 0, 'hadir', '-7.453839', '112.407005', '[TERLAMBAT 122.74594786667 Menit - Potongan Rp 29.214] ', NULL, '2026-01-17 03:02:44', '2026-01-17 03:02:44'),
(42, 14, '2026-01-19', '07:26:22', NULL, 0, 'hadir', '-7.46479950192456', '112.42324156010515', ' ', NULL, '2026-01-19 00:26:22', '2026-01-19 00:26:22'),
(44, 13, '2026-01-19', '07:28:28', NULL, 0, 'hadir', '-7.464703180453603', '112.42324938062997', ' ', NULL, '2026-01-19 00:28:28', '2026-01-19 00:28:28'),
(45, 17, '2026-01-19', '07:29:08', NULL, 0, 'hadir', '-7.464700586083488', '112.42324905654982', ' ', NULL, '2026-01-19 00:29:08', '2026-01-19 00:29:08'),
(46, 16, '2026-01-19', '07:33:03', NULL, 0, 'izin', '-7.464799676332056', '112.42323788666471', ' ', '1768782784_surat izin sakit.png', '2026-01-19 00:33:04', '2026-01-19 00:33:04'),
(47, 15, '2026-01-19', '07:33:47', NULL, 0, 'sakit', '-7.464813742137471', '112.42325673528978', ' ', '1768782827_surat izin sakit.png', '2026-01-19 00:33:47', '2026-01-19 00:33:47'),
(48, 18, '2026-01-19', '07:53:18', '07:53:23', 0, 'hadir', '-7.464810268113253', '112.42324486047637', ' ', NULL, '2026-01-19 00:53:18', '2026-01-19 00:53:23'),
(49, 20, '2026-01-19', '09:50:20', NULL, 0, 'hadir', '-7.464647472420695', '112.42320229585873', '[TERLAMBAT 110.33730275 Menit - Potongan Rp 26.260] ', NULL, '2026-01-19 02:50:20', '2026-01-19 02:50:20'),
(50, 21, '2026-01-19', '13:31:31', '13:31:43', 0, 'hadir', '-7.464736419167954', '112.4232562119098', '[TERLAMBAT 331.53028543333 Menit - Potongan Rp 78.904] ', NULL, '2026-01-19 06:31:31', '2026-01-19 06:31:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_21_064259_create_karyawans_table', 1),
(5, '2025_12_05_113131_create_absensis_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `session`
--

CREATE TABLE `session` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('roHNzX4zf1ISpyys0dTsfRgGKhBq0ZdezZ8uXLAO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajBkdkx5YlJ1cTlHUGdWQVRBdjV0QWlxdWZ3TGRoRmhuNGJ2eWpUSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1768804371);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'karyawan',
  `gaji_per_hari` decimal(15,2) DEFAULT '0.00',
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'karyawan',
  `gaji_per_hari` decimal(15,2) DEFAULT '0.00',
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `gaji_per_hari`, `qr_code`, `jabatan`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Toko', 'admin@gmail.com', NULL, '$2y$12$pWcF3jInOwfy5DiNCVv0QOEzMttEndNHg/Z8KGktYG80IJRYEFnFW', 'admin', 0.00, NULL, 'Manager', NULL, '2026-01-09 01:49:48', '2026-01-09 01:50:05'),
(9, 'atin yuliana', 'atin@gmail.com', NULL, '$2y$12$pMFq6nKCEVDbSXPdqgQG2eCXXxppPz.m5ZeUK6b.Ngmx2zzEw2lPO', 'karyawan', 200000.00, 'ABSEN-69646cf3275a8', 'manager', NULL, '2026-01-12 03:39:31', '2026-01-19 01:04:45'),
(13, 'elga', 'elga@gmail.com', NULL, '$2y$12$Y8keSNmR0AvWfrwtOSRaC.9R5jln2wZaj1li1oP/m5mktDB1OXOje', 'karyawan', 200000.00, 'ABSEN-696723a02263a', 'manager', NULL, '2026-01-14 05:03:28', '2026-01-19 01:03:39'),
(14, 'riris', 'riris@gmail.com', NULL, '$2y$12$AtRlliVhut8MneVPynvrEOlMtWkcxbxX.H8ML95NUloOFC4bos5TG', 'karyawan', 150000.00, 'ABSEN-6967248e41814', 'staf', NULL, '2026-01-14 05:07:26', '2026-01-19 01:04:05'),
(15, 'icha', 'icha@gmail.com', NULL, '$2y$12$5I6T3zpb2ii2/aMgiItUIe4/DETLev.I09opXFXuEm8ECuoYAam4u', 'karyawan', 150000.00, 'ABSEN-69673b626b840', 'pelajar', NULL, '2026-01-14 06:44:50', '2026-01-14 06:44:50'),
(16, 'putri', 'putri@gmail.com', NULL, '$2y$12$kQ1y32S83I2SL2hrebLe5eGg.CxFlaS47mhV8vRbkZh3lm6QDHeGa', 'karyawan', 200000.00, 'ABSEN-69677a7810adb', 'setretaris', NULL, '2026-01-14 11:14:00', '2026-01-19 00:34:43'),
(17, 'rama', 'rama123@gmail.com', NULL, '$2y$12$xubw8E0XnExpuKsG/g4TgeI8BV0rWR.BczNcJQ3zLiqV80XubOOiu', 'karyawan', 200000.00, 'ABSEN-69677e54c4b31', 'staf', NULL, '2026-01-14 11:30:28', '2026-01-19 01:04:27'),
(18, 'pasha', 'pasha@gmail.com', NULL, '$2y$12$4ZpA3WaregizffXWdG1jV.ptvbPX1Jc7pxpdxE37AGkRGUV73DO6.', 'karyawan', 150000.00, 'ABSEN-696d7c598fd97', 'setretaris', NULL, '2026-01-19 00:35:37', '2026-01-19 00:35:37'),
(19, 'fika', 'fika123@gmail.com', NULL, '$2y$12$Mptb42kq7VnVTPXImU1zcenoftkLW9cBQIWHJB93ks4GwHI7dERMO', 'karyawan', 150000.00, 'ABSEN-696d7c7696f60', 'setretaris', NULL, '2026-01-19 00:36:06', '2026-01-19 00:36:06'),
(20, 'zira', 'zira@gmail.com', NULL, '$2y$12$72TJb5A8bHJ57Ab7V9q6wesrGcK9hw2w15W23nGdI.nJfKwek2SLy', 'karyawan', 100000.00, 'ABSEN-696d9bc766301', 'skertaris', NULL, '2026-01-19 02:49:43', '2026-01-19 02:49:43'),
(21, 'tiara', 'tiara@gmail.com', NULL, '$2y$12$gx5sso7jFMsD.1lSRE9k3Of88yZEJ1DvNSUv20tRGaQFHzff8Eob2', 'karyawan', 200000.00, 'ABSEN-696dcfa274d0b', 'manager', NULL, '2026-01-19 06:30:58', '2026-01-19 06:30:58');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_absensi_user` (`user_id`);

--
-- Indeks untuk tabel `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_email_unique` (`email`),
  ADD KEY `fk_karyawan_user` (`user_id`);

--
-- Indeks untuk tabel `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_email_unique` (`email`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_absensi_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_karyawan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

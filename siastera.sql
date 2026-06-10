-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jan 2026 pada 17.00
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siastera`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `condition` varchar(50) NOT NULL DEFAULT 'Baik',
  `purchase_date` date DEFAULT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `image_path` varchar(255) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`id`, `asset_code`, `name`, `category_id`, `room_id`, `employee_id`, `condition`, `purchase_date`, `price`, `status`, `image_path`, `document_path`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'INV-2026-00001', 'Samsung HD Smart TV', 1, 1, NULL, 'Baik', '2026-01-10', 1799000.00, 'active', 'assets/images/gTHN4YWDz8xNQmlkcDs5kMB2exD4TkJa5z9YMWJ9.jpg', NULL, '32\" UA32T4503AK', '2026-01-10 08:36:48', '2026-01-10 08:36:48', NULL),
(2, 'INV-2026-00002', 'Samsung Galaxy Tab A11+', 1, 8, 2, 'Baik', '2026-01-10', 2999000.00, 'active', 'assets/images/JAQAmDLR7jKJh9TP8ns1HEOlEriliy3l6diQwtNH.png', NULL, '6/128GB WiFi - Gray', '2026-01-10 08:37:24', '2026-01-10 08:38:52', NULL),
(3, 'INV-2026-00003', 'ADVAN Workmate R5', 1, 8, 1, 'Baik', '2026-01-10', 4699000.00, 'active', 'assets/images/YtORvWXrJTFXbnYbDk2pTIKTojr14ZJOFA6gUF3h.png', NULL, '8/256GB - Blue', '2026-01-10 08:37:55', '2026-01-10 08:37:55', NULL),
(4, 'INV-2026-00004', 'ADVAN Soulmate X2', 1, 8, 2, 'Baik', '2026-01-10', 3199000.00, 'active', 'assets/images/c2mDxOTWzC3t3v4LtJuzJqIjIA0dqzVlLvIRr8Xp.png', NULL, '8/128GB - White', '2026-01-10 08:38:17', '2026-01-10 08:38:17', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_histories`
--

CREATE TABLE `asset_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asset_histories`
--

INSERT INTO `asset_histories` (`id`, `asset_id`, `user_id`, `action`, `description`, `created_at`) VALUES
(1, 1, 1, 'CREATE', 'Mendaftarkan aset baru ke dalam sistem.', '2026-01-10 08:36:48'),
(2, 2, 1, 'CREATE', 'Mendaftarkan aset baru ke dalam sistem.', '2026-01-10 08:37:24'),
(3, 3, 1, 'CREATE', 'Mendaftarkan aset baru ke dalam sistem.', '2026-01-10 08:37:55'),
(4, 4, 1, 'CREATE', 'Mendaftarkan aset baru ke dalam sistem.', '2026-01-10 08:38:17'),
(5, 2, 1, 'HANDOVER', 'Serah terima aset dari: [Abdul] ke: [Budi]. Catatan: mutasi', '2026-01-10 08:38:52'),
(6, 3, 1, 'MAINTENANCE', 'Melakukan perawatan: Pemeliharaan Rutin. Biaya: Rp 150,000', '2026-01-10 08:39:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_maintenances`
--

CREATE TABLE `asset_maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `maintenance_date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `cost` decimal(15,2) NOT NULL DEFAULT 0.00,
  `vendor` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `invoice_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asset_maintenances`
--

INSERT INTO `asset_maintenances` (`id`, `asset_id`, `user_id`, `maintenance_date`, `type`, `cost`, `vendor`, `description`, `invoice_path`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2026-01-10', 'Pemeliharaan Rutin', 150000.00, 'TOKO KOMPUTER', 'Repasta Prosesor', NULL, '2026-01-10 08:39:23', '2026-01-10 08:39:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_results`
--

CREATE TABLE `audit_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_session_id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('match','moved','unregistered') NOT NULL DEFAULT 'match',
  `note` text DEFAULT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `audit_results`
--

INSERT INTO `audit_results` (`id`, `audit_session_id`, `asset_id`, `status`, `note`, `scanned_at`) VALUES
(1, 1, 3, 'match', NULL, '2026-01-10 08:40:48'),
(2, 1, 4, 'match', NULL, '2026-01-10 08:40:55'),
(3, 1, 1, 'match', NULL, '2026-01-10 08:41:18'),
(4, 1, 2, 'match', NULL, '2026-01-10 08:41:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_sessions`
--

CREATE TABLE `audit_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `audit_sessions`
--

INSERT INTO `audit_sessions` (`id`, `title`, `start_date`, `end_date`, `status`, `user_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Q1 2026', '2026-01-10', '2026-01-10', 'closed', 1, NULL, '2026-01-10 08:40:26', '2026-01-10 08:41:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'Elektronik & IT', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(2, 'FUR', 'Furniture & Meubel', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(3, 'MSN', 'Mesin Perbankan', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(4, 'VH', 'Kendaraan Dinas', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(5, 'OFF', 'Peralatan Kantor', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(6, 'SEC', 'Keamanan (Security)', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(7, 'LOG', 'Alat Tulis & Logistik', NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `nip`, `name`, `position`, `department`, `phone`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '123456', 'Abdul', 'Teknologi Informasi', 'Operasional', '08123456', 1, '2026-01-10 08:35:44', '2026-01-10 08:35:44'),
(2, '123455', 'Budi', 'Teknologi Informasi', 'Operasional', '081234567', 1, '2026-01-10 08:35:57', '2026-01-10 08:35:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_03_165841_create_master_data_tables', 1),
(6, '2026_01_03_165912_create_assets_table', 1),
(7, '2026_01_03_165940_create_asset_histories_table', 1),
(8, '2026_01_03_182554_create_asset_maintenances_table', 1),
(9, '2026_01_03_183833_create_employees_table', 1),
(10, '2026_01_03_190513_create_audit_tables', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `code`, `name`, `location`, `description`, `created_at`, `updated_at`) VALUES
(1, 'LBY', 'Lobby & Banking Hall', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(2, 'TLR', 'Area Teller', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(3, 'CS', 'Area Customer Service', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(4, 'OPS', 'Back Office (Operasional)', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(5, 'KHS', 'Ruang Khasanah (Vault)', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(6, 'DIR', 'Ruang Direksi / Pimpinan', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(7, 'MTG', 'Ruang Rapat (Meeting)', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(8, 'SRV', 'Ruang Server (IT)', 'Lantai 2', 'test', '2026-01-10 08:34:44', '2026-01-10 08:35:26'),
(9, 'MKT', 'Ruang Marketing / AO', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(10, 'ARS', 'Gudang Arsip', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(11, 'PAN', 'Pantry & Dapur', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(12, 'MUS', 'Mushola', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44'),
(13, 'SEC', 'Pos Satpam', NULL, NULL, '2026-01-10 08:34:44', '2026-01-10 08:34:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'ga',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sandika Wiranata', 'sandika', 'admin@bprs.co.id', '$2y$10$lOU3OKOXvvJ0A8aL9I9dnuoww0PGw7qXFP3I81QZqyKYChPAa0X2q', 'admin', 1, NULL, '2026-01-10 08:34:44', NULL),
(2, 'Staf Umum', 'umum', 'ga@bprs.co.id', '$2y$10$rS97.NXO9cdxBL8NUTdjBOSD10NZACMVd1XviqjVhtdlibB9gZSaq', 'ga', 1, NULL, '2026-01-10 08:34:44', NULL),
(3, 'Staff Audit', 'audit', 'ga@bprs.co.id', '$2y$10$1RU.3Ml54MVh4EjK3nFquO8kT9.sSL8Ka2Dxxdf/YjM2qvLR9EmnW', 'auditor', 1, NULL, '2026-01-10 08:34:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assets_asset_code_unique` (`asset_code`),
  ADD KEY `assets_category_id_foreign` (`category_id`),
  ADD KEY `assets_room_id_foreign` (`room_id`),
  ADD KEY `assets_employee_id_foreign` (`employee_id`);

--
-- Indeks untuk tabel `asset_histories`
--
ALTER TABLE `asset_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_histories_asset_id_foreign` (`asset_id`),
  ADD KEY `asset_histories_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `asset_maintenances`
--
ALTER TABLE `asset_maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_maintenances_asset_id_foreign` (`asset_id`),
  ADD KEY `asset_maintenances_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `audit_results`
--
ALTER TABLE `audit_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `audit_results_audit_session_id_asset_id_unique` (`audit_session_id`,`asset_id`),
  ADD KEY `audit_results_asset_id_foreign` (`asset_id`);

--
-- Indeks untuk tabel `audit_sessions`
--
ALTER TABLE `audit_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_sessions_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_code_unique` (`code`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_nip_unique` (`nip`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_code_unique` (`code`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `asset_histories`
--
ALTER TABLE `asset_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `asset_maintenances`
--
ALTER TABLE `asset_maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `audit_results`
--
ALTER TABLE `audit_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `audit_sessions`
--
ALTER TABLE `audit_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `assets_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Ketidakleluasaan untuk tabel `asset_histories`
--
ALTER TABLE `asset_histories`
  ADD CONSTRAINT `asset_histories_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `asset_maintenances`
--
ALTER TABLE `asset_maintenances`
  ADD CONSTRAINT `asset_maintenances_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_maintenances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `audit_results`
--
ALTER TABLE `audit_results`
  ADD CONSTRAINT `audit_results_asset_id_foreign` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `audit_results_audit_session_id_foreign` FOREIGN KEY (`audit_session_id`) REFERENCES `audit_sessions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `audit_sessions`
--
ALTER TABLE `audit_sessions`
  ADD CONSTRAINT `audit_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

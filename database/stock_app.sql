-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Nov 2025 pada 03.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED DEFAULT NULL,
  `merk_id` bigint(20) UNSIGNED DEFAULT NULL,
  `satuan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `min_stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode`, `nama`, `kategori_id`, `merk_id`, `satuan_id`, `stock`, `min_stock`, `created_at`, `updated_at`) VALUES
(1, 'SA-ATK-0001', 'KERTAS HVS A4', 5, 3, 6, 35, 10, '2025-10-21 01:32:17', '2025-10-30 04:20:39'),
(3, 'SA-IT-0001', 'PC GAMING', 7, 4, 3, 5, 10, '2025-10-21 01:34:31', '2025-11-05 02:00:00'),
(4, 'SA-IT-0002', 'MONITOR 21 INCH', 7, 4, 3, 35, 10, '2025-10-21 19:25:59', '2025-10-30 04:20:58'),
(5, 'SA-IT-0003', 'KEYBOARD RGB GAMING', 7, 4, 3, 20, 10, '2025-10-21 19:26:45', '2025-10-22 20:23:07'),
(6, 'SA-IT-0004', 'MOUSE RGB GAMING', 7, 4, 2, 20, 10, '2025-10-21 19:27:11', '2025-10-22 20:23:01'),
(7, 'SA-ATK-0002', 'PULPEN SNOWMAN V.5 BLACK', 5, 9, 5, 25, 10, '2025-10-22 20:26:57', '2025-10-30 03:36:54'),
(8, 'SA-ATK-0003', 'PULPEN SNOWMAN V.5 RED', 5, 9, 5, 20, 10, '2025-10-22 20:27:43', '2025-10-30 04:22:50'),
(9, 'SA-ATK-0004', 'PULPEN SNOWMAN V.5 BLUE', 5, 9, 5, 25, 10, '2025-10-22 20:29:00', '2025-10-22 20:29:00'),
(10, 'SA-TL-0001', 'OBENG PLUS MINUS', 9, 6, 2, 25, 10, '2025-10-22 20:30:04', '2025-10-23 07:28:32'),
(11, 'SA-TL-0002', 'TANG 5 INCH', 9, 6, 2, 25, 10, '2025-10-22 20:30:33', '2025-10-30 04:22:21'),
(12, 'SA-IT-0005', 'HUB', 7, 10, 3, 35, 10, '2025-11-04 18:54:34', '2025-11-05 01:58:58'),
(13, 'SA-IT-0006', 'LAN CABLE UTP CAT 6', 7, 11, 3, 30, 10, '2025-11-04 18:55:27', '2025-11-05 02:01:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` int(11) NOT NULL CHECK (`qty` > 0),
  `keterangan` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `tanggal`, `barang_id`, `customer_id`, `qty`, `keterangan`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2025-10-23', 1, 3, 10, 'DWK - KERTAS HVS - OK', 2, '2025-10-21 21:15:05', '2025-10-21 21:15:05'),
(2, '2025-10-22', 3, 2, 10, 'KMJ - PC GAMING - OK', 2, '2025-10-21 21:15:34', '2025-10-21 21:16:04'),
(4, '2025-10-22', 4, 2, 10, 'KMJ - MONITOR 21 INCH - OK', 2, '2025-10-21 21:19:40', '2025-10-21 21:19:40'),
(5, '2025-10-23', 5, 4, 5, 'ASE - KEYBOARD RGB GAMING - OK', 2, '2025-10-21 23:13:48', '2025-10-21 23:18:42'),
(6, '2025-10-23', 6, 4, 5, 'ASE - MOUSE RGB GAMING - OK', 2, '2025-10-21 23:14:49', '2025-10-21 23:18:47'),
(7, '2025-10-23', 10, 5, 35, 'TOP - OBENG - OK', 3, '2025-10-22 22:34:43', '2025-10-22 22:34:43'),
(8, '2025-10-23', 11, 5, 20, 'TOP - TANG - OK', 3, '2025-10-22 22:35:12', '2025-10-22 22:35:12'),
(9, '2025-10-30', 7, 9, 25, 'PI - PULPEN SNOWMAN - OK', 3, '2025-10-29 20:36:54', '2025-10-29 20:36:54'),
(10, '2025-10-30', 11, 7, 10, 'PPN - TANG 5 INCH - OK', 4, '2025-10-29 21:22:21', '2025-10-29 21:22:21'),
(11, '2025-10-30', 8, 7, 10, 'PPN - PULPEN SNOWMAN RED - OK', 4, '2025-10-29 21:22:50', '2025-10-29 21:22:50'),
(12, '2025-11-05', 3, 6, 20, 'KPP - OK - PC GAMING', 3, '2025-11-04 19:00:00', '2025-11-04 19:00:00'),
(13, '2025-11-05', 13, 6, 10, 'KPP - OK - LAN CABLE', 3, '2025-11-04 19:01:13', '2025-11-04 19:01:13');

--
-- Trigger `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `trg_keluar_after_delete` AFTER DELETE ON `barang_keluar` FOR EACH ROW BEGIN
  UPDATE barang SET stock = stock + OLD.qty, updated_at = NOW() WHERE id = OLD.barang_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_keluar_after_insert` AFTER INSERT ON `barang_keluar` FOR EACH ROW BEGIN
  UPDATE barang SET stock = stock - NEW.qty, updated_at = NOW() WHERE id = NEW.barang_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_keluar_after_update` AFTER UPDATE ON `barang_keluar` FOR EACH ROW BEGIN
  IF NEW.barang_id = OLD.barang_id THEN
    UPDATE barang SET stock = stock - (NEW.qty - OLD.qty), updated_at = NOW() WHERE id = NEW.barang_id;
  ELSE
    UPDATE barang SET stock = stock + OLD.qty, updated_at = NOW() WHERE id = OLD.barang_id;
    UPDATE barang SET stock = stock - NEW.qty, updated_at = NOW() WHERE id = NEW.barang_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL CHECK (`qty` > 0),
  `keterangan` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `tanggal`, `barang_id`, `qty`, `keterangan`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2025-10-22', 1, 5, 'OK - KERTAS HVS', 2, '2025-10-21 20:56:03', '2025-10-21 20:56:03'),
(2, '2025-10-22', 5, 5, 'OK - KEYBOARD RGB GAMING', 2, '2025-10-21 20:56:42', '2025-10-21 20:57:33'),
(3, '2025-10-22', 4, 5, 'OK - MONITOR 21 INCH', 2, '2025-10-21 21:11:52', '2025-10-21 21:11:58'),
(4, '2025-10-22', 6, 5, 'OK - MOUSE RGB GAMING', 2, '2025-10-21 21:12:22', '2025-10-21 21:12:22'),
(7, '2025-10-22', 3, 5, 'OK - PC GAMING', 2, '2025-10-21 21:13:52', '2025-10-21 21:13:52'),
(8, '2025-10-23', 10, 25, 'OK - OBENG', 2, '2025-10-22 22:33:06', '2025-10-23 00:28:32'),
(9, '2025-10-23', 11, 10, 'OK - TANG', 3, '2025-10-22 22:33:32', '2025-10-22 22:34:07'),
(10, '2025-10-30', 3, 10, 'OK - PC GAMING', 3, '2025-10-29 20:35:27', '2025-10-29 20:35:27'),
(11, '2025-10-30', 1, 20, 'OK - KERTAS HVS', 4, '2025-10-29 21:20:39', '2025-10-29 21:20:39'),
(12, '2025-10-30', 4, 20, 'OK - MONITOR 21 INCH', 4, '2025-10-29 21:20:58', '2025-10-29 21:20:58'),
(13, '2025-11-05', 12, 15, 'OK - IT - HUB TP LINK', 3, '2025-11-04 18:58:58', '2025-11-04 18:58:58'),
(14, '2025-11-05', 13, 20, 'OK - IT - LAN CABLE', 3, '2025-11-04 18:59:21', '2025-11-04 18:59:21');

--
-- Trigger `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `trg_masuk_after_delete` AFTER DELETE ON `barang_masuk` FOR EACH ROW BEGIN
  UPDATE barang SET stock = stock - OLD.qty, updated_at = NOW() WHERE id = OLD.barang_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_masuk_after_insert` AFTER INSERT ON `barang_masuk` FOR EACH ROW BEGIN
  UPDATE barang SET stock = stock + NEW.qty, updated_at = NOW() WHERE id = NEW.barang_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_masuk_after_update` AFTER UPDATE ON `barang_masuk` FOR EACH ROW BEGIN
  IF NEW.barang_id = OLD.barang_id THEN
    UPDATE barang SET stock = stock + (NEW.qty - OLD.qty), updated_at = NOW() WHERE id = NEW.barang_id;
  ELSE
    -- pindah item: kurangi di lama, tambah di baru
    UPDATE barang SET stock = stock - OLD.qty, updated_at = NOW() WHERE id = OLD.barang_id;
    UPDATE barang SET stock = stock + NEW.qty, updated_at = NOW() WHERE id = NEW.barang_id;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `nama`, `telepon`, `alamat`, `created_at`, `updated_at`) VALUES
(2, 'PT. KAPUAS MAJU JAYA', '08112020113', 'DESA SEI HANYO', '2025-10-21 19:33:41', '2025-10-21 19:33:41'),
(3, 'PT. DWIE WARNA KARYA', '081510102020', 'DESA SEI HANYO', '2025-10-21 19:34:08', '2025-10-21 19:34:08'),
(4, 'PT. SUSANTRI PERMAI', '082120203030', 'DESA SEI HANYO', '2025-10-21 19:34:26', '2025-10-21 19:34:26'),
(5, 'PT. TELEN ORBIT PRIMA', '082240405050', 'DESA BUHUT RAYA', '2025-10-22 20:18:15', '2025-10-22 20:18:15'),
(6, 'PT. KALIMANTAN PRIMA PERSADA', '083110102020', 'DESA BARUNANG', '2025-10-22 20:19:26', '2025-10-22 20:19:26'),
(7, 'PT. PAMA PERSADA NUSANTARA', '083850506060', 'DESA BARUNANG', '2025-10-22 20:19:54', '2025-10-22 20:19:54'),
(8, 'PT. ASMIN BARA BARONANG', '085270708080', 'DESA BARUNANG', '2025-10-22 20:32:17', '2025-10-22 20:32:17'),
(9, 'PT. PADA IDI', '085325253434', 'DESA TELUK TIMBAU', '2025-10-22 20:32:48', '2025-10-22 20:32:48'),
(10, 'CV. BORNEO SMART SOLUTION', '081230304040', 'Jl. Wortel, Palangka Raya', '2025-11-04 18:56:29', '2025-11-04 18:56:29'),
(11, 'CV. PRIMA ANANG PERSADA', '081320201010', 'Jl. G. Obos, Palangka Raya', '2025-11-04 18:58:04', '2025-11-04 18:58:04');

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
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(5, 'ATK', '2025-10-21 01:18:03', '2025-10-21 01:18:03'),
(6, 'ELEKTRONIK', '2025-10-21 01:18:58', '2025-10-21 01:18:58'),
(7, 'PERANGKAT IT', '2025-10-21 01:19:06', '2025-10-21 01:19:06'),
(9, 'TOOLS', '2025-10-22 19:41:48', '2025-10-22 19:41:48'),
(10, 'PECAH BELAH', '2025-10-22 19:50:31', '2025-10-22 19:50:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `merk`
--

CREATE TABLE `merk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `merk`
--

INSERT INTO `merk` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(3, 'SIDU', '2025-10-21 01:18:35', '2025-10-21 01:18:35'),
(4, 'LENOVO', '2025-10-21 01:18:42', '2025-10-21 01:18:42'),
(5, 'ROBOT', '2025-10-21 01:19:18', '2025-10-21 01:19:18'),
(6, 'TEKIRO', '2025-10-22 19:48:31', '2025-10-22 19:48:31'),
(7, 'ACE', '2025-10-22 19:50:42', '2025-10-22 19:50:42'),
(8, 'SWIFT', '2025-10-22 19:51:02', '2025-10-22 19:51:02'),
(9, 'SNOWMAN', '2025-10-22 20:26:19', '2025-10-22 20:26:19'),
(10, 'TP-LINK', '2025-11-04 18:53:28', '2025-11-04 18:53:28'),
(11, 'BELDEN', '2025-11-04 18:53:35', '2025-11-04 18:53:35');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'KG', '2025-10-21 01:19:27', '2025-10-21 01:19:27'),
(2, 'PCS', '2025-10-21 01:19:31', '2025-10-21 01:19:31'),
(3, 'UNI', '2025-10-21 01:19:35', '2025-10-21 01:19:35'),
(5, 'KTK', '2025-10-21 01:19:44', '2025-10-21 01:19:44'),
(6, 'BOX', '2025-10-21 01:19:51', '2025-10-21 01:19:51'),
(7, 'MTR', '2025-10-21 01:20:07', '2025-10-21 01:20:07'),
(8, 'BAR', '2025-10-22 19:57:12', '2025-10-22 19:57:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6ZuJAANa4HlUH3GMgodY5tghQwdI257z6AIfry7U', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicE9nWFpMSlprZlVWOWEwSWVJQ2MyRGFGdXRpMkFPbldyMlRKTzl4SCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovL2xvY2FsaG9zdC9zdG9jay1hcHAvcHVibGljL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vbG9jYWxob3N0L3N0b2NrLWFwcC9wdWJsaWMvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761026834);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','staff') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Tertu Akikkuti Jordan', 'tertu', '$2y$12$MfOJW6dQ748v.VI16FN4tey/uhDRZN0lwRx9FoI/8YxMt44dTPdfC', 'admin', NULL, '2025-10-20 22:58:35', '2025-10-20 22:58:35'),
(3, 'Ronaldo Dwi Anaku Aminu', 'ronaldo', '$2y$12$/x/Lb2ThKK/QWHEJeRtW5uFW0eY1/JEv1NtB2xizkuGBd6H9eiy5W', 'manager', NULL, '2025-10-22 22:32:19', '2025-10-22 22:32:19'),
(4, 'Bravo Teguh Sabarno', 'bravo', '$2y$12$hlABRyzOsZ2lbQY8b/6pa.QoZG9JTqgpO70RLvh2qXOb5bhIrdq8C', 'staff', NULL, '2025-10-22 22:37:07', '2025-10-22 22:37:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `idx_barang_nama` (`nama`),
  ADD KEY `idx_barang_kat` (`kategori_id`),
  ADD KEY `idx_barang_merk` (`merk_id`),
  ADD KEY `idx_barang_sat` (`satuan_id`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_keluar_tanggal` (`tanggal`),
  ADD KEY `fk_keluar_barang` (`barang_id`),
  ADD KEY `fk_keluar_customer` (`customer_id`),
  ADD KEY `fk_keluar_user` (`user_id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_masuk_tanggal` (`tanggal`),
  ADD KEY `fk_masuk_barang` (`barang_id`),
  ADD KEY `fk_masuk_user` (`user_id`);

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
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_customers_nama` (`nama`);

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
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indeks untuk tabel `merk`
--
ALTER TABLE `merk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

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
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `merk`
--
ALTER TABLE `merk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barang_merk` FOREIGN KEY (`merk_id`) REFERENCES `merk` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barang_satuan` FOREIGN KEY (`satuan_id`) REFERENCES `satuan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `fk_keluar_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_keluar_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_keluar_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `fk_masuk_barang` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_masuk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

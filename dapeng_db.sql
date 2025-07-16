-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 05:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dapeng_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_adytri064@gmail.com|127.0.0.1', 'i:1;', 1752462234),
('laravel_cache_adytri064@gmail.com|127.0.0.1:timer', 'i:1752462234;', 1752462234);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-07-13 08:13:18', '2025-07-13 08:13:18'),
(2, 2, '2025-07-13 20:15:36', '2025-07-13 20:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `itemable_type` varchar(255) NOT NULL,
  `itemable_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `itemable_type`, `itemable_id`, `quantity`, `options`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Product', 3, 1, NULL, '2025-07-13 08:13:19', '2025-07-13 08:13:19'),
(2, 2, 'App\\Models\\Product', 5, 1, NULL, '2025-07-13 20:15:36', '2025-07-13 20:15:36');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `address`, `created_at`, `updated_at`) VALUES
(1, 'dy', 'adytri064@gmail.com', NULL, '$2y$12$.1i1Ai0QeWtGGRCD7cLvG.DsKxugGsx2cqurpPq4.OPf8r3vHet9O', NULL, NULL, '2025-07-13 08:13:04', '2025-07-13 08:13:04'),
(2, 'dy', 'adytri810@gmail.com', NULL, '$2y$12$eq0j4qb3Cd.CbAzLJ.Tt7.xvOvRaJBtPRQGC.qh4GK6xjJYHkh9Em', NULL, NULL, '2025-07-13 20:15:19', '2025-07-13 20:15:19');

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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_16_052024_create_product_categories_table', 1),
(5, '2025_04_17_093723_create_posts_table', 1),
(6, '2025_05_20_234516_create_products_table', 1),
(7, '2025_05_21_000844_create_customers_table', 1),
(8, '2025_05_21_001006_create_orders_table', 1),
(9, '2025_05_21_001140_create_order_details_table', 1),
(10, '2025_05_21_015728_add_field_password', 1),
(11, '2025_05_28_013100_create_themes_table', 1),
(12, '2025_05_28_053957_create_personal_access_tokens_table', 1),
(13, '2025_06_10_115635_create_carts_table', 1),
(14, '2025_06_11_073851_create_cart_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sku` varchar(50) NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `sku`, `price`, `stock`, `product_category_id`, `image_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Adidas Samba OG', 'adidas-samba-og', 'Sepatu ikonik gaya streetwear klasik.', 'SAMBA-001', 1200000.00, 50, 1, 'uploads/products/1752416587_Samba OG-Core Black.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 07:23:07'),
(2, 'Adidas Ultraboost 22', 'adidas-ultraboost-22', 'Sepatu lari dengan bantalan Ultraboost responsif.', 'ULTRA-022', 2200000.00, 30, 2, 'uploads/products/1752416655_ultrabost.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 07:24:15'),
(4, 'Adidas Superstar', 'adidas-superstar', 'Sepatu kasual ikonik dengan shell toe.', 'SUPERSTAR-004', 1400000.00, 40, 1, 'uploads/products/1752416766_superstar.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 07:26:06'),
(5, 'Adidas Gazelle', 'adidas-gazelle', 'Desain retro untuk gaya kasual sehari-hari.', 'GAZELLE-005', 1300000.00, 35, 1, 'uploads/products/1752416799_adidas gazzele-adidas original.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 07:26:39'),
(6, 'Adidas NMD_R1', 'adidas-nmd-r1', 'Sneaker modern dengan teknologi Boost.', 'NMD-R1-006', 2000000.00, 20, 2, 'uploads/products/1752416848_nmd.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 20:06:48'),
(7, 'Adidas Adizero Adios', 'adidas-adizero-adios', 'Sepatu lari ringan untuk kecepatan maksimum.', 'ADI-ADIOS-007', 1900000.00, 15, 2, 'uploads/products/1752416891_Adidas Adizero Adios.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 07:28:11'),
(8, 'Adidas Forum Low', 'adidas-forum-low', 'Siluet basket retro yang stylish.', 'FORUM-LOW-008', 1500000.00, 30, 6, 'uploads/products/1752416930_Adidas Forum Low.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 07:28:50'),
(9, 'Adidas Terrex Swift', 'adidas-terrex-swift', 'Sepatu outdoor tahan air untuk hiking.', 'TERREX-009', 1750000.00, 20, 4, 'uploads/products/1752416977_tosusd.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 20:05:16'),
(10, 'Adidas Skateboarding', 'adidas-skateboarding', 'Sepatu khusus skate dengan grip ekstra.', 'SKATE-010', 1600000.00, 20, 5, 'uploads/products/1752417022_adidas matchbreak.jpg', 1, '2025-07-13 14:15:47', '2025-07-13 20:06:08'),
(11, 'Adidas ZX 2K Boost', 'adidas-zx-2k-boost', 'Sneaker futuristik dengan Boost.', 'ZX2K-011', 2100000.00, 20, 4, 'uploads/products/1752417069_Adidas ZX 2K Boost.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:07:13'),
(12, 'Adidas Stan Smith', 'adidas-stan-smith', 'Sepatu tenis legendaris.', 'STAN-012', 1450000.00, 30, 1, 'uploads/products/1752417115_Adidas Stan Smith.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:31:55'),
(13, 'Adidas Copa Sense', 'adidas-copa-sense', 'Sepatu bola dengan sentuhan sempurna.', 'COPA-013', 1850000.00, 15, 3, 'uploads/products/1752417159_Adidas Copa Sense.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:32:39'),
(14, 'Adidas X Speedflow', 'adidas-x-speedflow', 'Sepatu bola super ringan.', 'XFLOW-014', 1950000.00, 10, 3, 'uploads/products/1752417261_Adidas X Speedflow.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:34:21'),
(15, 'Adidas Solar Glide', 'adidas-solar-glide', 'Sepatu lari jarak jauh.', 'SOLAR-015', 2000000.00, 18, 2, 'uploads/products/1752417309_Adidas Solar Glide.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:35:09'),
(16, 'Adidas 4DFWD', 'adidas-4dfwd', 'Sepatu dengan sol cetak 3D.', '4DFWD-016', 2500000.00, 12, 2, 'uploads/products/1752417356_Adidas 4DFWD.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:25:31'),
(17, 'Adidas OZWEEGO', 'adidas-ozweego', 'Sneaker retro chunky.', 'OZWEEGO-017', 1600000.00, 25, 2, 'uploads/products/1752417411_Adidas OZWEEGO.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:26:00'),
(18, 'Adidas Retropy E5', 'adidas-retropy-e5', 'Retro sneaker bergaya 70-an.', 'RETRO-E5-018', 1700000.00, 18, 2, 'uploads/products/1752417458_Adidas Retropy E5.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:26:22'),
(19, 'Adidas EQT Support', 'adidas-eqt-support', 'Equipment line klasik.', 'EQT-019', 1550000.00, 20, 2, 'uploads/products/1752417499_EQT Support.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:26:48'),
(20, 'Adidas Tubular Shadow', 'adidas-tubular-shadow', 'Desain street yang simpel.', 'TUBULAR-020', 1400000.00, 20, 2, 'uploads/products/1752417547_Adidas Tubular Shadow.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:27:18'),
(21, 'Adidas Deerupt Runner', 'adidas-deerupt-runner', 'Sneaker ringan dan minimalis.', 'DEERUPT-021', 1350000.00, 20, 2, 'uploads/products/1752417597_Adidas Deerupt Runner.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:27:38'),
(22, 'Adidas Alphabounce', 'adidas-alphabounce', 'Sepatu lari fleksibel.', 'ALPHA-022', 1600000.00, 15, 2, 'uploads/products/1752417635_Adidas Alphabounce.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:40:35'),
(23, 'Adidas Pulseboost', 'adidas-pulseboost', 'Sepatu urban running.', 'PULSE-023', 1700000.00, 14, 2, 'uploads/products/1752417682_Adidas Pulseboost.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:41:22'),
(24, 'Adidas Harden Vol. 9', 'adidas-harden-vol9', 'Sandal slide ikonik.', 'harden-024', 550000.00, 40, 7, 'uploads/products/1752419514_didas Adilette Slides.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 08:11:54'),
(25, 'Adidas Matchcourt', 'adidas-matchcourt', 'Sepatu skate klasik.', 'MATCH-025', 1450000.00, 10, 5, 'uploads/products/1752417763_Adidas Matchcourt.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:08:55'),
(26, 'Adidas Busenitz', 'adidas-busenitz', 'Sepatu skate signature.', 'BUSENITZ-026', 1500000.00, 12, 5, 'uploads/products/1752417810_Adidas Busenitz.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:09:16'),
(27, 'Adidas Terrex AX4', 'adidas-terrex-ax4', 'Sepatu hiking multifungsi.', 'TERREX-027', 1800000.00, 10, 4, 'uploads/products/1752417849_Adidas Terrex AX4.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:10:06'),
(28, 'Adidas Terrex Free Hiker', 'adidas-terrex-free-hiker', 'Boots hiking ringan.', 'TERREX-FREE-028', 2100000.00, 8, 4, 'uploads/products/1752417899_Adidas Terrex Free Hiker.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:21:25'),
(29, 'Adidas Response Super', 'adidas-response-super', 'Sepatu running ringan.', 'RESP-029', 1400000.00, 15, 2, 'uploads/products/1752417949_Adidas Response Super.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:45:49'),
(30, 'Adidas SL20', 'adidas-sl20', 'Lari cepat dengan bobot ringan.', 'SL20-030', 1550000.00, 14, 2, 'uploads/products/1752418005_Adidas SL20.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:46:45'),
(31, 'Adidas Runfalcon', 'adidas-runfalcon', 'Sepatu running basic.', 'RUNFALCON-031', 900000.00, 25, 2, 'uploads/products/1752418048_Adidas Runfalcon.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:47:28'),
(32, 'Adidas Lite Racer', 'adidas-lite-racer', 'Sepatu ringan kasual.', 'LITE-032', 950000.00, 20, 2, 'uploads/products/1752418098_Adidas Lite Racer.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:27:59'),
(33, 'Adidas Advantage', 'adidas-advantage', 'Sneaker clean dan simpel.', 'ADVANTAGE-033', 1000000.00, 20, 2, 'uploads/products/1752418148_Adidas Advantage.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:28:27'),
(34, 'Adidas Courtpoint', 'adidas-courtpoint', 'Sepatu court casual.', 'COURTPOINT-034', 1100000.00, 15, 1, 'uploads/products/1752418196_Adidas Courtpoint.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:49:56'),
(35, 'Adidas Grand Court', 'adidas-grand-court', 'Desain minimalis.', 'GRAND-035', 1200000.00, 18, 1, 'uploads/products/1752418249_Adidas Grand Court.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:50:49'),
(36, 'Adidas Continental 80', 'adidas-continental-80', 'Retro vibes.', 'CONT80-036', 1450000.00, 12, 1, 'uploads/products/1752418298_Adidas Continental 80.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:51:38'),
(37, 'Adidas Advantage Base', 'adidas-advantage-base', 'Basic sneaker everyday.', 'ADVB-037', 900000.00, 20, 1, 'uploads/products/1752418349_Adidas Advantage Base.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:52:29'),
(38, 'Adidas Questar', 'adidas-questar', 'Sepatu running urban.', 'QUESTAR-038', 1150000.00, 15, 2, 'uploads/products/1752418410_Adidas Questar.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:53:30'),
(39, 'Adidas Senseboost', 'adidas-senseboost', 'Lari di kota.', 'SENSE-039', 1600000.00, 12, 2, 'uploads/products/1752418474_Adidas Senseboost.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 07:54:34'),
(40, 'Adidas Phosphere', 'adidas-phosphere', 'Casual sporty.', 'PHOSPH-040', 1300000.00, 10, 2, 'uploads/products/1752418646_Adidas Phosphere.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:29:13'),
(41, 'Adidas Terrex Agravic', 'adidas-terrex-agravic', 'Trail running.', 'TERREX-041', 1700000.00, 8, 4, 'uploads/products/1752418706_Adidas Terrex Agravic.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:11:10'),
(42, 'Adidas Skate Lucas Premiere', 'adidas-skate-lucas-premiere', 'Signature skate.', 'LUCAS-042', 1450000.00, 10, 5, 'uploads/products/1752418752_Adidas Skate Lucas Premiere.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:22:39'),
(43, 'Adidas Tyshawn', 'adidas-tyshawn', 'Signature skate.', 'TYSHAWN-043', 1500000.00, 12, 5, 'uploads/products/1752418794_Adidas Tyshawn.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:23:31'),
(44, 'Adidas Seeley', 'adidas-seeley', 'Basic skateboarding.', 'SEELEY-044', 1300000.00, 15, 5, 'uploads/products/1752418877_Adidas Seeley.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 20:23:58'),
(45, 'Adidas Copa Mundial', 'adidas-copa-mundial', 'Klasik sepatu bola.', 'COPA-MUN-045', 1650000.00, 10, 3, 'uploads/products/1752418920_Adidas Copa Mundial.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 08:02:00'),
(46, 'Adidas Nemeziz', 'adidas-nemeziz', 'Sepatu bola agility.', 'NEMEZIZ-046', 1800000.00, 8, 3, 'uploads/products/1752418969_Adidas Nemeziz.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 08:02:49'),
(47, 'Adidas Predator Freak', 'adidas-predator-freak', 'Sepatu bola.', 'PRED-FREAK-047', 1750000.00, 10, 3, 'uploads/products/1752419009_Adidas Predator Freak.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 08:03:29'),
(48, 'Adidas X Ghosted', 'adidas-x-ghosted', 'Super lightweight.', 'XGHOST-048', 1800000.00, 8, 3, 'uploads/products/1752419043_Adidas Predator Freak.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 08:04:03'),
(49, 'Adidas Copa Sense.1', 'adidas-copa-sense-1', 'Sentuhan sempurna.', 'COPA-S1-049', 1900000.00, 10, 3, 'uploads/products/1752419087_Adidas Copa Sense.1', 1, '2025-07-13 14:19:24', '2025-07-13 08:04:47'),
(50, 'Adidas F50 Ghosted', 'adidas-f50-ghosted', 'Legendary speed.', 'F50-050', 2000000.00, 6, 3, 'uploads/products/1752419159_Adidas F50 Ghosted.jpg', 1, '2025-07-13 14:19:24', '2025-07-13 08:05:59'),
(51, 'Adidas Campus 00s', 'adidas-casual-campus00s', 'Adidas campus 00s adalah sepatu yang bergaya casual, dan menjadi sepatu terlaris di kalangan anak muda.', 'AD-00S-CMP', 1200000.00, 30, 8, 'uploads/products/1752464053_campus00s-casual.jpg', 1, '2025-07-13 20:34:13', '2025-07-13 20:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Adidas Originals', 'adidas-originals', 'Koleksi sepatu Adidas dengan gaya klasik dan ikonik.', 'uploads/categories/1752415707_gazzele pink.jpg', '2025-07-13 14:06:27', '2025-07-13 07:08:27'),
(2, 'Adidas Running', 'adidas-running', 'Sepatu lari Adidas untuk performa maksimal.', 'uploads/categories/1752415744_running.jpg', '2025-07-13 14:06:27', '2025-07-13 07:09:04'),
(3, 'Adidas Football', 'adidas-football', 'Sepatu bola Adidas dengan teknologi terbaru.', 'uploads/categories/1752415766_adidas F50 Elite Laceless AG.jpg', '2025-07-13 14:06:27', '2025-07-13 07:09:26'),
(4, 'Adidas Training', 'adidas-training', 'Sepatu training dan gym Adidas.', 'uploads/categories/1752415799_Adidas Questar 3 training.jpg', '2025-07-13 14:06:27', '2025-07-13 07:09:59'),
(5, 'Adidas Skateboarding', 'adidas-skateboarding', 'Sepatu Adidas untuk skateboard.', 'uploads/categories/1752415854_campus00s-casual.jpg', '2025-07-13 14:06:27', '2025-07-13 07:10:54'),
(6, 'Adidas Outdoor', 'adidas-outdoor', 'Sepatu hiking dan outdoor Adidas.', 'uploads/categories/1752415885_adidas matchbreak.jpg', '2025-07-13 14:06:27', '2025-07-13 07:11:25'),
(7, 'Adidas Basketball', 'adidas-basketball', 'Sepatu basket Adidas.', 'uploads/categories/1752415939_Harden Vol. 4 adidas CA.jpg', '2025-07-13 14:06:27', '2025-07-13 07:12:19'),
(8, 'Adidas Casual', 'adidas-casual', 'Koleksi sepatu Adidas dengan gaya casual.', 'uploads/categories/1752463885_campus00s.jpg', '2025-07-13 20:31:25', '2025-07-13 20:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('da8hvcjvubzImdc2HtiRuuCsKJyKsDzFIAG4XULr', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUTUyMko0SnJIVkdBU1FLTlZmT0NCUVlQaVFaSkwwNzBwbkFYUTNIZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NTU6ImxvZ2luX2N1c3RvbWVyXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1752464095);

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `folder` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@solevibe.ac.id', NULL, '$2y$12$o6QEmhet4S3EwYr7qGFzH.XLpvj/Cfb/eSE5Kn9mSVq.QXh0TfSBa', NULL, '2025-07-13 07:03:03', '2025-07-13 07:03:03'),
(2, 'admin', 'adytri064@gmail.com', NULL, '$2y$12$08tr13nn7pv.T2xKZwVOr.aPcVgm2tqHMMroslcwpdcz3/vHdzGZy', NULL, '2025-07-13 20:03:34', '2025-07-13 20:03:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_itemable_type_itemable_id_index` (`itemable_type`,`itemable_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

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
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_product_category_id_foreign` (`product_category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_categories_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_product_category_id_foreign` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

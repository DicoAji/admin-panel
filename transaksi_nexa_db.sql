-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jul 2024 pada 10.41
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transaksi_nexa_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `counter`
--

CREATE TABLE `counter` (
  `id` int(11) NOT NULL,
  `bulan` varchar(10) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `counter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `counter`
--

INSERT INTO `counter` (`id`, `bulan`, `tahun`, `counter`) VALUES
(6, '7', 2024, 6),
(7, '7', 2024, 7),
(8, '7', 2024, 8),
(9, '7', 2024, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_counter`
--

CREATE TABLE `ms_counter` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ms_counter`
--

INSERT INTO `ms_counter` (`id`, `nama`, `alamat`, `phone`) VALUES
(6, 'Dico', 'Sengon', '0882003305460'),
(7, 'aji', 'Sengon', '0882003305460'),
(8, 'prasetyo', 'Sengon', '0882003305460'),
(9, 'customer1', 'Sengon', '0882003305460');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_d`
--

CREATE TABLE `transaksi_d` (
  `id` int(11) NOT NULL,
  `id_transaksi_h` int(11) DEFAULT NULL,
  `kd_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_d`
--

INSERT INTO `transaksi_d` (`id`, `id_transaksi_h`, `kd_barang`, `nama_barang`, `qty`, `subtotal`) VALUES
(6, 6, '1412', 'barang2', 3, 1000),
(7, 7, '123132', 'asdas', 2, 2000),
(8, 8, '12321', 'barang1', 2, 10000),
(9, 9, '1322131312', 'barang1', 3, 1000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_h`
--

CREATE TABLE `transaksi_h` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `nomor_transaksi` varchar(50) DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `total_transaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_h`
--

INSERT INTO `transaksi_h` (`id`, `id_customer`, `nomor_transaksi`, `tanggal_transaksi`, `total_transaksi`) VALUES
(6, 6, 'TRX1720334719', '2024-07-07', 3000),
(7, 7, 'TRX1720335101', '2024-07-22', 4000),
(8, 8, 'TRX1720335352', '2024-07-07', 20000),
(9, 9, 'TRX1720341475', '2024-07-07', 3000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_counter`
--
ALTER TABLE `ms_counter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_d`
--
ALTER TABLE `transaksi_d`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_h`
--
ALTER TABLE `transaksi_h`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `counter`
--
ALTER TABLE `counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `ms_counter`
--
ALTER TABLE `ms_counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `transaksi_d`
--
ALTER TABLE `transaksi_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `transaksi_h`
--
ALTER TABLE `transaksi_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

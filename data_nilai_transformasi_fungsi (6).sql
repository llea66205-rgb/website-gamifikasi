-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Sep 2026 pada 21.02
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
-- Database: `latihan transformasi fungsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_nilai_transformasi_fungsi`
--

CREATE TABLE `data_nilai_transformasi_fungsi` (
  `id` int(11) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Kelas` varchar(10) NOT NULL,
  `No_Absen` varchar(10) NOT NULL,
  `Skor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_nilai_transformasi_fungsi`
--

INSERT INTO `data_nilai_transformasi_fungsi` (`id`, `Nama`, `Kelas`, `No_Absen`, `Skor`) VALUES
(1, 'ayikkk', '1', '1', 10),
(2, 'yas', 's', '1', 30);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_nilai_transformasi_fungsi`
--
ALTER TABLE `data_nilai_transformasi_fungsi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_nilai_transformasi_fungsi`
--
ALTER TABLE `data_nilai_transformasi_fungsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

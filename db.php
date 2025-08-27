<?php
/*
 * File: db.php
 * Deskripsi: Konfigurasi dan koneksi ke database MySQL.
 */

$host = 'localhost';
$db_user = 'root'; // Ganti dengan username database Anda
$db_pass = '';     // Ganti dengan password database Anda
$db_name = 'toko_db'; // Nama database yang sudah dibuat

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
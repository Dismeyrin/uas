<?php
$servername = "localhost";  // atau nama host database Anda
$username = "root";         // atau nama pengguna database Anda
$password = "";             // atau kata sandi pengguna database Anda
$dbname = "perpustakaan";  // ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

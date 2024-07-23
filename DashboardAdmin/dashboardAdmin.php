<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/admin/sign_in.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
        }
        .navbar img {
            width: 40px;
        }
        .navbar .welcome {
            font-size: 18px;
        }
        .navbar .dropdown img {
            width: 40px;
            cursor: pointer;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            color: #fff;
            overflow-y: auto;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #007bff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            overflow-y: auto;
            height: calc(100vh - 60px);
        }
        .card {
            border: none;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 250px;
            width: calc(100% - 250px);
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="navbar">
    <img src="../assets/logoNav.png" alt="logo">
    <div class="welcome">Selamat datang admin - <span class="fw-bold text-capitalize"><?php echo $_SESSION['admin']['nama_admin']; ?></span></div>
    <div class="dropdown">
        <img src="../assets/adminLogo.png" alt="adminLogo" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item text-danger" href="signOut.php">Sign Out</a></li>
        </ul>
    </div>
</div>

<div class="sidebar">
    <a href="dashboardAdmin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="anggota/anggota.php"><i class="fas fa-users"></i> Anggota</a>
    <a href="buku/daftarBuku.php"><i class="fas fa-book"></i> Buku</a>
    <a href="peminjaman/peminjamanBuku.php"><i class="fas fa-book-reader"></i> Detil</a>
    <a href="pengembalian/pengembalianBuku.php"><i class="fas fa-undo"></i> Master</a>
    <a href="denda/daftarDenda.php"><i class="fas fa-money-bill-alt"></i> kategori</a>
    <a href="penerbit/penerbit.php"><i class="fas fa-money-bill-alt"></i> Penerbit</a>
    <a href="penulis/penulis.php"><i class="fas fa-money-bill-alt"></i> Penulis</a>
</div>

<div class="content">
    <?php
    // Mendapatkan tanggal dan waktu saat ini
    $date = date('Y-m-d H:i:s'); // Format tanggal dan waktu default (tahun-bulan-tanggal jam:menit:detik)
    // Mendapatkan hari dalam format teks (e.g., Senin, Selasa, ...)
    $day = date('l');
    // Mendapatkan tanggal dalam format 1 hingga 31
    $dayOfMonth = date('d');
    // Mendapatkan bulan dalam format teks (e.g., Januari, Februari, ...)
    $month = date('F');
    // Mendapatkan tahun dalam format 4 digit (e.g., 2023)
    $year = date('Y');
    ?>

    <h1 class="mt-5 fw-bold">Dashboard - <span class="fs-4 text-secondary"><?php echo $day . " " . $dayOfMonth . " " . $month . " " . $year; ?></span></h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Anggota</h5>
                    <p class="card-text">Kelola data anggota perpustakaan.</p>
                    <a href="member/member.php" class="btn btn-primary">Lihat Anggota</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Buku</h5>
                    <p class="card-text">Kelola daftar buku yang tersedia.</p>
                    <a href="buku/daftarBuku.php" class="btn btn-primary">Lihat Buku</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Peminjaman</h5>
                    <p class="card-text">Kelola data peminjaman buku.</p>
                    <a href="peminjaman/peminjamanBuku.php" class="btn btn-primary">Lihat Peminjaman</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pengembalian</h5>
                    <p class="card-text">Kelola data pengembalian buku.</p>
                    <a href="pengembalian/pengembalianBuku.php" class="btn btn-primary">Lihat Pengembalian</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Denda</h5>
                    <p class="card-text">Kelola data denda keterlambatan.</p>
                    <a href="denda/daftarDenda.php" class="btn btn-primary">Lihat Denda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    &copy; 2023 CuyPerpus. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

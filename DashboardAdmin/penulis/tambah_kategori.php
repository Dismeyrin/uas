<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/admin/sign_in.php");
    exit;
}

require '../peminjaman/conf.php'; // memastikan file config.php di-include

// Query untuk mengambil data dari tabel tb_kategori
$query = "SELECT kodekategori, nama_kategori FROM tb_kategori";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($conn));
}

// Fungsi untuk menambahkan kategori
if (isset($_POST['tambah_kategori'])) {
    $kodekategori = $_POST['kodekategori'];
    $nama_kategori = $_POST['nama_kategori'];
    
    $insert_query = "INSERT INTO tb_kategori (kodekategori, nama_kategori) VALUES ('$kodekategori', '$nama_kategori')";
    $insert_result = mysqli_query($conn, $insert_query);
    
    if (!$insert_result) {
        die("Gagal menambahkan kategori: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menambahkan data
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fungsi untuk menghapus kategori
if (isset($_POST['delete_kategori'])) {
    $kode_kategori = $_POST['kode_kategori'];
    $delete_query = "DELETE FROM tb_kategori WHERE kodekategori = '$kode_kategori'";
    $delete_result = mysqli_query($conn, $delete_query);
    
    if (!$delete_result) {
        die("Gagal menghapus kategori: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menghapus data
    header("Location: $_SERVER[PHP_SELF]");
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
    <title>Admin Dashboard - Master Kategori</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }
        .content {
            padding: 20px;
            overflow-y: auto;
            height: calc(100vh - 20px);
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
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="content">
    <h1 class="mt-5 fw-bold">Master Kategori</h1>
    
    <div class="mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal"><i class="fas fa-plus"></i> Tambah Data</button>
    </div>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Kode Kategori</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['kodekategori']; ?></td>
                        <td><?php echo $row['nama_kategori']; ?></td>
                        <td>
                            <form action="edit_kategori.php" method="POST" style="display: inline-block;">
                                <input type="hidden" name="kode_kategori" value="<?php echo $row['kodekategori']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button>
                            </form>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline-block;">
                                <input type="hidden" name="kode_kategori" value="<?php echo $row['kodekategori']; ?>">
                                <button type="submit" name="delete_kategori" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kodekategori" class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" id="kodekategori" name="kodekategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_kategori" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    &copy; 2024 Perpustakan. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
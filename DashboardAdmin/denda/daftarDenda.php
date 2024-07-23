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

// Fungsi untuk menambah kategori baru
if (isset($_POST['tambah_kategori'])) {
    $kode_kategori = $_POST['kode_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    $insert_query = "INSERT INTO tb_kategori (kodekategori, nama_kategori) VALUES ('$kode_kategori', '$nama_kategori')";
    $insert_result = mysqli_query($conn, $insert_query);
    
    if (!$insert_result) {
        die("Gagal menambah kategori: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menambah data
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fungsi untuk mengedit kategori
if (isset($_POST['edit_kategori'])) {
    $kode_kategori = $_POST['kode_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    $update_query = "UPDATE tb_kategori SET nama_kategori='$nama_kategori' WHERE kodekategori='$kode_kategori'";
    $update_result = mysqli_query($conn, $update_query);
    
    if (!$update_result) {
        die("Gagal mengedit kategori: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah mengedit data
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
    
    <!-- Button untuk menambah data kategori -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal"><i class="fas fa-plus"></i> Tambah Data</button>

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
                            <!-- Button untuk membuka modal edit -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editKategoriModal" data-kode="<?php echo $row['kodekategori']; ?>" data-nama="<?php echo $row['nama_kategori']; ?>"><i class="fas fa-edit"></i> Edit</button>
                            <!-- Form hapus kategori -->
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
                        <label for="tambah_kodekategori" class="form-label">Kode Kategori</label>
                        <input type="text" class="form-control" id="tambah_kodekategori" name="kode_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="tambah_nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_kategori" class="btn btn-success">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKategoriModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kode_kategori" id="edit_kodekategori">
                    <div class="mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_kategori" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    &copy; 2024 Perpustakan. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // Script untuk mengisi data modal edit dengan data dari tabel
    document.addEventListener('DOMContentLoaded', function () {
        var editKategoriModal = document.getElementById('editKategoriModal');
        editKategoriModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var kodeKategori = button.getAttribute('data-kode');
            var namaKategori = button.getAttribute('data-nama');

            var kodeKategoriInput = editKategoriModal.querySelector('#edit_kodekategori');
            var namaKategoriInput = editKategoriModal.querySelector('#edit_nama_kategori');

            kodeKategoriInput.value = kodeKategori;
            namaKategoriInput.value = namaKategori;
        });
    });
</script>
</body>
</html>

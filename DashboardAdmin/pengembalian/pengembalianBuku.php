<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/admin/sign_in.php");
    exit;
}

require '../peminjaman/conf.php'; // memastikan file config.php di-include

// Query untuk mengambil data dari tabel tb_mastertransaksi
$query = "SELECT kodetransaksi, tgltransaksi, kodeanggota FROM tb_mastertransaksi";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($conn));
}

// Fungsi untuk menghapus transaksi
if (isset($_POST['delete_transaksi'])) {
    $kodetransaksi = $_POST['kodetransaksi'];
    $delete_query = "DELETE FROM tb_mastertransaksi WHERE kodetransaksi = '$kodetransaksi'";
    $delete_result = mysqli_query($conn, $delete_query);
    if (!$delete_result) {
        die("Gagal menghapus transaksi: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menghapus data
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fungsi untuk menambah transaksi baru
if (isset($_POST['tambah_transaksi'])) {
    $kodetransaksi = $_POST['kodetransaksi'];
    $tgltransaksi = $_POST['tgltransaksi'];
    $kodeanggota = $_POST['kodeanggota'];
    $insert_query = "INSERT INTO tb_mastertransaksi (kodetransaksi, tgltransaksi, kodeanggota) VALUES ('$kodetransaksi', '$tgltransaksi', '$kodeanggota')";
    $insert_result = mysqli_query($conn, $insert_query);
    
    if (!$insert_result) {
        die("Gagal menambah transaksi: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menambah data
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fungsi untuk mengedit transaksi
if (isset($_POST['edit_transaksi'])) {
    $kodetransaksi = $_POST['kodetransaksi'];
    $tgltransaksi = $_POST['tgltransaksi'];
    $kodeanggota = $_POST['kodeanggota'];
    $update_query = "UPDATE tb_mastertransaksi SET tgltransaksi='$tgltransaksi', kodeanggota='$kodeanggota' WHERE kodetransaksi='$kodetransaksi'";
    $update_result = mysqli_query($conn, $update_query);
    
    if (!$update_result) {
        die("Gagal mengedit transaksi: " . mysqli_error($conn));
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard - Transaksi</title>
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
    <h1 class="mt-5 fw-bold">Data Transaksi</h1>
    
    <!-- Button untuk menambah data transaksi -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahTransaksiModal"><i class="fas fa-plus"></i> Tambah Data</button>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Kode Anggota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['kodetransaksi']; ?></td>
                        <td><?php echo $row['tgltransaksi']; ?></td>
                        <td><?php echo $row['kodeanggota']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTransaksiModal" data-kode="<?php echo $row['kodetransaksi']; ?>" data-tanggal="<?php echo $row['tgltransaksi']; ?>" data-anggota="<?php echo $row['kodeanggota']; ?>"><i class="fas fa-edit"></i> Edit</button>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline-block;">
                                <input type="hidden" name="kodetransaksi" value="<?php echo $row['kodetransaksi']; ?>">
                                <button type="submit" name="delete_transaksi" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="tambahTransaksiModal" tabindex="-1" aria-labelledby="tambahTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTransaksiModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tambah_kodetransaksi" class="form-label">Kode Transaksi</label>
                        <input type="text" class="form-control" id="tambah_kodetransaksi" name="kodetransaksi" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_tgltransaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tambah_tgltransaksi" name="tgltransaksi" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_kodeanggota" class="form-label">Kode Anggota</label>
                        <input type="text" class="form-control" id="tambah_kodeanggota" name="kodeanggota" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_transaksi" class="btn btn-success">Tambah Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="editTransaksiModal" tabindex="-1" aria-labelledby="editTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransaksiModalLabel">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kodetransaksi" id="edit_kodetransaksi">
                    <div class="mb-3">
                        <label for="edit_tgltransaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="edit_tgltransaksi" name="tgltransaksi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kodeanggota" class="form-label">Kode Anggota</label>
                        <input type="text" class="form-control" id="edit_kodeanggota" name="kodeanggota" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_transaksi" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer>
    &copy; 2024 Perpustakan. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script untuk mengisi data modal edit dengan data dari tabel
    document.addEventListener('DOMContentLoaded', function () {
        var editTransaksiModal = document.getElementById('editTransaksiModal');
        editTransaksiModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var kodetransaksi = button.getAttribute('data-kode');
            var tgltransaksi = button.getAttribute('data-tanggal');
            var kodeanggota = button.getAttribute('data-anggota');

            var modalTitle = editTransaksiModal.querySelector('.modal-title');
            var kodetransaksiInput = editTransaksiModal.querySelector('#edit_kodetransaksi');
            var tgltransaksiInput = editTransaksiModal.querySelector('#edit_tgltransaksi');
            var kodeanggotaInput = editTransaksiModal.querySelector('#edit_kodeanggota');

            modalTitle.textContent = 'Edit Transaksi: ' + kodetransaksi;
            kodetransaksiInput.value = kodetransaksi;
            tgltransaksiInput.value = tgltransaksi;
            kodeanggotaInput.value = kodeanggota;
        });
    });
</script>
</body>
</html>

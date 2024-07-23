<?php
session_start();

if (!isset($_SESSION["signIn"])) {
    header("Location: ../sign/admin/sign_in.php");
    exit;
}

require '../peminjaman/conf.php'; // memastikan file config.php di-include

// Query untuk mengambil data dari tabel tb_penulis
$query = "SELECT kodepenulis, namapenulis, alamatpenulis, tlppenulis FROM tb_penulis";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($conn));
}

// Fungsi untuk menghapus penulis
if (isset($_POST['delete_penulis'])) {
    $kode_penulis = $_POST['kode_penulis'];
    $delete_query = "DELETE FROM tb_penulis WHERE kodepenulis = '$kode_penulis'";
    $delete_result = mysqli_query($conn, $delete_query);
    if (!$delete_result) {
        die("Gagal menghapus penulis: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menghapus data
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fungsi untuk menambah penulis baru
if (isset($_POST['tambah_penulis'])) {
    $kode_penulis = $_POST['kode_penulis'];
    $nama_penulis = $_POST['nama_penulis'];
    $alamat_penulis = $_POST['alamat_penulis'];
    $tlp_penulis = $_POST['tlp_penulis'];
    $insert_query = "INSERT INTO tb_penulis (kodepenulis, namapenulis, alamatpenulis, tlppenulis) VALUES ('$kode_penulis', '$nama_penulis', '$alamat_penulis', '$tlp_penulis')";
    $insert_result = mysqli_query($conn, $insert_query);
    
    if (!$insert_result) {
        die("Gagal menambah penulis: " . mysqli_error($conn));
    }
    // Redirect atau refresh halaman setelah menambah data
    header("Location: $_SERVER[PHP_SELF]");
    exit;
}

// Fungsi untuk mengedit penulis
if (isset($_POST['edit_penulis'])) {
    $kode_penulis = $_POST['kode_penulis'];
    $nama_penulis = $_POST['nama_penulis'];
    $alamat_penulis = $_POST['alamat_penulis'];
    $tlp_penulis = $_POST['tlp_penulis'];
    $update_query = "UPDATE tb_penulis SET namapenulis='$nama_penulis', alamatpenulis='$alamat_penulis', tlppenulis='$tlp_penulis' WHERE kodepenulis='$kode_penulis'";
    $update_result = mysqli_query($conn, $update_query);
    
    if (!$update_result) {
        die("Gagal mengedit penulis: " . mysqli_error($conn));
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
    <title>Admin Dashboard - Penulis</title>
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
    <h1 class="mt-5 fw-bold">Penulis</h1>
    
    <!-- Button untuk menambah data penulis -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahPenulisModal"><i class="fas fa-plus"></i> Tambah Data</button>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Kode Penulis</th>
                <th>Nama Penulis</th>
                <th>Alamat Penulis</th>
                <th>Telepon Penulis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['kodepenulis']; ?></td>
                        <td><?php echo $row['namapenulis']; ?></td>
                        <td><?php echo $row['alamatpenulis']; ?></td>
                        <td><?php echo $row['tlppenulis']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editPenulisModal" data-kode="<?php echo $row['kodepenulis']; ?>" data-nama="<?php echo $row['namapenulis']; ?>" data-alamat="<?php echo $row['alamatpenulis']; ?>" data-tlp="<?php echo $row['tlppenulis']; ?>"><i class="fas fa-edit"></i> Edit</button>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline-block;">
                                <input type="hidden" name="kode_penulis" value="<?php echo $row['kodepenulis']; ?>">
                                <button type="submit" name="delete_penulis" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data penulis.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Penulis -->
<div class="modal fade" id="tambahPenulisModal" tabindex="-1" aria-labelledby="tambahPenulisModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPenulisModalLabel">Tambah Penulis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tambah_kodepenulis" class="form-label">Kode Penulis</label>
                        <input type="text" class="form-control" id="tambah_kodepenulis" name="kode_penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_nama_penulis" class="form-label">Nama Penulis</label>
                        <input type="text" class="form-control" id="tambah_nama_penulis" name="nama_penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_alamat_penulis" class="form-label">Alamat Penulis</label>
                        <input type="text" class="form-control" id="tambah_alamat_penulis" name="alamat_penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="tambah_tlp_penulis" class="form-label">Telepon Penulis</label>
                        <input type="text" class="form-control" id="tambah_tlp_penulis" name="tlp_penulis" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_penulis" class="btn btn-success">Tambah Penulis</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Penulis -->
<div class="modal fade" id="editPenulisModal" tabindex="-1" aria-labelledby="editPenulisModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPenulisModalLabel">Edit Penulis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kode_penulis" id="edit_kodepenulis">
                    <div class="mb-3">
                        <label for="edit_nama_penulis" class="form-label">Nama Penulis</label>
                        <input type="text" class="form-control" id="edit_nama_penulis" name="nama_penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat_penulis" class="form-label">Alamat Penulis</label>
                        <input type="text" class="form-control" id="edit_alamat_penulis" name="alamat_penulis" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tlp_penulis" class="form-label">Telepon Penulis</label>
                        <input type="text" class="form-control" id="edit_tlp_penulis" name="tlp_penulis" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="edit_penulis" class="btn btn-primary">Simpan Perubahan</button>
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
        var editPenulisModal = document.getElementById('editPenulisModal');
        editPenulisModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var kodePenulis = button.getAttribute('data-kode');
            var namaPenulis = button.getAttribute('data-nama');
            var alamatPenulis = button.getAttribute('data-alamat');
            var tlpPenulis = button.getAttribute('data-tlp');

            var modalTitle = editPenulisModal.querySelector('.modal-title');
            var kodePenulisInput = editPenulisModal.querySelector('#edit_kodepenulis');
            var namaPenulisInput = editPenulisModal.querySelector('#edit_nama_penulis');
            var alamatPenulisInput = editPenulisModal.querySelector('#edit_alamat_penulis');
            var tlpPenulisInput = editPenulisModal.querySelector('#edit_tlp_penulis');

            modalTitle.textContent = 'Edit Penulis: ' + namaPenulis;
            kodePenulisInput.value = kodePenulis;
            namaPenulisInput.value = namaPenulis;
            alamatPenulisInput.value = alamatPenulis;
            tlpPenulisInput.value = tlpPenulis;
        });
    });
</script>
</body>
</html>

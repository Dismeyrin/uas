<?php 
require "../../loginSystem/connect.php";

if (isset($_POST["signUp"])) {
    if (signUp($_POST) > 0) {
        echo "<script>alert('Sign Up berhasil!')</script>";
    } else {
        echo "<script>alert('Sign Up gagal!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Sign Up || Member</title>
    <style>
        .form-container {
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5 form-container">
        <div class="card p-3">
            <div class="text-center">
                <img src="../../assets/memberLogo.png" alt="adminLogo" width="85px">
            </div>
            <h2 class="text-center fw-bold">Sign Up</h2>
            <form action="" method="post" class="needs-validation" novalidate>
                <?php
                function createInput($type, $name, $icon, $label) {
                    echo "
                    <div class='mb-3'>
                        <label for='{$name}' class='form-label'>{$label}</label>
                        <div class='input-group'>
                            <span class='input-group-text'><i class='{$icon}'></i></span>
                            <input type='{$type}' class='form-control' name='{$name}' id='{$name}' required>
                            <div class='invalid-feedback'>{$label} wajib diisi!</div>
                        </div>
                    </div>
                    ";
                }

                createInput('number', 'nisn', 'fa-solid fa-hashtag', 'Nisn');
                createInput('text', 'kode_member', '', 'Kode Member');
                createInput('text', 'nama', 'fa-solid fa-user', 'Nama Lengkap');
                createInput('password', 'password', 'fa-solid fa-lock', 'Password');
                createInput('password', 'confirmPw', 'fa-solid fa-lock', 'Confirm Password');
                createInput('number', 'no_tlp', 'fa-solid fa-phone', 'No Telepon');
                createInput('date', 'tgl_pendaftaran', 'fa-solid fa-calendar-days', 'Tanggal Pendaftaran');

                function createSelect($name, $label, $options) {
                    echo "
                    <div class='mb-3'>
                        <label for='{$name}' class='form-label'>{$label}</label>
                        <select class='form-select' id='{$name}' name='{$name}' required>
                            <option selected disabled value=''>Choose...</option>
                            {$options}
                        </select>
                        <div class='invalid-feedback'>{$label} wajib dipilih!</div>
                    </div>
                    ";
                }

                createSelect('jenis_kelamin', 'Gender', '
                    <option value="Laki laki">Laki laki</option>
                    <option value="Perempuan">Perempuan</option>
                ');

                createSelect('kelas', 'Kelas', '
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                    <option value="XII">XII</option>
                    <option value="XIII">XIII</option>
                ');

                createSelect('jurusan', 'Jurusan', '
                    <option value="Desain Gambar Mesin">Desain Gambar Mesin</option>
                    <option value="Teknik Pemesinan">Teknik Pemesinan</option>
                    <option value="Teknik Otomotif">Teknik Otomotif</option>
                    <option value="Desain Pemodelan Informasi Bangunan">Desain Pemodelan Informasi Bangunan</option>
                    <option value="Teknik Konstruksi Perumahan">Teknik Konstruksi Perumahan</option>
                    <option value="Teknik Tenaga Listrik">Teknik Tenaga Listrik</option>
                    <option value="Teknik Instalasi Tenaga Listrik">Teknik Instalasi Tenaga Listrik</option>
                    <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                    <option value="Sistem Informatika Jaringan dan Aplikasi">Sistem Informatika Jaringan dan Aplikasi</option>
                    <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                    <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                ');
                ?>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" name="signUp">Sign Up</button>
                    <button class="btn btn-warning text-light" type="reset">Reset</button>
                </div>
                <p class="mt-3 text-center">Already have an account? <a href="sign_in.php" class="text-decoration-none text-primary">Sign In</a></p>
            </form>
        </div>
    </div>

    <script>
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

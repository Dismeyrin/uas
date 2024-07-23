<?php 
session_start();

//Jika member sudah login, tidak boleh kembali ke halaman login, kecuali logout
if(isset($_SESSION["signIn"]) ) {
  header("Location: ../../DashboardMember/dashboardMember.php");
  exit;
}

require "../../loginSystem/connect.php";

if(isset($_POST["signIn"]) ) {
  
  $nama = strtolower($_POST["nama"]);
  $nisn = $_POST["nisn"];
  $password = $_POST["password"];
  
  $result = mysqli_query($connect, "SELECT * FROM member WHERE nama = '$nama' AND nisn = $nisn");
  
  if(mysqli_num_rows($result) === 1) {
    //cek pw 
    $pw = mysqli_fetch_assoc($result);
    if(password_verify($password, $pw["password"]) ) {
      // SET SESSION 
      $_SESSION["signIn"] = true;
      $_SESSION["member"]["nama"] = $nama;
      $_SESSION["member"]["nisn"] = $nisn;
      header("Location: ../../DashboardMember/buku/daftarBuku.php");
      exit;
    }
  }
  $error = true;
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
  <title>Sign In || Member</title>
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
      <h2 class="text-center fw-bold">Sign In</h2>
      <form action="" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Lengkap</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <input type="text" class="form-control" name="nama" id="nama" required>
            <div class="invalid-feedback">
                Masukkan nama anda!
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="nisn" class="form-label">Nisn</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
            <input type="number" class="form-control" name="nisn" id="nisn" required>
            <div class="invalid-feedback">
                Masukkan Nisn anda!
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">
                Masukkan Password anda!
            </div>
          </div>
        </div>
        <div class="d-grid gap-2">
          <button class="btn btn-primary" type="submit" name="signIn">Sign In</button>
          <a class="btn btn-success" href="../link_login.html">Batal</a>
        </div>
        <p class="mt-3 text-center">Don't have an account yet? <a href="sign_up.php" class="text-decoration-none text-primary">Sign Up</a></p>
      </form>
      <?php if(isset($error)) : ?>
        <div class="alert alert-danger mt-2" role="alert">Nama / Nisn / Password tidak sesuai!</div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    (function () {
      'use strict';
      const forms = document.querySelectorAll('.needs-validation');
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

<?php 
require "../../config/config.php";
$kodebuku = $_GET["kodebuku"];
//var_dump($bukuId); die;

if(delete($kodebuku) > 0) {
  echo "
  <script>
  alert('Data buku berhasil dihapus');
  document.location.href = 'daftarBuku.php';
  </script>";
}else {
  echo "
  <script>
  alert('Data buku gagal dihapus');
  document.location.href = 'daftarBuku.php';
  </script>";
}
?>
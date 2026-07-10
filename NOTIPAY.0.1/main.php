<?php
session_start();
include 'connect.php';
include 'header.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$kategori = mysqli_query($conn, "
    SELECT * FROM categories 
    WHERE id_user = '$id_user'
    ORDER BY nama_category ASC
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>NotiPay - Kategori Tagihan</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
  <h2 class="title-page1 mb-4 text-light">KATEGORI TAGIHAN</h2>

  <a href="tambah_kategori.php" class="add-btn btn mb-3" style="margin-right: 7px;">+ Tambah Kategori</a>
  

  <div class="cont">
    <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
      <div class="col-md-4 mb-3">
        <a href="kategori.php?id_category=<?= $k['id_category']; ?>" class="text-decoration-none">
         <div class="kategori-cont d-flex justify-content-between align-items-center">
            <h4 class=" nama-kat mb-0"><?= $k['nama_category']; ?></h4>

            <a href="hapus_kategori.php?id_category=<?= $k['id_category']; ?>"
              onclick="return confirm('Yakin ingin menghapus kategori ini? Semua tagihan di dalamnya akan ikut terhapus.');"
              class="fw-bold" style="text-decoration:none;">
              X           
            </a>
        </div>

        </a>
      </div>
    <?php } ?>
  </div>

</div>
</body>
</html>

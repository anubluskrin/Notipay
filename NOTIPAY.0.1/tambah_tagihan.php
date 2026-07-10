<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user']; // gunakan id_user

if (!isset($_GET['id_category'])) {
    header("Location: main.php");
    exit;
}

$idcat = intval($_GET['id_category']);

// CEK kategori apakah punya user ini
$kategori = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT * FROM categories 
  WHERE id_category='$idcat'
"));

if (!$kategori) {
    echo "<script>
    alert('❌ Anda tidak memiliki akses ke kategori ini!');
    window.location='main.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Tagihan - <?= $kategori['nama_category']; ?></title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

<style>

</style>
</head>
<body class="tambah">

<div class="container mt-5">
  <div class="card-holder">
  <h3 class="title-page1">Tambah Tagihan: <?= $kategori['nama_category']; ?></h3>

  <form method="post">
    <div class="mb-3">
      <label>Nama Tagihan</label>
      <input type="text" name="nama_tagihan" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="jumlah" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Jatuh Tempo</label>
      <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
    </div>

    <button type="submit" name="simpan" class="btn add-btn">Simpan</button>
    <a href="kategori.php?id_category=<?= $idcat ?>" class="btn back-btn">Kembali</a>
  </form>

  <?php
  if (isset($_POST['simpan'])) {

    $nama = $_POST['nama_tagihan'];
    $jumlah = $_POST['jumlah'];
    $tgl = $_POST['tanggal_jatuh_tempo'];

    mysqli_query($conn, "
      INSERT INTO bills (nama_tagihan, jumlah, tanggal_jatuh_tempo, id_category, id_user)
      VALUES ('$nama', '$jumlah', '$tgl', '$idcat', '$id_user')
    ");

    echo "<script>
      alert('Tagihan berhasil ditambahkan!');
      window.location='kategori.php?id_category=$idcat';
      </script>";
  }
  ?>

</div>
</body>
</html>

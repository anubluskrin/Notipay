<?php
session_start();
include 'connect.php';
include 'header.php';
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_category'])) {
    header("Location: main.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$idcat = intval($_GET['id_category']);

date_default_timezone_set('Asia/Jakarta');

$today = date('Y-m-d');
$idcat = $_GET['id_category'];

$kategori = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT * FROM categories 
  WHERE id_category='$idcat'
"));



// AMBIL TAGIHAN BERDASARKAN KATEGORI
$tagihan = mysqli_query($conn, "
  SELECT * FROM bills 
  WHERE id_category='$idcat'
  AND id_user='{$_SESSION['id_user']}'
  ORDER BY tanggal_jatuh_tempo ASC
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tagihan <?= $kategori['nama_category']; ?></title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<style>

</style>
<body>

<div class="container mt-5">

  <h2 class="title-page mb-4">Tagihan <?= $kategori['nama_category']; ?></h2>

<div class="">
  <a href="tambah_tagihan.php?id_category=<?= $idcat ?>" class="add-btn btn mb-3" style="margin-right: 7px;">+ Tambah Tagihan</a>
  <a href="main.php" class="back-btn btn mb-3 ">Kembali ke Kategori</a>
</div>

  <table class="table table-glass">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Tagihan</th>
        <th>Jumlah</th>
        <th>Jatuh Tempo</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $no = 1;
      while ($row = mysqli_fetch_assoc($tagihan)) {

        $tgl = $row['tanggal_jatuh_tempo'];
        $status = $row['status'];
        $diff = (strtotime($tgl) - strtotime($today)) / 86400;

        // Badge warna
        if ($status == 'Lunas') {
          $badge = 'success';
        } elseif ($diff < 0) {
          $badge = 'danger'; // Lewat tempo
        } elseif ($diff <= 3) {
          $badge = 'warning'; // Tinggal 3 hari
        } else {
          $badge = 'secondary';
        }

        echo "<tr>
          <td>{$no}</td>
          <td>{$row['nama_tagihan']}</td>
          <td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>
          <td>{$row['tanggal_jatuh_tempo']}</td>
          <td><span class='badge bg-$badge'>{$status}</span></td>

          <td>
            <a href='edit.php?id={$row['id']}' class='btn btn-sm add-btn'>Edit</a>
            <a href='hapus.php?id={$row['id']}' class='btn btn-sm back-btn' 
               onclick='return confirm(\"Hapus tagihan ini?\")'>Hapus</a>
            " . ($status == 'Belum' 
                ? "<a href='update_status.php?id={$row['id']}' class='btn btn-sm btn-success'>Tandai Lunas</a>" 
                : "") . "
          </td>
        </tr>";

        $no++;
      }
      ?>
    </tbody>
  </table>



  <!-- Bagian Pengingat -->
  <hr>
  <h5 class="mb-3 text-center reminder-text">JANGAN LUPA !!</h5>

  <?php
$alert = mysqli_query($conn, "
    SELECT * FROM bills
    WHERE id_category='$idcat'
    AND id_user='{$_SESSION['id_user']}'
    AND status='Belum'
    AND DATEDIFF(tanggal_jatuh_tempo, '$today') <= 3
");



  if (mysqli_num_rows($alert) > 0) {

    while ($a = mysqli_fetch_assoc($alert)) {
      $sisa = (strtotime($a['tanggal_jatuh_tempo']) - strtotime($today)) / 86400;

      echo "<div class='alert alert-warning'>
        ! Tagihan <b>{$a['nama_tagihan']}</b> jatuh tempo dalam <b>{$sisa}</b> hari!
      </div>";
    }

  } else {
    echo "<div class='alert alert-success'>
      Tidak ada tagihan kategori ini yang mendekati jatuh tempo.
    </div>";
  }
  ?>

</div>
</body>
</html>

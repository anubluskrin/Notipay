<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
  header("Location: main.php");
  exit;
}

$id = intval($_GET['id']);

// ambil data tagihan
$user_id = $_SESSION['id_user'];

$data = mysqli_query($conn, "
    SELECT * FROM bills 
    WHERE id=$id 
    AND id_user='$user_id'
");
$row = mysqli_fetch_assoc($data);


// Jika data tidak ditemukan
if (!$row) {
  echo "Data tidak ditemukan!";
  exit;
}

// setelah $row ada, ambil id_category untuk redirect kembali
$idcat = $row['id_category'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Tagihan</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body class="tambah">

<div class="container mt-5">
  <h3 class="title-page">Edit Tagihan</h3>

  <form method="post">
    <div class="card-holder">
    <div class="mb-3">
      <label>Nama Tagihan</label>
      <input type="text" name="nama_tagihan" class="form-control" value="<?php echo htmlspecialchars($row['nama_tagihan']); ?>" required>
    </div>

    <div class="mb-3">
      <label>Jumlah</label>
      <input type="number" name="jumlah" class="form-control" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
    </div>

    <div class="mb-3">
      <label>Tanggal Jatuh Tempo</label>
      <input type="date" name="tanggal_jatuh_tempo" class="form-control" 
        value="<?php echo htmlspecialchars($row['tanggal_jatuh_tempo']); ?>" required>
    </div>

    <div class="mb-3">
      <label>Status</label>
      <select name="status" class="form-control">
        <option value="Belum" <?php echo ($row['status']=='Belum') ? 'selected' : ''; ?>>Belum</option>
        <option value="Lunas" <?php echo ($row['status']=='Lunas') ? 'selected' : ''; ?>>Lunas</option>
      </select>
    </div>
</div>
    <button type="submit" name="update" class="btn add-btn">Update</button>
    <a href="kategori.php?id_category=<?php echo urlencode($idcat); ?>" class="btn back-btn">Kembali</a>
  </form>

  <?php
  if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_tagihan']);
    $jumlah = floatval($_POST['jumlah']);
    $tgl = mysqli_real_escape_string($conn, $_POST['tanggal_jatuh_tempo']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

$update = mysqli_query($conn, "
  UPDATE bills 
  SET nama_tagihan='$nama', jumlah='$jumlah', tanggal_jatuh_tempo='$tgl', status='$status'
  WHERE id=$id AND id_user='$user_id'
");


    if ($update) {
      echo "<script>
      alert('Data berhasil diupdate!');
      window.location='kategori.php?id_category=" . $idcat . "';
      </script>";
      exit;
    } else {
      echo "<div class='alert alert-danger mt-3'>Gagal memperbarui data.</div>";
    }
  }
  ?>
</div>

</body>
</html>

<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Kategori</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>

<body class="tambah">

<div class="container mt-5">
    <h2 class="text-light mb-4">Tambah Kategori Baru</h2>

    <form method="post">
        <div class="mb-3">
            <label class="form-label text-light">Nama Kategori</label>
            <input type="text" name="nama_category" class="form-control" required>
        </div>

        <button type="submit" name="simpan" class="btn add-btn">Simpan</button>
        <a href="kategori.php" class="btn back-btn">Kembali</a>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama_category']);

        // Simpan kategori untuk user yang login
        // tiap user punya kategori sendiri
        $insert = mysqli_query($conn, "
            INSERT INTO categories (nama_category, id_user) 
            VALUES ('$nama', '$id_user')
        ");

        if ($insert) {
            echo "<script>
                alert('Kategori berhasil ditambahkan!');
                window.location='kategori.php';
            </script>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Gagal menambah kategori.</div>";
        }
    }
    ?>
</div>

</body>
</html>

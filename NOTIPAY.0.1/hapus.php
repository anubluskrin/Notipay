<?php
session_start();
include 'connect.php';

// Pastikan user login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: main.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['id_user'];

// Ambil data tagihan yang akan dihapus, pastikan milik user tersebut
$data = mysqli_query($conn, "
    SELECT id_category 
    FROM bills 
    WHERE id = $id 
    AND id_user = '$user_id'
");

$row = mysqli_fetch_assoc($data);

// Jika tidak ada data  bukan milik user
if (!$row) {
    echo "<script>
        alert('Akses ditolak! Data bukan milik akun ini.');
        window.location='main.php';
    </script>";
    exit;
}

$idcat = $row['id_category'];

// Hapus data
mysqli_query($conn, "
    DELETE FROM bills 
    WHERE id = $id AND id_user = '$user_id'
");

// Redirect balik ke kategori
header("Location: kategori.php?id_category=$idcat");
exit;
?>

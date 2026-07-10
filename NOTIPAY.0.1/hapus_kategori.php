<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_category'])) {
    header("Location: kategori.php");
    exit;
}

$id_category = intval($_GET['id_category']);
$id_user = $_SESSION['id_user'];

//kategori milik user yang login
$cek = mysqli_query($conn, "
    SELECT id_category FROM categories 
    WHERE id_category = '$id_category' AND id_user = '$id_user'
");

if (mysqli_num_rows($cek) === 0) {
    echo "<script>
        alert('Kategori tidak ditemukan atau bukan milik Anda!');
        window.location='kategori.php';
    </script>";
    exit;
}

// Hapus kategori (bills yang terkait akan ikut terhapus karena ON DELETE CASCADE)
$delete = mysqli_query($conn, "
    DELETE FROM categories 
    WHERE id_category = '$id_category' AND id_user = '$id_user'
");

if ($delete) {
    echo "<script>
        alert('Kategori berhasil dihapus!');
        window.location='kategori.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus kategori!');
        window.location='kategori.php';
    </script>";
}
?>

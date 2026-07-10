<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);
$id_user = $_SESSION['id_user'];

// 1. Ambil data tagihan berdasarkan id + user
$cek = mysqli_query($conn, "
    SELECT id_category 
    FROM bills 
    WHERE id='$id' AND id_user='$id_user'
");

if (mysqli_num_rows($cek) === 0) {
    // Jika bukan milik user yang login
    echo "
    <script>
    alert('Anda tidak memiliki akses untuk mengubah tagihan ini!');
    window.location='main.php';
    </script>";
    exit;
}

$data = mysqli_fetch_assoc($cek);
$idcat = $data['id_category'];

// 2. Update status menjadi Lunas
mysqli_query($conn, "
    UPDATE bills 
    SET status='Lunas' 
    WHERE id='$id' AND id_user='$id_user'
");

echo "
<script>
alert('Tagihan berhasil ditandai LUNAS!');
window.location='kategori.php?id_category=$idcat';
</script>
";
exit;

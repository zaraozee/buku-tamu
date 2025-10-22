<?php
// Panggil file function.php
require_once 'function.php';

// Jika ada id yang dikirim lewat URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapus_user($id) > 0) {
        // Jika data berhasil dihapus
        echo "<script>alert('Data Berhasil dihapus!');</script>";

        echo "<script>window.location.href='users.php';</script>";
    } else {
        // Jika gagal dihapus
        echo "<script>alert('Data Gagal dihapus!');</script>";
        echo "<script>window.location.href='users.php';</script>";
    }
}
?>
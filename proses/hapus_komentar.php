<?php
include "../koneksi/koneksi.php"; 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && isset($_GET["hapus_komentar"])) {
    $id_video = $_GET["id"];
    $id_komentar = $_GET["hapus_komentar"];

    $hapus_query = "DELETE FROM komentar WHERE id = $id_komentar";

    // Eksekusi query
    if (mysqli_query($koneksi, $hapus_query)) {
        header("Location: ../video_admin.php?id=$id_video");
        exit();
    } else {
        echo "Gagal menghapus komentar: " . mysqli_error($koneksi);
    }
} else {
    echo "Akses tidak sah.";
}
?>

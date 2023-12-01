<?php
include "../koneksi/koneksi.php"; // Ganti dengan path ke file koneksi Anda

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Nonaktifkan konstrain referensial
    mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS = 0");

    // Hapus kategori yang terkait
    $delete_kategori_query = "DELETE FROM kategori WHERE id_video = $id";
    mysqli_query($koneksi, $delete_kategori_query);

    // Hapus komentar yang terkait
    $delete_comment_query = "DELETE FROM komentar WHERE id_video = $id";
    mysqli_query($koneksi, $delete_comment_query);

    // Query untuk mengambil nama file dari database
    $select_query = "SELECT * FROM video WHERE id = $id";
    $result = mysqli_query($koneksi, $select_query);

    if ($row = mysqli_fetch_assoc($result)) {
        $thumbnail_name = $row['thumbnail_url'];
        $video_name = $row['video_url'];

        // Hapus file thumbnail dari folder uploads
        $thumbnail_path = "../" . $thumbnail_name;
        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }

        // Hapus file video dari folder uploads
        $video_path = "../" . $video_name;
        if (file_exists($video_path)) {
            unlink($video_path);
        }

        // Buat query DELETE untuk video
        $delete_query = "DELETE FROM video WHERE id = $id";

        // Jalankan query DELETE untuk video
        if (mysqli_query($koneksi, $delete_query)) {
            // Aktifkan kembali konstrain referensial
            mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS = 1");

            // Jika penghapusan berhasil, Anda dapat mengarahkan pengguna kembali ke halaman data
            header("Location: ../editVideo.php"); // Kembali ke halaman data setelah penghapusan berhasil
            exit();
        } else {
            // Aktifkan kembali konstrain referensial
            mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS = 1");

            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        // Aktifkan kembali konstrain referensial
        mysqli_query($koneksi, "SET FOREIGN_KEY_CHECKS = 1");

        echo "Data tidak ditemukan.";
    }
} else {
    echo "Akses tidak sah.";
}
?>

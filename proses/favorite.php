<?php
include "../koneksi/koneksi.php";
session_start();

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $id_video = (int)$_GET['id'];
    $id_pengguna = (int)$_SESSION['id'];

    if ($id_video <= 0 || $id_pengguna <= 0) {
        die("Data tidak valid.");
    }

    $cek = "SELECT pengguna_id, video_id FROM favorit WHERE pengguna_id = ? AND video_id = ?";
    $stmt_cek = mysqli_prepare($koneksi, $cek);
    
    if ($stmt_cek) {
        mysqli_stmt_bind_param($stmt_cek, "ii", $id_pengguna, $id_video);
        mysqli_stmt_execute($stmt_cek);
        
        $cek_result = mysqli_stmt_get_result($stmt_cek);
        if(mysqli_num_rows($cek_result) > 0) {
            echo '<script>alert("Video Sudah Ada Di Favorite");
            window.location.href = "../video.php?id=' . $id_video . '";
            </script>';
        } else {
            $sql = "INSERT INTO favorit (pengguna_id, video_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($koneksi, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ii", $id_pengguna, $id_video);
                if (mysqli_stmt_execute($stmt)) {
                    echo '<script>alert("Video Berhasil Ditambahkan Ke Favorite"); 
                    window.location.href = "../video.php?id=' . $id_video . '";
                    </script>';
                } else {
                    echo '<script>alert("Gagal Menambah Video Ke Favorite"); 
                    window.location.href = "../video.php?id=' . $id_video . '";
                    </script>';
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Gagal: " . mysqli_error($koneksi);
            }
        }
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>
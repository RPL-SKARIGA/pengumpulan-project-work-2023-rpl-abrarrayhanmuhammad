<?php
    include "../koneksi/koneksi.php";

    $id_video = $_POST['video_id'];
    $id_user = $_POST['id_user'];
    $komen = $_POST['comment'];

    $stmt = $koneksi->prepare("INSERT INTO komentar (id, user_id, video_id, komentar) VALUES ('',?,?,?)");
    $stmt->bind_param("iis", $id_user, $id_video, $komen);
    if($stmt->execute()){
        echo "<script>window.location.href = '../video.php?id=".$id_video."';</script>";
    }else{
        echo "<script>alert('Komen gagal ditambahkan');
              window.location.href = '../video.php?id=".$id_video."';</script>";
    }
?>
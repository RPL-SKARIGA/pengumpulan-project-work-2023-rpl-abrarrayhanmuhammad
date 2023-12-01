<?php
include "../koneksi/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["new-username"];
    $password = md5($_POST["new-password"]);
    $email = $_POST["email"];

    $a = "SELECT email FROM pengguna WHERE email = '$email'";
    $result = mysqli_query($koneksi, $a);
    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('Maaf Email Sudah Terdaftar');
              window.location.href = '../login.php';
              </script>";
    }else{
        $sql = "INSERT INTO pengguna (username, password, email) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $email);

    if($stmt->execute()){
        echo "<script>alert('Berhasil Register');
              window.location.href = '../login.php';
              </script>";
    }else {
        echo "<script>alert('Gagal Register');
              window.location.href = '../login.php';
              </script>";
    }

    }
    // $thumbnail_file_tmp = $_FILES["foto_profil"]["tmp_name"];

    // $uploadOk = 1;
    // $thumbnailFileType = strtolower(pathinfo($_FILES["foto_profil"]["name"], PATHINFO_EXTENSION));

    // $allowed_thumbnail_types = array("jpeg", "png");
    // if (!in_array($thumbnailFileType, $allowed_thumbnail_types)) {
    //     echo "Sorry, only JPEG and PNG files are allowed for thumbnails.";
    //     $uploadOk = 0;
    // }

    // $max_file_size = 900000000;
    // if ($_FILES["foto_profil"]["size"] > $max_file_size) {
    //     echo "Sorry, your file is too large.";
    //     $uploadOk = 0;
    // }

    // if ($uploadOk == 0) {
    //     echo "Sorry, your files were not uploaded.";
    // } else {
    //     $thumbnail_upload_dir = "foto_profil/";

    //     if (!file_exists($thumbnail_upload_dir)) {
    //         mkdir($thumbnail_upload_dir, 0777, true);
    //     }

    //     $thumbnail_file_name =  $thumbnail_upload_dir. basename($_FILES["foto_profil"]["name"]);

    //     if (move_uploaded_file($thumbnail_file_tmp, $thumbnail_file_name)) {
            
    //         $query = "INSERT INTO pengguna (username, password, email, foto_profil) VALUES (?, ?, ?, ?)";
    //         $stmt = $koneksi->prepare($query);
    //         $stmt->bind_param("ssss", $username, $password, $email, $thumbnail_file_name);

    //         if ($stmt->execute()) {
    //             header("Location: ../login.php");
    //         } else {
    //             echo "Error: " . $stmt->error;
    //         }

    //         $stmt->close();
    //     } else {
    //         echo "Sorry, there was an error uploading your files.";
    //     }
    // }
}

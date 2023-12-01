<?php
include "../koneksi/koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = md5( $_POST["password"]);

    $admin_query = "SELECT * FROM admin WHERE email = '$email' AND `password` = '$password'";
    $admin_result = mysqli_query($koneksi, $admin_query);
    $r = mysqli_fetch_assoc($admin_result);
    $id_admin = $r['id'];
    $admin_username = $r['username'];

    if (!$admin_result) {
        die("Query failed: " . mysqli_error($koneksi));
    }
    
    $pengguna_query = "SELECT * FROM pengguna WHERE email = '$email' AND `password` = '$password'";
    $pengguna_result = mysqli_query($koneksi, $pengguna_query);
    $row = mysqli_fetch_assoc($pengguna_result);
    $username = $row["username"];
    $id = $row["id"];

    if (!$pengguna_result) {
        die("Query failed: " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($admin_result) === 1) {
        $_SESSION['id_admin'] = $id_admin;
        $_SESSION['username'] = $admin_username;
        echo '<script>alert("Login Berhasil Sebagai Admin");
              window.location.href = "../admin.php";
        </script>'; 
        exit();
    } elseif (mysqli_num_rows($pengguna_result) === 1) {
        $_SESSION["id"] = $id;
        $_SESSION['username'] = $username;
        header('Location: ../');
        exit();
    } else {
        echo '<script>alert("Email dan Password salah");
              window.location.href = "../login.php";</script>';
        exit();
    }
    
}

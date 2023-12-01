<?php
    session_start();
    
    // Hapus semua data sesi
    session_unset();
    
    // Hapus sesi secara permanen
    session_destroy();
    
    // Redirect ke halaman login atau halaman lainnya
    header("Location: ../login.php");
    exit();
?>

<!DOCTYPE html>
<html lang="en">
<?php
    include "koneksi/koneksi.php";
    session_start();
    $id = $_SESSION["id"];
    $a = "SELECT * FROM pengguna WHERE id = $id";
    $result = mysqli_query($koneksi, $a);
    while($row = mysqli_fetch_assoc($result)){
        $username = $row["username"];
        $email = $row["email"];
        $password = $row["password"];
        $foto_profil = $row["foto_profil"];
    }
    
    
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            text-align: center;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin: 20px auto;
            padding: 20px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        /* Hapus border pada formulir */
        .profile-form {
            border: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Modifikasi gaya formulir */
        .profile-form h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .profile-form label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .profile-form input[type="text"],
        .profile-form input[type="password"],
        .profile-form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .profile-form input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .photo-profile {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .photo-text {
            background-color: rgb(29, 47, 112);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 100%;
            width: 2em;
            height: 2em;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4em;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <div class="photo-profile">
            <div class="photo-text"><?= substr($username, 0, 1); ?></div>
        </div>
        
        <h1>Profil Saya</h1>
        <p>Username: <?php echo $username; ?></p>
        <p>Email: <?php echo $email; ?></p>
    </div>
</body>


</html>

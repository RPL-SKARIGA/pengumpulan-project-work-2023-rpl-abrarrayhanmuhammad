<!DOCTYPE html>
<?php
include "koneksi/koneksi.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Video</title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }

        .navbar {
            background-color: #041C32;
            color: #fff;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar-brand {
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .navbar-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        .navbar-links li {
            display: inline;
        }

        .navbar-links a {
            text-decoration: none;
            color: #fff;
        }

        .navbar-dropdown {
            position: relative;
        }

        .navbar-dropdown-content {
            display: none;
            position: absolute;
            background-color: #041C32;
            min-width: 100px;
            z-index: 1;
        }

        .navbar-dropdown:hover .navbar-dropdown-content {
            display: block;
        }

        .navbar-dropdown-content a {
            padding: 10px;
            display: block;
        }

        /* Gaya untuk kotak pencarian */
        .navbar-search {
            display: flex;
            align-items: center;
            margin-left: auto;
            /* Memindahkan kotak pencarian ke sisi kanan */
        }

        #search-input {
            width: 0;
            opacity: 0;
            border: none;
            background: transparent;
            color: #fff;
            transition: width 0.3s ease, opacity 0.3s ease;
            font-size: 16px;
            padding: 5px;
            margin-right: 10px;
        }

        #search-button {
            background: transparent;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        /* Gaya untuk kotak pencarian yang aktif */
        .navbar-search.active #search-input {
            width: 200px;
            /* Sesuaikan lebar sesuai kebutuhan */
            opacity: 1;
        }

        .navbar-search.active #search-button {
            display: none;
            /* Sembunyikan tombol saat kotak pencarian aktif */
        }

        /* CSS untuk sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            background-color: #041C32;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            color: #fff;
        }

        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 20px;
            color: #fff;
            display: block;
            transition: 0.3s;
        }

        .sidebar .logout {
            margin-top: 100%;
        }

        .sidebar h3 {
            padding: 0px 25px 15px;
            margin-top: -45px;
            text-decoration: none;
            color: #fff;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #064663;
        }

        .sidebar.open {
            left: 0;
            /* Munculkan sidebar ketika kelas 'open' ditambahkan */
        }

        /* CSS untuk konten halaman utama */
        .content {
            margin-left: 250px;
            /* Sesuaikan margin dengan lebar sidebar */
            margin-top: -50px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <h3>DASHBOARD</h3>
        <a href="#">Beranda</a>
        <a href="postVideo.php">Upload Video</a>
        <a href="editVideo.php">Edit Video</a>
        <a href="proses/logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <form action="video_admin.php" method="GET">
            <div class="container">
                <h2>Daftar Video</h2>
                <div class="row">
                    <?php
                    $query = "SELECT id, judul, thumbnail_url FROM video";
                    $result = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $judul = $row['judul'];
                        $thumbnail_url = $row['thumbnail_url'];
                    ?>
                        <div class="col-md-4">
                            <a href="video_admin.php?id=<?php echo $id ?>">
                                <div class="card">
                                    <?php
                                    echo '<img src="' . $thumbnail_url . '" alt="' . $judul . '" class="card-img-top">';
                                    ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $judul ?></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
    </header>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchButton = document.getElementById("search-button");
        const searchInput = document.getElementById("search-input");
        const navbarSearch = document.querySelector(".navbar-search");

        searchButton.addEventListener("click", function() {
            navbarSearch.classList.toggle("active");
            if (navbarSearch.classList.contains("active")) {
                searchInput.focus();
            }
        });
        document.addEventListener("click", function(event) {
            if (!navbarSearch.contains(event.target)) {
                navbarSearch.classList.remove("active");
                searchInput.value = "";
            }
        });
    });
</script>
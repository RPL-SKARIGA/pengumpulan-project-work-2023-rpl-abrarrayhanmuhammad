<?php

include "koneksi/koneksi.php";
include "header.php";

$pencarian = "";

if (isset($_GET['search'])) {

    $pencarian = mysqli_real_escape_string($koneksi, $_GET['search']);


    $query = "SELECT id, judul, thumbnail_url FROM video WHERE judul LIKE '%$pencarian%'";
    $result = mysqli_query($koneksi, $query);
} else {

    $query = "SELECT id, judul, thumbnail_url FROM video";
    $result = mysqli_query($koneksi, $query);
}

?>

<!DOCTYPE html>
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

        ::-webkit-scrollbar {
            width: 0px;
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
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .navbar-brand:hover {
            color: #fff;
        }

        .navbar-links {
            text-decoration: none;
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
            color: #f2f2f2;
        }

        .navbar-search-input {
            width: 25vw;
            padding: 5px;
            border: none;
            background-color: #fff;
            color: black;
            transition: width 0.3s;
            border-radius: 10px;
            text-align: center;
        }

        .navbar-search-input:focus {
            width: 26vw;
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

        .navbar-dropdown-btn {
            display: none;
        }

        .dropdown-lg {
            display: none;
        }

        .dd-list {
            transition: 0.2s;
        }
        
        .dd-list:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        @media only screen and (width <= 1125px) {
            .navbar-search-input {
                width: 45vw;
                padding: 5px;
                border: none;
                background-color: #fff;
                color: black;
                transition: width 0.3s;
                border-radius: 10px;
                text-align: center;
                margin-left: -20px;
            }

            .navbar-search-input:focus {
                width: 50vw;
            }

            .navbar-links {
                display: none;
            }

            
            .navbar-dropdown-btn {
                display: block;
            }
            
        }

        @media only screen and (width > 1125px) {
            
            .dropdown-lg {
                display: none;
            }
        }
        
        @media only screen and (width <= 900px) {
            
            .navbar-brand {
                display: none;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="row row-cols-3 w-100 mx-auto">
                <div class="col">
                    <a href="/WEB_TA" class="navbar-brand">Streaming Web</a>
                </div>
                <div class="col d-flex justify-content-center">
                    <form class="navbar-search" action="pencarian.php" method="GET">
                        <input type="text" id="search-inputx" placeholder="Cari Video" class="navbar-search-input" name="search" autocomplete="off">
                    </form>
                </div>
                <div class="col d-flex align-items-center justify-content-end">
                    <ul class="navbar-links">
                        <li><a href="/WEB_TA">Beranda</a></li>
                        <li><a href="#">Kategori</a></li>
                        <li><a href="#">Favorite</a></li>
                        <li class="navbar-dropdown">
                            <a href="#">Akun <i class="bi bi-caret-down"></i></a>
                            <div class="navbar-dropdown-content">
                                <a href="akun.php" method="GET">Profil</a>
                                <a href="proses/logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                    <button class="btn btn-outline-light navbar-dropdown-btn" onclick="openDropdown()" id="dropdown-btn" style="margin-right: -20px; border: none;"><i class="bi bi-list"></i></button>
                </div>
            </div>
        </div>
        <div class="flex-column mt-2 w-100 dropdown-lg" style="display: none;" id="dropdown-lg">
            <div class="w-100 p-2 rounde dd-list">
                <a href="/" class="text-decoration-none text-light fs-4 my-2">Beranda</a>
            </div>
            <div class="w-100 p-2 rounde dd-list">
                <a href="#" class="text-decoration-none text-light fs-4 my-2">Kategori</a>
            </div>
            <div class="w-100 p-2 rounde dd-list">
                <a href="#" class="text-decoration-none text-light fs-4 my-2">Favorite</a>
            </div>
            <div class="w-100 p-2 rounde dd-list">
                <a href="akun.php" class="text-decoration-none text-light fs-4 my-2">Profile</a>
            </div>
        </div>
    </nav> -->
    
    </header>
    <form action="video.php" method="GET">
        <div class="container-fluid" style="margin-top: 10vh;">
            <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1 mx-4">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $judul = $row['judul'];
                    $thumbnail_url = $row['thumbnail_url'];
                ?>
                <div class="col mx-auto vh-75">
                    <div class="card border shadow" style="width: 100%; height: 90%;">
                        <a href="video.php?id=<?= $id ?>" style="text-decoration: none; color: black; height: 100%;">
                            <img src="<?= $thumbnail_url ?>" class="card-img-top border-bottom" alt="..." style="height: 75%; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text fs-6"><?= $judul ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            
                <?php
                }
                ?>
            </div>
        </div>
    </form>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchButton = document.getElementById("search-text");
        const searchInput = document.getElementById("search-input");
        const navbarSearch = document.querySelector(".navbar-search");

        let isInputActive = false; // Menyimpan status input aktif atau tidak

        searchButton.addEventListener("click", function() {
            isInputActive = !isInputActive; // Mengubah status input aktif atau tidak
            if (isInputActive) {
                searchButton.textContent = "Pencarian"; // Mengubah teks tombol pencarian menjadi "X"
                searchInput.style.width = "150px"; // Sesuaikan lebar input
                searchInput.style.opacity = "1";
                searchInput.focus();
            } else {
                searchButton.textContent = "Pencarian"; // Mengembalikan teks tombol pencarian
                searchInput.style.width = "0";
                searchInput.style.opacity = "0";
                searchInput.value = ""; // Reset nilai input
            }
        });

        document.addEventListener("click", function(event) {
            if (!navbarSearch.contains(event.target) && isInputActive) {
                isInputActive = false;
                searchButton.textContent = "Pencarian"; // Mengembalikan teks tombol pencarian
                searchInput.style.width = "0";
                searchInput.style.opacity = "0";
                searchInput.value = ""; // Reset nilai input
            }
        });
    });

    const dropdown = document.getElementById("dropdown-lg");
    const myElement = document.getElementById("dropdown-btn");

    myElement.addEventListener("click", function() {
        dropdown.classList.toggle("clicked");
    });

    function handleResize() {
        var screenWidth = window.innerWidth;

        if (screenWidth > 1125) {
            document.getElementById("dropdown-lg").style.display = "none";
        }
    }
    window.addEventListener("resize", handleResize);

    handleResize();


    function openDropdown() {
    if(window.innerWidth <= "1225"){
            if(document.getElementById("dropdown-lg").style.display == "flex"){
                document.getElementById("dropdown-lg").style.display = "none";
            }else{
                document.getElementById("dropdown-lg").style.display = "flex";
            }
        }
    }

</script>


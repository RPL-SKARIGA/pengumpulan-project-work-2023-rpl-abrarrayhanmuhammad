<?php
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* CSS untuk kolom pencarian */
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

<nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="row row-cols-3 w-100 mx-auto">
                <div class="col">
                    <a class="navbar-brand">Streaming Web</a>
                </div>
                <div class="col d-flex justify-content-center">
                    <form class="navbar-search" action="pencarian.php" method="GET">
                        <input type="text" id="search-inputx" placeholder="Cari Video" class="navbar-search-input" name="search" autocomplete="off">
                    </form>
                </div>
                <div class="col d-flex align-items-center justify-content-end">
                    <ul class="navbar-links">
                        <li><a href="/WEB_TA">Beranda</a></li>
                        <li><a href="kategori.php">Kategori</a></li>
                        <li><a href="favorite.php">Favorite</a></li>
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
                <a href="/WEB_TA" class="text-decoration-none text-light fs-4 my-2">Beranda</a>
            </div>
            <div class="w-100 p-2 rounde dd-list">
                <a href="kategori.php" class="text-decoration-none text-light fs-4 my-2">Kategori</a>
            </div>
            <div class="w-100 p-2 rounde dd-list">
                <a href="favorite.php" class="text-decoration-none text-light fs-4 my-2">Favorite</a>
            </div>
            <div class="w-100 p-2 rounde dd-list">
                <a href="akun.php" class="text-decoration-none text-light fs-4 my-2">Profile</a>
            </div>
        </div>
    </nav>
    
</body>
</html>
<script>
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
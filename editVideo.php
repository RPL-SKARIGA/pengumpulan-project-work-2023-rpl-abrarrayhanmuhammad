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

        #search-button {
            margin-left: 10px;
            /* Menggeser tombol ke kanan dari teks "DAFTAR VIDEO" */
        }

        .navbar-search {
            display: none;
            position: absolute;
            top: 40px;
            right: 65px;
            /* Mengatur jarak dari kanan untuk kotak pencarian */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #search-input {
            width: 200px;
            border: none;
            outline: none;
            padding: 5px;
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
            display: flex;
            flex-wrap: wrap;
            /* Menambahkan flexbox untuk mengatur layout */
        }

        .video-card {
            width: calc(33.33% - 20px);
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .video-card img {
            max-width: 100%;
            height: auto;
        }

        .video-card h5 {
            font-size: 18px;
            margin: 10px 0;
        }

        .video-card p {
            /* Gaya awal untuk deskripsi */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-height: 3em;
            /* Sesuaikan dengan ketinggian yang Anda inginkan */
        }

        .video-card .show-more {
            cursor: pointer;
            color: blue;
        }

        /* Menyesuaikan lebar kolom deskripsi */
        table {
            table-layout: fixed;
            width: 100%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 40%;
            /* Sesuaikan dengan lebar yang diinginkan */
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <h3>DASHBOARD</h3>
        <a href="admin.php">Beranda</a>
        <a href="postVideo.php">Upload Video</a>
        <a href="editVideo.php">Edit Video</a>
        <a href="proses/logout.php" class="logout">Logout</a>
    </div>

    <!-- Mengubah struktur konten menjadi tabel -->
    <div class="content">
        <div class="container">
            <h2>
                <span>DAFTAR VIDEO</span>
            </h2>
            <div class="navbar-search">
                <input type="text" id="search-input" placeholder="Cari...">
            </div>
            <form action="edit.php" method="GET">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT id, judul, deskripsi, thumbnail_url FROM video";
                        $result = mysqli_query($koneksi, $query);

                        $no = 1; // Variabel untuk nomor urut

                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $judul = $row['judul'];
                            $deskripsi = $row['deskripsi'];
                            $thumbnail_url = $row['thumbnail_url'];
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td> 
                                <td><?php echo $judul ?></td>
                                <td>
                                    <p><?php echo substr($deskripsi, 0, 40); ?></p> <!-- Tampilkan hanya 80 karakter pertama -->
                                <td>
                                    <a href="edit.php?id=<?php echo $id ?>" class="btn btn-primary">Edit</a> <!-- Tombol Edit -->
                                </td>
                                <td>
                                    <a href="proses/delete_proses.php?id=<?php echo $id ?>"
                                     onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger">Delete</a> <!-- Tombol Delete -->
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
        </div>
        </form>
    </div>
    </header>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showMore(element) {
            var description = element.parentElement.querySelector('p');
            var showMoreLink = element;

            if (description.style.whiteSpace === 'normal') {
                description.style.whiteSpace = 'nowrap';
                showMoreLink.innerText = 'Lebih Banyak';
            } else {
                description.style.whiteSpace = 'normal';
                showMoreLink.innerText = 'Lebih Sedikit';
            }
        }
    </script>
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
<!DOCTYPE html>
<?php
include "koneksi/koneksi.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $deskripsi = $_POST["deskripsi"];
    $kategori = $_POST["kategori"];
    $video_file_tmp = $_FILES["video"]["tmp_name"];
    $thumbnail_file_tmp = $_FILES["thumbnail"]["tmp_name"];

    $uploadOk = 1;
    $videoFileType = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
    $thumbnailFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));

    $allowed_video_types = array("mp4", "avi", "mov", "mpeg", "wmv");
    if (!in_array($videoFileType, $allowed_video_types)) {
        echo "<script>alert('Video hanya bisa mp4, avi, mov, mpeg, wmv');
            window.location.href = 'postVideo.php';    
            </script>";
        $uploadOk = 0;
    }

    $allowed_thumbnail_types = array("jpeg", "png", "jpg");
    if (!in_array($thumbnailFileType, $allowed_thumbnail_types)) {
        echo "<script>alert('Gambar hanya bisa jpeg, png dan jpg');
                 window.location.href = 'postVideo.php';    
            </script>";
        $uploadOk = 0;
    }

    $max_file_size = 1024 * 1024 * 1024 * 1.5;
    if ($_FILES["video"]["size"] > $max_file_size || $_FILES["thumbnail"]["size"] > $max_file_size) {
        echo "<script>alert('Data terlalu besar');
        window.location.href = 'postVideo.php';    
            </script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Data gagal diupload');
                 window.location.href = 'postVideo.php';    
            </script>"; 
    } else {
        $thumbnail_upload_dir = "uploads/thumbnail/";

        if (!file_exists($thumbnail_upload_dir)) {
            mkdir($thumbnail_upload_dir, 0777, true);
        }

        $thumbnail_file_name = $thumbnail_upload_dir . basename($_FILES["thumbnail"]["name"]);

        if (move_uploaded_file($thumbnail_file_tmp, $thumbnail_file_name)) {
            $conn = mysqli_connect("localhost", "root", "", "web_ta");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "INSERT INTO video (judul, deskripsi, video_url, thumbnail_url, kategori) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $video_data = file_get_contents($video_file_tmp);

                $check_query = "SELECT id FROM video WHERE judul = ? OR video_url = ?";
                $check_stmt = $conn->prepare($check_query);
                $check_stmt->bind_param("ss", $judul, $video_data);
                $check_stmt->execute();
                $check_stmt->store_result();
                if ($check_stmt->num_rows > 0) {
                    echo "<script>alert('Video sudah ada');
                    window.location.href = 'postVideo.php';    
                    </script>";
                    exit();
                }
                $check_stmt->close();

                $stmt->bind_param("sssss", $judul, $deskripsi, $video_data, $thumbnail_file_name, $kategori);
                if ($stmt->execute()) {
                    $id_video = $stmt->insert_id;

                    $query_kategori = "INSERT INTO kategori (id_kategori, id_video, kategori) VALUES ('', ?, ?)";
                    $stmt_kategori = $conn->prepare($query_kategori);
                    $stmt_kategori->bind_param("is", $id_video, $kategori);

                    if ($stmt_kategori->execute()) {
                        echo "<script>alert('Video berhasil diupload');
                            window.location.href = 'postVideo.php';    
                        </script>";
                    } else {
                        echo "<script>alert('Video berhasil diupload, tetapi kategori gagal disimpan.');
                            window.location.href = 'postVideo.php';    
                        </script>";
                    }
                    $stmt_kategori->close();
                } else {
                    echo "<script>alert('Video gagal diupload');
                        window.location.href = 'postVideo.php';    
                    </script>";
                }
                $stmt->close();
            } else {
                echo "Error: " . $conn->error;
            }
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your files.";
        }
    }
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

        .preview-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 5px;
        }

        #video-preview,
        #thumbnail-preview {
            max-width: 100%;
            height: auto;
            display: block;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <h3>DASHBOARD</h3>
        <a href="admin.php">Beranda</a>
        <a href="postVideo.php">Upload Video</a>
        <a href="editVideo.php">Edit Video</a>
        <a href="proses/logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <form method="POST" action="" enctype="multipart/form-data" class="w-100 p-2">
            <div class="container w-100">
                <h2>Form Upload Video</h2>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul:</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi:</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori:</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="" selected>Pilihan Kategori</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Islamic">Islamic</option>
                                <option value="Music">Music</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label for="video" class="form-label">Video:</label>
                            <div class="preview-container mb-3">
                                <video id="video-preview" width="320" height="240" controls style="display: none;"></video>
                            </div>
                            <input type="file" class="form-control" id="video" name="video" onchange="previewVideo(this);" required>
                        </div>
                        <div class="mb-4">
                            <label for="thumbnail" class="form-label">Thumbnail:</label>
                            <div class="preview-container mb-3">
                                <img id="thumbnail-preview" src="" alt="Thumbnail Preview" style="max-width: 100px; display: none;">
                            </div>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail" onchange="previewThumbnail(this);" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Simpan" name="submit">
                    <input type="button" class="btn btn-danger" value="Batal" onclick="resetForm();" name="batal">
                </div>
            </div>

        </form>
    </div>
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

    function resetForm() {
        document.getElementById('judul').value = '';
        document.getElementById('deskripsi').value = '';
        document.getElementById('video').value = '';
        document.getElementById('thumbnail').value = '';
        document.getElementById('video-preview').style.display = 'none';
        document.getElementById('thumbnail-preview').style.display = 'none';
    }

    function previewThumbnail(input) {
        var thumbnailPreview = document.getElementById('thumbnail-preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreview.src = e.target.result;
                thumbnailPreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            thumbnailPreview.style.display = 'none';
        }
    }

    function previewVideo(input) {
        var videoPreview = document.getElementById('video-preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                videoPreview.src = e.target.result;
                videoPreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            videoPreview.style.display = 'none';
        }
    }
</script>
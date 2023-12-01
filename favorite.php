<?php
    session_start();
    include 'header.php';
    include "koneksi/koneksi.php";
    

    $id = $_SESSION['id'];
    $sql = "SELECT favorit.video_id, video.judul, video.deskripsi, video.video_url, video.thumbnail_url FROM favorit
            JOIN video ON favorit.video_id = video.id WHERE favorit.pengguna_id = $id";
    $result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
            #favorites-list {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                margin: 20px;
            }

            .video {
                width: 300px;
                background-color: #f4f4f4;
                border: 1px solid #ddd;
                margin: 10px;
                padding: 10px;
                text-align: center;
            }

            .video img {
                max-width: 100%;
                height: auto;
                border: 1px solid #ddd;
                margin-bottom: 10px;
            }

            .video h4 {
                color: #333;
            }

            .video p {
                color: #777;
            }

            .fade-in {
                animation: fadeIn 1s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

    </style>
    <title>My Favorite Videos</title>
</head>
<body>
    <header>
        <h1 style="text-align: center;">My Favorite Videos</h1>
    </header>
<div class="container-fluid" style="margin-top: 10vh;">
        <div class="row row-cols-xl-3 row-cols-md-2 row-cols-1 mx-4">
        <?php
            while ($r = mysqli_fetch_assoc($result)) {
                $video_id = $r['video_id'];
                $judul = $r['judul'];
                $deskripsi = $r['deskripsi'];
                $video = $r['video_url'];
                $thumbnail = $r['thumbnail_url'];
        ?>
            <div class="col mx-auto vh-75">
                <div class="card border shadow" style="width: 100%; height: 90%;">
                    <a href="video.php?id=<?= $video_id?>" style="text-decoration: none; color: black; height: 100%;">
                        <img src="<?= $thumbnail ?>" class="card-img-top border-bottom" alt="..." style="height: 75%; object-fit: cover;">
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
    <!-- <header>
        <h1 style="text-align: center;">My Favorite Videos</h1>
    </header>
    <section id="favorites-list">
        <?php
            while ($r = mysqli_fetch_assoc($result)) {
                $video_id = $r['video_id'];
                $judul = $r['judul'];
                $deskripsi = $r['deskripsi'];
                $video = $r['video_url'];
                $thumbnail = $r['thumbnail_url'];
        ?>
        <div class="video fade-in">
            <a href="video.php?id=<?= $video_id?>"><img src="<?= $thumbnail?>"  alt="Video Thumbnail"></a>
            <p><?= $judul?></p>
        </div>
        <?php
            }
        ?>
    </section> -->
</body>
</html>

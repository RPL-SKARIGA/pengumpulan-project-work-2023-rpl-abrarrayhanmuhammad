<!DOCTYPE html>
<?php
include "koneksi/koneksi.php";
session_start();

$videoId = $_GET['id'];
$query = "SELECT id, judul, video_url FROM video WHERE id = $videoId";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "Error executing query: " . mysqli_error($koneksi);
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $judul = $row['judul'];
    $video_blob = $row['video_url'];
    $v = finfo_buffer(finfo_open(), $video_blob, FILEINFO_MIME_TYPE);
    $base64Video = base64_encode($video_blob);
    $videSRC = "data:$v;base64,$base64Video";
} else {
    echo '<p>Invalid video selection.</p>';
    exit;
}

$komen = "SELECT komentar.*, pengguna.username FROM komentar INNER JOIN pengguna ON pengguna.id = komentar.user_id WHERE video_id = $videoId";
$result_komen = mysqli_query($koneksi, $komen);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style2.css">
    <title>Video Player</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .comment-section {
            float: right;
            width: 40%;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .comment {
            margin-bottom: 10px;
        }

        .favorite-button {
            background-color: #ff4081;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .favorite-button:hover {
            background-color: #d81b60;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <a class="header-brand" href="/WEB_TA">Streaming Web</a>
        </div>
    </header>

    <div class="container mt-4">
        <div class="video-container" style="max-width: 650px;">
            <video controls width="320" height="240">
                <source src="<?= $videSRC ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <h2 style="color: black;"><?= $judul ?></h2>
            <form action="proses/favorite.php" method="get">
                <input type="hiudden" name="id" value="<?= $id ?>">
                <!-- Tambahkan kelas favorite-button pada tombol -->
                <button type="submit" class="btn mb-md-0 mb-2 btn-primary favorite-button">
                    <ion-icon name="heart"></ion-icon>
                    <span class="sr-only"></span>
                </button>
            </form>
        </div>
        <div class="comment-section">
            <h3>Komentar</h3>
        <?php
        while ($row1 = mysqli_fetch_assoc($result_komen)) {
            $username1 = $row1['username'];
            $komentar = $row1['komentar'];
            echo '<div class="comment">' . $username1 . ': ' . $komentar . '</div>';
            }
        ?>
            <form action="proses/add_comment.php" method="post">
                <input type="hidden" name="video_id" value="<?= $id ?>">
                <input type="hidden" name="id_user" value="<?= $_SESSION['id'] ?>">
                <textarea style="border-radius: 10px" placeholder ="Add your comment" id="comment" name="comment" rows="4" cols="50"></textarea>
                <br>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>

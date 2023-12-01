<!DOCTYPE html>
<?php
include "koneksi/koneksi.php";
session_start();

if (isset($_GET['id'])) {
    $video_id = $_GET['id'];

    $query = "SELECT id, judul, deskripsi, video_url, thumbnail_url FROM video WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $video_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $judul = $row['judul'];
        $deskripsi = $row['deskripsi'];
        $video_url = $row['video_url'];
        $thumbnail_url = $row['thumbnail_url'];

        if (isset($_POST['simpan'])) {
            $new_judul = $_POST['judul'];
            $new_deskripsi = $_POST['deskripsi'];
            $old_thumbnail = $thumbnail_url;

            if (!empty($_FILES['new_thumbnail']['name'])) {
                $thumbnail_tmp = $_FILES['new_thumbnail']['tmp_name'];
                $thumbnail_name = $_FILES['new_thumbnail']['name'];
                $thumbnail_path = "uploads/thumbnail/" . $thumbnail_name;

                if (!is_dir("uploads/thumbnail/")) {
                    mkdir("uploads/thumbnail/", 0755, true);
                }

                if (move_uploaded_file($thumbnail_tmp, $thumbnail_path)) {
                    $new_thumbnail = $thumbnail_path;

                    if (file_exists($old_thumbnail)) {
                        unlink($old_thumbnail);
                    }
                } else {
                    die("Error uploading thumbnail file.");
                }
            } else {
                $new_thumbnail = $thumbnail_url;
            }

            $update_query = "UPDATE video SET judul = ?, deskripsi = ?, thumbnail_url = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($koneksi, $update_query);

            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, "sssi", $new_judul, $new_deskripsi, $new_thumbnail, $video_id);

                if (mysqli_stmt_execute($update_stmt)) {
                    header("Location: editVideo.php?id=$video_id");
                    exit();
                } else {
                    die("Query Error: " . mysqli_error($koneksi));
                }
            } else {
                die("Query Error: " . mysqli_error($koneksi));
            }
        }
    } else {
        die("Query Error: " . mysqli_error($koneksi));
    }
} else {
    header("Location: editVideo.php");
    exit();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Video</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $judul; ?>">
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo $deskripsi; ?></textarea>
            </div>
            <div class="form-group">
                <label for="new_thumbnail">Thumbnail Baru:</label>
                <input type="file" class="form-control-file" id="new_thumbnail" name="new_thumbnail" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan Perubahan</button>
                <a href="editVideo.php" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>

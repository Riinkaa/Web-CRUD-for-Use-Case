<?php
require_once 'db.php';

$nama = $deskripsi = $harga = "";
$id = 0;

// Cek jika form disubmit untuk proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $harga = trim($_POST['harga']);

    // Validasi sederhana
    if (!empty($nama) && !empty($harga) && is_numeric($harga)) {
        $sql = "UPDATE produk SET nama = ?, deskripsi = ?, harga = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssdi", $nama, $deskripsi, $harga, $id);

            if ($stmt->execute()) {
                header("location: index.php");
                exit();
            } else {
                echo "Terjadi kesalahan saat update.";
            }
            $stmt->close();
        }
    }
} else {
    // Cek keberadaan parameter id di URL
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM produk WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $nama = $row['nama'];
                    $deskripsi = $row['deskripsi'];
                    $harga = $row['harga'];
                } else {
                    // URL tidak mengandung id yang valid
                    header("location: index.php");
                    exit();
                }
            } else {
                echo "Terjadi kesalahan.";
            }
            $stmt->close();
        }
    } else {
        // URL tidak mengandung parameter id
        header("location: index.php");
        exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Produk</h2>
    <p>Silakan ubah data pada formulir di bawah ini.</p>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div style="margin-bottom: 15px;">
            <label>Nama Produk</label><br>
            <input type="text" name="nama" style="width: 100%; padding: 8px;" value="<?php echo htmlspecialchars($nama); ?>">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" style="width: 100%; padding: 8px; height: 100px;"><?php echo htmlspecialchars($deskripsi); ?></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label>Harga</label><br>
            <input type="text" name="harga" style="width: 100%; padding: 8px;" value="<?php echo htmlspecialchars($harga); ?>">
        </div>
        <div>
            <input type="submit" class="btn" value="Simpan Perubahan">
            <a href="index.php" class="btn" style="background-color: #6c757d;">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
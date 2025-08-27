<?php
require_once 'db.php';

$nama = $deskripsi = $harga = "";
$errors = [];

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input
    if (empty(trim($_POST["nama"]))) {
        $errors[] = "Nama produk tidak boleh kosong.";
    } else {
        $nama = trim($_POST["nama"]);
    }

    if (empty(trim($_POST["harga"]))) {
        $errors[] = "Harga tidak boleh kosong.";
    } elseif (!is_numeric($_POST["harga"])) {
        $errors[] = "Harga harus berupa angka.";
    } else {
        $harga = trim($_POST["harga"]);
    }

    $deskripsi = trim($_POST["deskripsi"]);

    // Jika tidak ada error, masukkan data ke database
    if (empty($errors)) {
        $sql = "INSERT INTO produk (nama, deskripsi, harga) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variabel ke prepared statement sebagai parameter
            $stmt->bind_param("ssd", $param_nama, $param_deskripsi, $param_harga);

            // Set parameter
            $param_nama = $nama;
            $param_deskripsi = $deskripsi;
            $param_harga = $harga;

            // Eksekusi statement
            if ($stmt->execute()) {
                // Redirect ke halaman utama
                header("location: index.php");
                exit();
            } else {
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Produk Baru</h2>
    <p>Silakan isi formulir di bawah ini untuk menambahkan produk baru.</p>

    <?php if(!empty($errors)): ?>
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div style="margin-bottom: 15px;">
            <label>Nama Produk</label><br>
            <input type="text" name="nama" style="width: 100%; padding: 8px;" value="<?php echo $nama; ?>">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Deskripsi</label><br>
            <textarea name="deskripsi" style="width: 100%; padding: 8px; height: 100px;"><?php echo $deskripsi; ?></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label>Harga</label><br>
            <input type="text" name="harga" style="width: 100%; padding: 8px;" value="<?php echo $harga; ?>">
        </div>
        <div>
            <input type="submit" class="btn" value="Simpan">
            <a href="index.php" class="btn" style="background-color: #6c757d;">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
<?php
// Cek jika parameter id ada di URL
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "db.php";

    $sql = "DELETE FROM produk WHERE id = ?";

    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("i", $param_id);

        // Set parameter
        $param_id = trim($_GET["id"]);

        // Eksekusi statement
        if($stmt->execute()){
            // Jika berhasil, redirect ke halaman utama
            header("location: index.php");
            exit();
        } else{
            echo "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
    $stmt->close();
    $conn->close();
} else{
    // Jika tidak ada id, redirect ke halaman utama
    header("location: index.php");
    exit();
}
?>
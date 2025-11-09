<?php 
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan_8";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM data_kecamatan WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect kembali ke halaman utama dengan pesan sukses
        header("Location: leafletjs.php?status=deletesuccess");
        exit;
    } else {
        // Redirect dengan pesan error
        header("Location: leafletjs.php?status=deleteerror");
        exit;
    }
} else {
    // Redirect jika tidak ada ID
    header("Location: leafletjs.php");
    exit;
}

$conn->close();
?>

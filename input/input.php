<?php
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan_8";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query simpan data lengkap
$sql = "INSERT INTO data_kecamatan (kecamatan, longitude, latitude, luas, jumlah_penduduk)
        VALUES ('$kecamatan', $longitude, $latitude, $luas, $jumlah_penduduk)";

// Menyimpan data dan memeriksa apakah berhasil
if ($conn->query($sql) === TRUE) {
    // Redirect ke halaman utama dengan pesan sukses
    header("Location: ../leafletjs.php?status=addsuccess");
    exit;
} else {
    // Redirect dengan pesan error
    header("Location: ../leafletjs.php?status=adderror");
    exit;
}

// Menutup koneksi
$conn->close();

?>
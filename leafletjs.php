
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Sebaran Data Kecamatan</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff332;
            margin: 0;
            padding: 0;
            text-align: center;
            color: #1e293b;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #1e3a8a;
        }

        .map-container {
            width: 95%;
            max-width: 1300px;
            height: 600px; /* lebih tinggi */
            margin: 30px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        #map {
            width: 100%;
            height: 100%;
        }

        a.back-link {
            display: inline-block;
            background-color: #6366f1;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
            margin-left: 40px;
        }

        a.back-link:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body>

<h1>Peta Persebaran Kecamatan di Kabupaten Sleman</h1>
<a href="index.php" class="back-link">Tabel Data Kecamatan</a>

<div class="map-container">
    <div id="map"></div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan_8";

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM data_kecamatan";
$result = $conn->query($sql);

// Siapkan array koordinat
$locations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = [
            'kecamatan' => $row['kecamatan'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'luas' => $row['luas'],
            'jumlah_penduduk' => $row['jumlah_penduduk']
        ];
    }
}
$conn->close();
?>

<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-7.7956, 110.3695], 11); // Pusat di Yogyakarta

    // Tambahkan layer peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Data dari PHP
    var data = <?php echo json_encode($locations); ?>;

    // Tambahkan marker untuk setiap kecamatan
    data.forEach(function(item) {
    if (item.latitude && item.longitude) {
        L.marker([item.latitude, item.longitude])
            .addTo(map)
            .bindPopup(`
                <b>${item.kecamatan}</b><br>
                Latitude: ${item.latitude}<br>
                Longitude: ${item.longitude}<br>
                Luas: ${item.luas} km²<br>
                Jumlah Penduduk: ${item.jumlah_penduduk}
            `);
    }
});
</script>

</body>
</html>

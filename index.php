
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acara 8 - Data Kecamatan</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

  <style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #eaffc8, #fff9c2);
    margin: 0;
    text-align: center;
    padding: 0;
    color: #14532d;
  }

  h1 {
    text-align: center;
    padding: 10px;
    margin-bottom: 0px;
    color: #166534;
  }

  h2 {
    text-align: center;
    padding: 10px;
    margin-top: 0px;
    color: #166534;
  }


  .container {
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
    background: #ffffff;
    padding: 20px 30px;
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  }

  a {
    display: inline-block;
    background-color: #16a34a;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-bottom: 20px;
  }

  a:hover {
    background-color: #15803d;
    transform: translateY(-2px);
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    font-size: 15px;
  }

  th, td {
    border: 1px solid #d4d4a3;
    padding: 10px;
    text-align: center;
  }

  th {
    background-color: #16a34a;
    color: #fff9c2;
    font-weight: 600;
  }

  tr:nth-child(even) {
    background-color: #f7fcd1;
  }



  #map {
    height: 400px;
    width: 100%;
    border-radius: 12px;
    margin: 30px 0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  footer {
    text-align: center;
    margin-top: 30px;
    font-size: 13px;
    color: #4d7c0f;
  }
</style>

</head>

<body>
  <h1>WEB GIS</h1>
  <h2>Kabupaten Sleman</h2>

  <div class="container">
    <a href="input/index.html">Tambah Data Kecamatan</a>

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

    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn->query($sql);

    // Array PHP untuk dikirim ke JavaScript
    $locations = [];

    if ($result->num_rows > 0) {
      echo "<table><tr>
        <th>ID</th>
        <th>Kecamatan</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Luas</th>
        <th>Jumlah Penduduk</th>
        <th colspan='2'>Aksi</th>
      </tr>";

      while ($row = $result->fetch_assoc()) {
        echo "<tr>
          <td>" . $row["id"] . "</td>
          <td>" . $row["kecamatan"] . "</td>
          <td>" . $row["longitude"] . "</td>
          <td>" . $row["latitude"] . "</td>
          <td>" . $row["luas"] . "</td>
          <td>" . $row["jumlah_penduduk"] . "</td>
          <td><a href='delete.php?id=" . $row["id"] . "'>Hapus</a></td>
          <td><a href='edit/index.php?id=" . $row["id"] . "'>Edit</a></td>
        </tr>";

        // Masukkan ke array lokasi untuk peta
        $locations[] = [
          "kecamatan" => $row["kecamatan"],
          "latitude" => $row["latitude"],
          "longitude" => $row["longitude"]
        ];
      }

      echo "</table>";
    } else {
      echo "<p style='text-align:center; color:#64748b;'>Tidak ada data kecamatan.</p>";
    }

    $conn->close();
    ?>

    <!-- Div untuk menampilkan peta -->
    <div id="map"></div>

  </div>

  <footer>
    © 2025 Zulfatah Ahmad K.
  </footer>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    // Ambil data dari PHP ke JavaScript
    const locations = <?php echo json_encode($locations); ?>;

    // Inisialisasi peta (pusat default di Indonesia)
    const map = L.map('map').setView([-7.7829, 110.3671], 11);

    // Tambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Tambahkan marker untuk setiap data kecamatan
    locations.forEach(loc => {
      if (loc.latitude && loc.longitude) {
        const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
        marker.bindPopup(`<b>${loc.kecamatan}</b><br>Lat: ${loc.latitude}<br>Lng: ${loc.longitude}`);
      }
    });
  </script>
</body>
</html>

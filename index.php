<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "latihan_8";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn -> query($sql);

    

    if($result -> num_rows > 0) { 
 echo "<table border='1px'><tr> 
  <th>Kecamatan</th> 
  <th>Longitude</th> 
  <th>Latitude</th> 
  <th>Luas</th> 
  <th>Jumlah Penduduk</th>"; 
  
 // output data of each row 
 while($row = $result->fetch_assoc()) { 
  echo "<tr><td>".$row["kecamatan"]."</td><td>".
        $row["longitude"]."</td><td align='right'>".
        $row["latitude"]."</td><td align='right'>". 
        $row["luas"]."</td><td align='right'>". 
        $row["jumlah_penduduk"]."</td></tr>"; 
 } 
   echo "</table>"; 
} else { 
echo "0 results"; 
} 
$conn->close(); 


    ?>
</body>
</html>
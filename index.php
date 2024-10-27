<?php
// Konfigurasi MySQL
$servername = "127.0.0.1:8111";
$username = "root";
$password = "";
$dbname = "penduduk_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hapus data jika ada parameter 'kecamatan'
if (isset($_GET['kecamatan'])) {
    $kecamatan = $conn->real_escape_string($_GET['kecamatan']); // Hindari SQL Injection
    $sql = "DELETE FROM pendudukk WHERE kecamatan = '$kecamatan'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Refresh halaman setelah penghapusan
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Query untuk mengambil data dari tabel penduduk
$sql = "SELECT * FROM pendudukk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1px'>
            <tr>
                <th>Kecamatan</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Luas</th>
                <th>Jumlah Penduduk</th>
                <th>Aksi</th> <!-- Tambahkan kolom aksi -->
            </tr>";

    // Output data tiap baris dengan tombol hapus
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["kecamatan"] . "</td>
                <td>" . $row["longitude"] . "</td>
                <td>" . $row["latitude"] . "</td>
                <td>" . $row["luas"] . "</td>
                <td align='right'>" . $row["jumlah_penduduk"] . "</td>
                <td> <!-- Kolom aksi dengan link hapus -->
                    <a href='index.php?kecamatan=" . urlencode($row["kecamatan"]) . "' 
                    onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Menutup koneksi
$conn->close();

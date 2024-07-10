<?php 

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=oprec', 'root', '');

$statement = $db->prepare('select p.nama_petugas, b.nama_barang, r.tahun, r.total_pendapatan from rekapan r join petugas p on r.kode_petugas = p.kode_petugas join barang b on r.kode_barang = b.kode_barang');
$statement->execute();
$daftar_penjualan = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    
    <form action=""></form>

    <a href="logout.php">Logout</a>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Petugas</th>
            <th>Nama Barang</th>
            <th>Tahun</th>
            <th>Total Pendapatan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($daftar_penjualan as $daftar): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $daftar['nama_petugas']; ?></td>
                <td><?= $daftar['nama_barang']; ?></td>
                <td><?= $daftar['tahun']; ?></td>
                <td><?= $daftar['total_pendapatan']; ?></td>
            </tr>
        <?php endforeach ?>
    </table>
    
</body>
</html>
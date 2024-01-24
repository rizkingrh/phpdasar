<?php
session_start();

if (!isset($_SESSION["login"])) { // jika blom ada 
    header("Location: login.php");
    exit;
}

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");

// tombal cari di klik
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    
    <a href="logout.php">Logout!</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah Data</a>
    <br><br>

    <!-- Note atribut:
    size = untuk melebarkan input
    autofocus = untuk langsung focus pada inputan
    autocomplete = untuk menghilangkan history input
    -->
    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword..." autocomplete="off">
        <button type="submit" name="cari">Search</button>
    </form>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Nim</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach($mahasiswa as $row) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="ubah.php?id=<?= $row["id"]; ?>">edit</a> |
                <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?')">delete</a>
            </td>
            <td><img src="img/<?= $row["gambar"]; ?>" width="60"></td>
            <td><?= $row["nim"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["email"]; ?></td>
            <td><?= $row["jurusan"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>



</body>
</html>
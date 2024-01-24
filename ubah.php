<?php 
session_start();

if (!isset($_SESSION["login"])) { // jika blom ada 
    header("Location: login.php");
    exit;
}

require 'functions.php';

// mengambil data id di url
$id = $_GET["id"];

// query data mahasiwa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


// cek tombol submit dipencet apa blom
if(isset($_POST["submit"])) {
    // cek data berhasil ubah atau tidak

    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil diupdate!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diupdate!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
</head>
<body>
    <h1>Update Data Mahasiswa</h1>
    
    <!-- Untuk mengelola input file menggunakan atribut "enctype", dimana input type string akan dikelola oleh $_POST dan untuk file dikelola $_FILES -->
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Kasih atribut "required" agar data tidak boleh kosong -->
        <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">
        <ul>
            <li>
                <label for="nim">Nim : </label>
                <input type="text" name="nim" id="nim" value="<?= $mhs["nim"]; ?>" required>
            </li>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" value="<?= $mhs["nama"]; ?>" required>
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" value="<?= $mhs["email"]; ?>" required>
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label> <br>
                <img src="img/<?= $mhs['gambar']; ?>" width="50"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Update Data!</button>
            </li>
        </ul>
        

    </form>
</body>
</html>
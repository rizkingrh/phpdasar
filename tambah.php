<?php
session_start();

if (!isset($_SESSION["login"])) { // jika blom ada 
    header("Location: login.php");
    exit;
}

require 'functions.php';

// cek tombol submit dipencet apa blom
if(isset($_POST["submit"])) {

    // var_dump($_POST); // untuk melihat isi elemen dari form
    // var_dump($_FILES); // untuk melihat isi elemen dari input file yang dikelola
    // die(); // berfungsi agar code dibawahnya tidak dijalankan

    // cek data berhasil tambah atau tidak
    if (tambah($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
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
    <title>Tambah Data</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>

    <!-- Untuk mengelola input file menggunakan atribut "enctype", dimana input type string akan dikelola oleh $_POST dan untuk file dikelola $_FILES -->
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Kasih atribut "required" agar data tidak boleh kosong -->
        <ul>
            <li>
                <label for="nim">Nim : </label>
                <input type="text" name="nim" id="nim" required>
            </li>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data!</button>
            </li>
        </ul>
        

    </form>
</body>
</html>
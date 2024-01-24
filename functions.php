<?php 
// connect to db
$db_conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $db_conn;
    $result = mysqli_query($db_conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data) {
    global $db_conn;

    // htmlspecialchars, berfungsi untuk menjaga agar elemen html tidak dijalankan
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) { // !$gambar itu sama kaya $gambar == false
        return false; // dimana nanti di tambah.php, fungsi akan menghasilkan nilai false
    }

    // query insert data
    $query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nim', '$email', '$jurusan', '$gambar')";

    mysqli_query($db_conn, $query);

    return mysqli_affected_rows($db_conn);
}

function upload() {
    $namaFile = $_FILES["gambar"]["name"];
    $ukuranFile = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmpName = $_FILES["gambar"]["tmp_name"];

    // cek apakah user mengupload gambar atau tidak
    if ($error === 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu');
            </script>";

        return false;
    }

    // cek yang di upload berupa gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile); // untuk memecah string menjadi array dengan delimiter '.' contoh: rizki.jpg = ['rizki', 'jpg']
    $ekstensiGambar = strtolower(end($ekstensiGambar)); // untuk mengambil elemen array paling terakhir

    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) { // in_array === false, percabangan if akan mengeksekusi yang bernilai true. contoh: rizki.pdf, nilai "in_array" akan mengahsilkan false dan kemudian di notkan, sehingga nilai di dalam if menjadi true, yang akan mengeksekusi alert gagal
        echo "<script>
                alert('yang anda upload bukan gambar');
            </script>";

        return false;
    }

    // cek ukuran gambar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('ukuran gambar terlalu besar');
            </script>";

        return false;
    }

    // lolos pengecekan maka gambar di upload
    // generate nama gambar baru, agar ketika user memiliki nama file yang sama tidak tertimpa
    $namaFileBaru = uniqid(); // misal uniqid = abc123
    $namaFileBaru .= '.'; // menjadi = abc123.
    $namaFileBaru .= $ekstensiGambar; // menjadi = abc123.jpg

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}


function hapus($id) {
    global $db_conn;

    mysqli_query($db_conn, "DELETE FROM mahasiswa WHERE id = '$id'");

    return mysqli_affected_rows($db_conn);
}

function ubah($data) {
    global $db_conn;

    // htmlspecialchars, berfungsi untuk menjaga agar elemen html tidak dijalankan
    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    // cek user upload gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // query insert data
    $query = "UPDATE mahasiswa SET 
        nim = '$nim', 
        nama = '$nama', 
        email = '$email', 
        jurusan = '$jurusan',
        gambar = '$gambar'

        WHERE id = $id
    ";

    mysqli_query($db_conn, $query);

    return mysqli_affected_rows($db_conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa
        WHERE
        nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        email LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%'
    ";

    return query($query);
}

function registrasi($data) {
    global $db_conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($db_conn, $data["password"]);
    $password2 = mysqli_real_escape_string($db_conn, $data["password2"]);

    // cek username sudah ada atau tidak
    $result = mysqli_query($db_conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username sudah terdaftar');        
            </script>";

        return false;
    }
    //cek password confirm
    if ($password !== $password2) {
        echo "<script>
                alert('password tidak sesuai!');        
            </script>";
        
        return false;
    }

    // enkripsi password 
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambah user baru ke database
    mysqli_query($db_conn, "INSERT INTO user VALUES('','$username','$password')");

    return mysqli_affected_rows($db_conn);
}

?>
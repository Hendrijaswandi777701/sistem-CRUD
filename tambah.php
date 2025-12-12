<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

include "config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-600 to-indigo-700 min-h-screen flex items-center justify-center p-4">

<div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">  <!-- diperkecil -->

    <h2 class="text-xl font-bold text-center mb-5 text-gray-800">
        Tambah Data Mahasiswa
    </h2>

    <form method="post" enctype="multipart/form-data" class="space-y-3">

        <!-- Nama -->
        <div>
            <label class="font-medium text-gray-700 text-sm">Nama</label>
            <input type="text" name="nama"
                   class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"
                   required>
        </div>

        <!-- NIM -->
        <div>
            <label class="font-medium text-gray-700 text-sm">NIM</label>
            <input type="text" name="nim"
                   class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"
                   required>
        </div>

        <!-- Prodi -->
        <div>
            <label class="font-medium text-gray-700 text-sm">Prodi</label>
            <select name="prodi"
                    class="w-full p-2.5 border rounded-lg bg-white focus:ring-2 focus:ring-blue-500 text-sm"
                    required>
                <option value="">-- Pilih Prodi --</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
            </select>
        </div>

        <!-- Alamat -->
        <div>
            <label class="font-medium text-gray-700 text-sm">Alamat</label>
            <textarea name="alamat"
                      class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm"
                      required></textarea>
        </div>

        <!-- Gambar -->
        <div>
            <label class="font-medium text-gray-700 text-sm">Foto Mahasiswa</label>
            <input type="file" name="gambar"
                   class="w-full p-2 border rounded-lg bg-gray-50 text-sm"
                   required>
        </div>

        <!-- Tombol -->
        <button name="simpan"
                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-blue-700 transition">
            Simpan Data
        </button>

    </form>
</div>


<?php
if(isset($_POST['simpan'])){

    $gambar = time() . "-" . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/$gambar");

    mysqli_query($koneksi, "INSERT INTO mahasiswa (nama, nim, prodi, alamat, gambar) 
                            VALUES (
                            '$_POST[nama]',
                            '$_POST[nim]',
                            '$_POST[prodi]',
                            '$_POST[alamat]',
                            '$gambar'
                            )");

    echo "<script>
            alert('Data berhasil ditambahkan!');
            window.location='index.php';
          </script>";
}
?>

</body>
</html>

<?php 
session_start(); 
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
    exit(); 
} 

include "config.php"; 

$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id='$id'");
$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-600 to-indigo-700 min-h-screen flex items-center justify-center p-4">

<div class="bg-white w-full max-w-md rounded-xl shadow-lg p-4"> <!-- Dipendekkan lagi -->

    <h2 class="text-lg font-semibold text-center mb-3 text-gray-800">
        Edit Data Mahasiswa
    </h2>

    <form method="post" enctype="multipart/form-data" class="space-y-1.5"> <!-- Dipendekkan -->

        <div>
            <label class="text-sm font-medium">Nama</label>
            <input type="text" name="nama"
                   value="<?= $data['nama'] ?>"
                   class="w-full p-1.5 border rounded-md focus:ring-2 focus:ring-blue-500 text-sm"
                   required>
        </div>

        <div>
            <label class="text-sm font-medium">NIM</label>
            <input type="text" name="nim"
                   value="<?= $data['nim'] ?>"
                   class="w-full p-1.5 border rounded-md focus:ring-2 focus:ring-blue-500 text-sm"
                   required>
        </div>

        <div>
            <label class="text-sm font-medium">Prodi</label>
            <select name="prodi"
                    class="w-full p-1.5 border rounded-md bg-white focus:ring-2 focus:ring-blue-500 text-sm"
                    required>
                <option value="Teknik Informatika" <?= $data['prodi']=="Teknik Informatika"?"selected":"" ?>>
                    Teknik Informatika
                </option>
                <option value="Sistem Informasi" <?= $data['prodi']=="Sistem Informasi"?"selected":"" ?>>
                    Sistem Informasi
                </option>
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Alamat</label>
            <textarea name="alamat"
                      class="w-full p-1.5 border rounded-md focus:ring-2 focus:ring-blue-500 text-sm"
                      required><?= $data['alamat'] ?></textarea>
        </div>

        <div>
            <label class="text-sm font-medium">Foto Saat Ini</label><br>
            <img src="upload/<?= $data['gambar'] ?>" class="w-14 h-14 object-cover border rounded-md mt-1">
        </div>

        <div>
            <label class="text-sm font-medium">Ganti Foto (opsional)</label>
            <input type="file" name="gambar"
                   class="w-full p-1.5 border rounded-md bg-gray-50 text-sm">
        </div>

        <button name="update"
                class="w-full bg-blue-600 text-white py-2 rounded-md text-sm font-semibold hover:bg-blue-700 transition">
            Update
        </button>

        <!-- Tombol Kembali -->
        <a href="index.php"
           class="block text-center bg-gray-300 text-gray-800 py-2 rounded-md text-sm font-medium hover:bg-gray-400 transition">
           Kembali
        </a>

    </form>
</div>

<?php
if (isset($_POST['update'])) {

    if ($_FILES['gambar']['name'] != "") {
        $new = time() . "-" . $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/$new");
        unlink("upload/" . $data['gambar']);
    } else {
        $new = $data['gambar'];
    }

    mysqli_query($koneksi, "UPDATE mahasiswa SET
        nama='$_POST[nama]',
        nim='$_POST[nim]',
        prodi='$_POST[prodi]',
        alamat='$_POST[alamat]',
        gambar='$new'
        WHERE id='$id' ");

    echo "<script>alert('Data berhasil diupdate!'); window.location='index.php';</script>";
}
?>

</body>
</html>

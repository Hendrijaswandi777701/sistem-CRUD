<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include "config.php";

// 🔍 Proses pencarian
$keyword = isset($_GET['cari']) ? $_GET['cari'] : "";

$query = "SELECT * FROM mahasiswa";

if ($keyword != "") {
    $query .= " WHERE 
        nama LIKE '%$keyword%' OR
        nim LIKE '%$keyword%' OR
        prodi LIKE '%$keyword%' OR
        alamat LIKE '%$keyword%'";
}

$query .= " ORDER BY id DESC";

$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard - Data Mahasiswa</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-text mx-3">SIKAMPUS</div>
        </a>

        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Mahasiswa</span></a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            <?= $_SESSION['username'] ?> (<?= $_SESSION['role'] ?>)
                        </span>
                    </li>
                    <a href="logout.php" class="btn btn-danger btn-sm ml-2">Logout</a>
                </ul>
            </nav>

            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">Data Mahasiswa</h1>

                <!-- 🔍 FORM PENCARIAN -->
                <form method="GET" class="mb-3" style="max-width: 300px;">
                    <div class="input-group">
                        <input type="text" name="cari"
                               class="form-control"
                               placeholder="Cari nama / NIM / prodi..."
                               value="<?= $keyword ?>">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </form>

                <!-- Tombol tambah -->
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <a href="tambah.php" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                <?php } ?>

                <div class="card shadow">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">

                                <thead class="bg-primary text-white">
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Prodi</th>
                                    <th>Alamat</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php while ($d = mysqli_fetch_assoc($data)) { ?>
                                    <tr>
                                        <td><?= $d['nama'] ?></td>
                                        <td><?= $d['nim'] ?></td>
                                        <td><?= $d['prodi'] ?></td>
                                        <td><?= $d['alamat'] ?></td>
                                        <td><img src="upload/<?= $d['gambar'] ?>" width="60" class="rounded"></td>
                                        <td>
                                            <?php if ($_SESSION['role'] == 'admin') { ?>
                                                <a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="hapus.php?id=<?= $d['id'] ?>"
                                                   onclick="return confirm('Hapus data ini?')"
                                                   class="btn btn-sm btn-danger">Hapus</a>
                                            <?php } else { ?>
                                                <span class="text-muted">Tidak ada akses</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
</body>
</html>

<?php
include "config.php";
mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE nim='$_GET[id]'");
header("Location: index.php");
?>

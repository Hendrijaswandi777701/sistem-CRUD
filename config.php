<?php
$koneksi = mysqli_connect("localhost", "root", "HENDRIJASWANDI", "stilo");

if(!$koneksi){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

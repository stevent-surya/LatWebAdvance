<?php
$server = "localhost";
$user = "root";
$pwd = "";
$db = "aboutme";

$koneksi = new mysqli($server, $user, $pwd, $db);

if ($koneksi->connect_error) {
  die("Connection failed: " . $koneksi->connect_error);
}
?>
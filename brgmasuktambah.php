<?php
include 'function.php';
$barang = $_POST['barang'];
$qty = $_POST['qty'];
$tanggal = $_POST['tanggal'];

$dt = mysqli_query($con, "select * from brg where idx='$barang'");
$data = mysqli_fetch_array($dt);
$sisa = $data['stok'] + $qty;
$query1 = mysqli_query($con, "update brg set stok='$sisa' where idx='$barang'");

$query2 = mysqli_query($con, "insert into brgmasuk (idx,tanggal,jumlah) values('$barang','$tanggal','$qty')");

if ($query1 && $query2) {
    echo " <div class='alert alert-success'>
    <strong>Success!</strong> Redirecting you back in 1 seconds.
  </div>
<meta http-equiv='refresh' content='1; url= brgmasuk.php'/>  ";
} else {
    echo "<div class='alert alert-warning'>
    <strong>Failed!</strong> Redirecting you back in 1 seconds.
  </div>
  <meta http-equiv='refresh' content='1; url= brgmasuk.php'/> ";
}

?>

<html>

<head>
    <title>Barang Masuk</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
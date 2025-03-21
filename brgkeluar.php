<?php

require 'function.php';
session_start();
if ($_SESSION['username'] != "ricky") {
    header("location: index.php");
}

$brgs = query("SELECT * FROM brg");
$brgkeluar = query("SELECT * FROM brgkeluar");


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $idx = $_POST['idx'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    $lihatstock = mysqli_query($con, "select * from brg where idx='$idx'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stok'];

    $lihatdataskrg = mysqli_query($con, "select * from brgkeluar where id='$id'");
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg);
    $qtyskrg = $preqtyskrg['jumlah'];

    if ($jumlah >= $qtyskrg) {
        $hitungselisih = $jumlah - $qtyskrg;
        $kurangistock = $stockskrg - $hitungselisih;

        $queryx = mysqli_query($con, "update brg set stok='$kurangistock' where idx='$idx'");
        $updatedata1 = mysqli_query($con, "update brgkeluar set tanggal='$tanggal',jumlah='$jumlah' where id='$id'");

        if ($updatedata1 && $queryx) {

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url= brgkeluar.php'/>  ";
        } else {
            echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 3 seconds.
            </div>
            <meta http-equiv='refresh' content='3; url= brgkeluar.php'/> ";
        };
    } else {
        $hitungselisih = $qtyskrg - $jumlah;
        $tambahistock = $stockskrg + $hitungselisih;

        $query1 = mysqli_query($con, "update brg set stok='$tambahistock' where idx='$idx'");

        $updatedata = mysqli_query($con, "update brgkeluar set tanggal='$tanggal', jumlah='$jumlah' where id='$id'");

        if ($query1 && $updatedata) {

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url= brgkeluar.php'/>  ";
        } else {
            echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 3 seconds.
            </div>
            <meta http-equiv='refresh' content='3; url= brgkeluar.php'/> ";
        };
    };
};

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $idx = $_POST['idx'];

    $lihatstock = mysqli_query($con, "select * from brg where idx='$idx'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stok'];

    $lihatdataskrg = mysqli_query($con, "select * from brgkeluar where id='$id'");
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg);
    $qtyskrg = $preqtyskrg['jumlah'];

    $adjuststock = $stockskrg + $qtyskrg;

    $queryx = mysqli_query($con, "update brg set stok='$adjuststock' where idx='$idx'");
    $del = mysqli_query($con, "delete from brgkeluar where id='$id'");


    if ($queryx && $del) {

        echo " <div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
        <meta http-equiv='refresh' content='1; url= brgkeluar.php'/>  ";
    } else {
        echo "<div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url= brgkeluar.php'/> ";
    }
};
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="index1.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">

    <title>Angkringan RA</title>
</head>

<body>
    <!-- Jumbotron -->
    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-4"><span class="font-weight-bold" style="color: #80ced6;">ANGKRINGAN RA</span></h1>
            <hr>
            <!-- <p class="lead font-weight-bold" style="color: #80ced6;">Silahkan Pesan Menu Sesuai Keinginan Anda <br></p> -->
        </div>
    </div>
    <!-- Akhir Jumbotron -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg  bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="https://www.instagram.com/angkringanra/"><strong>Angkringan RA</strong></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-brg">
                        <a class="nav-link mr-4" href="brg.php">BARANG</a>
                    </li>
                    <li class="nav-brg">
                        <a class="nav-link mr-4" href="brgmasuk.php">BARANG MASUK</a>
                    </li>
                    <li class="nav-brg">
                        <a class="nav-link mr-4" href="brgkeluar.php">BARANG KELUAR</a>
                    </li>
                    <li class="nav-brg">
                        <a class="nav-link mr-4" href="logout.php">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->
    <div class="d-sm-flex justify-content-between align-brgs-center">
        <a href="laporanbrgkeluar.php" target="_blank" class="btn btn-info">Print</a>
        <button style="margin-bottom:20px;position: relative; top:80px;right:100px;" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah</button>
    </div>

    <table class="table table-hover" style="position: relative; top:80px;" id="dataTable3">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">TANGGAL</th>
                <th scope="col">NAMA</th>
                <th scope="col">JUMLAH</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $brg = mysqli_query($con, "SELECT * from brgkeluar sb, brg st where st.idx=sb.idx order by sb.id DESC");
            $no = 1;
            while ($b = mysqli_fetch_array($brg)) {
                $idb = $b['idx'];
                $id = $b['id'];
            ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?php $tanggals = $b['tanggal'];
                        echo date("d-M-Y", strtotime($tanggals)) ?></td>
                    <td><?php echo $b['nama_barang'] ?></td>
                    <td><?php echo $b['jumlah'] ?></td>
                    <td>
                        <a class="btn btn-warning" style="background-color: blue; border-color:black;" id="tombolUbah" data-toggle="modal" data-target="#ubahModal<?= $id; ?>">Edit</a>
                        <a class="btn btn-danger" style="background-color: crimson; border-color:black;" id="tombolDel" data-toggle="modal" data-target="#delModal<?= $id; ?>">Delete</a>
                    </td>
                </tr>
                <div class="modal fade" id="ubahModal<?= $id; ?>" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ubahModalLabel">Edit Barang Keluar</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo $b['tanggal'] ?>">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $b['nama_barang'] ?>" disabled>
                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" id="jumlah" name="jumlah" class="form-control" value="<?php echo $b['jumlah'] ?>">
                                    <input type="hidden" name="id" value="<?= $id; ?>">
                                    <input type="hidden" name="idx" value="<?= $idb; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" name="update">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="delModal<?= $id; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Hapus Barang <?php echo $b['nama_barang'] ?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini dari daftar barang keluar?
                                    <br>
                                    *Stok barang akan bertambah
                                    <input type="hidden" name="id" value="<?= $id; ?>">
                                    <input type="hidden" name="idx" value="<?= $idb; ?>">
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" name="hapus">Hapus</a></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
        </tbody>
    </table>

    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Input Barang Keluar</h4>
                </div>
                <div class="modal-body">
                    <form action="brgkeluartambah.php" method="post">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <select name="barang" class="custom-select form-control">
                                <option selected>Pilih barang</option>
                                <?php
                                $det = mysqli_query($con, "select * from brg order by idx ASC");
                                while ($d = mysqli_fetch_array($det)) {
                                ?>
                                    <option value="<?php echo $d['idx'] ?>"><?php echo $d['nama_barang'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input name="qty" type="text" min="1" class="form-control" placeholder="Qty">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Awal Footer -->
    <hr class="footer">
    <div class="container">
        <div class="row footer-body">
            <div class="col-md-6">
                <div class="copyright">
                    <strong>Copyright</strong> <i class="far fa-copyright"></i> 2022 - Ricky Arianto</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Footer -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
</body>

</html>
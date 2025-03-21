<?php

require 'function.php';
session_start();
if ($_SESSION['username'] != "ricky") {
    header("location: index.php");
}
$brg = query("SELECT * FROM brg");

function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'images/' . $namaFileBaru);

    return $namaFileBaru;
}

if (isset($_POST['update'])) {
    $idx = $_POST['idx'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $fotoLama = $_POST["fotoLama"];

    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
    }

    $updatedata = mysqli_query($con, "update brg set nama_barang='$nama', harga='$harga', stok='$stok', foto='$foto' where idx='$idx'");

    //cek apakah berhasil
    if ($updatedata) {

        echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= brg.php'/>  ";
    } else {
        echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= brg.php'/> ";
    }
};

if (isset($_POST['hapus'])) {
    $idx = $_POST['idbrg'];

    $delete = mysqli_query($con, "delete from brg where idx='$idx'");
    //hapus juga semua data barang ini di tabel keluar-masuk
    $deltabelkeluar = mysqli_query($con, "delete from brgkeluar where id='$idx'");
    $deltabelmasuk = mysqli_query($con, "delete from brgmasuk where id='$idx'");

    //cek apakah berhasil
    if ($delete && $deltabelkeluar && $deltabelmasuk) {

        echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= brg.php'/>  ";
    } else {
        echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= brg.php'/> ";
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
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="brg.php">BARANG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="brgmasuk.php">BARANG MASUK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="brgkeluar.php">BARANG KELUAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-4" href="logout.php">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Akhir Navbar -->
    <div class="d-sm-flex justify-content-between align-items-center">
        <a href="laporanbrg.php" target="_blank" class="btn btn-info">Print</a>
        <button style="margin-bottom:20px;position: relative; top:80px;right:100px;" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah</button>
    </div>

    <table class="table table-hover" style="position: relative; top:80px;" id="dataTable3">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">NAMA</th>
                <th scope="col">HARGA</th>
                <th scope="col">STOCK</th>
                <th scope="col">FOTO</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $brgs = mysqli_query($con, "SELECT * from brg order by idx ASC");
            $no = 1;
            while ($p = mysqli_fetch_array($brgs)) {
                $idb = $p['idx'];

            ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $p["nama_barang"] ?></td>
                    <td><?= $p["harga"] ?></td>
                    <td><?= $p["stok"] ?></td>
                    <td><img src="images/<?= $p["foto"] ?>" alt="" width="100px"></td>
                    <td>
                        <button data-toggle="modal" data-target="#edit<?= $idb; ?>" class="btn btn-warning" style="background-color: gray; border-color:black;">Edit</button>
                        <button data-toggle="modal" data-target="#del<?= $idb; ?>" class="btn btn-danger" style="background-color: crimson; border-color:black;">Delete</button>
                    </td>
                </tr>

                <div class="modal fade" id="edit<?= $idb; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" enctype="multipart/form-data">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">

                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $p['nama_barang'] ?>">

                                    <label for="nama">Harga</label>
                                    <input type="number" id="harga" name="harga" class="form-control" value="<?php echo $p['harga'] ?>">

                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" id="stok" name="stok" class="form-control" value="<?php echo $p['stok'] ?>">

                                    <label for="nama">Foto</label>
                                    <img src="images/<?php echo $p["foto"]; ?>" alt="" width="100">
                                    <input type="file" id="foto" name="foto" class="form-control" value="<?php echo $p['foto'] ?>">

                                    <input type="hidden" name="idx" value="<?= $idb; ?>">
                                    <input type="hidden" name="fotoLama" value="<?= $p["foto"] ?>">
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" name="update">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <!-- The Modal -->
                <div class="modal fade" id="del<?= $idb; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Hapus Barang <?php echo $p['nama_barang'] ?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini dari daftar?
                                    <input type="hidden" name="idbrg" value="<?= $idb; ?>">
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
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
                    <h4 class="modal-title">Tambah</h4>
                </div>
                <div class="modal-body">
                    <form action="brgtambah.php" method="post">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="nama" type="text" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input name="harga" type="number" class="form-control" placeholder="Harga">
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input name="stok" type="number" min="0" class="form-control" placeholder="Stok">
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input name="foto" type="file" min="0" class="form-control" placeholder="Foto">
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
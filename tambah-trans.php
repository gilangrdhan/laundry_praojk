<?php
session_start();
include 'koneksi.php';

$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer");
$id = isset($_GET['detail']) ? $_GET['detail'] : '';

// Ambil detail transaksi berdasarkan ID order
$queryTransDetail = mysqli_query($koneksi, "SELECT 
        trans_order.no_transaksi, 
        trans_order.tanggal_laundry, 
        trans_order.order_end_date, 
        trans_order.status, 
        trans_order.order_pay, 
        trans_order.order_change, 
        paket.nama_paket, 
        paket.harga,  
        customer.nama_customer, 
        customer.phone, 
        customer.address,
        trans_order_detail.* FROM 
        trans_order_detail 
    LEFT JOIN 
        paket ON paket.id = trans_order_detail.id_paket 
    LEFT JOIN 
        trans_order ON trans_order.id = trans_order_detail.id_order 
    LEFT JOIN 
        customer ON customer.id = trans_order.id_customer 
    WHERE 
        trans_order_detail.id_order = '$id'");

// Mengambil hasil query dan menyimpannya dalam array $row
$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;

}



$queryPaket = mysqli_query($koneksi, "SELECT * FROM paket");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}

// jika button simpan ditekan atau di klik
if (isset($_POST['simpan'])) {
    //mengambil dari form input dengan attribut name=""
    $id_customer         = $_POST['id_customer'];
    $no_transaksi        = $_POST['no_transaksi'];
    $tanggal_laundry     = $_POST['tanggal_laundry'];
    //id_paket cuma ada di trans_order detail jadi tidak dimasukin
    $id_paket                  = $_POST['id_paket'];
    $order_end_date            = $_POST['order_end_date'];
    $order_pay                 = $_POST['order_pay'];
    $order_change              = $_POST['order_change'];



    //insert ke table trans_order
    $insertTransOrder = mysqli_query($koneksi, "INSERT INTO trans_order (id_customer, no_transaksi, tanggal_laundry, order_end_date, order_pay, order_change) VALUES ('$id_customer', '$no_transaksi', '$tanggal_laundry','$order_end_date', '$order_pay', '$order_change')");

    $last_id = mysqli_insert_id($koneksi);
    // insert ke table trans_detail_order
    // MENGAMBIL NILAI LEBIH DARI SATU, LOOPING DENGAN FOREACH
    foreach ($id_paket as $key => $value) {
        $id_paket = array_filter($_POST['id_paket']);
        $qty = array_filter($_POST['qty']);

        $id_paket = $_POST['id_paket'][$key];
        $qty = $_POST['qty'][$key];

        // query untuk mengambil harga dari table paket
        $queryPaket = mysqli_query($koneksi, "SELECT id, harga FROM paket WHERE id= '$id_paket'");
        $rowPaket = mysqli_fetch_assoc($queryPaket);
        // print_r($rowPaket);
        // die;
        $harga = isset($rowPaket['harga']) ? $rowPaket['harga'] : '';

        //sub total
        $subTotal = (int)$qty * (int)$harga;
        // print_r($subTotal);
        // die;

        if ($id_paket > 0) {
            $insertTransDetail = mysqli_query($koneksi, "INSERT INTO trans_order_detail (id_order, id_paket, qty, subtotal) VALUES ('$last_id', '$id_paket', '$qty', '$subTotal')");
        }
    }




    if ($insertTransDetail) {
        header("location:trans_order.php?tambah=berhasil");
    }
    //$_POST    : form input name=""
    //$_GET     : url ?param='nilai'
    //$_FILES   : ngambil nilai dari input type file
    // if (!empty($_FILES['foto']['name'])) {
    //     $nama_foto = $_FILES['foto']['name'];
    //     $ukuran_foto = $_FILES['foto']['size'];

    //     //png,jpg,jpeg
    //     $ext = array('png', 'jpg', 'jpeg');
    //     $extFoto = pathinfo($nama_foto, PATHINFO_EXTENSION);

    //     //jika extensi foto tidak ada ext yang terdaftar di array ext
    //     if (!in_array($extFoto, $ext)) {
    //         echo "Ekstensi tidak ditemukan";
    //         die;
    //     } else {
    //         // Pindahkan gambar dari tmp ke folder yang sudah kita buat
    //         move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/' . $nama_foto);
    //         $sql = "INSERT INTO user (nama,email,password,foto) VALUES ('$nama','$email','$password', '$nama_foto')";
    //         $insert = mysqli_query($koneksi, $sql);
    //     }
    // } else {
    //     $sql = "INSERT INTO user (nama,email,password) VALUES ('$nama','$email','$password')";
    //     $insert = mysqli_query($koneksi, $sql);
    // }

    // // print_r($insert);
    // // die;


    // if ($insert) {
    //     header("location:user.php?tambah=berhasil");
    // }
}
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

// jika button edit di klik
if (isset($_POST['edit'])) {
    $nama  = $_POST['nama'];
    $email = $_POST['email'];

    $id_level = $_POST['id_level'];


    // jika password diisi sama user
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = $rowEdit['password'];
    }

    $update = mysqli_query($koneksi, "UPDATE user SET  id_level='$id_level', nama='$nama', email='$email', password='$password' WHERE id='$id'");
    header("location:user.php?ubah=berhasil");
}

//  NOMER INVOICE
//001, JIKA ADA AUTO INCREMENT ID + 1 =002, SELAIN ITU 001
// MAX : TERBESAR  MIN : TERKECIL

$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS no_invoice FROM trans_order");
//JIKA DI DALAM TABLE TRANS ORDER ADA DATANYA
$str_unique = "INV";
$date_now = date("dmy");

if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['no_invoice'] + 1;
    $code = $str_unique . "" . $date_now . "" . "000" . $incrementPlus;
} else {
    $code = $str_unique . "" . $date_now . "" . "001";
}

?>


<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />


    <?php include 'inc/head.php'; ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->


            <!-- / Menu -->
            <?php include 'inc/sidebar.php'; ?>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php'; ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?php if (isset($_GET['detail'])): ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h5>Transaksi Laundry <?php echo $row[0]['nama_customer'] ?></h5>
                                            </div>
                                            <div class="col-sm-6" align="right">
                                                <a href="trans_order.php" class="btn btn-secondary">Kembali</a>
                                                <a href="print.php?id=<?php echo $row[0]['id_order'] ?>" class="btn btn-success">Print</a>
                                                <?php if ($row[0]['status'] == 0): ?>
                                                    <a href="tambah-trans-pickup.php?ambil=<?php echo $row[0]['id_order'] ?>" class="btn btn-warning">Ambil Cucian</a>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                        <div class="card-body"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Transaksi</h5>
                                        </div>
                                        <?php include 'helper.php'; ?>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]['no_transaksi'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Laundry</th>
                                                    <td><?php echo $row[0]['tanggal_laundry'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php
                                                        echo changeStatus($row[0]['status']) ?>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Pelanggan</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?php echo $row[0]['nama_customer'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Telp</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['address'] ?></td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Paket</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($row as $key => $value): ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $value['nama_paket'] ?></td>
                                                            <td><?php echo $value['qty'] ?></td>
                                                            <td><?php echo $value['harga'] ?></td>
                                                            <td><?php echo $value['subtotal'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="container-xxl container-p-y">

                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil dihapus
                                                    </div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-6 mb-3">
                                                        <label for="">Nama Pelanggan</label>
                                                        <select name="id_customer" id="" class="form-control">
                                                            <option value="">Pilih Customer</option>
                                                            <?php while ($row = mysqli_fetch_assoc($queryCustomer)): ?>

                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nama_customer'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-3">
                                                        <label for="" class="form-label">No Invoice</label>
                                                        <input type="text"
                                                            value="<?php echo $code; ?>"
                                                            class="form-control"
                                                            name="no_transaksi" readonly value='#'>
                                                    </div>
                                                    <div class="col-sm-6 mb-3">
                                                        <label for="" class="form-label">Tanggal Order Start</label>
                                                        <input type="date"
                                                            value="<?php echo isset($_GET['edit']) ? $rowEdit['tanggal_laundry
                                                            '] : '' ?>"
                                                            class="form-control"
                                                            name="tanggal_laundry">
                                                    </div>
                                                    <div class="col-sm-6 mb-3">
                                                        <label for="" class="form-label">Tanggal Order End</label>
                                                        <input type="date"
                                                            value="<?php echo isset($_GET['edit']) ? $rowEdit['tanggal_laundry
                                                            '] : '' ?>"
                                                            class="form-control"
                                                            name="order_end_date">
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Detail Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil dihapus
                                                    </div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-1">
                                                        <label for="">Paket</label>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <select name="id_paket[]" id="" class="form-control">
                                                            <option value="">Pilih Paket</option>
                                                            <?php foreach ($rowPaket as $key => $value) {
                                                            ?>

                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-1">
                                                        <label for="" class="form-label">qty</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input type="number"
                                                            value="<?php echo isset($_GET['edit']) ? $rowEdit['tanggal_laundry
                                                    '] : '' ?>"
                                                            class="form-control"
                                                            name="qty[]"
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-1">
                                                        <label for="">Paket</label>
                                                    </div>
                                                    <div class="col-md-11">
                                                        <select name="id_paket[]" id="" class="form-control">
                                                            <option value="">Pilih Paket</option>
                                                            <?php foreach ($rowPaket as $key => $value) {
                                                            ?>

                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nama_paket'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-1">
                                                        <label for="" class="form-label">qty</label>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input type="number"
                                                            value="<?php echo isset($_GET['edit']) ? $rowEdit['tanggal_laundry
                                                    '] : '' ?>"
                                                            class="form-control"
                                                            name="qty[]"
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">simpan</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php endif ?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                            </div>
                            <div>
                                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                                <a
                                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                                    target="_blank"
                                    class="footer-link me-4">Documentation</a>

                                <a
                                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                                    target="_blank"
                                    class="footer-link me-4">Support</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/assets/vendor/js/bootstrap.js"></script>
    <script src="assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
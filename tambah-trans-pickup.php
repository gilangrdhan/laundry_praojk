<?php
session_start();
include 'koneksi.php';

$queryCustomer  = mysqli_query($koneksi, "SELECT * FROM customer");
$id = isset($_GET['ambil']) ? $_GET['ambil'] : '';
$queryTransDetail    = mysqli_query($koneksi, "SELECT customer.nama_customer, customer.address, customer.phone, trans_order.no_transaksi,trans_order.tanggal_laundry, trans_order.status, trans_order.id_customer, paket.nama_paket, paket.harga, trans_order_detail.*FROM trans_order_detail 
LEFT JOIN paket ON paket.id = trans_order_detail.id_paket 
LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order
LEFT JOIN customer ON trans_order.id_customer = customer.id
WHERE trans_order_detail.id_order='$id'");
$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;
}
// print_r($_POST);
// die;


$queryPaket = mysqli_query($koneksi, "SELECT * FROM paket");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}

$queryTransPickup = mysqli_query($koneksi, "SELECT * FROM trans_laundry_pickup where id_order = '$id'");

// jika button simpan ditekan atau di klik
if (isset($_POST['simpan_transaksi'])) {
    //mengambil dari form input dengan attribut name=""
    $id_customer         = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_date         = date("Y-m-d");
    $order_pay = $_POST['order_pay'];
    $order_change = $_POST['order_change'];



    //insert ke table trans_pickup_laundry
    $insertTransPickup = mysqli_query($koneksi, "INSERT INTO trans_laundry_pickup (id_customer, id_order, pickup_date) VALUES ('$id_customer','$pickup_date', '$id_order')");

    //ubah status order menjadi  1 ATAU SUDAH DIAMBIL    
    $updateTransOrder = mysqli_query($koneksi, "UPDATE trans_order SET status =1, order_pay = '$order_pay', order_change = '$order_change' WHERE id ='$id_order'");



    // if ($insertTransPickup) {
    header("location:trans_order.php?tambah=berhasil");
    // }
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
                    <?php if (isset($_GET['ambil'])): ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h5>Pengambilan Laundry <?php echo $row[0]['nama_customer'] ?></h5>
                                            </div>
                                            <div class="col-sm-6" align="right">
                                                <a href="trans_order.php" class="btn btn-secondary">Kembali</a>
                                                <a href="print.php?id=<?php echo $row[0]['id_order'] ?>" class="btn btn-success">Print</a>
                                                <a href="tambah-trans-pickup.php?ambil=<?php echo $row[0]['id_order'] ?>" class="btn btn-warning">Ambil Cucian</a>

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
                                        <?php include 'helper.php' ?>
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
                                                    <td><?php echo changeStatus($row[0]['status']) ?></td>
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
                                            <form action="" method="post">
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
                                                        $total = 0;
                                                        foreach ($row as $key => $value): ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $value['nama_paket'] ?></td>
                                                                <td><?php echo $value['qty'] ?></td>
                                                                <td><?php echo $value['harga'] ?></td>
                                                                <td><?php echo $value['subtotal'] ?></td>
                                                            </tr>
                                                            <?php $total  += $value['subtotal'] ?>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <strong>Total Keseluruhan</strong>
                                                            </td>
                                                            <td>
                                                                <strong><?php echo  "Rp" . number_format($total) ?></strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align=right>
                                                                <strong>Dibayar</strong>
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    <?php if (mysqli_num_rows($queryTransPickup)): ?>
                                                                        <?php $rowTransPickup = mysqli_fetch_assoc($queryTransPickup); ?>
                                                                        <input type='number' name="order_pay" placeholder="Dibayar" class="form-control" value="<?php echo number_format($rowTransPickup)['order_pay'] ?>" readonly>
                                                                    <?php else: ?>
                                                                        <input type='number' name="order_pay" placeholder="Dibayar" class="form-control" value="<?php echo isset($_POST['order_pay']) ? $_POST['order_pay'] : '' ?>">
                                                                    <?php endif ?>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align=right>
                                                                <strong>Kembalian</strong>
                                                            </td>
                                                            <?php if (isset($_POST['proses_kembalian'])) {
                                                                $total = $_POST['total'];
                                                                $dibayar = $_POST['order_pay'];

                                                                $kembalian = 0;
                                                                $kembalian = (int)$dibayar - (int)$total;
                                                            }
                                                            ?>
                                                            <td>
                                                                <strong>

                                                                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                                                                    <input type="hidden" name="id_customer" value="<?php echo $row[0]['id_customer']; ?>">
                                                                    <input type="hidden" name="id_order" value="<?php echo $row[0]['id_order']; ?>">

                                                                </strong>
                                                                <?php if (mysqli_num_rows($queryTransPickup) > 0): ?>
                                                                    <input type="text" name="" placeholder="Kembalian" class="form-control" readonly value="<?php echo $rowTransPickup['order_change']; ?>">
                                                                <?php else: ?>
                                                                    <input type="text" name="order_change" placeholder="Kembalian" class="form-control" readonly value="<?php echo isset($kembalian) ? $kembalian : 0; ?>">
                                                                <?php endif; ?>


                                                            </td>
                                                        </tr>
                                                        <?php if ($row[0]['status'] == 0): ?>
                                                            <tr>
                                                                <td colspan="5">
                                                                    <button class="btn btn-primary" name="proses_kembalian">Proses Kembalian</button>
                                                                    <button class="btn btn-success" name="simpan_transaksi">Simpan Transaksi</button>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </form>
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
                                                    <div class="col-sm mb-3">
                                                        <label for="">Nama Pelanggan</label>
                                                        <select name="id_customer" id="" class="form-control">
                                                            <option value="">Pilih Customer</option>
                                                            <?php while ($row = mysqli_fetch_assoc($queryCustomer)): ?>

                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nama_customer'] ?></option>
                                                            <?php endwhile ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">No Invoice</label>
                                                            <input type="text"
                                                                value="<?php echo $code; ?>"
                                                                class="form-control"
                                                                name="no_transaksi" readonly value='#'>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Tanggal Laundry</label>
                                                            <input type="date"
                                                                value="<?php echo isset($_GET['edit']) ? $rowEdit['tanggal_laundry
                                                            '] : '' ?>"
                                                                class="form-control"
                                                                name="tanggal_laundry"
                                                                value="">
                                                        </div>
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
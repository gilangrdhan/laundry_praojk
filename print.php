<?php

include "koneksi.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';

//mengambil data detail_penjualan dan penjualan



$queryDetail = mysqli_query($koneksi, "SELECT trans_order.id, paket.nama_paket, paket.harga, trans_order.order_pay, trans_order.order_change,trans_order_detail.* FROM trans_order_detail LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order LEFT JOIN paket ON paket.id = trans_order_detail.id_paket WHERE trans_order_detail.id_order='$id'");

$row = [];
while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
    $row[] = $rowDetail;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Doto:wght@100..900&display=swap');

        body {
            margin: 20px;
            font-family: "Doto", sans-serif;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header,
        .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 30px;
            font-weight: 800;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body table th {
            border-bottom: 1px solid #000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-evenly;
            padding: 5px 0;
            font-weight: 750;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1,
            .struk-footer {
                font-size: 14px;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>

    <title>Cetak Transaksi: </title>
</head>

<body>


    <div class="struk">
        <div class="struk-header">
            <h1>Laundry Kilat</h1>
            <p>Jl. Karet Tengsin</p>
            <p>Melayani 24 jam</p>
        </div>

        <div class="struk-body">
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>

                </thead>
                <?php
                $total = 0;
                foreach ($row as $rowDetail):
                    $total += $rowDetail['subtotal'];
                ?>
                    <tr>
                        <td><?php echo $rowDetail['nama_paket']; ?></td>
                        <td><?php echo $rowDetail['qty']; ?></td>
                        <td><?php echo "Rp " . number_format($rowDetail['harga']); ?></td>
                        <td><?php echo "Rp " . number_format($rowDetail['subtotal']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total">
                <span>Total: </span>
                <span><?php echo "Rp " . number_format($total); ?></span>
            </div>

            <div class="payment">
                <span>Bayar: </span>
                <span><?php echo "Rp " . number_format($row[0]['order_pay']); ?></span>
            </div>

            <div class="change">
                <span>Kembalian: </span>
                <span><?php echo "Rp " . number_format($row[0]['order_change']); ?></span>
            </div>
        </div>

        <div class="struk-footer">
            <p>Thx for coming!</p>
            <p>Have a great day!</p>
            <p>♥</p>
        </div>

    </div>


    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>
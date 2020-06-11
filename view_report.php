<?php
include_once("init.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pure Nature Shop - Rekap</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/date_pic/date_input.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/date_pic/jquery.date_input.js"></script>
    <script src="js/script.js"></script>
    <script src="js/view_report.js"></script>
</head>
<body>
<?php include_once("tpl/top_bar.php"); ?>
<div id="header-with-tabs">
    <div class="page-full-width cf">
        <ul id="tabs" class="fl">
          <li><a href="dashboard.php" class="active-tab dashboard-tab">Dashboard</a></li>
          <li><a href="view_sales.php" class="sales-tab">Penjualan</a></li>
          <li><a href="view_customers.php" class=" customers-tab">Pelangggan</a></li>
          <li><a href="view_purchase.php" class="purchase-tab">Pembelian</a></li>
          <li><a href="view_supplier.php" class=" supplier-tab">Pemasok</a></li>
          <li><a href="view_product.php" class=" stock-tab">Produk</a></li>
          <li><a href="view_payments.php" class="payment-tab">Pembayaran</a></li>
            <li><a href="view_report.php" class="active-tab report-tab">Rekap Laporan</a></li>
        </ul>
        <a href="dashboard.php" id="company-branding-small" class="fr"><img src="images/s.png" alt=""></a>
      </div>
</div>
<div id="content">
    <div class="page-full-width cf">
        <div class="side-menu fr">
            <h3>Rekap Data</h3>
            <ul>
                <ul>
                    <li><a></a></li>
                </ul>
            </ul>
        </div>
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fr">Rekap Data</h3>
                </div>
                <div class="content-module-main cf">
                    <form action="">
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <form action="sales_report.php" method="post" name="form1" id="form1" name="sales_report"
                                  id="sales_report" target="myNewWinsr">
                                <tr>
                                    <td><strong>Rekap Penjualan</strong></td>
                                    <td>From</td>
                                    <td><input name="from_sales_date" type="text" id="from_sales_date"
                                               style="width:80px;"></td>
                                    <td>To</td>
                                    <td><input name="to_sales_date" type="text" id="to_sales_date" style="width:80px;">
                                    </td>
                                    <td><div style="padding-left: 15px;"><input class="button round blue image" name="submit" type="button" value="Lihat" onClick='sales_report_fn();'>
                                        </div></td>
                                </tr>
                            </form>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <form action="purchase_report.php" method="post" name="purchase_report" target="_blank">
                                <tr>
                                    <td><strong>Rekap Pembelian </strong></td>
                                    <td>From</td>
                                    <td><input name="from_purchase_date" type="text" id="from_purchase_date"
                                               style="width:80px;"></td>
                                    <td>To</td>
                                    <td><input name="to_purchase_date" type="text" id="to_purchase_date"
                                               style="width:80px;"></td>
                                    <td><div style="padding-left: 15px;"><input class="button round blue image" name="submit" type="button" value="Lihat" onClick='purchase_report_fn();'>
                                        </div></td>
                                </tr>
                            </form>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <form action="sales_purchase_report.php" method="post" name="sales_purchase_report"
                                  target="_blank">
                                <tr>
                                    <td><strong>Stok Pembelian </strong></td>
                                    <td>From</td>
                                    <td><input name="from_sales_purchase_date" type="text" id="from_sales_purchase_date"
                                               style="width:80px;"></td>
                                    <td>To</td>
                                    <td><input name="to_sales_purchase_date" type="text" id="to_sales_purchase_date"
                                               style="width:80px;"></td>
                                    <td><div style="padding-left: 15px;"><input  class="button round blue image" name="submit" type="button" value="Lihat"
                                                onClick='sales_purchase_report_fn();'></div></td>
                                </tr>
                            </form>
                        </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<?php include_once("tpl/footer.php"); ?>
</body>
</html>

<?php
include_once("init.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pure Nature Shop - Tambah Data Pemasok</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/date_pic/date_input.css">
    <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/date_pic/jquery.date_input.js"></script>
    <script src="lib/auto/js/jquery.autocomplete.js "></script>
    <script src="js/add_supplier.js"></script>
</head>
<body>
<?php include_once("tpl/top_bar.php"); ?>
<div id="header-with-tabs">
    <div class="page-full-width cf">
        <ul id="tabs" class="fl">
          <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
          <li><a href="view_sales.php" class="sales-tab">Penjualan</a></li>
          <li><a href="view_customers.php" class=" customers-tab">Pelangggan</a></li>
          <li><a href="view_purchase.php" class="purchase-tab">Pembelian</a></li>
          <li><a href="view_supplier.php" class="active-tab  supplier-tab">Pemasok</a></li>
          <li><a href="view_product.php" class=" stock-tab">Produk</a></li>
          <li><a href="view_payments.php" class="payment-tab">Pembayaran</a></li>
            <li><a href="view_report.php" class="report-tab">Rekap Laporan</a></li>
        </ul>
  <a href="dashboard.php" id="company-branding-small" class="fr"><img src="images/s.png" alt=""></a>
</div>
</div>
<div id="content">
    <div class="page-full-width cf">
        <div class="side-menu fr">
            <h3>Kelola Data Pemasok</h3>
            <ul>
                <li><a href="add_supplier.php">Tambah Pemasok</a></li>
                <li><a href="view_supplier.php">Lihat Pemasok</a></li>
            </ul>
        </div>
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fl">Tambah Data Pemasok</h3>
                </div>
                <div class="content-module-main cf">
                    <?php
                    if (isset($_POST['name'])) {
                        $_POST = $gump->sanitize($_POST);
                        $gump->validation_rules(array(
                            'name' => 'required|max_len,100|min_len,3',
                            'address' => 'max_len,200',
                            'contact1' => 'alpha_numeric|max_len,20',
                            'contact2' => 'alpha_numeric|max_len,20'
                        ));
                        $gump->filter_rules(array(
                            'name' => 'trim|sanitize_string|mysqli_escape',
                            'address' => 'trim|sanitize_string|mysqli_escape',
                            'contact1' => 'trim|sanitize_string|mysqli_escape',
                            'contact2' => 'trim|sanitize_string|mysqli_escape'
                        ));
                        $validated_data = $gump->run($_POST);
                        $name = "";
                        $address = "";
                        $contact1 = "";
                        $contact2 = "";
                        if ($validated_data === false) {
                            echo $gump->get_readable_errors(true);
                        } else {
                            $name = mysqli_real_escape_string($db->connection, $_POST['name']);
                            $address = mysqli_real_escape_string($db->connection, $_POST['address']);
                            $contact1 = mysqli_real_escape_string($db->connection, $_POST['contact1']);
                            $contact2 = mysqli_real_escape_string($db->connection, $_POST['contact2']);
                            $count = $db->countOf("supplier_details", "supplier_name='$name'");
                            if ($count == 1) {
                                echo "<font color=red> Dublicat Entry. Please Verify</font>";
                            } else {

                                if ($db->query("insert into supplier_details values(NULL,'$name','$address','$contact1','$contact2',0)"))
                                    echo "<br><font color=green size=+1 > [ $name ] Supplier Details Added !</font>";
                                else
                                    echo "<br><font color=red size=+1 >Problem in Adding !</font>";
                            }
                        }
                    }
                    ?>
                    <form name="form1" method="post" id="form1" action="">
                        <p><strong>Tambah Rincian Pemasok</strong></p>
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><span class="man">*</span>Nama:</td>
                                <td><input name="name" placeholder="Masukan Nama Pemasok" type="text" id="name"
                                           maxlength="200" class="round default-width-input"onKeyPress="return ValidateAlpha(event)"                                           value="<?php echo isset($name) ? $name : ''; ?>"/></td>
                                <td><span class="man">*</span><b>Kontak</b><b>-1</b></td>
                                <td><input name="contact1" placeholder="Masukan Kontak1" type="text"
                                           id="buyingrate" maxlength="20" class="round default-width-input"onkeypress="return numbersonly(event)"
                                           value="<?php echo isset($contact1) ? $contact1 : ''; ?>"/></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><textarea name="address" placeholder="Masukan Alamat" cols="8"
                                              class="round full-width-textarea"><?php echo isset($address) ? $address : ''; ?></textarea>
                                </td>
                                <td><b>Kontak</b><b>-2</b></td>
                                <td><input name="contact2" placeholder="Masukan Kontak2" type="text"
                                           id="sellingrate" maxlength="20" class="round default-width-input"onkeypress="return numbersonly(event)"
                                           value="<?php echo isset($contact2) ? $contact2 : ''; ?>"/></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper" type="submit"
                                           name="Submit" value="Simpan">
                                <td align="right"><input class="button round red   text-upper" type="reset" name="Reset"
                                                         value="Batal"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("tpl/footer.php"); ?>
</body>
</html>

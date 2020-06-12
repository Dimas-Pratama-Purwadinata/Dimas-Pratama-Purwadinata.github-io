<?php
include_once("init.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pure Nature Shop - Tambah Data Produk</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/date_pic/date_input.css">
    <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/date_pic/jquery.date_input.js"></script>
    <script src="lib/auto/js/jquery.autocomplete.js "></script>
    <script src="js/add_stock.js"></script>
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
          <li><a href="view_supplier.php" class=" supplier-tab">Pemasok</a></li>
          <li><a href="view_product.php" class="active-tab  stock-tab">Produk</a></li>
          <li><a href="view_payments.php" class="payment-tab">Pembayaran</a></li>
            <li><a href="view_report.php" class="report-tab">Rekap Laporan</a></li>
        </ul>
  <a href="dashboard.php" id="company-branding-small" class="fr"><img src="images/s.png" alt=""></a>
</div>
</div>
<div id="content">
    <div class="page-full-width cf">
        <div class="side-menu fr">
            <h3>Kelola Data Produk</h3>
            <ul>
              <li><a href="add_stock.php">Tambah Bibit Tanaman</a></li>
              <li><a href="view_product.php">Lihat Bibit Tanaman</a></li>
              <li><a href="add_category.php">Tambah Jenis Bibit Tanaman</a></li>
              <li><a href="view_category.php">Lihat Jenis Bibit Tanaman</a></li>
              <li><a href="view_stock_availability.php">Lihat Stok</a></li>
            </ul>
        </div>
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fl">Tambah Bibit Tanaman </h3>
                </div>
                <div class="content-module-main cf">
                    <?php
                    if (isset($_POST['name'])) {
                        $_POST = $gump->sanitize($_POST);
                        $gump->validation_rules(array(
                            'name' => 'required|max_len,100|min_len,3',
                            'stockid' => 'required|max_len,200',
                            'sell' => 'required|max_len,200',
                            'cost' => 'required|max_len,200',
                            'supplier' => 'max_len,200',
                            'category' => 'max_len,200'
                        ));
                        $gump->filter_rules(array(
                            'name' => 'trim|sanitize_string|mysqli_escape',
                            'stockid' => 'trim|sanitize_string|mysqli_escape',
                            'sell' => 'trim|sanitize_string|mysqli_escape',
                            'cost' => 'trim|sanitize_string|mysqli_escape',
                            'category' => 'trim|sanitize_string|mysqli_escape',
                            'supplier' => 'trim|sanitize_string|mysqli_escape'
                        ));
                        $validated_data = $gump->run($_POST);
                        $name = "";
                        $stockid = "";
                        $sell = "";
                        $cost = "";
                        $supplier = "";
                        $category = "";
                        if ($validated_data === false) {
                            echo $gump->get_readable_errors(true);
                        } else {
                            $name = mysqli_real_escape_string($db->connection, $_POST['name']);
                            $stockid = mysqli_real_escape_string($db->connection, $_POST['stockid']);
                            $sell = mysqli_real_escape_string($db->connection, $_POST['sell']);
                            $cost = mysqli_real_escape_string($db->connection, $_POST['cost']);
                            $supplier = mysqli_real_escape_string($db->connection, $_POST['supplier']);
                            $category = mysqli_real_escape_string($db->connection, $_POST['category']);
                            $count = $db->countOf("stock_details", "stock_id ='$stockid'");
                            if ($count == 1) {
                                echo "<font color=red> Dublicat Entry. Please Verify</font>";
                            } else {
                                if ($db->query("insert into stock_details(stock_id,stock_name,stock_quatity,supplier_id,company_price,selling_price,category) values('$stockid','$name',0,'$supplier','$cost','$sell','$category')")) {
                                    echo "<br><font color=green size=+1 > [ $name ] Stock Details Added !</font>";
                                    $db->query("insert into stock_avail(name,quantity) values('$name',0)");
                                } else
                                    echo "<br><font color=red size=+1 >Problem in Adding !</font>";
                            }
                        }
                    }
                    ?>
                    <form name="form1" method="post" id="form1" action="">
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <?php
                                $max = $db->maxOfAll("id", "stock_details");
                                $max = $max + 1;
                                $autoid = "ST" . $max . "";
                                ?>
                                <td><span class="man">*</span>IDBibit:</td>
                                <td><input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"
                                           class="round default-width-input"
                                           value="<?php echo isset($autoid) ? $autoid : ''; ?>"/></td>
                                <td><span class="man">*</span>Nama Bibit Tanaman:</td>
                                <td><input name="name" placeholder="Masukan nama bibit" type="text" id="name"
                                           maxlength="200" class="round default-width-input"
                                           value="<?php echo isset($name) ? $name : ''; ?>"/></td>
                            </tr>
                            <tr>
                                <td><span class="man">*</span>Harga beli:</td>
                                <td><input name="cost" placeholder="Masukan harga beli" type="text" id="cost"
                                           maxlength="200" class="round default-width-input"
                                           onkeypress="return numbersonly(event)"
                                           value="<?php echo isset($cost) ? $cost : ''; ?>"/></td>

                                <td><span class="man">*</span>Harga Jual&nbsp;</td>
                                <td><input name="sell" placeholder="Masukan harga jual" type="text" id="sell"
                                           maxlength="200" class="round default-width-input"
                                           onkeypress="return numbersonly(event)"
                                           value="<?php echo isset($sell) ? $sell : ''; ?>"/></td>
                            </tr>
                            <tr>
                                <td>Pemasok:</td>
                                <td><input name="supplier" placeholder="Masukan Nama Pemasok" type="text" id="supplier"
                                           maxlength="200" class="round default-width-input"
                                           value="<?php echo isset($supplier) ? $supplier : ''; ?>"/></td>
                                <td>Jenis:</td> <td><input name="category" placeholder="Masukan Jenis Bibit" type="text" id="category"
                                           maxlength="200" class="round default-width-input"
                                           value="<?php echo isset($category) ? $category : ''; ?>"/></td>
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
<?php include_once("tpl/footer.php"); ?>
</body>
</html>

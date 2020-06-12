<?php
include_once("init.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pure Nature Shop - Tambah Data Penjualan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="js/date_pic/date_input.css">
    <link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/date_pic/jquery.date_input.js"></script>
    <script src="lib/auto/js/jquery.autocomplete.js "></script>
    <script src="js/add_sales.js"></script>
</head>
<body>
<?php include_once("tpl/top_bar.php"); ?>
<div id="header-with-tabs">
    <div class="page-full-width cf">
    <a href="dashboard.php" id="company-branding-small" class="fr"><img src="images/s.png" alt=""></a>
      <ul id="tabs" class="fl">
          <li><a href="dashboard.php" class="dashboard-tab">Dashboard</a></li>
          <li><a href="view_sales.php" class="active-tab sales-tab">Penjualan</a></li>
          <li><a href="view_customers.php" class=" customers-tab">Pelangggan</a></li>
          <li><a href="view_purchase.php" class="purchase-tab">Pembelian</a></li>
          <li><a href="view_supplier.php" class=" supplier-tab">Pemasok</a></li>
          <li><a href="view_product.php" class=" stock-tab">Produk</a></li>
          <li><a href="view_payments.php" class="payment-tab">Pembayaran</a></li>
          <li><a href="view_report.php" class="report-tab">Rekap Laporan</a></li>
      </ul>
    </div>
</div>
<div id="content">
    <div class="page-full-width cf">
        <div class="side-menu fr">
            <h3>Kelola Data Penjualan</h3>
            <ul>
                <li><a href="add_sales.php">Tambah Penjualan</a></li>
                <li><a href="view_sales.php">Lihat Penjualan</a></li>
            </ul>
        </div>
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fl">Tambah Penjualan</h3>
                </div>
                <div class="content-module-main cf">
                    <?php
                    if (isset($_GET['msg'])) {
                        echo $_GET['msg'];
                    }
                    if (isset($_POST['total'])) {
                        $validated_data = $gump->run($_POST);
                        $stock_name = "";
                        $stockid = "";
                        $payment = "";
                        $bill_no = "";
                        if ($validated_data === false) {
                            echo $gump->get_readable_errors(true);
                        } else {
                            $username = $_SESSION['username'];
                            $stockid = mysqli_real_escape_string($db->connection, $_POST['stockid']);
                            //$bill_no = mysqli_real_escape_string($db->connection, $_POST['bill_no']);
                            $customer = mysqli_real_escape_string($db->connection, $_POST['supplier']);
                            $address = mysqli_real_escape_string($db->connection, $_POST['address']);
                            $contact = mysqli_real_escape_string($db->connection, $_POST['contact']);
                            $count = $db->countOf("customer_details", "customer_name='$customer'");
                            if ($count == 0) {
                                $db->query("insert into customer_details(customer_name,customer_address,customer_contact1) values('$customer','$address','$contact')");
                            }
                            $stock_name = $_POST['stock_name'];
                            $quty = $_POST['quty'];
                            $date = mysqli_real_escape_string($db->connection, $_POST['date']);
                            $sell = $_POST['sell'];
                            $total = $_POST['total'];
                            $payable = $_POST['subtotal'];
                            $description = mysqli_real_escape_string($db->connection, $_POST['description']);
                            $discount = mysqli_real_escape_string($db->connection, $_POST['discount']);
                            if ($discount == "") {
                                $discount = 00;
                            }
                            $dis_amount = mysqli_real_escape_string($db->connection, $_POST['dis_amount']);
                            if ($dis_amount == "") {
                                $dis_amount = 00;
                            }
                            $subtotal = mysqli_real_escape_string($db->connection, $_POST['payable']);
                            $mode = mysqli_real_escape_string($db->connection, $_POST['mode']);
                            $tax = mysqli_real_escape_string($db->connection, $_POST['tax']);
                            if ($tax == "") {
                                $tax = 00;
                            }
                            $tax_dis = mysqli_real_escape_string($db->connection, $_POST['tax_dis']);
                            $temp_balance = $db->queryUniqueValue("SELECT balance FROM customer_details WHERE customer_name='$customer'");
                            $db->execute("UPDATE customer_details SET balance=$temp_balance WHERE customer_name='$customer'");
                            $str = $db->maxOfAll("transactionid", "stock_sales");
                            $array = explode(' ', $str);
                            $autoid = ++$array[0];
                            if($str == ''){
                            $autoid_new = "SL".$autoid;
                            }
                            for ($i = 0; $i < count($stock_name); $i++) {
                                $name1 = $stock_name[$i];
                                $quantity = $_POST['quty'][$i];
                                $rate = $_POST['sell'][$i];
                                $total = $_POST['total'][$i];
                                $selected_date = $_POST['date'];
                                $selected_date = strtotime($selected_date);
                                $mysqldate = date('Y-m-d H:i:s', $selected_date);
                                $username = $_SESSION['username'];
                                $count = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                                if ($count >= 1) {
                                    if($str == ''){
                                    $db->query("insert into stock_sales (tax,tax_dis,discount,dis_amount,grand_total,transactionid,stock_name,selling_price,quantity,amount,date,username,customer_id,subtotal,payment,mode,description,count1,billnumber)
                            values('$tax','$tax_dis','$discount','$dis_amount','$payable','$autoid_new','$name1','$rate','$quantity','$total','$mysqldate','$username','$customer','$subtotal','$payment','$mode','$description',$i+1,'$bill_no')");
                                    }
                                     if($str != ''){
                                    $db->query("insert into stock_sales (tax,tax_dis,discount,dis_amount,grand_total,transactionid,stock_name,selling_price,quantity,amount,date,username,customer_id,subtotal,payment,mode,description,count1,billnumber)
                            values('$tax','$tax_dis','$discount','$dis_amount','$payable','$autoid','$name1','$rate','$quantity','$total','$mysqldate','$username','$customer','$subtotal','$payment','$mode','$description',$i+1,'$bill_no')");
                                     }
                                    $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                                    $amount1 = $amount - $quantity;
                                    $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                                    $amount1 = $amount - $quantity;
                                    $db->execute("UPDATE stock_avail SET quantity='$amount1' WHERE name='$name1'");
                                } else {
                                    echo "<br><font color=green size=+1 >There is no enough stock deliver for $name1! Please add stock !</font>";
                                }
                            }
                            $msg = "<br><font color=green size=6px >Sales Added successfully Ref: [" . $_POST['stockid'] . "] !</font>";
                            echo $msg;
                            if($str == ''){
                            echo "<script>window.open('add_sales_print.php?sid=$autoid_new','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
                            }
                            if($str != ''){
                            echo "<script>window.open('add_sales_print.php?sid=$autoid','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
                            }
                            }
                        }
                    ?>
                    <form name="form1" method="post" id="form1" action="">
                        <input type="hidden" id="posnic_total">
                        <p><strong>Tambah Penjualan</strong></p>
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <?php
                                $str = $db->maxOfAll("transactionid", "stock_sales");
                                $array = explode(' ', $str);
                                $autoid = ++$array[0];
                                if($str == ''){
                                $autoid_new = "SL".$autoid;
                                }
                                  ?>
                                <?php if($str == ''){?>
                                <td>IDPenjualan:</td>
                                <td><input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"
                                           class="round default-width-input" style="width:130px "
                                           value="<?php echo $autoid_new ?>"/></td>
                                <?php }?>
                                <?php if($str != ''){?>
                                <td>IDPenjualan:</td>
                                <td><input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"
                                           class="round default-width-input" style="width:130px "
                                           value="<?php echo $autoid ?>"/></td>
                                <?php }?>
                                <td>Tanggal:</td>
                                <td><input name="date" id="test1" placeholder="" value="<?php date_default_timezone_set("Asia/Kolkata");echo date('Y-m-d H:i:s');?>"
                                style="margin-left: 15px;"type="text" id="name" maxlength="200" class="round default-width-input"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Pelanggan: </td>
                                <td><input name="supplier" placeholder="ENTER CUSTOMER" type="text" id="supplier"
                                           value="pembeli" maxlength="200" class="round default-width-input" style="width:130px "/></td>
                                <td>Alamat: </td>
                                <td><input name="address" placeholder="Masukan Alamat" type="text" id="address"
                                           value=""maxlength="200" class="round default-width-input"/></td>
                                <td>kontak: </td>
                                <td><input name="contact" placeholder="Masukan kontak" type="text" id="contact1"
                                           value=""maxlength="200" class="round default-width-input"
                                           onkeypress="return numbersonly(event)" style="width:120px "/></td>
                            </tr>
                        </table>
                        <input type="hidden" id="guid">
                        <input type="hidden" id="edit_guid">
                        <table class="form">
                            <tr>
                                <td>Produk</td>
                                <td>Kuantitas</td>
                                <td>Harga</td>
                                <td>Stok</td>
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
                                <td> &nbsp;</td>
                            </tr>
                            <tr>
                                <td><input name="" type="text" id="item" maxlength="200"
                                           class="round default-width-input " style="width: 150px"/></td>
                                <td><input name="" type="text" id="quty" maxlength="200"
                                           class="round default-width-input my_with"
                                           onKeyPress="quantity_chnage(event);return numbersonly(event)"
                                           onkeyup="total_amount();unique_check();stock_size();"/></td>
                                <td><input name="" type="text" id="sell" readonly="readonly" maxlength="200"
                                           class="round default-width-input my_with"/></td>
                                <td><input name="" type="text" id="stock" readonly="readonly" maxlength="200"
                                           class="round  my_with"/></td>
                                <td><input name="" type="text" id="total" maxlength="200"
                                           class="round default-width-input " style="width:120px;  margin-left: 20px"/>
                                           <input type="hidden" id="payable_amount" readonly="readonly" name="payable">
                                </td>
                            </tr>
                        </table>
                        <table class="form" style="width: inherit;">
                            <tr>
                                <td>Metode Pembayaran &nbsp;</td>
                                <td>
                                    <select name="mode">
                                        <option value="cash">Kontan</option>
                                        <option value="cheque">Tranfer</option>
                                    </select>
                                </td>
                                <td> &nbsp;</td>
                                <td> &nbsp;</td>
                                <td>Keterangan</td>
                                <td><textarea name="description"></textarea></td>
                            </tr>
                        </table>
                        <table class="form" style="width: inherit; transform: translate(157px, 10px);">
                            <tr>
                                <td>
                                    <input class="button round blue image-right ic-add text-upper" type="submit"
                                           name="Submit" value="Simpan">
                                </td>
                                <td> &nbsp;</td>
                                <td> <input class="button round red   text-upper" type="reset" id="Reset" name="Reset"
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

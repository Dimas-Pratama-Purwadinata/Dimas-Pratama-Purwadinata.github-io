<?php
include_once("init.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pure Nature Shop - Update Category</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script src="js/update_category.js"></script>
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
                <li><a href="view_product.php" class="active-tab stock-tab">Produk</a></li>
                <li><a href="view_payments.php" class="payment-tab">Pembayaran</a></li>
                <li><a href="view_report.php" class="report-tab">Rekap Laporan</a></li>
        </ul>
        <a href="#" id="company-branding-small" class="fr"><img src="<?php if (isset($_SESSION['logo'])) {
                echo "upload/" . $_SESSION['logo'];
            } else {
                echo "upload/posnic.png";
            } ?>" alt="Point of Sale"/></a>
    </div>
</div>
<div id="content">
    <div class="page-full-width cf">
        <div class="side-menu fr">
            <h3>Stock Category Management</h3>
            <ul>
                <li><a href="add_stock.php">Add Stock/Product</a></li>
                <li><a href="view_product.php">View Stock/Product</a></li>
                <li><a href="add_category.php">Add Stock Category</a></li>
                <li><a href="view_category.php">view Stock Category</a></li>
            </ul>
        </div>
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fl">Update Supplier</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>
                </div>
                <div class="content-module-main cf">
                    <form name="form1" method="post" id="form1" action="">
                        <p><strong>Add Stock </strong> - Add New ( Control + 3)</p>
                        <table class="form" border="0" cellspacing="0" cellpadding="0">
                            <?php
                            if (isset($_POST['id'])) {
                                $id = mysqli_real_escape_string($db->connection, $_POST['id']);
                                $name = trim(mysqli_real_escape_string($db->connection, $_POST['name']));
                                $address = trim(mysqli_real_escape_string($db->connection, $_POST['address']));
                                if ($db->query("UPDATE category_details  SET category_name='$name',category_description='$address' where id='$id'"))
                                    echo "<br><font color=green size=+1 > [ $name ] Supplier Details Updated!</font>";
                                else
                                    echo "<br><font color=red size=+1 >Problem in Updation !</font>";
                            }
                            ?>
                            <?php
                            if (isset($_GET['sid']))
                                $id = $_GET['sid'];
                            $line = $db->queryUniqueObject("SELECT * FROM category_details WHERE id=$id");
                            ?>
                            <form name="form1" method="post" id="form1" action="">
                                <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">
                                <tr>
                                    <td>Name</td>
                                    <td><input name="name" type="text" id="name" maxlength="200" class="round default-width-input" value="<?php echo $line->category_name; ?> "/></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><textarea name="address" cols="15" class="round full-width-textarea"><?php echo $line->category_description; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        <input class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Save">
                                        (Control + S)
                                    </td>
                                    <td align="right"><input class="button round red   text-upper" type="reset" name="Reset" value="Reset"></td>
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

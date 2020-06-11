<?php
include_once("init.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Pure Nature Shop - Stock Bibit Tanaman</title>
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php include_once("tpl/common_js.php"); ?>
        <script src="js/script.js"></script>
        <script src="js/view_stock_availability.js"></script>
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
                <a href="#" id="company-branding-small" class="fr"><img src="<?php
                    if (isset($_SESSION['logo'])) {
                        echo "upload/" . $_SESSION['logo'];
                    } else {
                        echo "upload/posnic.png";
                    }
                    ?>" alt="Point of Sale"/></a>
            </div>
        </div>
        <div id="content">
            <div class="page-full-width cf">
                <div class="side-menu fr">
                    <h3>Stock Management</h3>
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
                            <h3 class="fl">Stock/Product</h3>
                            <span class="fr expand-collapse-text">Click to collapse</span>
                            <span class="fr expand-collapse-text initial-expand">Click to expand</span>
                        </div>
                        <div class="content-module-main cf">
                            <table>
                                <form action="" method="post" name="search">
                                    <input name="searchtxt" type="text" class="round my_text_box" placeholder="Search"
                                           style="margin-left: 200px">
                                    &nbsp;&nbsp;<input name="Search" type="submit" class="my_button round blue   text-upper"
                                                       value="Search">
                                </form>
                                <form action="" method="get" name="limit_go">
                                    Page per Record<input name="limit" type="text" class="round my_text_box" id="search_limit" style="margin-left:5px;" value="
                                        <?php
                                            if (isset($_GET['limit']))
                                                echo $_GET['limit'];
                                            else
                                                echo "10";
                                        ?>" size="3" maxlength="3">
                                    <input name="go" type="button" value="Go" class=" round blue my_button  text-upper" onclick="return confirmLimitSubmit()">
                                </form>
                                <form name="deletefiles" action="delete.php" method="post">
                                    <table>
                                        <?php
                                        $SQL = "SELECT * FROM  stock_avail ORDER BY id DESC";
                                        if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {
                                            $SQL = "SELECT * FROM  stock_avail WHERE name LIKE '%" . $_POST['searchtxt'] . "%' ORDER BY id DESC";
                                        }
                                        $tbl_name = "stock_avail";
                                        $adjacents = 3;
                                        $query = "SELECT COUNT(*) as num FROM $tbl_name";
                                        if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {

                                            $query = "SELECT COUNT(*) as num FROM  stock_avail WHERE name LIKE '%" . $_POST['searchtxt'] . "%' ";
                                        }
                                        $total_pages = mysqli_fetch_array(mysqli_query($db->connection, $query));
                                        $total_pages = $total_pages['num'];
                                        $targetpage = "view_product.php";
                                        $limit = 10;                              
                                        if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
                                            $limit = $_GET['limit'];
                                            $_GET['limit'] = 10;
                                        }
                                        $page = isset($_GET['page']) ? $_GET['page'] : 0;
                                        if ($page)
                                            $start = ($page - 1) * $limit;  
                                        else
                                            $start = 0;                    
                                        $sql = "SELECT * FROM stock_avail ORDER BY id DESC LIMIT $start, $limit  ";
                                        if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {
                                            $sql = "SELECT * FROM  stock_avail WHERE name LIKE '%" . $_POST['searchtxt'] . "%'   ORDER BY id DESC LIMIT $start, $limit";
                                        }
                                        $result = mysqli_query($db->connection, $sql);
                                        if ($page == 0)
                                            $page = 1;  
                                        $prev = $page - 1;                  
                                        $next = $page + 1;                            
                                        $lastpage = ceil($total_pages / $limit);       
                                        $lpm1 = $lastpage - 1;                      
                                        $pagination = "";

                                        if ($lastpage > 1) {
                                            $pagination .= "<div >";
                                            if ($page > 1)
                                                $pagination .= "<a href=\"view_product.php?page=$prev&limit=$limit\" class=my_pagination >Previous</a>";
                                            else
                                                $pagination .= "<span class=my_pagination>Previous</span>";
                                            if ($lastpage < 7 + ($adjacents * 2)) {   
                                                for ($counter = 1; $counter <= $lastpage; $counter++) {
                                                    if ($counter == $page)
                                                        $pagination .= "<span class=my_pagination>$counter</span>";
                                                    else
                                                        $pagination .= "<a href=\"view_product.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                }
                                            } elseif ($lastpage > 5 + ($adjacents * 2)) {  
                                                if ($page < 1 + ($adjacents * 2)) {
                                                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                                        if ($counter == $page)
                                                            $pagination .= "<span class=my_pagination>$counter</span>";
                                                        else
                                                            $pagination .= "<a href=\"view_product.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                    }
                                                    $pagination .= "...";
                                                    $pagination .= "<a href=\"view_product.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";
                                                    $pagination .= "<a href=\"view_product.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";
                                                }
                                                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                                    $pagination .= "<a href=\"view_product.php?page=1&limit=$limit\" class=my_pagination>1</a>";
                                                    $pagination .= "<a href=\"view_product.php?page=2&limit=$limit\" class=my_pagination>2</a>";
                                                    $pagination .= "...";
                                                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                                        if ($counter == $page)
                                                            $pagination .= "<span  class=my_pagination>$counter</span>";
                                                        else
                                                            $pagination .= "<a href=\"view_product.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                    }
                                                    $pagination .= "...";
                                                    $pagination .= "<a href=\"view_product.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";
                                                    $pagination .= "<a href=\"view_product.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";
                                                }
                                                else {
                                                    $pagination .= "<a href=\"$view_product.php?page=1&limit=$limit\" class=my_pagination>1</a>";
                                                    $pagination .= "<a href=\"$view_product.php?page=2&limit=$limit\" class=my_pagination>2</a>";
                                                    $pagination .= "...";
                                                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                                        if ($counter == $page)
                                                            $pagination .= "<span class=my_pagination >$counter</span>";
                                                        else
                                                            $pagination .= "<a href=\"$targetpage?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                    }
                                                }
                                            }
                                            if ($page < $counter - 1)
                                                $pagination .= "<a href=\"view_product.php?page=$next&limit=$limit\" class=my_pagination>Next</a>";
                                            else
                                                $pagination .= "<span class= my_pagination >Next</span>";

                                            $pagination .= "</div>\n";
                                        }
                                        ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <th>No</th>
                                            <th>Stock Name</th>

                                            <th>Stock</th>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <?php
                                        $co = 0;
                                        $co1 = 0;
                                        $s = mysqli_query($db->connection, "select * from stock_avail");
                                        while ($r = mysqli_fetch_array($s)) {
                                            $co++;
                                        }
                                        $i = 1;
                                        $no = $page - 1;
                                        $no = $no * $limit;
                                        while ($row = mysqli_fetch_array($result)) {
                                            $co1++;
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td> <?php echo $no + $i; ?></td>

                                                <td><?php echo $row['name']; ?></td>

                                                <td> <?php
                                                    $quantity = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='" . $row['name'] . "'");
                                                    echo $quantity;
                                                    ?></td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                        <table>
                                            <tr>
                                                <td align='right'style="width:20%"><?php $end = $no + $co1; ?>
                                                    Showing <?php echo $no + 1; ?> to <?php echo $end; ?> of <?php echo $co; ?> entries</td><td >&nbsp;</td><td><?php echo $pagination; ?></td>
                                            </tr>
                                        </table> 
                                    </table>
                                </form>
                        </div>
                    </div>
            <?php include_once("tpl/footer.php"); ?>
            </body>
            </html>

<?php
include_once("init.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Pure Nature Shop - Jenis Produk</title>
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php include_once("tpl/common_js.php"); ?>
        <script src="js/script.js"></script>
        <script src="js/view_category.js"></script>
    </head>
    <body>
        <?php include_once("tpl/top_bar.php"); ?>
        <div id="header-with-tabs">
            <div class="page-full-width cf">
              <ul id="tabs" class="fl">
                  <li><a href="dashboard.php" class=" dashboard-tab">Dashboard</a></li>
                  <li><a href="view_sales.php" class="sales-tab">Penjualan</a></li>
                  <li><a href="view_customers.php" class=" customers-tab">Pelangggan</a></li>
                  <li><a href="view_purchase.php" class="purchase-tab">Pembelian</a></li>
                  <li><a href="view_supplier.php" class=" supplier-tab">Pemasok</a></li>
                  <li><a href="view_product.php" class="active-tab stock-tab">Produk</a></li>
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
                          <h3 class="fl">Jenis Produk</h3>
                        </div>
                        <div class="content-module-main cf">
                            <table>
                                <form action="" method="post" name="search">
                                    <input name="searchtxt" type="text" class="round my_text_box" placeholder="Search">
                                    &nbsp;&nbsp;<input name="Search" type="submit" class="my_button round blue   text-upper"
                                                       value="cari">
                                </form>
                                <form action="" method="get" name="limit_go">
                                    item yang ditampilkan<input name="limit" type="text" class="round my_text_box" id="search_limit"
                                                          style="margin-left:5px;"
                                                          value="<?php if (isset($_GET['limit'])) echo $_GET['limit'];
                                                                        else echo "10"; ?>"
                                                          size="3" maxlength="3">
                                    <input name="go" type="button" value="pergi" class=" round blue my_button  text-upper"
                                           onclick="return confirmLimitSubmit()">
                                </form>
                                <form name="deletefiles" action="delete.php" method="post">
                                    <input type="hidden" name="table" value="category_details">
                                    <input type="hidden" name="return" value="view_category.php">
                                    <input type="button" name="selectall" value="pilih semua"
                                           class="my_button round blue   text-upper" onClick="checkAll()"
                                           style="margin-left:5px;"/>
                                    <input type="button" name="unselectall" value="batal pilih"
                                           class="my_button round blue   text-upper" onClick="uncheckAll()"
                                           style="margin-left:5px;"/>
                                    <input name="dsubmit" type="button" value="hapus item terpilih"
                                           class="my_button round blue   text-upper" style="margin-left:5px;"
                                           onclick="return confirmDeleteSubmit()"/>
                                    <table>
                                        <?php
                                        $SQL = "SELECT * FROM  category_details ORDER BY id DESC";
                                        if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {

                                            $SQL = "SELECT * FROM  category_details WHERE category_name LIKE '%" . $_POST['searchtxt'] . "%' ORDER BY id DESC ";
                                        }
                                        $tbl_name = "category_details";
                                        $adjacents = 3;
                                        $query = "SELECT COUNT(*) as num FROM $tbl_name";
                                        if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {
                                            $query = "SELECT COUNT(*) as num FROM  category_details WHERE category_name LIKE '%" . $_POST['searchtxt'] . "%' ";
                                        }
                                        $total_pages = mysqli_fetch_array(mysqli_query($db->connection, $query));

                                        $total_pages = $total_pages['num'];
                                        $targetpage = "view_category.php";
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
                                        $sql = "SELECT * FROM category_details ORDER BY id DESC LIMIT $start, $limit  ";
                                        if (isset($_POST['Search']) AND trim($_POST['searchtxt']) != "") {

                                            $sql = "SELECT * FROM  category_details WHERE category_name LIKE '%" . $_POST['searchtxt'] . "%' ORDER BY id DESC LIMIT $start, $limit";
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
                                                $pagination .= "<a href=\"view_category.php?page=$prev&limit=$limit\" class=my_pagination >Previous</a>";
                                            else
                                                $pagination .= "<span class=my_pagination>Previous</span>";
                                            if ($lastpage < 7 + ($adjacents * 2)) {
                                                for ($counter = 1; $counter <= $lastpage; $counter++) {

                                                    if ($counter == $page)
                                                        $pagination .= "<span class=my_pagination>$counter</span>";
                                                    else
                                                        $pagination .= "<a href=\"view_category.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                }
                                            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                                                if ($page < 1 + ($adjacents * 2)) {
                                                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                                        if ($counter == $page)
                                                            $pagination .= "<span class=my_pagination>$counter</span>";
                                                        else
                                                            $pagination .= "<a href=\"view_category.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                    }
                                                    $pagination .= "...";
                                                    $pagination .= "<a href=\"view_category.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";
                                                    $pagination .= "<a href=\"view_category.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";
                                                }
                                                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                                    $pagination .= "<a href=\"view_category.php?page=1&limit=$limit\" class=my_pagination>1</a>";
                                                    $pagination .= "<a href=\"view_category.php?page=2&limit=$limit\" class=my_pagination>2</a>";
                                                    $pagination .= "...";
                                                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                                        if ($counter == $page)
                                                            $pagination .= "<span  class=my_pagination>$counter</span>";
                                                        else
                                                            $pagination .= "<a href=\"view_category.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
                                                    }
                                                    $pagination .= "...";
                                                    $pagination .= "<a href=\"view_category.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";
                                                    $pagination .= "<a href=\"view_category.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";
                                                }
                                                else {
                                                    $pagination .= "<a href=\"$view_category.php?page=1&limit=$limit\" class=my_pagination>1</a>";
                                                    $pagination .= "<a href=\"$view_category.php?page=2&limit=$limit\" class=my_pagination>2</a>";
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
                                                $pagination .= "<a href=\"view_category.php?page=$next&limit=$limit\" class=my_pagination>Next</a>";
                                            else
                                                $pagination .= "<span class= my_pagination >Next</span>";
                                            $pagination .= "</div>\n";
                                        }
                                        ?>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Produk</th>
                                            <th>keterangan</th>

                                            <th>Edit / hapus</th>
                                            <th>pilih</th>
                                        </tr>
                                        <?php
                                        $co = 0;
                                        $co1 = 0;
                                        $s = mysqli_query($db->connection, "select * from category_details");
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
                                                <td> <?php echo $no + $i; ?></td>
                                                <td><?php echo $row['category_name']; ?></td>
                                                <td> <?php echo $row['category_description']; ?></td>
                                                <td>
                                                    <a href="update_category.php?sid=<?php echo $row['id']; ?>&table=category_details&return=view_category.php"
                                                       class="table-actions-button ic-table-edit">
                                                    </a>
                                                    <a onclick="return confirmSubmit()"
                                                       href="delete.php?id=<?php echo $row['id']; ?>&table=category_details&return=view_category.php"
                                                       class="table-actions-button ic-table-delete"></a>
                                                </td>
                                                <td><input type="checkbox" value="<?php echo $row['id']; ?>" name="checklist[]"
                                                           id="check_box"/></td>
                                            </tr>
    <?php $i++;}?>
                                        <table>
                                        </table>
                                    </table>
                                </form>
                        </div>
                    </div>
                    <?php include_once("tpl/footer.php"); ?>
                    </body>
                    </html>

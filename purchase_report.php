<?php
include_once("init.php");
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') { 
    header("location: index.php?msg=Please%20login%20to%20access%20admin%20area%20!");
} else {
    if (isset($_GET['from_purchase_date']) && isset($_GET['to_purchase_date']) && $_GET['from_purchase_date'] != '' && $_GET['to_purchase_date'] != '') {
        $selected_date = $_GET['from_purchase_date'];
        $selected_date = strtotime($selected_date);
        $mysqldate = date('Y-m-d H:i:s', $selected_date);
        $fromdate = $mysqldate;
        $selected_date = $_GET['to_purchase_date'];
        $selected_date = strtotime($selected_date);
        $mysqldate = date('Y-m-d H:i:s', $selected_date);
        $todate = $mysqldate;
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
        <html>
        <head>
            <title>Laporan Penjualan</title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        </head>
        <style type="text/css" media="print">
            .hide {
                display: none
            }
        </style>
        <script type="text/javascript">
            function printpage() {
                document.getElementById('printButton').style.visibility = "hidden";
                window.print();
                document.getElementById('printButton').style.visibility = "visible";
            }
        </script>
        <body>
        <input name="print" type="button" value="Print" id="printButton" onClick="printpage()">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <div align="right">
                        <?php $line4 = $db->queryUniqueObject("SELECT * FROM store_details ");
                        ?>
                        <strong><?php echo $line4->name; ?></strong><br/>
                        <?php echo $line4->address; ?>,<?php echo $line4->place; ?>, <br/>
                        <?php echo $line4->city; ?>,<?php echo $line4->pin; ?><br/>
                        Website<strong>:<?php echo $line4->web; ?></strong><br>Email<strong>:<?php echo $line4->email; ?></strong><br/>Telepon
                        <strong>:<?php echo $line4->phone; ?></strong>
                        <br/>
                        <?php ?>
                    </div>
                    <table width="595" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td height="30" align="center"><strong>Laporan Pembelian</strong></td>
                        </tr>
                        <tr>
                            <td height="30" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right">
                                <table width="300" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="150"><strong>Total Pembelian</strong></td>
                                        <td width="150">
                                            &nbsp;<?php echo $age = $db->queryUniqueValue("SELECT sum(subtotal) FROM stock_entries where count1=1 AND type='entry' AND date BETWEEN '$fromdate' AND '$todate' "); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jumlah pembayaran</strong></td>
                                        <td>
                                            &nbsp;<?php echo $age = $db->queryUniqueValue("SELECT sum(payment) FROM stock_entries where count1=1 AND type='entry' AND date BETWEEN '$fromdate' AND '$todate' "); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="150"><strong>Pembayaran Tertunda </strong></td>
                                        <td width="150">
                                            &nbsp;<?php echo $age = $db->queryUniqueValue("SELECT sum(balance) FROM stock_entries where count1=1 AND type='entry' AND date BETWEEN '$fromdate' AND '$todate' "); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="45">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td height="20">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="45"><strong>Dari</strong></td>
                                        <td width="393">&nbsp;<?php echo $_GET['from_purchase_date']; ?></td>
                                        <td width="41"><strong>Untuk</strong></td>
                                        <td width="116">&nbsp;<?php echo $_GET['to_purchase_date']; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="45">
                                <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td><strong>Tanggal</strong></td>
                                        <td><strong>ID pembelian </strong></td>
                                        <td><strong>Pemasok</strong></td>
                                        <td><strong>Dibayar</strong></td>
                                        <td><strong>Keseimbangan</strong></td>
                                        <td><strong>Total</strong></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php
                                    $result = $db->query("SELECT * FROM stock_entries where  type='entry' AND date BETWEEN '$fromdate' AND '$todate' ");
                                    while ($line = $db->fetchNextObject($result)) {
                                        ?>
                                        <tr>
                                            <td><?php $mysqldate = $line->date;
                                                $phpdate = strtotime($mysqldate);
                                                $phpdate = date("d/m/Y", $phpdate);
                                                echo $phpdate; ?></td>
                                            <td><?php echo $line->stock_id; ?></td>
                                            <td><?php echo $line->stock_supplier_name; ?></td>
                                            <td><?php echo $line->payment;?></td>
                                            <td><?php echo $line->balance; ?></td>
                                            <td><?php echo $line->subtotal; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        </body>
        </html>
        <?php
    } else
        echo "Please from and to date to process report";
}
?>
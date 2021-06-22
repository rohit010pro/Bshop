<?php
require_once("header.php");
require_once("connection.php");

$sellerID = $_SESSION['admin-id'];
?>

<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Orders</h1>
    </div>

    <?php
    $query = "SELECT od.order_ref,
        GROUP_CONCAT(od.order_quantity) as order_qty_arr,
        GROUP_CONCAT(od.sell_price) as sell_price_arr,
        GROUP_CONCAT(p.name) as product_name_arr, 
        GROUP_CONCAT(p.brand) as product_brand_arr,
        od.order_date,od.status,od.payment_status,
        od.address,od.city,od.state,od.pin_code,od.contact_no,
        u.name as user_name
        FROM order_detail od 
        JOIN products p
        ON od.product_id = p.id
        JOIN users u
        ON od.user_id = u.user_id
        WHERE p.seller_id = $sellerID
        GROUP BY(order_ref)";

    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0){
    ?>
    <div class="table-wrapper">
        <table class="table" style="width: 100%; min-width:1200px;">
            <thead>
                <th>order ref</th>
                <th>Product Detail</th>
                <th>Qty</th>
                <th>TotalPrice</th>
                <th>Customer Details</th>
                <th>Order Date</th>
                <th>Payment status</th>
                <th>Delivery status</th>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>
                        <td><?php echo $row['order_ref']; ?></td>
                        <td class="multipe-product">
                            <?php
                            $productNameArr = explode(",", $row['product_name_arr']);
                            $productBrandArr = explode(",", $row['product_brand_arr']);
                            $orderQtyArr = explode(",", $row['order_qty_arr']);
                            $sellPriceArr = explode(",", $row['sell_price_arr']);

                            $totalPrice = 0;
                            $totalQty = 0;
                            for ($i = 0; $i < count($productNameArr); $i++) {
                                echo "<p><b>Product Name: </b>" . $productNameArr[$i] .
                                    "<br><b>Qty: </b>" . $orderQtyArr[$i] .
                                    "<br><b>Price: </b>" . $sellPriceArr[$i] . "</p>";
                                $totalQty += $orderQtyArr[$i];
                                $totalPrice += $sellPriceArr[$i] * $orderQtyArr[$i];
                            }
                            ?>
                        </td>
                        <td><?php echo $totalQty; ?></td>
                        <td><?php echo $totalPrice; ?></td>
                        <td>
                            <?php
                            echo "<p><b>Name:</b> " . $row['user_name'] . "</p>" .
                                "<p><b>Address:</b> " . $row['address'] . "</p>" .
                                "<p><b>City:</b> " . $row['city'] . " - " . $row['pin_code'] . "</p>" .
                                "<p><b>State:</b> " . $row['state'] . "</p>" .
                                "<p><b>Mobile no:</b> " . $row['contact_no'] . "</p>";
                            ?>
                        </td>
                        <td style="white-space: nowrap;">
                        <?php
                            $timeStamp = strtotime($row['order_date']);
                            echo date("d M Y", $timeStamp); ?>
                        </td>
                        <td><span class="badge bg-green"><?php echo $row['payment_status'];?></span></td>
                        <td><span class="badge-lg bg-blue">
                                <?php echo $row['status']; ?>
                            </span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else{
        echo "<h1 style='text-align:center;'>No Order Found.</h1>";
    } ?>
</section>

<?php
require_once("footer.php");
?>
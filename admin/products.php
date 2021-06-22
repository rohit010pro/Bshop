<?php
require_once("header.php");
require_once("connection.php");
$sellerID = $_SESSION['admin-id'];
?>

<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Products</h1>
        <a class="btn" href="product-add.php">Add Product</a>
    </div>
    <?php
    $query = "SELECT p.id,p.name,p.brand,p.price,p.quantity,p.quantity,c.name as cat_name, sc.name as sub_cat_name FROM 
        products p JOIN category c 
        ON p.cate_id = c.id 
        JOIN sub_category sc
        ON p.sub_cate_id = sc.id
        WHERE p.seller_id = $sellerID ORDER BY p.id";

    $result = mysqli_query($connection,$query);
    if(mysqli_num_rows($result) > 0){
    ?>
    <div class="table-wrapper">
        <table class="table" style="width: 100%; min-width:1200px">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Category</th>
                <th>Sub-category</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['cat_name']; ?></td>
                    <td><?php echo $row['sub_cat_name']; ?></td>
                    <td>
                        <a href="product-edit.php?pid=<?php echo $row['id']; ?>" class="icon-btn edit-btn">
                            <i class="fa fa-edit"></i></a>
                        <!-- <a href="product-delete.php?pid="" class="icon-btn delete-btn">
                            <i class="fa fa-trash-alt"></i></a> -->
                    </td>
                </tr>                
                <?php } ?>
               
            </tbody>
        </table>
    </div>
    <?php }else{
        echo "<h1 style='text-align:center;'>No Product Found.</h1>";
    } ?>
</section>

<?php
require_once("footer.php");
?>
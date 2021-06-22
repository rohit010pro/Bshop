<?php
require_once("header.php");
require_once("connection.php");
$sellerID = $_SESSION['admin-id'];
?>

<section class="section">
    <div class="sec-header">
    <h1 class="sec-heading">Sub Category</h1>
        <a class="btn" href="sub-category-add.php">Add Sub Category</a>
    </div>

    <?php 
    $query = "SELECT * FROM sub_category";
    $result = mysqli_query($connection,$query);

    if(mysqli_num_rows($result) > 0){
    ?>
    <div class="table-wrapper">
        <table class="table" style="min-width: 700px;">
            <thead>
                <th>ID</th>
                <th>Sub-category Name</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <a href="sub-category-edit.php?sub_cate_id=<?php echo $row['id'];?>" class="icon-btn edit-btn" ><i class="fa fa-edit"></i></a>
                        <!-- <a href="category-delete.php" class="icon-btn delete-btn"><i class="fa fa-trash-alt"></i></a> -->
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else{
        echo "<h1 style='text-align:center;'>No Sub Category Found.</h1>";
    } ?>
</section>

<?php
require_once("footer.php");
?>
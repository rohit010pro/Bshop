<?php
require_once("header.php");
require_once("connection.php");
?>

<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Category</h1>
        <a class="btn" href="category-add.php">Add Category</a>
    </div>

    <?php 
    $query = "SELECT * FROM category";
    $result = mysqli_query($connection,$query);

    if(mysqli_num_rows($result) > 0){
    ?>
    <div class="table-wrapper">
        <table class="table" style="min-width: 700px;">
            <thead>
                <th>ID</th>
                <th>Category Name</th>
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
                        <a href="category-edit.php?cate_id=<?php echo $row['id']; ?>" class="icon-btn edit-btn" ><i class="fa fa-edit"></i></a>
                        <!-- <a href="category-delete.php" class="icon-btn delete-btn"><i class="fa fa-trash-alt"></i></a> -->
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else{
        echo "<h1 style='text-align:center;'>No Category Found.</h1>";
    } ?>
</section>

<?php
require_once("footer.php");
?>
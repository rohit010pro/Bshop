<?php
require_once("header.php");
require_once("connection.php");

$subCateId = $_REQUEST['sub_cate_id'];

if(isset($_POST['edit-sub-cate'])){
    $subCateId = $_POST['sub_cate_id'];
    $category = $_POST['category'];
    $subCategoryName = $_POST['sub-category-name'];

    $query = "UPDATE sub_category SET name = '$subCategoryName', cate_id = $category WHERE id = $subCateId";
    $result = mysqli_query($connection,$query) or die("Query Failed");

    if($result)
        header("Location: sub-category.php");
}

$query = "SELECT * FROM sub_category WHERE id = $subCateId";
$result = mysqli_query($connection,$query) or die("Query Failed");

if(mysqli_num_rows($result)){
    $rowS = mysqli_fetch_assoc($result);
?>
<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Edit Sub Category</h1>
    </div>
    <div class="form-wrapper" style="max-width: 500px;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-field">
                <label>Category</label>
                <input type="hidden" name="sub_cate_id" value="<?php echo $subCateId; ?>">
                <select name="category" required>
                    <option disabled selected>Select</option>
                    <?php
                    $query = "SELECT * from category";
                    $result = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($rowS['cate_id'] == $row['id']) ? "selected" : "";      
                        echo "<option $selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }    
                    ?>
                </select>
            </div>
            <div class="input-field">
                <label>Sub Category Name</label>
                <input name="sub-category-name" type="text" value="<?php echo $rowS['name']; ?>"/>
            </div>
            <input class="button" name="edit-sub-cate" type="submit" value="Save">
        </form>
    </div>
</section>
<?php } ?>
<?php
require_once("footer.php");
?>
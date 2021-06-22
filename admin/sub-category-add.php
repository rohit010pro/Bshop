<?php
require_once("header.php");
require_once("connection.php");

if(isset($_POST['add-sub-cate'])){
    $category = $_POST['category'];
    $subCategoryName = $_POST['sub-category-name'];

    $query = "INSERT INTO sub_category(name,cate_id) VALUES('$subCategoryName', $category)";
    $result = mysqli_query($connection,$query) or die("Query Failed");

    if($result)
        header("Location: sub-category.php");
}

?>

<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Add Sub Category</h1>
    </div>

    <div class="form-wrapper" style="max-width: 500px;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-field">
                <label>Category</label>
                <select name="category" required>
                    <option disabled selected>Select</option>
                    <?php
                    $query = "SELECT * from category";
                    $result = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option $selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }    
                    ?>
                </select>
            </div>

            <div class="input-field">
                <label>Sub Category Name</label>
                <input name="sub-category-name" type="text"/>
            </div>
            <input class="button" name="add-sub-cate" type="submit" value="Add">
        </form>
    </div>
</section>

<?php
require_once("footer.php");
?>
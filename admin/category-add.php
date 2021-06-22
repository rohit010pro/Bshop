<?php
require_once("header.php");
require_once("connection.php");

if(isset($_POST['add-cate'])){
    $categoryName = $_POST['category-name'];

    $query = "INSERT INTO category(name) VALUES('$categoryName')";
    $result = mysqli_query($connection,$query) or die("Query Failed");

    if($result)
        header("Location: category.php");
}

?>

<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Add Category</h1>
    </div>

    <div class="form-wrapper" style="max-width: 500px;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-field">
                <label>Category Name</label>
                <input name="category-name" type="text"/>
            </div>
            <input class="button" name="add-cate" type="submit" value="Add">
        </form>
    </div>
</section>

<?php
require_once("footer.php");
?>
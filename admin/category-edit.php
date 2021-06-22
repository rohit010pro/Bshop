<?php
require_once("header.php");
require_once("connection.php");

$cateId = $_REQUEST['cate_id'];

if(isset($_POST['edit-cate'])){
    $categoryName = $_POST['category-name'];

    $query = "UPDATE category SET name = '$categoryName' WHERE id = $cateId";
    $result = mysqli_query($connection,$query) or die("Query Failed");

    if($result)
        header("Location: category.php");
}

$query = "SELECT * FROM category WHERE id=$cateId";
$result = mysqli_query($connection,$query) or die("Query Failed");

if(mysqli_num_rows($result)){
    $row = mysqli_fetch_assoc($result);
?>
<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Edit Category</h1>
    </div>
    <div class="form-wrapper" style="max-width: 500px;">
        <form action="<?php echo $_SERVER['PHP_SELF'] .'?cate_id=' . $row['id']; ?>"  method="post">
            <div class="input-field">
                <label>Category Name</label>
                <input name="category-name" type="text" value="<?php echo $row['name']; ?>"/>
            </div>
            <input class="button" name="edit-cate" type="submit" value="Save">
        </form>
    </div>
</section>
<?php }?>

<?php
require_once("footer.php");
?>
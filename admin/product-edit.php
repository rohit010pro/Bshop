<?php
require_once("header.php");
require_once("connection.php");

$adminId = $_SESSION['admin-id'];

if(isset( $_REQUEST['pid']))
    $productId = $_REQUEST['pid'];
else
    $productId = $_POST['product-id'];
    
$errors = array();
if (isset($_POST['edit-product-btn'])) 
{
    $productId = mysqli_real_escape_string($connection, $_POST['product-id']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $brand = mysqli_real_escape_string($connection, $_POST['brand']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $subCategory = mysqli_real_escape_string($connection, $_POST['sub-category']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

    $oldImage = mysqli_real_escape_string($connection, $_POST['old-image']);

    // Fetching Category name 
    $query = "SELECT name FROM category WHERE id = $category";
    $result = mysqli_query($connection,$query) or die("Query Failed");
    $row = mysqli_fetch_assoc($result);
    $categoryName = strtolower($row['name']);  
    
    // Fetching Sub Category name 
    $query = "SELECT name FROM sub_category WHERE id = $subCategory";
    $result = mysqli_query($connection,$query) or die("Query Failed");
    $row = mysqli_fetch_assoc($result);
    $subCategoryName = strtolower($row['name']); 

    $storeImagePath = "";

    if (!isset($_FILES['product-image']) || $_FILES['product-image']['error'] == UPLOAD_ERR_NO_FILE) {
        $storeImagePath = $oldImage;
    }else
    {
        $fileName = $_FILES["product-image"]['name'];
        $fileSize = $_FILES["product-image"]['size'];
        $fileTmpName = $_FILES["product-image"]['tmp_name'];

        $tempVar = explode("/", $_FILES["product-image"]['type']);
        $fileType = strtolower(end($tempVar));

        $newFileName = str_replace(" ","_",$name) . "." . $fileType;

        $validFileTypes = array("jpg", "png", "jpeg");  // Valid file types

        if ($fileSize > 4194304)     // 4MB = 4194304 
            $errors[] = "Image size must be less than or equal to 4MB";

        if (in_array($fileType, $validFileTypes) == false)
            $errors[] = "Image must be of type jpg, png or jpeg";
  
        $storeImagePath = "uploads/$categoryName/$subCategoryName/$newFileName";

        $folderPath = "../uploads/$categoryName/$subCategoryName"; 

        // if directory doesn't exist 
        if(is_dir($folderPath) == false)
           mkdir($folderPath, 0777, true); // Creating directory
        
        if(count($errors) == 0)
            move_uploaded_file($fileTmpName, $folderPath."/".$newFileName);
    }

    if(count($errors) == 0){
        $query = "UPDATE products SET name = '$name',
                brand = '$brand',
                cate_id = $category,
                sub_cate_id = $subCategory,
                price = $price,
                img_url = '$storeImagePath',
                description = '$description',
                quantity = $quantity,
                seller_id = $adminId
                WHERE id = $productId";

        $result = mysqli_query($connection, $query) or die("Query Failed");

        if ($result)
            header("Location: products.php");
    }
}


$query = "SELECT * FROM products WHERE id = $productId";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
?>
<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Edit Product</h1>
    </div>

    <div id="product-info" class="form-wrapper">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            <div id="grid-wrapper">
                <div id="first">
                    <div class="input-field">
                        <label>Name</label>
                        <input name="name" type="text" value="<?php echo $row['name']; ?>" />
                        <input type="hidden" name="product-id" value="<?php echo $row['id']; ?>">
                    </div>
                    <div id="type">
                        <div class="input-field">
                            <label>Brand</label>
                            <input name="brand" type="text" value="<?php echo $row['brand']; ?>" />
                        </div>
                        <div class="input-field">
                            <label>Category</label>
                            <select name="category" required>
                                <option disabled>Select</option>
                                <?php
                                $queryC = "SELECT * from category";
                                $resultC = mysqli_query($connection, $queryC);

                                while ($rowC = mysqli_fetch_assoc($resultC)) {
                                    $selected = "";
                                    if ($rowC['id'] == $row['cate_id'])
                                        $selected = "selected";
                                ?>
                                    <option <?php echo $selected; ?> value="<?php echo $rowC['id']; ?>"><?php echo $rowC['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Sub-Category</label>
                            <select name="sub-category" required>
                                <option disabled selected>Select</option>
                                <?php
                                $querySC = "SELECT * from sub_category";
                                $resultSC = mysqli_query($connection, $querySC);

                                while ($rowSC = mysqli_fetch_assoc($resultSC)) {
                                    $selected = "";
                                    if ($rowSC['id'] == $row['sub_cate_id'])
                                        $selected = "selected";
                                ?>
                                    <option <?php echo $selected; ?> value="<?php echo $rowSC['id']; ?>"><?php echo $rowSC['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="numbers">
                        <div class="input-field">
                            <label>Price</label>
                            <input name="price" type="number" value="<?php echo $row['price']; ?>" />
                        </div>
                        <div class="input-field">
                            <label>Quantity</label>
                            <input name="quantity" type="number" value="<?php echo $row['quantity']; ?>" />
                        </div>
                    </div>
                    <div class="input-field">
                        <label style="margin-bottom:10px;">Description</label>
                        <textarea name="description" rows="4" id="product-desc"><?php echo $row['description']; ?></textarea>
                    </div>
                </div>
                <div id="second">
                    <div class="input-field">
                        <label>Product Images</label>
                        <input type="file" name="product-image"/><br>
                        <p style="color: red;">
                            <?php
                            if(isset($errors) && count($errors) > 0){
                                foreach($errors as $error)
                                echo $error . "<br>";
                            }
                            ?>
                        </p>
                        <input type="hidden" name="old-image" value="<?php echo $row['img_url']; ?>">
                    </div>
                    <div class="image-wrapper">
                            <img src="../<?php echo ($row['img_url']); ?>" alt="Product Image">
                    </div>
                </div>
                <div id="third">
                    <input class="button" style="width: 200px;" name="edit-product-btn" type="submit" value="Save Product">
                </div>
            </div>
        </form>
    </div>
</section>

<?php require_once("footer.php"); ?>
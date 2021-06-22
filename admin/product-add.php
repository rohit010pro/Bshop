<?php
require_once("header.php");
require_once("connection.php");

$adminId = $_SESSION['admin-id'];

$errors = array();
if (isset($_POST['add-product-btn'])) {

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $brand = mysqli_real_escape_string($connection, $_POST['brand']);
    $category = mysqli_real_escape_string($connection, $_POST['category']);
    $subCategory = mysqli_real_escape_string($connection, $_POST['sub-category']);
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

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
    
    if (isset($_FILES["product-image"])) {
        $fileName = $_FILES["product-image"]['name'];
        $fileSize = $_FILES["product-image"]['size'];
        $fileTmpName = $_FILES["product-image"]['tmp_name'];

        $tempVar = explode("/", $_FILES["product-image"]['type']);
        $fileType = strtolower(end($tempVar));

        $newFileName = time() ."_". str_replace(" ","_",$name) . "." . $fileType;

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
        $query = "INSERT INTO products(name, brand, cate_id, sub_cate_id, price, img_url, description, quantity, seller_id) 
                VALUES ('$name', '$brand', $category, $subCategory, $price, '$storeImagePath', '$description', $quantity, $adminId)";

        $result = mysqli_query($connection, $query) or die("Query Failed");

        if ($result)
            header("Location: products.php");
    }
}
?>
<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Add New Product</h1>
    </div>

    <div id="product-info" class="form-wrapper">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div id="grid-wrapper">
                <div id="first">
                    <div class="input-field">
                        <label>Name</label>
                        <input name="name" type="text" required 
                        value="<?php echo (isset($_POST['name']) ? $_POST['name'] : ""); ?>"/>
                    </div>
                    <div id="type">
                        <div class="input-field">
                            <label>Brand</label>
                            <input name="brand" type="text" required  
                            value="<?php echo (isset($_POST['brand']) ? $_POST['brand'] : ""); ?>"/>
                        </div>
                        <div class="input-field">
                            <label>Category</label>
                            <select name="category" required>
                                <option disabled selected>Select</option>
                                <?php
                                $query = "SELECT * from category";
                                $result = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = (isset($_POST['category']) && $_POST['category'] == $row['id']) ? "selected" : "";
                                          
                                    echo "<option $selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }    
                                ?>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Sub-Category</label>
                            <select name="sub-category" required>
                                <option disabled selected>Select</option>
                                <?php
                                $query = "SELECT * from sub_category";
                                $result = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = (isset($_POST['sub-category']) && $_POST['sub-category'] == $row['id']) ? "selected" : "";
                                    
                                    echo "<option $selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="numbers">
                        <div class="input-field">
                            <label>Price</label>
                            <input name="price" type="number" required   
                            value="<?php echo (isset($_POST['price']) ? $_POST['price'] : ""); ?>"/>
                        </div>
                        <div class="input-field">
                            <label>Quantity</label>
                            <input name="quantity" type="number" required  
                            value="<?php echo (isset($_POST['quantity']) ? $_POST['quantity'] : ""); ?>"/>
                        </div>
                    </div>
                    <div class="input-field">
                        <label style="margin-bottom:10px;">Description</label>
                        <textarea name="description" rows="4" id="product-desc" required><?php echo (isset($_POST['description']) ? $_POST['description'] : ""); ?></textarea>                    
                    </div>
                </div>
                <div id="second">
                    <div class="input-field">
                        <label>Product Images</label>
                        <input name="product-image" type="file" required/><br>
                        <p style="color: red;">
                            <?php
                            if(isset($errors) && count($errors) > 0){
                                foreach($errors as $error)
                                echo $error . "<br>";
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div id="third">
                    <input class="button" style="width: 200px;" name="add-product-btn" type="submit" value="Add Product">
                </div>
            </div>
        </form>
    </div>
</section>

<?php require_once("footer.php"); ?>
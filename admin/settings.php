<?php
require_once("header.php");
require_once("connection.php");

function uploadImage($prefixImg, $siteName, &$fullPath, &$errors)
{
    $key = "";
    if ($prefixImg == "favicon")
        $key = "title-logo";
    else if ($prefixImg == "brand")
        $key = "site-logo";

    $fileName = $_FILES[$key]['name'];
    $fileSize = $_FILES[$key]['size'];
    $fileTmpName = $_FILES[$key]['tmp_name'];

    $tempVar = explode("/", $_FILES[$key]['type']);
    $fileType = strtolower(end($tempVar));

    $newFileName = $prefixImg . "_" . str_replace(" ", "_", $siteName) . "." . $fileType;

    $validFileTypes = array("jpg", "png", "jpeg");  // Valid file types

    if ($fileSize > 4194304)     // 4MB = 4194304 
        $errors[] = "Image size must be less than or equal to 4MB";

    if (in_array($fileType, $validFileTypes) == false)
        $errors[] = "Image must be of type jpg, png or jpeg";

    $fullPath = "uploads/site_logo/$newFileName";

    $folderPath = "../uploads/site_logo/";

    // if directory doesn't exist 
    if (is_dir($folderPath) == false)
        mkdir($folderPath, 0777, true); // Creating directory

    if (count($errors) == 0)
        move_uploaded_file($fileTmpName, $folderPath . "/" . $newFileName);
}

if (isset($_POST['save-settings'])) {
    $siteTitle = $_POST['site-title'];
    $siteName = $_POST['site-name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $siteCopyright = $_POST['site-copyright'];

    // Title Logo
    $errorsTitleLogo = array();
    $fullPathTitleLogo = "";
    if (!isset($_FILES['title-logo']) || $_FILES['title-logo']['error'] == UPLOAD_ERR_NO_FILE) {
        $fullPathTitleLogo = $_POST['old-title-logo'];
    } else {
        uploadImage("favicon", $siteName, $fullPathTitleLogo, $errorsTitleLogo);
    }

    // Site Logo
    $errorsSiteLogo = array();
    $fullPathSiteLogo = "";
    if (!isset($_FILES['site-logo']) || $_FILES['site-logo']['error'] == UPLOAD_ERR_NO_FILE) {
        $fullPathSiteLogo = $_POST['old-site-logo'];
    } else {
        uploadImage("brand", $siteName, $fullPathSiteLogo, $errorsSiteLogo);
    }

    if (count($errorsSiteLogo) == 0 && count($errorsTitleLogo) == 0) {

        $query = "UPDATE site_settings SET 
                title = '$siteTitle', 
                title_logo = '$fullPathTitleLogo', 
                name = '$siteName', 
                site_logo = '$fullPathSiteLogo', 
                phone_no = $phone, 
                email = '$email', 
                address = '$address',
                copyright = '$siteCopyright'";
        $result = mysqli_query($connection, $query) or die("Update Query Failed : " . mysqli_error($connection));

        header("Location: settings.php");
    }
}

?>
<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Site Settings</h1>
    </div>
    <?php
    $query = "SELECT * FROM site_settings";
    $result = mysqli_query($connection, $query) or die("Query Failed");

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    ?>
        <div class="form-wrapper">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div id="site-settings">
                    <div class="first">
                        <div class="input-field">
                            <label>Site title</label>
                            <input name="site-title" type="text" value="<?php echo $row['title']; ?>" required />
                        </div>
                        <div class="input-field">
                            <label>Site Name</label>
                            <input name="site-name" type="text" value="<?php echo $row['name']; ?>" required />
                        </div>
                        <div class="input-field">
                            <label>Company Phone number</label>
                            <input name="phone" type="tel" value="<?php echo $row['phone_no']; ?>" required>
                        </div>
                        <div class="input-field">
                            <label>Company Email</label>
                            <input name="email" type="email" value="<?php echo $row['email']; ?>" required>
                        </div>
                        <div class="input-field">
                            <label>Company Address</label>
                            <textarea name="address" type="text"><?php echo $row['address']; ?></textarea>
                        </div>
                        <div class="input-field">
                            <label>Site Copyright mark</label>
                            <textarea name="site-copyright" type="text"><?php echo $row['copyright']; ?></textarea>
                        </div>
                    </div>

                    <div class="second">
                        <div class="input-field">
                            <label>Company Title Logo</label>
                            <input name="title-logo" type="file" />
                            <input type="hidden" name="old-title-logo" value="<?php echo $row['title_logo']; ?>">
                            <p style="color: red;">
                                <?php
                                if (isset($errorsTitleLogo) && count($errorsTitleLogo) > 0) {
                                    foreach ($errorsTitleLogo as $error)
                                        echo $error . "<br>";
                                }
                                ?>
                            </p>
                            <img class="title-logo" src="<?php echo "../" . $row['title_logo']; ?>" alt="Title Logo">
                        </div>
                        <div class="input-field">
                            <label>Company Logo</label>
                            <input name="site-logo" type="file" />
                            <input type="hidden" name="old-site-logo" value="<?php echo $row['site_logo']; ?>">
                            <p style="color: red;">
                                <?php
                                if (isset($errorsSiteLogo) && count($errorsSiteLogo) > 0) {
                                    foreach ($errorsSiteLogo as $error)
                                        echo $error . "<br>";
                                }
                                ?>
                            </p>
                            <img class="site-logo" src="<?php echo "../" . $row['site_logo']; ?>" alt="Site Logo">
                        </div>
                    </div>
                    <div class="third">
                        <input class="button" name="save-settings" type="submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    <?php } ?>
</section>

<?php
require_once("footer.php");
?>
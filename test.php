<?php
require_once "connection.php";

if(isset($_REQUEST['page']))
  $page = $_REQUEST['page'];
else
  $page = 1;
 
$recordPerPage = 10;

$offset = ($page - 1) * $recordPerPage;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Demo</title>
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="admin/assets/css/style.css">
    <style>
        .pagination{
            width: fit-content;
            margin: auto;
        }       
        .pagination li{
            display: inline-block;
            background-color: #333;
            margin-right: 2px;
        }
        .pagination li:first-child{
            border-radius: 3px 0 0 3px;
        }
        .pagination li:last-child{
            border-radius: 0 3px 3px 0;
        }
        .pagination li a{
            display: inline-block;
            padding:6px 12px;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="sub-heading">Products</h1>

        <div class="table-wrapper">
            <table class="table" style="width: 100%; min-width:1200px">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Qty</th>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM products ORDER BY id DESC LIMIT $offset, $recordPerPage";

                    $result = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['brand']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <?php
            $query = "SELECT * FROM products";
            $result = mysqli_query($connection, $query);
            $totalRecord = mysqli_num_rows($result);
            $totalPages = ceil($totalRecord / $recordPerPage);

            if ($totalRecord > $recordPerPage) {
                echo "<ul class='pagination'>";
                if ($page > 1)
                    echo "<li><a href='test.php?page=" . ($page - 1) . "'>Prev</a></li>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    $class = ($i == $page) ? "active" : "";
                    echo "<li class='$class'><a href='test.php?page=$i'>$i</a></li>";
                }
                if ($page < $totalPages)
                    echo "<li><a href='test.php?page=" . ($page + 1) . "'>Next</a></li>";
                echo "</ul>";
            }
        ?>
    </div>

</body>

</html>
<?php
require_once("header.php");
require_once("connection.php");
?>

<section class="section">
    <div class="sec-header">
        <h1 class="sec-heading">Users</h1>
    </div>

    <?php
    $query = "SELECT user_id, name, email, phone_no, address, city, state, pin_code FROM users";
    $result = mysqli_query($connection,$query) or die("Query Failed");
    if(mysqli_num_rows($result) > 0){
    ?>
    <div class="table-wrapper">
        <table class="table" style="width: 100%; min-width:1200px;">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Pin code</th>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td style="white-space: nowrap;"><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo ($row['phone_no'] ? $row['phone_no'] : "--"); ?></td>
                    <td><?php echo ($row['address'] ? $row['address'] : "--"); ?></td>
                    <td><?php echo ($row['city'] ? $row['city'] : "--"); ?></td>
                    <td><?php echo ($row['state'] ? $row['state'] : "--"); ?></td>
                    <td><?php echo ($row['pin_code'] ? $row['pin_code'] : "--"); ?></td>
                </tr> 
                <?php } ?>               
            </tbody>
        </table>
    </div>
    <?php }else{
        echo "<h1 style='text-align:center;'>No User Found.</h1>";
    } ?>    
</section>

<?php require_once("footer.php"); ?>
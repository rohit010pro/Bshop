<?php 
require("../connection.php"); 
$search = $_POST['search'];

// $query = "SELECT name from products WHERE name LIKE '$search%'";

$query = "SELECT p.name,p.brand,p.price,p.description,p.img_url,c.name cname,sc.name scname FROM products p 
        JOIN category c
        ON p.cate_id = c.id
        JOIN sub_category sc
        ON p.sub_cate_id = sc.id
        WHERE p.name LIKE '%$search%'
        OR p.brand LIKE '%$search%'
        OR p.price LIKE '%$search%'
        OR p.description LIKE '%$search%'
        OR c.name LIKE '%$search%' 
        OR sc.name LIKE '%$search%'";

$result = mysqli_query($connection,$query);

$html = "";

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result)){
        $html .= <<< "EOT"
        <option value="{$row['name']}">
        EOT;
    }
    echo $html;
}else{
    echo 0;
}



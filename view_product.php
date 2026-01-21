<?php
include "db.php";

$query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");

if(!$query){
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:20px; }
        h2 { text-align:center; color:#333; margin-bottom:30px; }
        .product { background:#fff; padding:20px; border-radius:10px; margin-bottom:20px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
        .product h3 { margin:0 0 10px 0; }
        .product p { margin:5px 0; }
        .images { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }
        .images img { width:150px; height:150px; object-fit:cover; border-radius:5px; }
        @media(max-width:600px){ .images img { width:100px; height:100px; } }
    </style>
</head>
<body>

<h2>All Products</h2>

<?php
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        echo "<div class='product'>";
        echo "<h3>{$row['name']}</h3>";
        echo "<p><strong>Price:</strong> {$row['price']}</p>";
        echo "<p><strong>Description:</strong> {$row['description']}</p>";

        if(!empty($row['image'])){
            $images = explode(',', $row['image']); // Get all images
            echo "<div class='images'>";
            foreach($images as $img){
                echo "<img src='uploads/$img' alt='Product Image'>";
            }
            echo "</div>";
        }

        echo "</div>";
    }
}else{
    echo "<p style='text-align:center;'>No products found.</p>";
}
?>

</body>
</html>

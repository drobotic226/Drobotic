<?php
include "db.php";

/* ---------------- FETCH PRODUCT FOR EDIT ---------------- */
$edit_id = isset($_GET['edit']) ? $_GET['edit'] : '';
$editData = null;

if ($edit_id) {
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id='$edit_id'");
    $editData = mysqli_fetch_assoc($res);
}

/* ---------------- ADD / UPDATE PRODUCT ---------------- */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $id = $_POST['id'];

    if (!empty($_FILES['images']['name'][0])) {
        $imgArr = [];
        foreach ($_FILES['images']['name'] as $k => $img) {
            $imgName = time() . "_" . $img;
            move_uploaded_file($_FILES['images']['tmp_name'][$k], "uploads/" . $imgName);
            $imgArr[] = $imgName;
        }
        $images = implode(',', $imgArr);
    } else {
        $images = $_POST['old_image'];
    }

    if ($id) {
        mysqli_query($conn,"UPDATE products SET name='$name', price='$price', description='$description', image='$images' WHERE id='$id'");
    } else {
        mysqli_query($conn,"INSERT INTO products (name, price, description, image) VALUES ('$name','$price','$description','$images')");
    }

    header("Location: add_edit_product.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - Products</title>

<style>
body{
    font-family:Segoe UI,Arial;
    background:#eef2f7;
    margin:0;
}
.container{
    max-width:1100px;
    margin:auto;
    padding:20px;
}
.header{
    background:#343a40;
    color:#fff;
    padding:15px 20px;
    border-radius:10px;
    font-size:22px;
}
.card{
    background:#fff;
    padding:20px;
    margin-top:20px;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}
.card h2{
    margin-bottom:15px;
}
form label{
    font-weight:600;
    margin-top:10px;
    display:block;
}
input, textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:6px;
    border:1px solid #ccc;
}
textarea{resize:none;height:90px}
button{
    background:#28a745;
    color:#fff;
    padding:10px 20px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    margin-top:15px;
    font-size:15px;
}
button:hover{background:#218838}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}
th{
    background:#343a40;
    color:#fff;
    padding:10px;
}
td{
    padding:10px;
    border-bottom:1px solid #ddd;
}
img{
    border-radius:8px;
}
.edit-btn{
    background:#007bff;
    color:#fff;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
    font-size:14px;
}
.edit-btn:hover{background:#0056b3}
.flex{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}
@media(max-width:900px){
    .flex{grid-template-columns:1fr}
}
</style>
</head>

<body>

<div class="container">

<div class="header">Admin Dashboard – Product Management</div>

<div class="flex">

<!-- ADD / EDIT FORM -->
<div class="card">
<h2><?= $editData ? "Edit Product" : "Add Product" ?></h2>

<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
<input type="hidden" name="old_image" value="<?= $editData['image'] ?? '' ?>">

<label>Product Name</label>
<input type="text" name="name" required value="<?= $editData['name'] ?? '' ?>">

<label>Price</label>
<input type="number" name="price" required value="<?= $editData['price'] ?? '' ?>">

<label>Description</label>
<textarea name="description" required><?= $editData['description'] ?? '' ?></textarea>

<label>Images</label>
<input type="file" name="images[]" multiple>

<?php if($editData): ?>
<br>
<img src="uploads/<?= explode(',', $editData['image'])[0] ?>" width="120">
<?php endif; ?>

<button type="submit"><?= $editData ? "Update Product" : "Add Product" ?></button>
</form>
</div>

<!-- PRODUCT LIST -->
<div class="card">
<h2>All Products</h2>

<table>
<tr>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM products ORDER BY id DESC");
while($row = mysqli_fetch_assoc($result)):
?>
<tr>
<td><img src="uploads/<?= explode(',',$row['image'])[0] ?>" width="70"></td>
<td><?= $row['name'] ?></td>
<td>₹<?= $row['price'] ?></td>
<td>
<a class="edit-btn" href="add_edit_product.php?edit=<?= $row['id'] ?>">Edit</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>
</div>

</body>
</html>

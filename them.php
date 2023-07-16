<?php 
    include "../config/config.php";
?>

<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));

// Xử lý thêm sản phẩm khi người dùng nhấn nút "Thêm sản phẩm"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $image_url = $_POST['image_url'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];

    // Thêm thông tin sản phẩm vào bảng Products
    $sqlAddProduct = "INSERT INTO Products (name, description, price, category_id, image_url) VALUES (?, ?, ?, ?, ?)";
    $paramsAddProduct = array($name, $description, $price, $category_id, $image_url);

    $stmtAddProduct = sqlsrv_query($conn, $sqlAddProduct, $paramsAddProduct);
    if ($stmtAddProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Lấy product_id của sản phẩm vừa thêm
    $sqlGetProductID = "SELECT @@IDENTITY AS product_id";
    $stmtGetProductID = sqlsrv_query($conn, $sqlGetProductID);
    if ($stmtGetProductID === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $product_id = sqlsrv_fetch_array($stmtGetProductID, SQLSRV_FETCH_ASSOC)['product_id'];

    // Thêm thông tin size của sản phẩm vào bảng Size_Product
    $sqlAddSizeProduct = "INSERT INTO Size_Product (product_id, size, SoLuongTrongKho) VALUES (?, ?, ?)";
    $paramsAddSizeProduct = array($product_id, $size, $quantity);

    $stmtAddSizeProduct = sqlsrv_query($conn, $sqlAddSizeProduct, $paramsAddSizeProduct);
    if ($stmtAddSizeProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Thêm sản phẩm thành công";
}

sqlsrv_close($conn);
?>

<form method="POST">
    <label for="name">Tên sản phẩm:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="description">Mô tả:</label>
    <textarea name="description" id="description" required></textarea><br>

    <label for="price">Giá:</label>
    <input type="number" name="price" id="price" required><br>

    <label for="category">Danh mục:</label>
    <select name="category" id="category" required>
        <option value="1">Áo</option>
        <option value="2">Quần</option>
    </select><br>

    <label for="image_url">URL hình ảnh:</label>
    <input type="text" name="image_url" id="image_url" required><br>

    <label for="size">Kích cỡ:</label>
    <select name="size" id="size" required>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
    </select><br>

    <label for="quantity">Số lượng:</label>
    <input type="number" name="quantity" id="quantity" required><br>

    <input type="submit" value="Thêm sản phẩm">
</form>
<a href="listsp.php">Quay lại</a>

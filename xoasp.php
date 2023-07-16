<?php 
    include "../config/config.php";
?>

<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));

// Xử lý xóa thông tin sản phẩm và size khi người dùng nhấn nút "Xóa"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['delete_product_id'];

    // Xóa thông tin size của sản phẩm từ bảng Size_Product
    $sqlDeleteSizeProduct = "DELETE FROM Size_Product WHERE product_id = ?";
    $paramsDeleteSizeProduct = array($product_id);

    $stmtDeleteSizeProduct = sqlsrv_query($conn, $sqlDeleteSizeProduct, $paramsDeleteSizeProduct);
    if ($stmtDeleteSizeProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Xóa thông tin sản phẩm từ bảng Products
    $sqlDeleteProduct = "DELETE FROM Products WHERE product_id = ?";
    $paramsDeleteProduct = array($product_id);

    $stmtDeleteProduct = sqlsrv_query($conn, $sqlDeleteProduct, $paramsDeleteProduct);
    if ($stmtDeleteProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Xóa thông tin sản phẩm thành công";
}

// Hiển thị danh sách sản phẩm để người dùng có thể chọn sản phẩm cần xóa
$sqlProducts = "SELECT * FROM Products";
$stmtProducts = sqlsrv_query($conn, $sqlProducts);
if ($stmtProducts === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "Danh sách sản phẩm:<br>";
while ($product = sqlsrv_fetch_array($stmtProducts, SQLSRV_FETCH_ASSOC)) {
    echo "Product ID: " . $product['product_id'] . "<br>";
    echo "Tên sản phẩm: " . $product['name'] . "<br>";
    echo "Mô tả: " . $product['description'] . "<br>";
    echo "Giá: " . $product['price'] . "<br>";
    echo "Danh mục ID: " . $product['category_id'] . "<br>";
    echo "URL hình ảnh: " . $product['image_url'] . "<br>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='delete_product_id' value='" . $product['product_id'] . "'>";
    echo "<input type='submit' value='Xóa'>";
    echo "</form>";
    echo "<br>";
}

sqlsrv_close($conn);
?>
<?php 
    include "../config.php";
?>

<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));

// Xử lý xóa thông tin sản phẩm và size khi người dùng nhấn nút "Xóa"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['delete_product_id'];

    // Xóa thông tin size của sản phẩm từ bảng Size_Product
    $sqlDeleteSizeProduct = "DELETE FROM Size_Product WHERE product_id = ?";
    $paramsDeleteSizeProduct = array($product_id);

    $stmtDeleteSizeProduct = sqlsrv_query($conn, $sqlDeleteSizeProduct, $paramsDeleteSizeProduct);
    if ($stmtDeleteSizeProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Xóa thông tin sản phẩm từ bảng Products
    $sqlDeleteProduct = "DELETE FROM Products WHERE product_id = ?";
    $paramsDeleteProduct = array($product_id);

    $stmtDeleteProduct = sqlsrv_query($conn, $sqlDeleteProduct, $paramsDeleteProduct);
    if ($stmtDeleteProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Xóa thông tin sản phẩm thành công";
}

// Hiển thị danh sách sản phẩm để người dùng có thể chọn sản phẩm cần xóa
$sqlProducts = "SELECT * FROM Products";
$stmtProducts = sqlsrv_query($conn, $sqlProducts);
if ($stmtProducts === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "Danh sách sản phẩm:<br>";
while ($product = sqlsrv_fetch_array($stmtProducts, SQLSRV_FETCH_ASSOC)) {
    echo "Product ID: " . $product['product_id'] . "<br>";
    echo "Tên sản phẩm: " . $product['name'] . "<br>";
    echo "Mô tả: " . $product['description'] . "<br>";
    echo "Giá: " . $product['price'] . "<br>";
    echo "Danh mục ID: " . $product['category_id'] . "<br>";
    echo "URL hình ảnh: " . $product['image_url'] . "<br>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='delete_product_id' value='" . $product['product_id'] . "'>";
    echo "<input type='submit' value='Xóa'>";
    echo "</form>";
    echo "<br>";
}

sqlsrv_close($conn);
?>

<a href="listsp.php">Quay lại</a>
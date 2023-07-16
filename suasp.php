<?php 
    include "../config/config.php";
?>
<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));

// Xử lý sửa thông tin sản phẩm và size khi người dùng nhấn nút "Sửa"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xử lý thông tin sản phẩm
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $image_url = $_POST['image_url'];

    $sqlUpdateProduct = "UPDATE Products SET name = ?, description = ?, price = ?, category_id = ?, image_url = ? WHERE product_id = ?";
    $paramsUpdateProduct = array($name, $description, $price, $category_id, $image_url, $product_id);

    $stmtUpdateProduct = sqlsrv_query($conn, $sqlUpdateProduct, $paramsUpdateProduct);
    if ($stmtUpdateProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Xử lý thông tin size và số lượng trong kho
    if (isset($_POST['size_id'])) {
        $size_id = $_POST['size_id'];
        $size = $_POST['size'];
        $SoLuongTrongKho = $_POST['SoLuongTrongKho'];

        // Cập nhật thông tin size của sản phẩm trong bảng Size_Product
        $sqlUpdateSizeProduct = "UPDATE Size_Product SET size = ?, SoLuongTrongKho = ? WHERE size_id = ?";
        $paramsUpdateSizeProduct = array($size, $SoLuongTrongKho, $size_id);

        $stmtUpdateSizeProduct = sqlsrv_query($conn, $sqlUpdateSizeProduct, $paramsUpdateSizeProduct);
        if ($stmtUpdateSizeProduct === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    } else {
        // Thêm thông tin size mới vào bảng Size_Product
        $size = $_POST['size'];
        $SoLuongTrongKho = $_POST['SoLuongTrongKho'];

        $sqlInsertSizeProduct = "INSERT INTO Size_Product (product_id, size, SoLuongTrongKho) VALUES (?, ?, ?)";
        $paramsInsertSizeProduct = array($product_id, $size, $SoLuongTrongKho);

        $stmtInsertSizeProduct = sqlsrv_query($conn, $sqlInsertSizeProduct, $paramsInsertSizeProduct);
        if ($stmtInsertSizeProduct === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    echo "Cập nhật thông tin sản phẩm và size thành công";
}

// Hiển thị danh sách sản phẩm để người dùng có thể chọn sản phẩm cần sửa
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

    // Hiển thị thông tin size tương ứng của sản phẩm
    $sqlSizeProduct = "SELECT * FROM Size_Product WHERE product_id = ?";
    $paramsSizeProduct = array($product['product_id']);
    $stmtSizeProduct = sqlsrv_query($conn, $sqlSizeProduct, $paramsSizeProduct);
    if ($stmtSizeProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Thông tin size của sản phẩm:<br>";
    while ($sizeProduct = sqlsrv_fetch_array($stmtSizeProduct, SQLSRV_FETCH_ASSOC)) {
        echo "Size ID: " . $sizeProduct['size_id'] . "<br>";
        echo "Kích cỡ: " . $sizeProduct['size'] . "<br>";
        echo "Số lượng trong kho: " . $sizeProduct['SoLuongTrongKho'] . "<br>";
        echo "<br>";
    }

    // Form để người dùng cập nhật thông tin sản phẩm và size
    echo "<form method='post'>";
    echo "<input type='hidden' name='product_id' value='" . $product['product_id'] . "'>";
    echo "<label for='name'>Tên sản phẩm:</label>";
    echo "<input type='text' name='name' value='" . $product['name'] . "' required><br>";
    echo "<label for='description'>Mô tả:</label>";
    echo "<textarea name='description' required>" . $product['description'] . "</textarea><br>";
    echo "<label for='price'>Giá:</label>";
    echo "<input type='number' name='price' value='" . $product['price'] . "' required><br>";
    echo "<label for='category'>Danh mục:</label>";
    echo "<select name='category' required>";
    echo "<option value='1'" . ($product['category_id'] == 1 ? 'selected' : '') . ">Áo</option>";
    echo "<option value='2'" . ($product['category_id'] == 2 ? 'selected' : '') . ">Quần</option>";
    echo "</select><br>";
    echo "<label for='image_url'>URL hình ảnh:</label>";
    echo "<input type='text' name='image_url' value='" . $product['image_url'] . "' required><br>";

    // Hiển thị thông tin size của sản phẩm
    echo "Thông tin size của sản phẩm:<br>";
    $sqlSizeProduct = "SELECT * FROM Size_Product WHERE product_id = ?";
    $paramsSizeProduct = array($product['product_id']);
    $stmtSizeProduct = sqlsrv_query($conn, $sqlSizeProduct, $paramsSizeProduct);
    if ($stmtSizeProduct === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($sizeProduct = sqlsrv_fetch_array($stmtSizeProduct, SQLSRV_FETCH_ASSOC)) {
        echo "<input type='hidden' name='size_id' value='" . $sizeProduct['size_id'] . "'>";
        echo "<label for='size'>Kích cỡ:</label>";
        echo "<select name='size' required>";
        echo "<option value='S'" . ($sizeProduct['size'] == 'S' ? 'selected' : '') . ">S</option>";
        echo "<option value='M'" . ($sizeProduct['size'] == 'M' ? 'selected' : '') . ">M</option>";
        echo "<option value='L'" . ($sizeProduct['size'] == 'L' ? 'selected' : '') . ">L</option>";
        echo "<option value='XL'" . ($sizeProduct['size'] == 'XL' ? 'selected' : '') . ">XL</option>";
        echo "<option value='XXL'" . ($sizeProduct['size'] == 'XXL' ? 'selected' : '') . ">XXL</option>";
        echo "</select><br>";
        echo "<label for='SoLuongTrongKho'>Số lượng trong kho:</label>";
        echo "<input type='number' name='SoLuongTrongKho' value='" . $sizeProduct['SoLuongTrongKho'] . "' required><br>";
    }
    echo "<br>";
    echo "<input type='submit' value='Sửa'>";
    echo "</form>";
    echo "<br>";
}

sqlsrv_close($conn);
?>

<a href="listsp.php">Quay lại</a>

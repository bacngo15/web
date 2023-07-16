<?php 
    include "../config/config.php";
?>
<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Kiểm tra xem đơn hàng có tồn tại hay không
    $sqlCheckOrder = "SELECT * FROM Orders WHERE order_id = ?";
    $paramsCheckOrder = array($order_id);
    $stmtCheckOrder = sqlsrv_query($conn, $sqlCheckOrder, $paramsCheckOrder);

    if (sqlsrv_has_rows($stmtCheckOrder)) {
        // Xóa thông tin từ bảng OrderItems dựa trên order_id
        $sqlOrderItems = "DELETE FROM OrderItems WHERE order_id = ?";
        $paramsOrderItems = array($order_id);
        $stmtOrderItems = sqlsrv_query($conn, $sqlOrderItems, $paramsOrderItems);

        if ($stmtOrderItems === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Xóa thông tin từ bảng Orders dựa trên order_id
        $sqlOrders = "DELETE FROM Orders WHERE order_id = ?";
        $paramsOrders = array($order_id);
        $stmtOrders = sqlsrv_query($conn, $sqlOrders, $paramsOrders);

        if ($stmtOrders === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        echo "Xóa đơn hàng thành công";
    } else {
        echo "Đơn hàng không tồn tại";
    }
}

sqlsrv_close($conn);
?>

<form method="GET">
    <label for="order_id">Nhập order_id để xóa đơn hàng:</label>
    <input type="text" name="order_id" id="order_id" required>
    <input type="submit" value="Xóa đơn hàng">
</form>


<a href="listorder.php">Quay lại</a>

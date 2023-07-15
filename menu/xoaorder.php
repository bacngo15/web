<?php
 $server = "LAPTOP-3P14SVIR";
 $conn = sqlsrv_connect( $server, array( 'Database' => 'ClothingStoreDB' ) ); 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

$deleteOrderItemsSql = "DELETE FROM OrderItems WHERE order_id = ?";
    $deleteOrderItemsParams = array($order_id);
    $deleteOrderItemsStmt = sqlsrv_query($conn, $deleteOrderItemsSql, $deleteOrderItemsParams);
    if ($deleteOrderItemsStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Xóa dữ liệu từ bảng Orders
    $deleteOrderSql = "DELETE FROM Orders WHERE order_id = ?";
    $deleteOrderParams = array($order_id);
    $deleteOrderStmt = sqlsrv_query($conn, $deleteOrderSql, $deleteOrderParams);
    if ($deleteOrderStmt === true) {
        echo "Xóa đơn hàng thành công";
       
    }
     echo "Xóa đơn hàng thất bại";
     die(print_r(sqlsrv_errors(), true));
}
?>

<form method="POST">
    <label for="order_id">Order ID:</label>
    <input type="number" name="order_id" id="order_id" required><br>

    <input type="submit" value="Xóa đơn hàng">
</form>
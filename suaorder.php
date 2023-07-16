<?php 
    include "../config/config.php";
?>

<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

// Hiển thị thông tin ban đầu của đơn hàng có order_id tương ứng
if ($order_id) {
    $sqlGetOrder = "SELECT * FROM Orders WHERE order_id = ?";
    $paramsGetOrder = array($order_id);

    $stmtGetOrder = sqlsrv_query($conn, $sqlGetOrder, $paramsGetOrder);
    if ($stmtGetOrder === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $order = sqlsrv_fetch_array($stmtGetOrder, SQLSRV_FETCH_ASSOC);

    if (!$order) {
        echo "Không tìm thấy đơn hàng với order_id = $order_id";
    } else {
        echo "Thông tin ban đầu của đơn hàng có order_id = $order_id:<br>";
        echo "Customer ID: " . $order['customer_id'] . "<br>";
        echo "Ngày đặt hàng: " . $order['order_date']->format('Y-m-d') . "<br>";
        echo "Tổng giá trị: " . $order['total_amount'] . "<br>";
    }
}

// Xử lý cập nhật thông tin đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_order_date = $_POST['new_order_date'];
    $new_total_amount = $_POST['new_total_amount'];

    $sqlUpdateOrder = "UPDATE Orders SET order_date = ?, total_amount = ? WHERE order_id = ?";
    $paramsUpdateOrder = array($new_order_date, $new_total_amount, $order_id);

    $stmtUpdateOrder = sqlsrv_query($conn, $sqlUpdateOrder, $paramsUpdateOrder);
    if ($stmtUpdateOrder === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Cập nhật thông tin đơn hàng thành công";
}

sqlsrv_close($conn);
?>

<form method="GET">
    <label for="order_id">Nhập order_id để sửa đơn hàng:</label>
    <input type="text" name="order_id" id="order_id" required>
    <input type="submit" value="Tìm đơn hàng">
</form>

<?php if ($order_id && $order): ?>
    <h2>Thông tin cập nhật đơn hàng:</h2>
    <form method="POST">
        <label for="new_order_date">Ngày đặt hàng mới:</label>
        <input type="date" name="new_order_date" id="new_order_date" value="<?php echo $order['order_date']->format('Y-m-d'); ?>" required><br>

        <label for="new_total_amount">Tổng giá trị mới:</label>
        <input type="number" name="new_total_amount" id="new_total_amount" value="<?php echo $order['total_amount']; ?>" required><br>

        <input type="submit" value="Cập nhật đơn hàng">
    </form>
    <a href="listorder.php">Quay lại</a>
<?php endif; ?>

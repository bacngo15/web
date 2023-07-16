<?php 
    include "../config/config.php";
?>

<?php
$server = "LAPTOP-3P14SVIR";
$conn = sqlsrv_connect($server, array('Database' => 'ClothingStoreDB'));

// Xử lý xóa khách hàng khi nhấn nút "Xóa"
if (isset($_POST['delete_customer_id'])) {
    $customer_id = $_POST['delete_customer_id'];

    // Xóa thông tin khách hàng từ bảng Customers
    $sqlDeleteCustomer = "DELETE FROM Customers WHERE customer_id = ?";
    $paramsDeleteCustomer = array($customer_id);

    $stmtDeleteCustomer = sqlsrv_query($conn, $sqlDeleteCustomer, $paramsDeleteCustomer);
    if ($stmtDeleteCustomer === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Xóa thông tin khách hàng thành công";
}

// Hiển thị danh sách khách hàng để người dùng có thể chọn khách hàng cần xóa
$sqlCustomers = "SELECT * FROM Customers";
$stmtCustomers = sqlsrv_query($conn, $sqlCustomers);
if ($stmtCustomers === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "Danh sách khách hàng:<br>";
while ($customer = sqlsrv_fetch_array($stmtCustomers, SQLSRV_FETCH_ASSOC)) {
    echo "Customer ID: " . $customer['customer_id'] . "<br>";
    echo "Tên khách hàng: " . $customer['customer_name'] . "<br>";
    echo "Email: " . $customer['email'] . "<br>";
    echo "Địa chỉ: " . $customer['address'] . "<br>";
    echo "Số điện thoại: " . $customer['phone'] . "<br>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='delete_customer_id' value='" . $customer['customer_id'] . "'>";
    echo "<input type='submit' value='Xóa'>";
    echo "</form>";
    echo "<br>";
}

sqlsrv_close($conn);
?>
<a href="listorder.php">Quay lại</a>
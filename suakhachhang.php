<?php 
    include "../config/config.php";
?>

<?php

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;

// Hiển thị thông tin khách hàng có customer_id tương ứng
if ($customer_id) {
    $sqlGetCustomer = "SELECT * FROM Customers WHERE customer_id = ?";
    $paramsGetCustomer = array($customer_id);

    $stmtGetCustomer = sqlsrv_query($conn, $sqlGetCustomer, $paramsGetCustomer);
    if ($stmtGetCustomer === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $customer = sqlsrv_fetch_array($stmtGetCustomer, SQLSRV_FETCH_ASSOC);

    if (!$customer) {
        echo "Không tìm thấy khách hàng với customer_id = $customer_id";
    } else {
        echo "Thông tin khách hàng có customer_id = $customer_id:<br>";
        echo "Tên khách hàng: " . $customer['customer_name'] . "<br>";
        echo "Email: " . $customer['email'] . "<br>";
        echo "Địa chỉ: " . $customer['address'] . "<br>";
        echo "Số điện thoại: " . $customer['phone'] . "<br>";
    }
}

// Xử lý cập nhật thông tin khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_customer_name = $_POST['new_customer_name'];
    $new_email = $_POST['new_email'];
    $new_address = $_POST['new_address'];
    $new_phone = $_POST['new_phone'];

    $sqlUpdateCustomer = "UPDATE Customers SET customer_name = ?, email = ?, address = ?, phone = ? WHERE customer_id = ?";
    $paramsUpdateCustomer = array($new_customer_name, $new_email, $new_address, $new_phone, $customer_id);

    $stmtUpdateCustomer = sqlsrv_query($conn, $sqlUpdateCustomer, $paramsUpdateCustomer);
    if ($stmtUpdateCustomer === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Cập nhật thông tin khách hàng thành công";
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cập Nhật Thông Tin Khách Hàng</title>
    <link rel="stylesheet" href="suakhachhang.css">
</head>
<body>
    <div class="container">
        <form method="GET">
            <label for="customer_id">Nhập customer_id để xem thông tin khách hàng:</label>
            <input type="text" name="customer_id" id="customer_id" required>
            <input type="submit" value="Tìm khách hàng">
        </form>

        <?php if ($customer_id && $customer): ?>
            <div class="content">
                <h2>Thông tin cập nhật khách hàng:</h2>
                <form method="POST">
                    <label for="new_customer_name">Tên khách hàng mới:</label>
                    <input type="text" name="new_customer_name" id="new_customer_name" value="<?php echo $customer['customer_name']; ?>" required><br>

                    <label for="new_email">Email mới:</label>
                    <input type="email" name="new_email" id="new_email" value="<?php echo $customer['email']; ?>" required><br>

                    <label for="new_address">Địa chỉ mới:</label>
                    <input type="text" name="new_address" id="new_address" value="<?php echo $customer['address']; ?>" required><br>

                    <label for="new_phone">Số điện thoại mới:</label>
                    <input type="text" name="new_phone" id="new_phone" value="<?php echo $customer['phone']; ?>" required><br>

                    <input type="submit" value="Cập nhật thông tin khách hàng">
                </form>
            </div>
        <?php endif; ?>
    </div>
    <a href="listorder.php">Quay lại</a>
</body>
</html>

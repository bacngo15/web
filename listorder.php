<?php 
    include "../config/config.php";
?>
<?php

 
    if(isset($_GET['id'])){
        $rs = $conn->query("delete from product where product_id = ".$_GET['id']."");
        //echo "<script>alert('Xóa Thành Công!!.');</script>";
        sleep(1);
        header("location:listorder.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="listorder.css">
</head>
<body>
    <div class="container">
        <div class="menu">
            <a href="xoaorder.php">Xóa đơn hàng</a>
            <a href="suaorder.php">Sửa đơn hàng</a>
            <a href="suakhachhang.php">Sửa thông tin khách hàng</a>
            <a href="xoakhachhang.php">Xóa thông tin khách hàng</a>
            <a href="list.php">Quay lại</a>
        </div>
        <div class="content">
            <?php 
            sqlsrv_configure("ClientCharset", "UTF-8"); 
            // Lấy thông tin từ bảng Customers
            $sqlCustomers = "SELECT * FROM Customers";
            $stmtCustomers = sqlsrv_query($conn, $sqlCustomers);
            if ($stmtCustomers === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        
            echo "<h2>Thông tin khách hàng:</h2>";
            echo "<table>";
            echo "<tr><th>Customer ID</th><th>Tên khách hàng</th><th>Email</th><th>Địa chỉ</th><th>Số điện thoại</th></tr>";
            while ($row = sqlsrv_fetch_array($stmtCustomers, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        
            // Lấy thông tin từ bảng Orders
            $sqlOrders = "SELECT * FROM Orders";
            $stmtOrders = sqlsrv_query($conn, $sqlOrders);
            if ($stmtOrders === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        
            echo "<h2>Thông tin đơn hàng:</h2>";
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Customer ID</th><th>Ngày đặt hàng</th><th>Tổng giá trị</th></tr>";
            while ($row = sqlsrv_fetch_array($stmtOrders, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['order_id'] . "</td>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['order_date']->format('Y-m-d') . "</td>";
                echo "<td>" . $row['total_amount'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        
            // In thông tin từ bảng OrderItems
            $sqlOrderItems = "SELECT * FROM OrderItems";
            $stmtOrderItems = sqlsrv_query($conn, $sqlOrderItems);
            if ($stmtOrderItems === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        
            echo "<h2>Thông tin chi tiết đơn hàng:</h2>";
            echo "<table>";
            echo "<tr><th>Order Item ID</th><th>Order ID</th><th>Product ID</th><th>Số lượng</th></tr>";
            while ($orderItem = sqlsrv_fetch_array($stmtOrderItems, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $orderItem['order_item_id'] . "</td>";
                echo "<td>" . $orderItem['order_id'] . "</td>";
                echo "<td>" . $orderItem['product_id'] . "</td>";
                echo "<td>" . $orderItem['quantity'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            sqlsrv_close($conn);
            ?>
        </div>
    </div>
</body>
</html>

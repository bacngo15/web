<?php 
    include "../config.php";
?>
<?php
 $server = "LAPTOP-3P14SVIR";
 $conn = sqlsrv_connect( $server, array( 'Database' => 'ClothingStoreDB' ) ); 
 
    if(isset($_GET['id'])){
        $rs = $conn->query("delete from product where product_id = ".$_GET['id']."");
        //echo "<script>alert('Xóa Thành Công!!.');</script>";
        sleep(1);
        header("location:listsp.php");
    }
?>
<a href="them.php">Thêm Sản Phẩm</a>
<?php 
    sqlsrv_configure("ClientCharset", "UTF-8"); 
     // Lấy thông tin từ bảng Products
     $sqlProducts = "SELECT * FROM Products";
     $stmtProducts = sqlsrv_query($conn, $sqlProducts);
     if ($stmtProducts === false) {
         die(print_r(sqlsrv_errors(), true));
     }
 
     echo "<h2>Thông tin sản phẩm:</h2>";
     echo "<table>";
     echo "<tr><th>Product ID</th><th>Tên sản phẩm</th><th>Mô tả</th><th>Giá</th><th>Danh mục ID</th><th>URL hình ảnh</th></tr>";
     while ($row = sqlsrv_fetch_array($stmtProducts, SQLSRV_FETCH_ASSOC)) {
         echo "<tr>";
         echo "<td>" . $row['product_id'] . "</td>";
         echo "<td>" . $row['name'] . "</td>";
         echo "<td>" . $row['description'] . "</td>";
         echo "<td>" . $row['price'] . "</td>";
         echo "<td>" . $row['category_id'] . "</td>";
         echo "<td>" . $row['image_url'] . "</td>";
         echo "</tr>";
     }
     echo "</table>";
 
     // Lấy thông tin từ bảng Size_Product
     $sqlSizeProduct = "SELECT * FROM Size_Product";
     $stmtSizeProduct = sqlsrv_query($conn, $sqlSizeProduct);
     if ($stmtSizeProduct === false) {
         die(print_r(sqlsrv_errors(), true));
     }
 
     echo "<h2>Thông tin size sản phẩm:</h2>";
     echo "<table>";
     echo "<tr><th>Size ID</th><th>Product ID</th><th>Size</th><th>Số lượng trong kho</th></tr>";
     while ($row = sqlsrv_fetch_array($stmtSizeProduct, SQLSRV_FETCH_ASSOC)) {
         echo "<tr>";
         echo "<td>" . $row['size_id'] . "</td>";
         echo "<td>" . $row['product_id'] . "</td>";
         echo "<td>" . $row['size'] . "</td>";
         echo "<td>" . $row['SoLuongTrongKho'] . "</td>";
         echo "</tr>";
     }
     echo "</table>";
 
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
 
     sqlsrv_close($conn);
?>

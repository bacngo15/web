<?php
include "../config/config.php";
if (isset($_POST["txtDN"])) {
    if ($_POST["txtUser"] == "" || $_POST["txtPass"] == "") {
        echo "<script>alert('Chưa nhập đầy đủ thông tin');</script>";
    } else {

        $stmt = sqlsrv_query($conn, "SELECT * FROM Admin WHERE account = '" . $_POST["txtUser"] . "' and password = '" . $_POST["txtPass"] . "' ",
            array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));

        $row_count = sqlsrv_num_rows($stmt);
        if ($row_count > 0) {
            header("location:list.php");
        } else {
            echo "<script>alert('Mật khẩu hoặc tài khoản chưa chính xác!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng Nhập Admin</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <h1>Đăng nhập trang quản trị</h1>
        <form action="index.php" method="post">
            <label for="txtUser">Tên Đăng Nhập:</label>
            <input type="text" name="txtUser" id="txtUser" required>
            <label for="txtPass">Mật Khẩu:</label>
            <input type="password" name="txtPass" id="txtPass" required>
            <input type="submit" name="txtDN" value="Đăng Nhập">
        </form>
    </div>
</body>
</html>

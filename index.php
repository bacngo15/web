<?php
    include "../config/config.php";
    if(isset($_POST["txtDN"])){
        if(($_POST["txtUser"] == "")|| ($_POST["txtPass"] == "")){
            echo "<script>alert('chưa nhập đầy đủ thông tin');</script>";
        }else{
            

            $stmt = sqlsrv_query( $conn,"SELECT * FROM Admin WHERE account = '".$_POST["txtUser"]."' and password = '".$_POST["txtPass"]."' ", 
            array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));

            $row_count = sqlsrv_num_rows( $stmt );
            if($row_count >0){
                header("location:list.php"); 
            }
            else{
                echo "<script>alert('mật khẩu hoặc tài khoản chưa chính xác!');</script>";
            }
            
        }
    }
?>
<table border=1>
    
        <form action="index.php" method="post">
            <tr>
                <th>Tên Đăng Nhập:</th><td><input type="text" name="txtUser" /></td>
            </tr>
            <tr>
                <th> Mật Khẩu:</th><td><input type="text" name="txtPass" /></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" name="txtDN" value="Đăng Nhập" /></th>
            </tr>
        </form>
    
</table>


<?php
//sử dụng file connect.php
//require/include
include "connect.php";
//6. Kiểm tra phương thức gửi dữ liệu của form: POST?
//Khai báo biến $fullname, khởi tạo giá trị biến $fullname = 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Kiểm tra xem email đã tồn tại chưa
    //tạo query kiểm tra email trong toàn bộ bảng user
    $check_query = "SELECT * FROM Users WHERE Email = ?";
    //chuẩn bị câu lệnh query tuy nhiên dấu dữ liệu truyền vào
    $stmt = mysqli_prepare($conn, $check_query);

    if ($stmt) {
        //truyền giá trị cho biến trong câu lệnh query qua functionmysqli_stmt_bind_param
        mysqli_stmt_bind_param($stmt, "s", $email);
        //Thực hiện câu lệnh query qua funct mysqli_stmt_execute
        mysqli_stmt_execute($stmt);
        //Lấy kết quả query qua funct mysqli_stmt_store_result
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "Email đã tồn tại. Vui lòng chọn email khác.";
        } else {
            // Email chưa tồn tại, thêm người dùng mới
            $insert_query = "INSERT INTO Users (FullName, Email, PasswordHash, PhoneNumber, Address) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_query);

            if ($stmt_insert) {
                mysqli_stmt_bind_param($stmt_insert, "sssss", $fullname, $email, $password, $phone, $address);
                if (mysqli_stmt_execute($stmt_insert)) {
                    // Đăng ký thành công, chuyển sang form đăng nhập
                    header("Location: login.html");
                    exit();
                } else {
                    echo "Lỗi khi thêm người dùng: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                echo "Lỗi chuẩn bị truy vấn đăng ký: " . mysqli_error($conn);
            }
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Lỗi truy vấn kiểm tra email: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role']; // Lấy giá trị từ form

    $check_query = "SELECT * FROM Users WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $check_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error_message = "Email đã tồn tại. Vui lòng chọn email khác.";
        } else {
            $insert_query = "INSERT INTO Users (FullName, Email, PasswordHash, PhoneNumber, Address, Role) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_query);

            if ($stmt_insert) {
                mysqli_stmt_bind_param($stmt_insert, "ssssss", $fullname, $email, $password, $phone, $address, $role);
                if (mysqli_stmt_execute($stmt_insert)) {
                    header("Location: login.php");
                    exit();
                } else {
                    $error_message = "Lỗi khi thêm người dùng: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                $error_message = "Lỗi chuẩn bị truy vấn đăng ký: " . mysqli_error($conn);
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Lỗi truy vấn kiểm tra email: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký | Bệnh viện BTEC FPT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff7f0;
      font-family: 'Roboto', sans-serif;
    }
    .form-container {
      max-width: 520px;
      margin: 60px auto;
      padding: 35px 30px;
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    h2 {
      color: #ff6f00;
      text-align: center;
      margin-bottom: 25px;
    }
    label {
      font-weight: 500;
      margin-top: 12px;
    }
    .form-control {
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 15px;
    }
    .btn-custom {
      background-color: #ff6f00;
      color: white;
      font-weight: bold;
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: none;
    }
    .btn-custom:hover {
      background-color: #e65c00;
    }
    .form-select {
      border-radius: 8px;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Đăng ký tài khoản</h2>

  <?php if (!empty($error_message)): ?>
    <p class="error"><?= $error_message ?></p>
  <?php endif; ?>

  <form method="POST">
    <label for="fullname">Họ và tên:</label>
    <input type="text" class="form-control" id="fullname" name="fullname" required>

    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" name="email" required>

    <label for="password">Mật khẩu:</label>
    <input type="password" class="form-control" id="password" name="password" required>

    <label for="phone">Số điện thoại:</label>
    <input type="text" class="form-control" id="phone" name="phone">

    <label for="address">Địa chỉ:</label>
    <input type="text" class="form-control" id="address" name="address">

    <div class="mb-3">
      <label for="role" class="form-label">Vai trò:</label>
      <select id="role" name="role" class="form-select" required>
        <option value="" selected disabled>-- Chọn vai trò --</option>
        <option value="user">Người dùng</option>
        <option value="admin">Quản trị viên</option>
      </select>
    </div>

    <button type="submit" class="btn btn-custom mt-3">Đăng ký</button>
  </form>

  <p class="mt-3 text-center">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</div>

</body>
</html>

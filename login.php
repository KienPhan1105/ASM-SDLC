<?php
session_start();
include "connect.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // Dùng role từ form gửi lên

    $query = "SELECT UserID, FullName, PasswordHash FROM Users WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $userid, $fullname, $hashed_password);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $userid;
                $_SESSION['user_name'] = $fullname;
                $_SESSION['role'] = $role;

                // Điều hướng theo vai trò đã chọn từ form
                if ($role === 'admin') {
                    header("Location: ./admin/admin.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $error = "❌ Mật khẩu không đúng.";
            }
        } else {
            $error = "❌ Không tìm thấy tài khoản với email này.";
        }
    } else {
        $error = "❌ Lỗi truy vấn.";
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập | Bệnh viện BTEC FPT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #fff7f0;
    }
    .form-container {
      max-width: 430px;
      margin: 80px auto;
      background-color: #fff;
      padding: 35px 30px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #ff6f00;
      margin-bottom: 30px;
      font-weight: bold;
    }
    label {
      font-weight: 500;
      margin-top: 15px;
    }
    .form-control, .form-select {
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 10px;
    }
    .form-select:focus, .form-control:focus {
      border-color: #ff6f00;
      box-shadow: 0 0 0 0.2rem rgba(255, 111, 0, 0.25);
    }
    .btn-login {
      width: 100%;
      background-color: #ff6f00;
      color: white;
      padding: 10px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      transition: background-color 0.3s;
    }
    .btn-login:hover {
      background-color: #e65c00;
    }
    .form-footer {
      text-align: center;
      margin-top: 15px;
    }
    .form-footer a {
      color: #ff6f00;
      font-weight: 500;
      text-decoration: none;
    }
    .form-footer a:hover {
      text-decoration: underline;
    }
    .error {
      background-color: #ffe3e3;
      color: #b70000;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 15px;
      text-align: center;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Đăng nhập</h2>

  <?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form action="login.php" method="POST">
    <div class="mb-3">
      <label for="email" class="form-label">Email:</label>
      <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Mật khẩu:</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Vai trò:</label>
      <select id="role" name="role" class="form-select" required>
        <option value="" selected disabled>-- Chọn vai trò --</option>
        <option value="user">Người dùng</option>
        <option value="admin">Quản trị viên</option>
      </select>
    </div>

    <button type="submit" class="btn-login">Đăng nhập</button>
  </form>

  <div class="form-footer">
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
  </div>
</div>

</body>
</html>
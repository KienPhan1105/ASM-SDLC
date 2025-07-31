<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu và loại bỏ khoảng trắng thừa
    $fullname = trim($_POST['fullname']);
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $service  = trim($_POST['service']);
    $doctor   = trim($_POST['doctor']);
    $date     = trim($_POST['date']);
    $time     = trim($_POST['time']);
    $note     = trim($_POST['note']);

    // Kiểm tra dữ liệu bắt buộc
    if (empty($fullname) || empty($phone) || empty($service) || empty($doctor) || empty($date) || empty($time)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin bắt buộc.'); history.back();</script>";
        exit();
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO appointments (fullname, phone, email, service, doctor, date, time, note)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss",
            $fullname, $phone, $email, $service, $doctor, $date, $time, $note);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Đặt lịch khám thành công!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi đặt lịch. Vui lòng thử lại.'); history.back();</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Lỗi kết nối CSDL.'); history.back();</script>";
    }

    mysqli_close($conn);
} else {
    echo "Truy cập không hợp lệ.";
}
?>


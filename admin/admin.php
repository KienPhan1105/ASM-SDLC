<?php
include '../connect.php';
session_start();

// Xử lý thêm hoặc cập nhật bác sĩ
if (isset($_POST['save_doctor'])) {
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $available_days = trim($_POST['available_days'] ?? '');
    $available_times = trim($_POST['available_times'] ?? '');
    $note = trim($_POST['note'] ?? '');

    if ($id) {
        $sql = "UPDATE doctor SET name=?, specialty=?, phone=?, email=?, available_days=?, available_times=?, note=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssi", $name, $specialty, $phone, $email, $available_days, $available_times, $note, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    } else {
        $sql = "INSERT INTO doctor (name, specialty, phone, email, available_days, available_times, note) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $specialty, $phone, $email, $available_days, $available_times, $note);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: admin.php");
    exit();
}

if (isset($_GET['delete_doctor'])) {
    $id = $_GET['delete_doctor'];
    mysqli_query($conn, "DELETE FROM doctor WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// Xử lý thêm hoặc cập nhật hóa đơn
if (isset($_POST['save_payment'])) {
    $id = $_POST['payment_id'] ?? '';
    $order_id = trim($_POST['order_id'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if ($id) {
        $sql = "UPDATE payments SET order_id=?, amount=?, status=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $order_id, $amount, $status, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: admin.php");
    exit();
}

if (isset($_GET['delete_payment'])) {
    $id = $_GET['delete_payment'];
    mysqli_query($conn, "DELETE FROM payments WHERE id=$id");
    header("Location: admin.php");
    exit();
}

// Xử lý thêm hoặc cập nhật lịch hẹn
if (isset($_POST['save_appointment'])) {
    $id = $_POST['appointment_id'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $doctor = trim($_POST['doctor'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');
    $note = trim($_POST['note_appointment'] ?? '');

    if ($id) {
        $sql = "UPDATE appointments SET fullname=?, email=?, phone=?, doctor=?, date=?, time=?, note=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssi", $fullname, $email, $phone, $doctor, $date, $time, $note, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
    header("Location: admin.php");
    exit();
}

if (isset($_GET['delete_appointment'])) {
    $id = $_GET['delete_appointment'];
    mysqli_query($conn, "DELETE FROM appointments WHERE id=$id");
    header("Location: admin.php");
    exit();
}

$doctors = mysqli_query($conn, "SELECT * FROM doctor");
$payments = mysqli_query($conn, "SELECT * FROM payments");
$appointments = mysqli_query($conn, "SELECT * FROM appointments");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang Quản Trị</title>
  <link rel="stylesheet" href="admin.css">
  <script src="admin.js"></script>
</head>
<body>
<div class="container">
  <h1 style="text-align:center;color:#f37021">TRANG QUẢN TRỊ</h1>
  <div class="btn-group" style="text-align:center;margin-bottom:20px">
    <button onclick="showSection('section-doctor')" class="btn">Quản lý Bác sĩ</button>
    <button onclick="showSection('section-payment')" class="btn">Quản lý Hóa đơn</button>
    <button onclick="showSection('section-appointment')" class="btn">Quản lý Đặt lịch</button>
  </div>

  <div id="section-doctor" class="form-section">
    <form method="POST">
        <input type="hidden" name="id" id="doctor_id">
        <input type="text" name="name" id="doctor_name" placeholder="Tên bác sĩ" required>
        <input type="text" name="specialty" id="doctor_specialty" placeholder="Chuyên khoa" required>
        <input type="text" name="phone" id="doctor_phone" placeholder="Số điện thoại" required>
        <input type="email" name="email" id="doctor_email" placeholder="Email" required>
        <input type="text" name="available_days" id="doctor_available_days" placeholder="Ngày làm việc" required>
        <input type="text" name="available_times" id="doctor_available_times" placeholder="Giờ làm việc" required>
        <input type="text" name="note" id="doctor_note" placeholder="Ghi chú">
        <button type="submit" name="save_doctor" class="btn">Lưu</button>
    </form>
    <table>
      <tr><th>ID</th><th>Tên</th><th>Chuyên khoa</th><th>SĐT</th><th>Email</th><th>Ngày</th><th>Giờ</th><th>Ghi chú</th><th>Hành động</th></tr>
      <?php while ($row = mysqli_fetch_assoc($doctors)): ?>
      <tr>
        <td><?= $row['id'] ?></td><td><?= $row['name'] ?></td><td><?= $row['specialty'] ?></td><td><?= $row['phone'] ?></td>
        <td><?= $row['email'] ?></td><td><?= $row['available_days'] ?></td><td><?= $row['available_times'] ?></td><td><?= $row['note'] ?></td>
        <td>
          <button type="button" class="btn" onclick="editDoctor(<?= $row['id'] ?>, <?= json_encode($row['name']) ?>, <?= json_encode($row['specialty']) ?>, <?= json_encode($row['phone']) ?>, <?= json_encode($row['email']) ?>, <?= json_encode($row['available_days']) ?>, <?= json_encode($row['available_times']) ?>, <?= json_encode($row['note']) ?>)">Sửa</button>
          <a href="?delete_doctor=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Xóa bác sĩ này?')">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div id="section-payment" class="form-section" style="display:none">
    <form method="POST">
        <input type="hidden" name="payment_id" id="payment_id">
        <input type="text" name="order_id" id="payment_order_id" placeholder="Mã đơn hàng" required>
        <input type="text" name="amount" id="payment_amount" placeholder="Số tiền" required>
        <input type="text" name="status" id="payment_status" placeholder="Trạng thái" required>
        <button type="submit" name="save_payment" class="btn">Lưu</button>
    </form>
    <table>
      <tr><th>ID</th><th>Mã đơn hàng</th><th>Số tiền</th><th>Trạng thái</th><th>Ngày tạo</th><th>Hành động</th></tr>
      <?php while ($row = mysqli_fetch_assoc($payments)): ?>
      <tr>
        <td><?= $row['id'] ?></td><td><?= $row['order_id'] ?></td><td><?= $row['amount'] ?></td><td><?= $row['status'] ?></td><td><?= $row['created_at'] ?></td>
        <td>
          <button type="button" class="btn" onclick="editPayment(<?= $row['id'] ?>, <?= json_encode($row['order_id']) ?>, <?= json_encode($row['amount']) ?>, <?= json_encode($row['status']) ?>)">Sửa</button>
          <a href="?delete_payment=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Xóa hóa đơn này?')">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div id="section-appointment" class="form-section" style="display:none">
    <form method="POST">
        <input type="hidden" name="appointment_id" id="appointment_id">
        <input type="text" name="fullname" id="appointment_fullname" placeholder="Họ tên" required>
        <input type="email" name="email" id="appointment_email" placeholder="Email" required>
        <input type="text" name="phone" id="appointment_phone" placeholder="SĐT" required>
        <input type="text" name="doctor" id="appointment_doctor" placeholder="Bác sĩ" required>
        <input type="text" name="date" id="appointment_date" placeholder="Ngày" required>
        <input type="text" name="time" id="appointment_time" placeholder="Giờ" required>
        <input type="text" name="note_appointment" id="appointment_note" placeholder="Ghi chú">
        <button type="submit" name="save_appointment" class="btn">Lưu</button>
    </form>
    <table>
      <tr><th>ID</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Bác sĩ</th><th>Ngày</th><th>Giờ</th><th>Ghi chú</th><th>Hành động</th></tr>
      <?php while ($row = mysqli_fetch_assoc($appointments)): ?>
      <tr>
        <td><?= $row['id'] ?></td><td><?= $row['fullname'] ?></td><td><?= $row['email'] ?></td><td><?= $row['phone'] ?></td><td><?= $row['doctor'] ?></td><td><?= $row['date'] ?></td><td><?= $row['time'] ?></td><td><?= $row['note'] ?></td>
        <td>
          <button type="button" class="btn" onclick="editAppointment(<?= $row['id'] ?>, <?= json_encode($row['fullname']) ?>, <?= json_encode($row['email']) ?>, <?= json_encode($row['phone']) ?>, <?= json_encode($row['doctor']) ?>, <?= json_encode($row['date']) ?>, <?= json_encode($row['time']) ?>, <?= json_encode($row['note']) ?>)">Sửa</button>
          <a href="?delete_appointment=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Xóa lịch hẹn này?')">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body>
</html>
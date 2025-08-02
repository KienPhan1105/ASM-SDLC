<?php
session_start();
include '../connect.php';

// Xử lý thêm hoặc cập nhật bác sĩ
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_doctor'])) {
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name']);
    $specialty = trim($_POST['specialty']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $available_days = trim($_POST['available_days']);
    $available_times = trim($_POST['available_times']);
    $note = trim($_POST['note']);

    if ($id) {
        // UPDATE
        $sql = "UPDATE doctor SET name=?, specialty=?, phone=?, email=?, available_days=?, available_times=?, note=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $name, $specialty, $phone, $email, $available_days, $available_times, $note, $id);
    } else {
        // INSERT
        $sql = "INSERT INTO doctor (name, specialty, phone, email, available_days, available_times, note) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $specialty, $phone, $email, $available_days, $available_times, $note);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

// Xử lý xóa bác sĩ
if (isset($_GET['delete_doctor'])) {
    $id = $_GET['delete_doctor'];
    $sql = "DELETE FROM doctor WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: admin.php");
    exit();
}

// Xử lý thêm hoặc cập nhật hóa đơn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_payment'])) {
    $id = $_POST['payment_id'] ?? '';
    $appointment_id = $_POST['appointment_id'];
    $order_id = trim($_POST['order_id']);
    $amount = trim($_POST['amount']);
    $status = trim($_POST['status']);
    $created_at = date("Y-m-d H:i:s");

    if ($id) {
        $sql = "UPDATE payments SET appointment_id=?, order_id=?, amount=?, status=?, created_at=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issssi", $appointment_id, $order_id, $amount, $status, $created_at, $id);
    } else {
        $sql = "INSERT INTO payments (appointment_id, order_id, amount, status, created_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issss", $appointment_id, $order_id, $amount, $status, $created_at);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

// Xử lý xóa hóa đơn
if (isset($_GET['delete_payment'])) {
    $id = $_GET['delete_payment'];
    $sql = "DELETE FROM payments WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: admin.php");
    exit();
}

// Xử lý thêm hoặc cập nhật lịch hẹn
if (isset($_POST['save_appointment'])) {
    $id = $_POST['appointment_id'] ?? '';
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $doctor = trim($_POST['doctor']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $note = trim($_POST['note_appointment']);

    if ($id) {
        $sql = "UPDATE appointments SET fullname=?, email=?, phone=?, doctor=?, date=?, time=?, note=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $fullname, $email, $phone, $doctor, $date, $time, $note, $id);
    } else {
        $sql = "INSERT INTO appointments (fullname, email, phone, doctor, date, time, note) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $fullname, $email, $phone, $doctor, $date, $time, $note);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

// Xử lý xóa lịch hẹn
if (isset($_GET['delete_appointment'])) {
    $id = $_GET['delete_appointment'];
    $sql = "DELETE FROM appointments WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: admin.php");
    exit();
}

$doctors = mysqli_query($conn, "SELECT id, name, specialty, phone, email, available_days, available_times, note FROM doctor");
$payments = mysqli_query($conn, "SELECT id, appointment_id, order_id, amount, status, created_at FROM payments");
$appointments = mysqli_query($conn, "SELECT id, fullname, phone, email, doctor, date, time, note FROM appointments");
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <!-- Quản lí bác sĩ -->
  <div id="section-doctor" class="form-section" style="display:none;">
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
      <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Chuyên khoa</th>
        <th>SĐT</th>
        <th>Email</th>
        <th>Ngày</th>
        <th>Giờ</th>
        <th>Ghi chú</th>
        <th>Hành động</th>
    </tr>
      <?php while ($row = mysqli_fetch_assoc($doctors)): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name'])?></td>
        <td><?= htmlspecialchars($row['specialty'])?></td>
        <td><?= htmlspecialchars($row['phone'])?></td>
        <td><?= htmlspecialchars($row['email'])?></td>
        <td><?= htmlspecialchars($row['available_days'])?></td>
        <td><?= htmlspecialchars($row['available_times'])?></td>
        <td><?= htmlspecialchars($row['note'])?></td>
        <td>
        <button class="btn edit-btn" onclick="editDoctor(
        '<?= $row['id'] ?>', 
        '<?= htmlspecialchars($row['name']) ?>', 
        '<?= htmlspecialchars($row['specialty']) ?>', 
        '<?= htmlspecialchars($row['phone']) ?>', 
        '<?= htmlspecialchars($row['email']) ?>', 
        '<?= htmlspecialchars($row['available_days']) ?>', 
        '<?= htmlspecialchars($row['available_times']) ?>', 
        '<?= htmlspecialchars($row['note']) ?>'
        )">Sửa</button>
          <a href="?delete_doctor=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Xóa bác sĩ này?')">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
    </div>

    <!-- Quản lí hóa đơn -->
    <div id="section-payment" class="form-section" style="display:none">
    <form method="POST">
        <input type="hidden" name="payment_id" id="payment_id">
        <input type="text" name="appointment_id" id="payment_appointment_id" placeholder="Mã đặt lịch" required>
        <input type="text" name="order_id" id="payment_order_id" placeholder="Mã đơn hàng" required>
        <input type="text" name="amount" id="payment_amount" placeholder="Số tiền" required>
        <input type="text" name="status" id="payment_status" placeholder="Trạng thái" required>
        <button type="submit" name="save_payment" class="btn">Lưu</button>
    </form>
    <table>
      <tr>
        <th>ID</th>
        <th>Mã đặt lịch</th>
        <th>Mã đơn hàng</th>
        <th>Số tiền</th>
        <th>Trạng thái</th>
        <th>Ngày tạo</th>
        <th>Hành động</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($payments)): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['appointment_id']) ?></td>
        <td><?= htmlspecialchars($row['order_id']) ?></td>
        <td><?= htmlspecialchars($row['amount']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td><?= htmlspecialchars($row['created_at']) ?></td>
        <td>
          <button type="button" class="btn" onclick="editPayment(
          '<?= $row['id'] ?>',
          '<?= htmlspecialchars($row['appointment_id']) ?>',
          '<?= htmlspecialchars($row['order_id']) ?>',
          '<?= htmlspecialchars($row['amount']) ?>',
          '<?= htmlspecialchars($row['status']) ?>',
          '<?= htmlspecialchars($row['created_at']) ?>'
      )">Sửa </button>
          <a href="?delete_payment=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Xóa bác sĩ này?')">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <!-- Quản lí đặt lịch -->
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
      <tr>
        <th>ID</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>SĐT</th>
        <th>Bác sĩ</th>
        <th>Ngày</th>
        <th>Giờ</th>
        <th>Ghi chú</th>
        <th>Hành động</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($appointments)): ?>
      <tr>
        <td>
          <?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['email'])?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['doctor'])?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td><?= htmlspecialchars($row['time']) ?></td>
          <td><?= htmlspecialchars($row['note']) ?></td>
        <td>
          <button type="button" class="btn" onclick="editAppointment(
          '<?= $row['id'] ?>',
          '<?= htmlspecialchars($row['fullname']) ?>',
          '<?= htmlspecialchars($row['email']) ?>',
          '<?= htmlspecialchars($row['phone']) ?>',
          '<?= htmlspecialchars($row['doctor']) ?>',
          '<?= htmlspecialchars($row['date']) ?>',
          '<?= htmlspecialchars($row['time']) ?>',
          '<?= htmlspecialchars($row['note']) ?>'
          )">Sửa </button>
          <a href="?delete_appointment=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Xóa đặt lịch này?')">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body>
</html>

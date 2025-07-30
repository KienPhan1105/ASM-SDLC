<?php
// qr.php
include 'connect.php';

$total = isset($_POST['total']) ? (int)$_POST['total'] : 0;
$invoice_id = isset($_POST['invoice_id']) ? (int)$_POST['invoice_id'] : 0;
$appointment_id = isset($_POST['appointment_id']) ? (int)$_POST['appointment_id'] : 0;

$order_id = '';
$patient_name = '';

// Trường hợp hóa đơn đã có
if (!empty($invoice_id)) {
    $stmt = $conn->prepare("SELECT p.id, p.order_id, p.amount, a.fullname 
                            FROM payments p 
                            LEFT JOIN appointments a ON p.appointment_id = a.id
                            WHERE p.id = ?");
    $stmt->bind_param("i", $invoice_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($payment = $result->fetch_assoc()) {
        $order_id = $payment['order_id'];
        $total = $payment['amount'];
        $patient_name = $payment['fullname'] ?? '';
    } else {
        die("Hóa đơn không tồn tại.");
    }
}
// Trường hợp tạo mới
elseif ($total > 0 && $appointment_id > 0) {
    $order_id = 'DH' . time() . rand(100, 999);
    $stmt = $conn->prepare("INSERT INTO payments (order_id, amount, status, appointment_id) VALUES (?, ?, 'pending', ?)");
    $stmt->bind_param("sii", $order_id, $total, $appointment_id);
    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id;

        // Lấy tên bệnh nhân từ bảng appointments
        $stmt2 = $conn->prepare("SELECT fullname FROM appointments WHERE id = ?");
        $stmt2->bind_param("i", $appointment_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($row = $result2->fetch_assoc()) {
            $patient_name = $row['fullname'];
        }
    } else {
        die("Lỗi tạo hóa đơn: " . $stmt->error);
    }
} else {
    die("Thiếu dữ liệu: tổng tiền hoặc lịch hẹn không hợp lệ.");
}
?>

<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Thanh Toán - QR Code</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .qr-image {
      max-width: 100%;
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 10px;
      background: white;
    }
    .info-label {
      font-weight: 600;
    }
    #statusBox {
      transition: all 0.3s ease;
    }
  </style>
</head>
<body>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card p-4">
        <h3 class="text-center text-success mb-3">Đơn hàng đã được tạo thành công</h3>
        <p class="text-center">Mã đơn hàng: <strong class="text-primary">#<?= htmlspecialchars($order_id) ?></strong></p>
        <?php if ($patient_name): ?>
          <p class="text-center mb-0">Bệnh nhân: <strong class="text-dark"><?= htmlspecialchars($patient_name) ?></strong></p>
        <?php endif; ?>

        <div class="row g-4 mt-3">
  <!-- QR Code và nút tải -->
  <div class="col-md-6 text-center">
    <p class="fw-bold">Quét mã QR để thanh toán</p>
    <img class="qr-image mb-2" 
         src="https://qr.sepay.vn/img?acc=0355676986&bank=MBBank&amount=<?= $total ?>&des=<?= $order_id ?>&template=compact" 
         alt="QR Code" style="max-width: 100%; height: auto;">
    <div class="mt-2">
      <a class="btn btn-outline-primary btn-sm" 
         href="https://qr.sepay.vn/img?acc=0355676986&bank=MBBank&amount=<?= $total ?>&des=<?= $order_id ?>&template=compact&download=true">
        Tải về mã QR
      </a>
    </div>
  </div>

  <!-- Thông tin ngân hàng -->
  <div class="col-md-6">
    <p class="fw-bold">Chuyển khoản thủ công:</p>
    <ul class="list-group">
      <li class="list-group-item d-flex justify-content-between">
        <span class="info-label">Ngân hàng:</span> <span>MBBank</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        <span class="info-label">Chủ tài khoản:</span> <span>PHAN TRUNG KIÊN</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        <span class="info-label">Số tài khoản:</span> 
        <span class="text-danger fw-bold">0355676986</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        <span class="info-label">Số tiền:</span> 
        <span class="text-primary fw-bold"><?= number_format($total, 0, ',', '.') ?>đ</span>
      </li>
      <li class="list-group-item d-flex justify-content-between">
        <span class="info-label">Nội dung:</span> 
        <span class="text-success fw-bold"><?= $order_id ?></span>
      </li>
    </ul>
  </div>
</div>
        <!-- Trạng thái thanh toán -->
        <div id="statusBox" class="alert alert-warning mt-4 text-center">
          Đang chờ thanh toán... <span class="spinner-border spinner-border-sm text-warning"></span>
        </div>

        <div class="text-center mt-2">
          <a href="pay.php" class="btn btn-secondary">← Quay lại</a>
          <a href="index.php" class="btn btn-secondary">Trang Chủ</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const invoiceId = <?= (int)$invoice_id ?>;
function checkStatus() {
  $.post("check_payment_status.php", { invoice_id: invoiceId }, function (data) {
    if (data.payment_status === "Paid") {
      $("#statusBox").removeClass("alert-warning")
                     .addClass("alert-success")
                     .html("✅ Đã thanh toán thành công!");
    }
  }, "json");
}
setInterval(checkStatus, 3000);
</script>
</body>
</html>
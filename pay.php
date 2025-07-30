<?php
// Kết nối database
include 'connect.php';

// Lấy danh sách hóa đơn từ database (có fullname để hiển thị)
$invoices = [];
$sql = "SELECT p.id, p.order_id, p.amount, a.fullname
        FROM payments p
        LEFT JOIN appointments a ON p.appointment_id = a.id
        WHERE p.status = 'pending'
        ORDER BY p.id DESC";
$result = $conn->query($sql);
if (!$result) {
  die("Lỗi SQL: " . $conn->error);
}
while ($row = $result->fetch_assoc()) {
  $invoices[] = $row;
}

// Lấy danh sách lịch hẹn để tạo đơn
$appointments = [];
$sql2 = "SELECT id, fullname, service, date, time FROM appointments ORDER BY id DESC";
$result2 = $conn->query($sql2);
if ($result2 && $result2->num_rows > 0) {
  while ($row = $result2->fetch_assoc()) {
    $appointments[] = $row;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SePay - Thanh toán lịch hẹn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
      --btec-orange: #f37021;
      --btec-orange-dark: #d35400;
    }

    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      border-radius: 16px;
      border: 1px solid #eee;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
      background-color: #ffffff;
    }

    .form-label {
      font-weight: 600;
      color: var(--btec-orange-dark);
    }

    h2 {
      color: var(--btec-orange);
    }

    .btn-success {
      background-color: var(--btec-orange-dark);
      border-color: var(--btec-orange-dark);
    }

    .btn-success:hover {
      background-color: var(--btec-orange);
      border-color: var(--btec-orange);
    }

    .form-select,
    .form-control {
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    .form-text {
      font-size: 0.875em;
      color: #666;
    }

    .container {
      background-color: #fffdf9;
      padding: 20px;
      border-radius: 12px;
    }

    select option {
      color: #000;
    }
  </style>
</head>
<body>


<div class="container my-5">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card p-4">
      <h2 class="mb-4 text-center" style="color: var(--btec-orange);">Tạo đơn thanh toán</h2>
      <form method="POST" action="qr.php">

        <input type="hidden" name="appointment_id" id="appointment_id">

        <!-- Số tiền -->
        <div class="mb-3">
          <label for="amountInput" class="form-label">Số tiền</label>
          <input type="number" name="total" class="form-control" id="amountInput" value="0" min="1000" required>
          <div class="form-text">Nhập số tiền để test hoặc chọn từ hóa đơn/lịch hẹn có sẵn.</div>
        </div>

        <!-- Chọn hóa đơn đã có -->
        <div class="mb-3">
          <label for="invoiceSelect" class="form-label">Chọn hóa đơn có sẵn</label>
          <select class="form-select" id="invoiceSelect" name="invoice_id" onchange="fillAmountFromInvoice()">
            <option value="">-- Chọn hóa đơn --</option>
            <?php foreach ($invoices as $inv): ?>
              <option value="<?= $inv['id']; ?>" data-amount="<?= $inv['amount']; ?>">
                <?= htmlspecialchars($inv['order_id']); ?> - <?= number_format($inv['amount'], 0, ',', '.'); ?>đ 
                (<?= htmlspecialchars($inv['fullname'] ?? 'Không rõ'); ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Chọn lịch hẹn -->
        <div class="mb-3">
          <label for="appointmentSelect" class="form-label">Hoặc chọn lịch hẹn để tạo hóa đơn</label>
          <select class="form-select" id="appointmentSelect" onchange="fillFromAppointment()">
            <option value="">-- Chọn lịch hẹn --</option>
            <?php foreach ($appointments as $apt): ?>
              <option value="<?= $apt['id']; ?>" 
                      data-info="<?= htmlspecialchars($apt['fullname']) ?> - <?= htmlspecialchars($apt['service']) ?> lúc <?= $apt['time'] ?> ngày <?= $apt['date'] ?>" 
                      data-amount="350000">
                <?= htmlspecialchars($apt['fullname']) ?> - <?= htmlspecialchars($apt['service']) ?> (<?= $apt['date'] ?>)
              </option>
            <?php endforeach; ?>
          </select>
          <div class="form-text">Mặc định: 350.000đ. Bạn có thể chỉnh sửa số tiền bên trên.</div>
        </div>

        <!-- Nút submit -->
        <button type="submit" class="btn btn-success w-100 mt-3">Tạo đơn thanh toán</button>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script>
function fillFromAppointment() {
  var select = document.getElementById('appointmentSelect');
  var amount = select.options[select.selectedIndex].getAttribute('data-amount');
  var appointmentId = select.value;
  if (amount) {
    document.getElementById('amountInput').value = amount;
  }
  document.getElementById('appointment_id').value = appointmentId;
}

function fillAmountFromInvoice() {
  var select = document.getElementById('invoiceSelect');
  var amount = select.options[select.selectedIndex].getAttribute('data-amount');
  if (amount) {
    document.getElementById('amountInput').value = amount;
  }
}

// Kiểm tra submit
document.querySelector('form').addEventListener('submit', function(e) {
  const invoice = document.getElementById('invoiceSelect').value;
  const appointment = document.getElementById('appointmentSelect').value;
  const amount = parseInt(document.getElementById('amountInput').value);

  if ((!invoice && !appointment) || isNaN(amount) || amount < 1000) {
    e.preventDefault();
    alert("Vui lòng chọn một hóa đơn hoặc lịch hẹn, và nhập số tiền hợp lệ (>= 1.000đ).");
    return;
  }

  if (invoice && appointment) {
    e.preventDefault();
    alert("Chỉ được chọn một trong hai: hóa đơn hoặc lịch hẹn.");
  }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
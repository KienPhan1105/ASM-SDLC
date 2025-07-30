<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thanh toán hóa đơn</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-warning">Thanh toán hóa đơn</h2>
    <p>Vui lòng nhập mã hóa đơn để kiểm tra và thanh toán:</p>
    <form>
      <div class="mb-3">
        <label for="billCode" class="form-label">Mã hóa đơn:</label>
        <input type="text" id="billCode" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-warning">Thanh toán</button>
    </form>
  </div>
</body>
</html>
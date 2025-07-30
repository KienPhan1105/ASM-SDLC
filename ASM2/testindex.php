<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bệnh viện BTEC FPT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #fff7f0;
    }
    header {
      background-color: #ff6f00;
      color: white;
    }
    .navbar-nav .nav-link {
      color: white !important;
    }
    .service-box {
      border-radius: 10px;
      background: white;
      padding: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      transition: transform 0.2s;
    }
    .service-box:hover {
      transform: translateY(-5px);
    }
    .service-box img {
      max-width: 100%;
      border-radius: 10px;
    }
    footer {
      background-color: #ff6f00;
      color: white;
      padding: 20px 0;
    }
    .top-bar a {
      margin: 0 10px;
      text-decoration: none;
      color: #ff6f00;
      font-weight: bold;
    }
  </style>
</head>
<body>

<!-- Thanh trên cùng -->
<div class="top-bar text-end pe-4 py-2 bg-white shadow-sm container d-flex justify-content-end align-items-center">
  <a href="login.html">Đăng nhập</a> | 
  <a href="register.html">Đăng ký</a>
</div>

<header class="py-3">
  <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        <img src="image/hospital.png" alt="BTEC Hospital Logo" width="150">
        <h1 class="h5 mb-0 text-white">Bệnh viện BTEC FPT</h1>
    </div>
    <nav class="navbar navbar-expand-md">
      <div class="container-fluid">
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item"><a class="nav-link" href="index.html">Trang chủ</a></li>
            <li class="nav-item"><a class="nav-link" href="oder.html">Đặt khám</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Tra cứu</a></li>
            <li class="nav-item"><a class="nav-link" href="https://bachmai.gov.vn">Cổng thông tin</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="text-end d-none d-md-block">
      <strong>Hotline:</strong> <a href="tel:19001018" class="text-white">1900 1018</a>
    </div>
  </div>
</header>

<main class="container my-5">
  <div class="text-center mb-4">
    <h2 class="text-warning">Các hình thức đặt khám</h2>
    <p>Vui lòng chọn dịch vụ bạn muốn sử dụng:</p>
  </div>
  <div class="row g-4 justify-content-center">
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="https://dkkham.bachmai.gov.vn/build/assets/stethoscope-1c43adff.png" alt="Khám bác sĩ">
        <p class="mt-2 fw-bold text-warning">Khám bác sĩ</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="https://dkkham.bachmai.gov.vn/build/assets/healthcare-ca9c18b6.png" alt="Chuyên khoa">
        <p class="mt-2 fw-bold text-warning">Chuyên khoa</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="https://dkkham.bachmai.gov.vn/build/assets/medical-book-5772752e.png" alt="Xét nghiệm">
        <p class="mt-2 fw-bold text-warning">Xét nghiệm</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="image/tiemchung.png" alt="Tiêm chủng">
        <p class="mt-2 fw-bold text-warning">Tiêm chủng</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
    <a href="pay.html" style="text-decoration: none;">
      <div class="service-box text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="Thanh toán hóa đơn">
        <p class="mt-2 fw-bold text-warning">Thanh toán hóa đơn</p>
      </div>
    </a>
  </div>
</div>
  
  
</div>
  <div class="text-center mt-5">
    <p class="fw-bold">Đặt lịch khám theo yêu cầu qua tổng đài:</p>
    <p class="text-danger fs-5">1900 1018</p>
    <p>Thời gian làm việc: <br> T2 - T6: 7:30–21:00 | T7 - CN: 7:30–16:30</p>
  </div>
</main>

<footer class="text-center">
  <div class="container">
    <p>&copy; 2025 Bệnh viện BTEC FPT</p>
    <p>
      Địa chỉ:
      <a href="https://www.google.com/maps?q=Tòa+D,+13+P.+Trịnh+Văn+Bô,+Xuân+Phương,+Nam+Từ+Liêm,+Hà+Nội"
         target="_blank"
         class="text-white text-decoration-underline">
         Tòa D, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội
      </a>
    </p>
  </div>
</footer>

<!-- Chat với AI -->
<div id="chat-widget" class="position-fixed bottom-0 end-0 m-3" style="z-index: 1050;">
  <div id="chat-box" class="card shadow-lg" style="width: 320px; display: none;">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
      <span>Trợ lý AI</span>
      <button type="button" class="btn-close btn-sm" onclick="toggleChat()"></button>
    </div>
    <div class="card-body p-2" style="height: 280px; overflow-y: auto;">
      <label for="message" class="form-label small">Nhập câu hỏi:</label>
      <textarea id="message" class="form-control mb-2" rows="3" placeholder="Ví dụ: tôi đang bị đau đầu..." required></textarea>
      <button id="sendBtn" class="btn btn-sm btn-warning w-100 text-white" onclick="sendMessage()">
        <span id="send-text">📨 Gửi câu hỏi</span>
        <span id="loading-icon" class="spinner-border spinner-border-sm visually-hidden ms-2" role="status"></span>
      </button>
      <div class="mt-2 small text-muted">📥 Phản hồi từ AI:</div>
      <div id="response" class="border rounded p-2 small" style="background:#f9f9f9; white-space:pre-line;">Chúng tôi sẽ trả lời bạn sớm nhất.</div>
    </div>
  </div>
  <button class="btn btn-warning rounded-circle shadow" style="width: 50px; height: 50px;" onclick="toggleChat()">💬</button>
</div>

<script>
  const prompt = `Bạn là một chuyên viên tư vấn bệnh viện, hãy cung cấp thông tin rõ ràng, ngắn gọn và chuyên sâu về các dịch vụ khám bệnh, giá cả và quy trình.`;
  let database_info = ""; // Không dùng PHP ở đây

  function toggleChat() {
    const box = document.getElementById("chat-box");
    box.style.display = box.style.display === "none" ? "block" : "none";
  }

  function sendMessage() {
    const msg = document.getElementById("message").value.trim();
    const responseDiv = document.getElementById("response");
    const btn = document.getElementById("sendBtn");
    const spinner = document.getElementById("loading-icon");
    const sendText = document.getElementById("send-text");

    if (!msg) {
      responseDiv.innerHTML = "❗ Vui lòng nhập nội dung câu hỏi.";
      return;
    }

    spinner.classList.remove("visually-hidden");
    sendText.textContent = "Đang gửi...";
    btn.disabled = true;

    const data = {
      contents: [{
        parts: [{
          text: prompt + "\n\n" + database_info + "\n\nCâu hỏi: " + msg
        }]
      }]
    };

    fetch('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-goog-api-key': 'AIzaSyB4jx2M8IkzDkxBCVF1HO1j5JxjVQgHakc'
      },
      body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
      if (data && data.candidates && data.candidates.length > 0) {
        const reply = data.candidates[0].content.parts[0].text;
        responseDiv.innerHTML = `<strong>AI:</strong><br>${reply}`;
      } else {
        responseDiv.innerHTML = "❌ Không có phản hồi từ AI.";
      }
    })
    .catch(err => {
      console.error("Lỗi:", err);
      responseDiv.innerHTML = "⚠️ Đã xảy ra lỗi khi gửi.";
    })
    .finally(() => {
      spinner.classList.add("visually-hidden");
      sendText.textContent = "📨 Gửi câu hỏi";
      btn.disabled = false;
    });
  }
</script>

</body>
</html>
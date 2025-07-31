<?php
session_start(); // BẮT BUỘC nếu dùng $_SESSION
include 'connect.php';
?>
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
    margin: 0;
    padding: 0;
  }

  header, footer {
    background-color: #ff6f00;
    color: white;
  }

  .navbar-nav .nav-link {
    color: white !important;
  }

  .top-bar a {
    margin: 0 10px;
    text-decoration: none;
    color: #ff6f00;
    font-weight: bold;
  }

  .service-box {
    border-radius: 10px;
    background: white;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s;
    height: 100%;
  }

  .service-box:hover {
    transform: translateY(-5px);
  }

  .service-box img {
    max-width: 100%;
    border-radius: 10px;
  }

  .slideshow {
  position: relative;
  width: 100vw; /* Chiếm toàn bộ chiều ngang trình duyệt */
  height: auto;
  aspect-ratio: 16 / 6; /* Tỷ lệ hình ảnh ngang, tùy chỉnh được */
  margin: 0 auto 30px;
  overflow: hidden;
  border-radius: 10px;
}

.slideshow img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  transition: opacity 0.5s ease-in-out;
}

.slideshow img.active {
  opacity: 1;
}

.dots {
  position: absolute;
  bottom: 10px;
  width: 100%;
  text-align: center;
  z-index: 2;
}

.dot {
  display: inline-block;
  width: 12px;
  height: 12px;
  margin: 0 5px;
  background: rgba(255, 255, 255, 0.4);
  border-radius: 50%;
  cursor: pointer;
}

.dot.active {
  background: #fff;
}


  .custom-orange-dark {
    color: #E65100;
  }

  .custom-btn {
    background-color: transparent;
    border: 1px solid #ff9f43;
    color: #ff9f43;
    transition: 0.3s;
  }

  .custom-btn:hover {
    background-color: #ff9f43;
    color: white;
    border-color: #ff9f43;
    box-shadow: 0 2px 6px rgba(255, 159, 67, 0.4);
  }
</style>

</head>
<body>

<!-- Thanh trên cùng -->
<div class="top-bar bg-light shadow-sm py-2 px-4 d-flex justify-content-between align-items-center border-bottom position-sticky top-0 z-3">
  <div class="logo fw-bold custom-orange-dark d-flex align-items-center fs-5">
    <i class="bi bi-hospital-fill me-2 fs-4"></i> BTEC FPT HOSPITAL
  </div>

  <div class="user-actions d-flex align-items-center">
    <?php if (isset($_SESSION['user_name'])): ?>
      <div class="d-flex align-items-center me-3">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=random" alt="User Avatar" class="rounded-circle shadow-sm me-2" width="36" height="36">
        <span class="fw-semibold text-dark">Xin chào, <strong><?php echo $_SESSION['user_name']; ?></strong></span>
      </div>
      <a href="logout.php" class="btn btn-sm btn-danger shadow-sm">Đăng xuất</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-sm custom-btn me-2">Đăng nhập</a>
      <a href="register.php" class="btn btn-sm custom-btn">Đăng ký</a>
    <?php endif; ?>
  </div>
</div>

<header class="py-3">
  <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
      <a href="index.php">
        <img src="image/hospital.png" alt="BTEC Hospital Logo" width="150">
      </a>
      <a href="index.php" class="h5 mb-0 text-white text-decoration-none">Bệnh viện BTEC FPT</a>
    </div>
    <nav class="navbar navbar-expand-md">
      <div class="container-fluid">
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
            <li class="nav-item"><a class="nav-link" href="oder.html">Đặt khám</a></li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#searchBar" role="button" aria-expanded="false" aria-controls="searchBar">
                Tra cứu
              </a>
            </li>
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

<!-- 🔍 Thanh tìm kiếm ẩn/hiện -->
<div class="container mt-3 collapse" id="searchBar">
  <form class="d-flex" action="search.php" method="get">
    <input class="form-control me-2" type="search" name="query" placeholder="Nhập thông tin cần tra cứu" aria-label="Search">
    <button class="btn btn-outline-primary" type="submit">Tìm</button>
  </form>
</div>

<div class="slideshow">
  <img src="image/bgr-hospital1.png" class="active">
  <img src="image/bgr-hospital2.png">
  <img src="image/bgr-hospital3.png">
  <div class="dots"></div>
</div>

<main class="container my-5">
  <div class="text-center mb-4">
    <h2 class="text-warning">Các hình thức đặt khám</h2>
    <p>Vui lòng chọn dịch vụ bạn muốn sử dụng:</p>
  </div>
  <div class="row g-4 justify-content-center">
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="image/khambs.png" alt="Khám bác sĩ">
        <p class="mt-2 fw-bold text-warning">Khám bác sĩ</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="image/chuyenkhoa.png" alt="Chuyên khoa">
        <p class="mt-2 fw-bold text-warning">Chuyên khoa</p>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="service-box text-center">
        <img src="image/xetnghiem.png" alt="Xét nghiệm">
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
      <a href="pay.php" class="text-decoration-none">
        <div class="service-box text-center">
          <img src="image/thanhtoan.png" alt="Thanh toán hóa đơn">
          <p class="mt-2 fw-bold text-warning">Thanh toán hóa đơn</p>
        </div>
      </a>
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

<!-- Các script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const imgs = document.querySelectorAll('.slideshow img');
  const dotsContainer = document.querySelector('.dots');
  let current = 0, timer;

  imgs.forEach((_, i) => {
    const d = document.createElement('span');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.onclick = () => { clearInterval(timer); show(i); start(); };
    dotsContainer.appendChild(d);
  });
  const dots = document.querySelectorAll('.dot');

  function show(i) {
    imgs.forEach((img, idx) => img.classList.toggle('active', idx === i));
    dots.forEach((dot, idx) => dot.classList.toggle('active', idx === i));
    current = i;
  }

  function next() { show((current + 1) % imgs.length); }

  function start() { timer = setInterval(next, 3000); }

  start();
</script>

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
  const prompt = `Chào bạn, với vai trò là chuyên viên tư vấn tại BTEC FPT Hospital, bạn hãy hỗ trợ 
  khách hàng một cách tận tình bằng cách cung cấp thông tin dễ hiểu, ngắn gọn và chính xác về các 
  dịch vụ khám bệnh, chi phí cũng như quy trình thăm khám.`;
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
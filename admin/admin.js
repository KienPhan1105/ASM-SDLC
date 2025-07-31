function showSection(id) {
  document.querySelectorAll('.form-section').forEach(e => e.style.display = 'none');
  document.getElementById(id).style.display = 'block';
}

// Bác sĩ
function editDoctor(id, name, specialty, phone, email, days, times, note) {
  showSection('section-doctor');
  document.getElementById('doctor_id').value = id;
  document.getElementById('doctor_name').value = name;
  document.getElementById('doctor_specialty').value = specialty;
  document.getElementById('doctor_phone').value = phone;
  document.getElementById('doctor_email').value = email;
  document.getElementById('doctor_available_days').value = days;
  document.getElementById('doctor_available_times').value = times;
  document.getElementById('doctor_note').value = note;
}

// Hóa đơn
function editPayment(id, orderId, amount, status) {
  showSection('section-payment');
  document.getElementById('payment_id').value = id;
  document.getElementById('payment_order_id').value = orderId;
  document.getElementById('payment_amount').value = amount;
  document.getElementById('payment_status').value = status;
}

// Đặt lịch
function editAppointment(id, fullname, email, phone, doctor, date, time, note) {
  showSection('section-appointment');
  document.getElementById('appointment_id').value = id;
  document.getElementById('appointment_fullname').value = fullname;
  document.getElementById('appointment_email').value = email;
  document.getElementById('appointment_phone').value = phone;
  document.getElementById('appointment_doctor').value = doctor;
  document.getElementById('appointment_date').value = date;
  document.getElementById('appointment_time').value = time;
  document.getElementById('appointment_note').value = note;
}
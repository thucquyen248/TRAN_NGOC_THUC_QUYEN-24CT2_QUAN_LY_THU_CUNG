<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Cổng Đăng Nhập & Đăng Ký</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Link CSS chuẩn Laravel -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="hologram-animated-body">

    <!-- KHUNG THÔNG BÁO TOAST NỔI GÓC PHẢI -->
    <div id="toast-box" class="toast-container"></div>

    <div id="auth-page" class="page active">
        <div class="auth-left">
            <div class="bg-slider">
                <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1552053831-71594a27632d?q=80&w=1200')"></div>
                <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?q=80&w=1200')"></div>
            </div>
            <div class="auth-caption">
                <h1 class="ppt-slide-in">Chăm sóc bé yêu <br> Chuyên nghiệp hơn mỗi ngày.</h1>
                <p class="ppt-fade-up">Hệ sinh thái Y tế - Spa - Khách sạn thú cưng tiêu chuẩn Quốc tế</p>
            </div>
        </div>

        <div class="auth-right">
            <div class="login-card holo-glass-card ppt-zoom-in">
                
                <!-- TAB CHUYỂN ĐỔI: KHÁCH HÀNG VS CÁN BỘ NỘI BỘ -->
                <div class="auth-role-tabs">
                    <button id="tab-cust" class="auth-tab-btn active" onclick="switchLoginMode('customer')">
                        <i class="fas fa-heart"></i> Khách Hàng
                    </button>
                    <button id="tab-staff" class="auth-tab-btn" onclick="switchLoginMode('internal')">
                        <i class="fas fa-user-shield"></i> Cán Bộ & Bác Sĩ
                    </button>
                </div>

                <!-- CỔNG 1: DÀNH CHO KHÁCH HÀNG -->
                <div id="customer-login-box">
                    <div id="cust-form-login">
                        <i class="fas fa-paw fa-3x" style="color: var(--primary); margin: 10px 0;"></i>
                        <h2>Khách Hàng Đăng Nhập</h2>
                        <p style="color:#666; font-size:13.5px; margin-bottom:15px;">Dành cho chủ nuôi đặt lịch & theo dõi hồ sơ bé</p>

                        <div class="input-group">
                            <label><i class="fas fa-envelope"></i> Email của bạn</label>
                            <input type="email" id="cust-email" placeholder="khachhang@petcare.com" value="khachhang@petcare.com" oninput="clearCustInputError()">
                        </div>
                        <div class="input-group">
                            <label><i class="fas fa-lock"></i> Mật khẩu</label>
                            <input type="password" id="cust-pass" placeholder="••••••••" value="123456" oninput="clearCustInputError()" onkeypress="if(event.key==='Enter') handleCustomerLogin()">
                            <span id="cust-login-err" class="field-error-text"></span>
                        </div>
                        <button class="btn-login" onclick="handleCustomerLogin()">ĐĂNG NHẬP NGAY</button>
                        <p style="text-align:center; margin-top:15px; font-size:13px; color:#555;">
                            Chưa có tài khoản? <a href="javascript:void(0)" onclick="toggleCustForm('register')" style="color:var(--primary); font-weight:700;">Đăng ký tài khoản mới</a>
                        </p>
                    </div>

                    <!-- Form Đăng Ký Khách Hàng -->
                    <div id="cust-form-register" style="display:none;">
                        <i class="fas fa-user-plus fa-3x" style="color: var(--secondary); margin: 10px 0;"></i>
                        <h2>Đăng Ký Khách Hàng</h2>
                        <p style="color:#666; font-size:13.5px; margin-bottom:15px;">Tạo hồ sơ chăm sóc bé cưng miễn phí</p>

                        <div class="input-group">
                            <label>Họ và tên</label>
                            <input type="text" id="reg-name" placeholder="Nguyễn Văn A">
                            <span id="err-reg-name" class="field-error-text"></span>
                        </div>
                        <div class="input-group">
                            <label>Số điện thoại</label>
                            <input type="tel" id="reg-phone" placeholder="0901 234 567">
                            <span id="err-reg-phone" class="field-error-text"></span>
                        </div>
                        <div class="input-group">
                            <label>Email liên hệ</label>
                            <input type="email" id="reg-email" placeholder="email@petcare.com">
                            <span id="err-reg-email" class="field-error-text"></span>
                        </div>
                        <div class="input-group">
                            <label>Mật khẩu</label>
                            <input type="password" id="reg-pass" placeholder="••••••••" onkeypress="if(event.key==='Enter') handleCustomerRegister()">
                            <span id="err-reg-pass" class="field-error-text"></span>
                        </div>
                        <button class="btn-login" onclick="handleCustomerRegister()">HOÀN TẤT ĐĂNG KÝ</button>
                        <p style="text-align:center; margin-top:15px; font-size:13px; color:#555;">
                            Đã có tài khoản? <a href="javascript:void(0)" onclick="toggleCustForm('login')" style="color:var(--primary); font-weight:700;">Đăng nhập</a>
                        </p>
                    </div>
                </div>

                <!-- CỔNG 2: DÀNH CHO CÁN BỘ NỘI BỘ -->
                <div id="internal-login-box" style="display:none;">
                    <i class="fas fa-user-md fa-3x" style="color: var(--primary); margin: 10px 0;"></i>
                    <h2>Cổng Cán Bộ Nội Bộ</h2>
                    <p style="color:#666; font-size:13.5px; margin-bottom:15px;">Chọn chức danh để vào bàn làm việc chuyên trách</p>

                    <div class="input-group">
                        <label><i class="fas fa-id-badge"></i> Vị trí chuyên trách</label>
                        <select id="internal-role-select" onchange="autoFillInternalAccount()">
                            <option value="advisor">Nhân Viên Tư Vấn</option>
                            <option value="staff">Nhân Viên Chăm Sóc</option>
                            <option value="doctor">Bác Sĩ Trực Thuộc</option>
                            <option value="manager">Quản Lý Cửa Hàng</option>
                            <option value="admin">Quản Trị Viên (Admin)</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-user-circle"></i> Gmail công vụ</label>
                        <input type="email" id="internal-email" value="tuvan@petcare.com" oninput="clearInternalInputError()">
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-key"></i> Mật khẩu bảo mật</label>
                        <input type="password" id="internal-pass" value="tuvan@123" oninput="clearInternalInputError()" onkeypress="if(event.key==='Enter') handleInternalLogin()">
                        <span id="internal-login-err" class="field-error-text"></span>
                    </div>

                    <button class="btn-login" onclick="handleInternalLogin()">VÀO BÀN LÀM VIỆC</button>
                    <small style="display:block; text-align:center; color:#888; margin-top:12px;">
                        <i class="fas fa-clock"></i> Ca làm việc: 08:00 - 17:00 (Trễ trừ 1.000đ/phút)
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- Link JS chuẩn Laravel -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function switchLoginMode(mode) {
            const tabCust = document.getElementById('tab-cust');
            const tabStaff = document.getElementById('tab-staff');
            const custBox = document.getElementById('customer-login-box');
            const internalBox = document.getElementById('internal-login-box');

            clearCustInputError();
            clearInternalInputError();

            if (mode === 'customer') {
                tabCust.classList.add('active');
                tabStaff.classList.remove('active');
                custBox.style.display = 'block';
                internalBox.style.display = 'none';
            } else {
                tabStaff.classList.add('active');
                tabCust.classList.remove('active');
                custBox.style.display = 'none';
                internalBox.style.display = 'block';
                autoFillInternalAccount();
            }
        }

        function toggleCustForm(type) {
            clearCustInputError();
            document.getElementById('cust-form-login').style.display = type === 'login' ? 'block' : 'none';
            document.getElementById('cust-form-register').style.display = type === 'register' ? 'block' : 'none';
        }

        function autoFillInternalAccount() {
            clearInternalInputError();
            const role = document.getElementById('internal-role-select').value;
            const emailEl = document.getElementById('internal-email');
            const passEl = document.getElementById('internal-pass');

            const accounts = {
                advisor: { email: "tuvan@petcare.com", pass: "tuvan@123" },
                staff: { email: "chamsoc@petcare.com", pass: "chamsoc@123" },
                doctor: { email: "bacsi@petcare.com", pass: "bacsi@123" },
                manager: { email: "quanly@petcare.com", pass: "quanly@123" },
                admin: { email: "admin@petcare.com", pass: "admin@123" }
            };

            if (accounts[role]) {
                emailEl.value = accounts[role].email;
                passEl.value = accounts[role].pass;
            }
        }

        function clearCustInputError() {
            const passInput = document.getElementById('cust-pass');
            const errEl = document.getElementById('cust-login-err');
            if (passInput) passInput.classList.remove('input-error');
            if (errEl) errEl.innerText = '';
        }

        function clearInternalInputError() {
            const passInput = document.getElementById('internal-pass');
            const errEl = document.getElementById('internal-login-err');
            if (passInput) passInput.classList.remove('input-error');
            if (errEl) errEl.innerText = '';
        }

        /* --- XỬ LÝ ĐĂNG NHẬP KHÁCH HÀNG & BÁO LỖI NẾU SAI MẬT KHẨU --- */
        function handleCustomerLogin() {
            clearCustInputError();

            const emailInput = document.getElementById('cust-email');
            const passInput = document.getElementById('cust-pass');
            const errEl = document.getElementById('cust-login-err');

            const email = emailInput ? emailInput.value.trim() : '';
            const pass = passInput ? passInput.value : '';

            if (!email || !pass) {
                if (passInput) passInput.classList.add('input-error');
                if (errEl) errEl.innerText = 'Bắt buộc nhập đủ email và mật khẩu!';
                showToast("Vui lòng nhập đầy đủ email và mật khẩu!", "warning");
                return;
            }

            // Danh sách tài khoản khách hàng mặc định và các tài khoản đã đăng ký
            let registeredList = loadData('pc_registered_accounts', []);
            const savedProfile = loadData('pc_current_profile', userProfile);

            let validCustomers = [
                { email: "khachhang@petcare.com", pass: "123456", name: "Nguyễn Văn A" }
            ];

            if (savedProfile && savedProfile.email) {
                validCustomers.push({
                    email: savedProfile.email,
                    pass: savedProfile.password || "123456",
                    name: savedProfile.name
                });
            }

            if (Array.isArray(registeredList)) {
                validCustomers = validCustomers.concat(registeredList);
            }

            // Tìm tài khoản theo email
            const matched = validCustomers.find(c => c.email.toLowerCase() === email.toLowerCase());

            if (!matched) {
                if (emailInput) emailInput.classList.add('input-error');
                if (errEl) errEl.innerText = 'Tài khoản email này chưa được đăng ký trong hệ thống!';
                showToast("Tài khoản email này chưa được đăng ký!", "error");
                return;
            }

            // Kiểm tra mật khẩu
            if (matched.pass !== pass) {
                if (passInput) passInput.classList.add('input-error');
                if (errEl) errEl.innerText = 'Mật khẩu không chính xác! Vui lòng thử lại.';
                showToast("Mật khẩu không chính xác! Vui lòng kiểm tra lại.", "error");
                return;
            }

            // Mật khẩu chính xác -> Cập nhật tên đăng nhập hiện tại và chuyển trang
            if (matched.name) {
                userProfile.name = matched.name;
                userProfile.email = matched.email;
                saveData('pc_current_profile', userProfile);
            }

            localStorage.setItem('pc_logged_role', 'customer');
            localStorage.setItem('pc_show_login_success', 'true');
            window.location.replace("{{ url('/home') }}");
        }

        /* --- XỬ LÝ ĐĂNG KÝ KHÁCH HÀNG (LƯU VÀO HỆ THỐNG ĐỂ ĐĂNG NHẬP ĐƯỢC NGAY) --- */
        function handleCustomerRegister() {
            // Xóa lỗi cũ
            ['err-reg-name', 'err-reg-phone', 'err-reg-email', 'err-reg-pass'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerText = '';
            });
            ['reg-name', 'reg-phone', 'reg-email', 'reg-pass'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('input-error');
            });

            const nameEl = document.getElementById('reg-name');
            const phoneEl = document.getElementById('reg-phone');
            const emailEl = document.getElementById('reg-email');
            const passEl = document.getElementById('reg-pass');

            const name = nameEl ? nameEl.value.trim() : '';
            const phone = phoneEl ? phoneEl.value.trim() : '';
            const email = emailEl ? emailEl.value.trim() : '';
            const pass = passEl ? passEl.value : '';

            let hasError = false;

            if (!name) {
                document.getElementById('err-reg-name').innerText = 'Bắt buộc!';
                if (nameEl) nameEl.classList.add('input-error');
                hasError = true;
            }
            if (!email) {
                document.getElementById('err-reg-email').innerText = 'Bắt buộc!';
                if (emailEl) emailEl.classList.add('input-error');
                hasError = true;
            }
            if (!pass) {
                document.getElementById('err-reg-pass').innerText = 'Bắt buộc!';
                if (passEl) passEl.classList.add('input-error');
                hasError = true;
            }

            if (hasError) {
                showToast("Vui lòng điền đầy đủ các thông tin bắt buộc!", "warning");
                return;
            }

            // Lưu tài khoản mới vào danh sách tài khoản hợp lệ
            let registeredList = loadData('pc_registered_accounts', []);
            registeredList.push({
                name: name,
                phone: phone || "0901 234 567",
                email: email,
                pass: pass
            });
            saveData('pc_registered_accounts', registeredList);

            // Cập nhật hồ sơ hiện hành
            userProfile.name = name;
            userProfile.phone = phone || "0901 234 567";
            userProfile.email = email;
            userProfile.password = pass;
            saveData('pc_current_profile', userProfile);

            notifyAdmin(`Khách hàng mới "${name}" (${email}) vừa đăng ký tài khoản!`, 'urgent');
            showToast("Đăng ký tài khoản thành công! Mời bạn đăng nhập.", "success");

            toggleCustForm('login');
            document.getElementById('cust-email').value = email;
            document.getElementById('cust-pass').value = pass;
        }

        /* --- XỬ LÝ ĐĂNG NHẬP CÁN BỘ NỘI BỘ & BÁO LỖI NẾU SAI MẬT KHẨU --- */
        function handleInternalLogin() {
            clearInternalInputError();

            const role = document.getElementById('internal-role-select').value;
            const emailInput = document.getElementById('internal-email');
            const passInput = document.getElementById('internal-pass');
            const errEl = document.getElementById('internal-login-err');

            const email = emailInput ? emailInput.value.trim() : '';
            const pass = passInput ? passInput.value : '';

            if (!email || !pass) {
                if (passInput) passInput.classList.add('input-error');
                if (errEl) errEl.innerText = 'Bắt buộc nhập email và mật khẩu công vụ!';
                showToast("Vui lòng nhập đầy đủ email và mật khẩu công vụ!", "warning");
                return;
            }

            const accounts = {
                advisor: { email: "tuvan@petcare.com", pass: "tuvan@123", title: "Nhân Viên Tư Vấn" },
                staff: { email: "chamsoc@petcare.com", pass: "chamsoc@123", title: "Nhân Viên Chăm Sóc" },
                doctor: { email: "bacsi@petcare.com", pass: "bacsi@123", title: "Bác Sĩ Trực Thuộc" },
                manager: { email: "quanly@petcare.com", pass: "quanly@123", title: "Quản Lý Cửa Hàng" },
                admin: { email: "admin@petcare.com", pass: "admin@123", title: "Quản Trị Viên (Admin)" }
            };

            const targetAccount = accounts[role];

            // Kiểm tra email
            if (!targetAccount || targetAccount.email.toLowerCase() !== email.toLowerCase()) {
                if (emailInput) emailInput.classList.add('input-error');
                if (errEl) errEl.innerText = `Email không khớp với vị trí "${targetAccount ? targetAccount.title : role}"!`;
                showToast(`Email công vụ không đúng với vị trí đã chọn!`, "error");
                return;
            }

            // Kiểm tra mật khẩu
            if (targetAccount.pass !== pass) {
                if (passInput) passInput.classList.add('input-error');
                if (errEl) errEl.innerText = 'Mật khẩu công vụ không chính xác! Vui lòng thử lại.';
                showToast("Mật khẩu công vụ không chính xác! Vui lòng kiểm tra lại.", "error");
                return;
            }

            // Đăng nhập thành công -> Lưu quyền và chuyển sang Dashboard
            localStorage.setItem('pc_logged_role', role);
            localStorage.setItem('pc_logged_email', email);
            localStorage.setItem('pc_show_login_success', 'true');

            processStaffCheckin(role);

            window.location.replace("{{ url('/dashboard') }}");
        }

        // Tự động điền tài khoản mẫu lần đầu tải trang nếu ở tab cán bộ
        window.addEventListener('DOMContentLoaded', () => {
            autoFillInternalAccount();
        });
    </script>
</body>
</html>
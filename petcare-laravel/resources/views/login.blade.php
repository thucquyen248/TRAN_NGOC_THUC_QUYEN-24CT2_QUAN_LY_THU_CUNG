<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Đăng Nhập & Đăng Ký</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="hologram-animated-body">

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

                <!-- CỔNG 1: DÀNH CHO KHÁCH HÀNG (Không cần chọn vai trò) -->
                <div id="customer-login-box">
                    <div id="cust-form-login">
                        <i class="fas fa-paw fa-3x" style="color: var(--primary); margin: 10px 0;"></i>
                        <h2>Khách Hàng Đăng Nhập</h2>
                        <p style="color:#666; font-size:13.5px; margin-bottom:15px;">Dành cho chủ nuôi đặt lịch & theo dõi hồ sơ bé</p>

                        <div class="input-group">
                            <label><i class="fas fa-envelope"></i> Email của bạn</label>
                            <input type="email" id="cust-email" placeholder="khachhang@petcare.com" value="khachhang@petcare.com">
                        </div>
                        <div class="input-group">
                            <label><i class="fas fa-lock"></i> Mật khẩu</label>
                            <input type="password" id="cust-pass" placeholder="••••••••" value="123456">
                        </div>
                        <button class="btn-login" onclick="handleCustomerLogin()">ĐĂNG NHẬP NGAY</button>
                        <p style="text-align:center; margin-top:15px; font-size:13px; color:#555;">
                            Chưa có tài khoản? <a href="javascript:void(0)" onclick="toggleCustForm('register')" style="color:var(--primary); font-weight:700;">Đăng ký tài khoản</a>
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
                        </div>
                        <div class="input-group">
                            <label>Số điện thoại</label>
                            <input type="tel" id="reg-phone" placeholder="0901 234 567">
                        </div>
                        <div class="input-group">
                            <label>Email liên hệ</label>
                            <input type="email" id="reg-email" placeholder="email@petcare.com">
                        </div>
                        <div class="input-group">
                            <label>Mật khẩu</label>
                            <input type="password" id="reg-pass" placeholder="••••••••">
                        </div>
                        <button class="btn-login" onclick="handleCustomerRegister()">HOÀN TẤT ĐĂNG KÝ</button>
                        <p style="text-align:center; margin-top:15px; font-size:13px; color:#555;">
                            Đã có tài khoản? <a href="javascript:void(0)" onclick="toggleCustForm('login')" style="color:var(--primary); font-weight:700;">Đăng nhập</a>
                        </p>
                    </div>
                </div>

                <!-- CỔNG 2: DÀNH CHO CÁN BỘ NỘI BỘ (Có chọn vai trò, Gmail và pass riêng) -->
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
                        <input type="email" id="internal-email" value="tuvan@petcare.com">
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-key"></i> Mật khẩu bảo mật</label>
                        <input type="password" id="internal-pass" value="tuvan@123">
                    </div>

                    <button class="btn-login" onclick="handleInternalLogin()">VÀO BÀN LÀM VIỆC</button>
                    <small style="display:block; text-align:center; color:#888; margin-top:12px;">
                        <i class="fas fa-clock"></i> Ca làm việc: 08:00 - 17:00 (Trễ trừ 1.000đ/phút)
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- <script src="js/script.js"></script> -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function switchLoginMode(mode) {
            const tabCust = document.getElementById('tab-cust');
            const tabStaff = document.getElementById('tab-staff');
            const custBox = document.getElementById('customer-login-box');
            const internalBox = document.getElementById('internal-login-box');

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
            document.getElementById('cust-form-login').style.display = type === 'login' ? 'block' : 'none';
            document.getElementById('cust-form-register').style.display = type === 'register' ? 'block' : 'none';
        }

        function autoFillInternalAccount() {
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

        function handleCustomerLogin() {
            localStorage.setItem('pc_logged_role', 'customer');
            localStorage.setItem('pc_show_login_success', 'true');
            window.location.replace("2.index.html");
        }

        function handleCustomerRegister() {
            const name = document.getElementById('reg-name').value.trim();
            const phone = document.getElementById('reg-phone').value.trim();
            const email = document.getElementById('reg-email').value.trim();

            if (!name || !email) {
                alert("Vui lòng điền đủ họ tên và email!");
                return;
            }

            userProfile.name = name;
            userProfile.phone = phone || "0901 234 567";
            userProfile.email = email;
            saveData('pc_current_profile', userProfile);

            notifyAdmin(`Khách hàng mới "${name}" (${email}) vừa đăng ký tài khoản!`, 'urgent');
            alert("Đăng ký thành công! Mời bạn đăng nhập.");
            toggleCustForm('login');
            document.getElementById('cust-email').value = email;
        }

        function handleInternalLogin() {
            const role = document.getElementById('internal-role-select').value;
            const email = document.getElementById('internal-email').value.trim();

            localStorage.setItem('pc_logged_role', role);
            localStorage.setItem('pc_logged_email', email);
            localStorage.setItem('pc_show_login_success', 'true');

            processStaffCheckin(role);

            window.location.replace("3.dashboard.html");
        }
    </script>
</body>
</html>
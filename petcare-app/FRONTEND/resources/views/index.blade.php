<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Pro - Cổng Khách Hàng</title>
    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Link CSS Laravel -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="customer-mode hologram-fluid-body">
    <ul>
        @foreach($pets as $pet)
            <li>{{ $pet->name }} - {{ $pet->species }} - {{ $pet->age }} tuổi</li>
        @endforeach
    </ul>
    <!-- KHUNG THÔNG BÁO TOAST GÓC PHẢI -->
    <div id="toast-box" class="toast-container"></div>

    <!-- POPUP THÀNH CÔNG NỔI CHÍNH GIỮA TRANG -->
    <div id="success-center-popup" class="success-center-modal">
        <div class="success-center-card ppt-zoom-in">
            <div class="success-icon-circle"><i class="fas fa-check"></i></div>
            <h2 style="color: var(--primary); margin-bottom: 10px;">Đặt Hàng Thành Công!</h2>
            <p id="success-center-desc" style="color: #666; font-size: 14.5px; line-height: 1.6; margin-bottom: 25px;"></p>
            <button class="btn-login" style="margin-top:0;" onclick="closeCenterSuccessPopup()">TUYỆT VỜI, XEM TIẾP</button>
        </div>
    </div>

    <!-- BANNER KHUYẾN MÃI HÌNH VUÔNG NỔI BẬT GÓC PHẢI (CÓ NÚT X THOÁT) -->
    <div id="promo-floating-banner" class="promo-floating-square">
        <button class="close-square-btn" onclick="closeSquarePromo()">&times;</button>
        <img id="square-promo-img" src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=300" alt="Khuyến mãi">
        <div class="square-promo-body">
            <span class="badge badge-danger">HOT PROMO</span>
            <h4 id="square-promo-title">Giảm 20% Spa Đầu Tuần</h4>
            <p id="square-promo-desc">Mã: SPA20 - Đặt lịch ngay nhận ưu đãi!</p>
            <button class="btn-action btn-save" style="padding:6px 12px; font-size:12px; margin-top:5px;" onclick="viewPromoFromBanner()">Xem Ngay</button>
        </div>
    </div>

    <!-- KHUNG CHAT MINI GÓC DƯỚI BÊN TRÁI (KẾT NỐI VỚI TƯ VẤN VIÊN) -->
    <div class="chat-mini-anchor-left">
        <button id="chat-toggle-btn" class="chat-bubble-btn" onclick="toggleMiniChat()">
            <i class="fas fa-comment-dots fa-2x"></i>
            <span class="chat-online-dot"></span>
            <!-- Icon số đỏ báo tin nhắn chat mới -->
            <span class="red-counter-badge" id="client-chat-badge" style="position:absolute; top:-5px; right:-5px;">1</span>
        </button>
        
        <div id="mini-chat-box" class="mini-chat-window" style="display:none;">
            <div class="mini-chat-header">
                <div style="display:flex; align-items:center; gap:10px;">
                    <img src="https://i.pravatar.cc/100?img=5" style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid #fff;">
                    <div>
                        <h4 style="font-size:13.5px; margin:0; color:#fff;">NV Tư Vấn: Trần Thị Tư Vấn</h4>
                        <small style="color:#e8f8f5; font-size:11px;"><i class="fas fa-circle" style="color:#2ecc71; font-size:8px;"></i> Đang trực tuyến hỗ trợ</small>
                    </div>
                </div>
                <div style="display:flex; gap:8px; align-items:center;">
                    <!-- Nút hạ khung chat xuống -->
                    <button onclick="toggleMiniChat()" title="Hạ khung chat xuống" style="background:none; border:none; color:#fff; font-size:18px; cursor:pointer;"><i class="fas fa-minus"></i></button>
                    <!-- Nút kết thúc tư vấn -->
                    <button onclick="endCustomerChatSession()" title="Kết thúc phiên tư vấn" class="badge badge-danger" style="border:none; cursor:pointer; font-size:11px;">Kết thúc</button>
                </div>
            </div>
            
            <!-- ĐÃ ĐIỀN SẴN DỮ LIỆU CHAT 2 CHIỀU ĐỐI XỨNG -->
            <div id="mini-chat-messages" class="mini-chat-body">
                <div class="chat-msg user-msg">
                    <small style="font-weight:bold; display:block; margin-bottom:2px; font-size:11px; opacity:0.85;">Nguyễn Văn A</small>
                    <p>Xin chào, cho mình hỏi bé Corgi 11kg tắm spa và cắt tỉa lông bao nhiêu tiền ạ?</p>
                    <small>09:00</small>
                </div>
                <div class="chat-msg bot-msg">
                    <small style="font-weight:bold; display:block; margin-bottom:2px; font-size:11px; opacity:0.85;">Trần Thị Tư Vấn</small>
                    <p>Chào Anh/chị! Bé Corgi 11kg bên em có gói Tắm thảo dược 150k và Cắt tỉa tạo kiểu mông trái tim 320k ạ!</p>
                    <small>09:02</small>
                </div>
            </div>

            <div class="mini-chat-footer">
                <input type="text" id="mini-chat-input" placeholder="Nhập câu hỏi cần tư vấn..." onkeypress="if(event.key==='Enter') sendClientChatMessage()">
                <button onclick="sendClientChatMessage()"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <!-- KHUNG ĐIỀU HƯỚNG VÀ NỘI DUNG CHÍNH -->
    <div id="main-page" class="page active">
        <aside class="sidebar holo-glass-sidebar">
            <h2 style="color: var(--primary); margin-bottom: 20px;"><i class="fas fa-heartbeat"></i> PETCARE</h2>
            
            <div class="user-greeting-box">
                <img id="sidebar-user-avatar" src="https://i.pravatar.cc/100?img=12" class="user-greeting-avatar">
                <div class="user-greeting-text">
                    <h4 id="sidebar-greeting-name">Xin chào, Nguyễn Văn A!</h4>
                    <small id="sidebar-user-role-badge">Thành viên HẠNG ĐỒNG</small>
                </div>
            </div>

            <!-- MENU KHÁCH HÀNG -->
            <div>
                <!-- 1. Về chúng tôi -->
                <li class="nav-item" onclick="switchTab('cust-about', this)">
                    <i class="fas fa-info-circle"></i> Về chúng tôi
                </li>

                <!-- 2. Hồ sơ -->
                <li class="nav-item" onclick="toggleSubmenu('sub-profile', this)">
                    <i class="fas fa-id-card"></i> Hồ sơ
                    <i class="fas fa-chevron-down arrow-icon rotate"></i>
                </li>
                <ul id="sub-profile" class="submenu open">
                    <li class="submenu-item active" onclick="switchTab('cust-pets', this)"><i class="fas fa-paw"></i> Hồ sơ bé</li>
                    <li class="submenu-item" onclick="switchTab('cust-profile-update', this)"><i class="fas fa-user-astronaut"></i> Cập nhật thông tin</li>
                </ul>

                <!-- 3. Lịch sử -->
                <li class="nav-item" onclick="toggleSubmenu('sub-history', this)">
                    <i class="fas fa-file-medical-alt"></i> Lịch sử
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-history" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-records', this)"><i class="fas fa-prescription-bottle-alt"></i> Bệnh án, đơn thuốc</li>
                    <li class="submenu-item" onclick="switchTab('cust-vaccines', this)"><i class="fas fa-syringe"></i> Tiêm phòng, xét nghiệm</li>
                </ul>

                <!-- 4. Sức khoẻ -->
                <li class="nav-item" onclick="toggleSubmenu('sub-health', this)">
                    <i class="fas fa-heartbeat"></i> Sức khoẻ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-health" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-health-overview', this)"><i class="fas fa-chart-line"></i> Theo dõi tổng quan</li>
                </ul>

                <!-- 5. Đặt lịch -->
                <li class="nav-item" onclick="toggleSubmenu('sub-appointments', this)">
                    <i class="fas fa-calendar-alt"></i> Đặt lịch
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-appointments" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-booking', this)"><i class="fas fa-calendar-plus"></i> Đặt lịch</li>
                    <li class="submenu-item" onclick="switchTab('cust-reminders-separate', this)"><i class="fas fa-clock"></i> Nhắc nhở</li>
                    <!-- BẤM VÀO THÔNG BÁO THÌ ICON SỐ ĐỎ TỰ ĐỘNG BIẾN MẤT -->
                    <li class="submenu-item" onclick="openCustomerNotificationsMenu(this)">
                        <i class="fas fa-bell"></i> Thông báo 
                        <span class="red-counter-badge" id="client-notification-badge">3</span>
                    </li>
                    <li class="submenu-item" onclick="switchTab('cust-appointment-status', this)"><i class="fas fa-clipboard-check"></i> Trạng thái lịch hẹn</li>
                </ul>

                <!-- 6. Dịch vụ (Tách riêng 3 menu con) -->
                <li class="nav-item" onclick="toggleSubmenu('sub-services', this)">
                    <i class="fas fa-concierge-bell"></i> Dịch vụ
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-services" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-svc-spa', this)"><i class="fas fa-bath"></i> Spa thú cưng</li>
                    <li class="submenu-item" onclick="switchTab('cust-svc-grooming', this)"><i class="fas fa-cut"></i> Grooming & Cắt tỉa lông</li>
                    <li class="submenu-item" onclick="switchTab('cust-svc-hotel', this)"><i class="fas fa-hotel"></i> Khách sạn thú cưng</li>
                </ul>

                <!-- 7. Mua sắm -->
                <li class="nav-item" onclick="toggleSubmenu('sub-shopping', this)">
                    <i class="fas fa-shopping-bag"></i> Mua sắm
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-shopping" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-products', this)"><i class="fas fa-store"></i> Thức ăn, phụ kiện, thuốc</li>
                    <li class="submenu-item" onclick="switchTab('cust-favorites', this)"><i class="fas fa-heart" style="color:#ff4757;"></i> Yêu thích</li>
                    <li class="submenu-item" onclick="switchTab('cust-orders', this)"><i class="fas fa-receipt"></i> Đơn hàng & giao dịch</li>
                </ul>

                <!-- 8. Báo cáo chi phí -->
                <li class="nav-item" onclick="switchTab('cust-expenses', this)">
                    <i class="fas fa-wallet"></i> Báo cáo chi phí
                </li>

                <!-- 9. Ưu đãi & Tin tức -->
                <li class="nav-item" onclick="toggleSubmenu('sub-promotions', this)">
                    <i class="fas fa-tags"></i> Ưu đãi & Tin tức
                    <i class="fas fa-chevron-down arrow-icon"></i>
                </li>
                <ul id="sub-promotions" class="submenu">
                    <li class="submenu-item" onclick="switchTab('cust-promos', this)"><i class="fas fa-ticket-alt"></i> Khuyến mãi & Voucher</li>
                    <li class="submenu-item" onclick="switchTab('cust-news', this)"><i class="fas fa-newspaper"></i> Tin tức</li>
                    <li class="submenu-item" onclick="switchTab('cust-reviews-section', this)"><i class="fas fa-star" style="color:var(--warning);"></i> Đánh giá dịch vụ</li>
                </ul>
            </div>

            <li class="nav-item" onclick="logoutToAuth()" style="margin-top: auto; color: var(--accent);"><i class="fas fa-sign-out-alt"></i> Đăng xuất</li>
        </aside>

        <main class="content-area holo-content-area">
            
            <!-- ================= SECTION 1: VỀ CHÚNG TÔI ================= -->
            <section id="cust-about" class="view-section">
                <div class="content-center-container ppt-slide-in">
                    <div class="table-container holo-card-border" style="max-width: 900px; margin: 0 auto; text-align: center;">
                        <h2 style="color: var(--primary); font-size: 26px; margin-bottom: 12px;"><i class="fas fa-heartbeat"></i> VỀ CHÚNG TÔI - PETCARE PRO</h2>
                        <p style="color: #666; font-size: 15px; line-height: 1.8; margin-bottom: 25px;">
                            PetCare Pro tự hào là trung tâm y tế, thẩm mỹ spa và khách sạn thú cưng cao cấp. Với tôn chỉ "Yêu thương trọn vẹn như thành viên gia đình", chúng tôi cam kết đem lại cho bé cưng một môi trường chăm sóc an toàn, hiện đại và chuẩn mực y khoa quốc tế.
                        </p>

                        <div class="card-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
                            <div class="pet-card">
                                <i class="fas fa-user-md fa-3x" style="color:var(--primary); margin-bottom:12px;"></i>
                                <h3>Đội ngũ Bác sĩ</h3>
                                <p style="font-size:13px; color:#777; margin-top:8px;">100% bác sĩ chính quy ngành Thú y, giàu kinh nghiệm lâm sàng và luôn lắng nghe thú cưng.</p>
                            </div>
                            <div class="pet-card">
                                <i class="fas fa-shield-alt fa-3x" style="color:var(--success); margin-bottom:12px;"></i>
                                <h3>Thiết bị an toàn</h3>
                                <p style="font-size:13px; color:#777; margin-top:8px;">Máy siêu âm màu, máy xét nghiệm tự động, buồng sấy ion âm chống hoảng sợ, phòng lưu máy lạnh 24/7.</p>
                            </div>
                            <div class="pet-card">
                                <i class="fas fa-spa fa-3x" style="color:var(--secondary); margin-bottom:12px;"></i>
                                <h3>Spa & Mỹ phẩm</h3>
                                <p style="font-size:13px; color:#777; margin-top:8px;">Mỹ phẩm 100% thảo mộc hữu cơ nhập khẩu, kéo tỉa chuyên dụng vô trùng tuyệt đối, an toàn cho da nhạy cảm.</p>
                            </div>
                        </div>

                        <div style="background: rgba(108, 92, 231, 0.08); padding: 20px; border-radius: 16px; text-align: left;">
                            <h4 style="color: var(--primary); margin-bottom: 8px;"><i class="fas fa-check-circle"></i> Tiêu chuẩn vàng cam kết từ PetCare:</h4>
                            <ul style="padding-left: 20px; color: #555; font-size: 13.5px; line-height: 1.8;">
                                <li>Phác đồ điều trị rõ ràng, minh bạch chi phí trước khi thực hiện.</li>
                                <li>Phòng lưu trú và spa được khử trùng tia cực tím định kỳ 2 lần mỗi ngày.</li>
                                <li>Hệ thống camera giám sát trực tuyến 24/7 kết nối ứng dụng để chủ nuôi theo dõi từ xa.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 2: HỒ SƠ BÉ & SLIDER 4 HẠNG THẺ ================= -->
            <section id="cust-pets" class="view-section active">
                
                <!-- SLIDER DEMO 4 HẠNG THẺ TỰ ĐỘNG LƯỚT -->
                <div class="member-auto-slider-container ppt-fade-up">
                    <div class="slider-header-info">
                        <h3><i class="fas fa-crown" style="color:#f1c40f;"></i> ĐẶC QUYỀN HẠNG THẺ THÀNH VIÊN</h3>
                        <p>Hệ thống tự động nâng hạng theo hạn mức chi tiêu tích lũy của bạn</p>
                    </div>

                    <div class="cards-carousel-wrapper">
                        <div class="cards-carousel-track" id="cards-track">
                            <!-- Thẻ Đồng -->
                            <div class="carousel-card card-bronze">
                                <div class="c-card-top">
                                    <span>PETCARE MEMBER</span>
                                    <span class="c-badge">ĐỒNG</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-award fa-2x"></i>
                                    <h4>HẠNG ĐỒNG</h4>
                                    <small>Chi tiêu tích lũy: Từ 0 đ</small>
                                </div>
                                <div class="c-card-bottom">Ưu đãi giảm 5% dịch vụ khám định kỳ</div>
                            </div>
                            <!-- Thẻ Bạc -->
                            <div class="carousel-card card-silver">
                                <div class="c-card-top">
                                    <span>PETCARE MEMBER</span>
                                    <span class="c-badge">BẠC</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-medal fa-2x"></i>
                                    <h4>HẠNG BẠC</h4>
                                    <small>Chi tiêu tích lũy: Từ 2.000.000 đ</small>
                                </div>
                                <div class="c-card-bottom">Giảm 10% Spa & Tặng cắt móng vệ sinh tai</div>
                            </div>
                            <!-- Thẻ Vàng -->
                            <div class="carousel-card card-gold">
                                <div class="c-card-top">
                                    <span>PETCARE MEMBER</span>
                                    <span class="c-badge">VÀNG</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-crown fa-2x"></i>
                                    <h4>HẠNG VÀNG</h4>
                                    <small>Chi tiêu tích lũy: Từ 5.000.000 đ</small>
                                </div>
                                <div class="c-card-bottom">Giảm 15% tất cả dịch vụ + Ưu tiên lịch hẹn</div>
                            </div>
                            <!-- Thẻ Đen Vàng -->
                            <div class="carousel-card card-blackgold">
                                <div class="c-card-top">
                                    <span>PETCARE VIP CLUB</span>
                                    <span class="c-badge">ĐEN VÀNG</span>
                                </div>
                                <div class="c-card-body">
                                    <i class="fas fa-gem fa-2x"></i>
                                    <h4>HẠNG ĐEN VÀNG</h4>
                                    <small>Chi tiêu tích lũy: Từ 10.000.000 đ</small>
                                </div>
                                <div class="c-card-bottom">Giảm 20% trọn đời + Miễn phí 1 ngày phòng VIP khách sạn</div>
                            </div>
                        </div>
                    </div>

                    <!-- NÚT MỞ MODAL ĐĂNG KÝ THÀNH VIÊN -->
                    <div style="text-align:center; margin-top:15px;">
                        <button class="btn-action btn-save" style="width:auto; padding:10px 24px;" onclick="openMemberRegistrationModal()">
                            <i class="fas fa-id-card"></i> ĐĂNG KÝ THÀNH VIÊN & NHẬN THẺ
                        </button>
                    </div>
                </div>

                <!-- Thẻ cá nhân hiển thị -->
                <div id="member-registered-info" style="max-width:400px; margin: 15px auto;">
                    <div class="vip-card-preview card-bronze" id="active-vip-card-box">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong><i class="fas fa-paw"></i> THẺ THÀNH VIÊN</strong>
                            <span class="vip-tier-badge" id="vip-card-tier">ĐỒNG</span>
                        </div>
                        <div style="display:flex; gap:14px; align-items:center; margin:15px 0 10px;">
                            <img id="vip-card-avatar" src="https://i.pravatar.cc/100?img=12" style="width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid #fff;">
                            <div>
                                <h3 id="vip-card-name" style="font-size:18px; text-transform:uppercase; margin-bottom:2px;">NGUYỄN VĂN A</h3>
                                <small style="opacity:0.85;" id="vip-card-dob">Sinh nhật: 15/08/1998</small>
                            </div>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                            <p style="font-size:12px; letter-spacing:2px; font-family:monospace;" id="vip-card-id">PC-MEMBER-88992</p>
                            <small id="vip-card-spending" style="font-weight:bold; background:rgba(0,0,0,0.3); padding:3px 8px; border-radius:6px;">Tích lũy: 850.000 đ</small>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin: 25px 0 15px;">
                    <div>
                        <h2 id="cust-greeting-banner">Xin chào, Nguyễn Văn A!</h2>
                        <p style="color:#777; margin-top:4px;">Danh sách các bé thú cưng trong hồ sơ của bạn</p>
                    </div>
                    <button class="btn-action btn-save" style="width: auto;" onclick="openPetModal()"><i class="fas fa-plus"></i> Thêm bé mới</button>
                </div>
                
                <!-- ĐÃ ĐIỀN ĐẦY ĐỦ THẺ THÚ CƯNG -->
                <div class="card-grid" id="pet-list">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200">
                        <h3>Bé Lu</h3>
                        <p style="color:#888">Corgi (11.5 kg)</p><br>
                        <button class="btn-action" style="background:#e8f0fe; color:var(--primary)" onclick="editPet(1)">Sửa</button>
                        <button class="btn-action" style="background:#ffebeb; color:var(--accent)" onclick="deletePet(1)">Xóa</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=200">
                        <h3>Bé Miu</h3>
                        <p style="color:#888">Mèo Anh Lông Ngắn (4.2 kg)</p><br>
                        <button class="btn-action" style="background:#e8f0fe; color:var(--primary)">Sửa</button>
                        <button class="btn-action" style="background:#ffebeb; color:var(--accent)">Xóa</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=200">
                        <h3>Bé Bơ</h3>
                        <p style="color:#888">Golden Retriever (26 kg)</p><br>
                        <button class="btn-action" style="background:#e8f0fe; color:var(--primary)">Sửa</button>
                        <button class="btn-action" style="background:#ffebeb; color:var(--accent)">Xóa</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 3: CẬP NHẬT THÔNG TIN TÀI KHOẢN ================= -->
            <section id="cust-profile-update" class="view-section">
                <div class="hologram-profile-wrapper ppt-zoom-in">
                    <div class="hologram-stars"></div>
                    <div class="holo-floating-pet" style="top: 8%; left: 10%;"><i class="fas fa-dog" style="color:#a29bfe;"></i></div>
                    <div class="holo-floating-pet" style="bottom: 12%; left: 8%; animation-delay: 1.5s;"><i class="fas fa-cat" style="color:#81ecec;"></i></div>
                    <div class="holo-floating-pet" style="top: 15%; right: 12%; animation-delay: 2.5s;"><i class="fas fa-paw" style="color:#fab1a0;"></i></div>
                    <div class="holo-floating-pet" style="bottom: 10%; right: 10%; animation-delay: 3.5s;"><i class="fas fa-bone" style="color:#ffeaa7;"></i></div>
                    <div class="holo-floating-pet" style="top: 50%; left: 4%; animation-delay: 4.5s;"><i class="fas fa-meteor" style="color:#ff7675;"></i></div>

                    <div class="hologram-profile-card">
                        <h2 style="color: var(--primary); margin-bottom: 6px;"><i class="fas fa-user-astronaut"></i> Cập Nhật Tài Khoản</h2>
                        <p style="color:#666; font-size: 13.5px; margin-bottom: 20px;">Tùy chỉnh thông tin & đổi ảnh đại diện cá nhân</p>

                        <div class="image-picker-container" style="background: rgba(240, 243, 255, 0.7);">
                            <img id="user-avatar-preview" src="https://i.pravatar.cc/100?img=12" class="img-preview" style="border: 3px solid var(--primary);">
                            <label class="btn-upload">
                                <i class="fas fa-camera"></i> Đổi ảnh đại diện
                                <input type="file" accept="image/*" style="display: none;" onchange="previewUserAvatar(this)">
                            </label>
                        </div>

                        <div style="text-align: left;">
                            <div class="input-group"><label>Họ và tên của bạn</label><input type="text" id="user-fullname" value="Nguyễn Văn A"></div>
                            <div class="input-group"><label>Số điện thoại liên hệ</label><input type="text" id="user-phone" value="0901 234 567"></div>
                            <div class="input-group"><label>Email</label><input type="email" id="user-email" value="khachhang@petcare.com"></div>
                            <div class="input-group"><label>Địa chỉ</label><input type="text" id="user-address" value="Quận 1, TP. Hồ Chí Minh"></div>
                        </div>
                        <button class="btn-login" style="margin-top: 10px;" onclick="updateCustomerProfile()"><i class="fas fa-save"></i> LƯU THAY ĐỔI</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 4: BỆNH ÁN & ĐƠN THUỐC ================= -->
            <section id="cust-records" class="view-section">
                <h2>Bệnh án & Đơn thuốc</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Ngày khám</th><th>Bé cưng</th><th>Chẩn đoán</th><th>Bác sĩ điều trị</th><th>Đơn thuốc</th><th>Trạng thái</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>15/05/2026</td>
                                <td><strong>Bé Lu</strong> (Corgi)</td>
                                <td>Viêm da dị ứng nhẹ</td>
                                <td>BS. Trần Nam</td>
                                <td>Thuốc bôi da Bio-Derma (x1 tuýp), Kháng histamine (x10 viên)</td>
                                <td><span class="badge badge-success">Đã khỏi</span></td>
                            </tr>
                            <tr>
                                <td>20/07/2026</td>
                                <td><strong>Bé Miu</strong> (Mèo Anh)</td>
                                <td>Rối loạn tiêu hóa nhẹ</td>
                                <td>BS. Hoàng Kim Yến</td>
                                <td>Men vi sinh Entero-Pet, Gel dinh dưỡng Nutri-Plus</td>
                                <td><span class="badge badge-success">Ổn định</span></td>
                            </tr>
                            <tr>
                                <td>12/08/2026</td>
                                <td><strong>Bé Bơ</strong> (Golden)</td>
                                <td>Kiểm tra khớp gối định kỳ</td>
                                <td>BS. Trần Nam</td>
                                <td>Canxi Nano PetCal, Dầu cá hồi Omega-3</td>
                                <td><span class="badge badge-info">Theo dõi định kỳ</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= SECTION 5: TIÊM PHÒNG & XÉT NGHIỆM ================= -->
            <section id="cust-vaccines" class="view-section">
                <h2>Lịch sử tiêm phòng & Xét nghiệm</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Ngày tiêm/xét nghiệm</th><th>Bé cưng</th><th>Loại vắc xin / Xét nghiệm</th><th>Ngày nhắc tiêm</th><th>Bác sĩ duyệt</th><th>Trạng thái</th></tr></thead>
                        <tbody>
                            <tr>
                                <td>10/01/2026</td>
                                <td><strong>Bé Lu</strong></td>
                                <td>Vắc xin 7 bệnh ngừa dại (Vanguard Plus)</td>
                                <td>10/01/2027</td>
                                <td>BS. Trần Nam</td>
                                <td><span class="badge badge-success">Đã hoàn thành</span></td>
                            </tr>
                            <tr>
                                <td>15/03/2026</td>
                                <td><strong>Bé Lu</strong></td>
                                <td>Tiêm phòng dại định kỳ (Rabisin)</td>
                                <td>15/03/2027</td>
                                <td>BS. Hoàng Kim Yến</td>
                                <td><span class="badge badge-success">Đã hoàn thành</span></td>
                            </tr>
                            <tr>
                                <td>02/06/2026</td>
                                <td><strong>Bé Miu</strong></td>
                                <td>Xét nghiệm sinh hóa máu 12 chỉ số</td>
                                <td>-</td>
                                <td>BS. Trần Nam</td>
                                <td><span class="badge badge-info">Chỉ số bình thường</span></td>
                            </tr>
                            <tr>
                                <td>05/08/2026</td>
                                <td><strong>Bé Bơ</strong></td>
                                <td>Xổ giun Drontal & Tiêm ngừa dại</td>
                                <td>05/08/2027</td>
                                <td>BS. Hoàng Kim Yến</td>
                                <td><span class="badge badge-success">Đã hoàn thành</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= SECTION 6: SỨC KHOẺ TỔNG QUAN ================= -->
            <section id="cust-health-overview" class="view-section">
                <h2>Theo dõi sức khoẻ tổng quan</h2><br>
                <div class="card-grid">
                    <div class="pet-card"><h3>Cân nặng gần nhất</h3><p id="disp-weight" style="font-size: 28px; color: var(--primary); font-weight: bold; margin-top: 10px;">11.5 kg</p></div>
                    <div class="pet-card"><h3>Nhiệt độ cơ thể</h3><p id="disp-temp" style="font-size: 28px; color: var(--success); font-weight: bold; margin-top: 10px;">38.5 °C</p></div>
                    <div class="pet-card"><h3>Tình trạng dinh dưỡng</h3><p id="disp-nutri" style="font-size: 20px; color: #555; margin-top: 10px;">Rất tốt - Khỏe mạnh</p></div>
                </div>

                <div class="table-container" style="margin-top: 25px; max-width: 600px; margin-left:auto; margin-right:auto;">
                    <h3 style="margin-bottom: 15px;"><i class="fas fa-edit"></i> Ghi nhận chỉ số thể trạng hôm nay</h3>
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <div class="input-group" style="flex:1;"><label>Cân nặng (kg)</label><input type="number" step="0.1" id="input-weight" placeholder="VD: 11.8"></div>
                        <div class="input-group" style="flex:1;"><label>Thân nhiệt (°C)</label><input type="number" step="0.1" id="input-temp" placeholder="VD: 38.6"></div>
                    </div>
                    <button class="btn-action btn-save" style="margin-top: 5px;" onclick="logHealthData()">Lưu chỉ số mới</button>
                </div>
            </section>

            <!-- ================= SECTION 7: ĐẶT LỊCH (DANH MỤC CỤ THỂ SẴN CÓ) ================= -->
            <section id="cust-booking" class="view-section">
                <div class="content-center-container">
                    <div class="table-container holo-card-border" style="max-width: 620px; margin:0 auto;">
                        <h2 style="color: var(--primary); margin-bottom: 6px;"><i class="fas fa-calendar-plus"></i> ĐẶT LỊCH DỊCH VỤ</h2>
                        <p style="color:#777; font-size:13.5px; margin-bottom: 20px;">Vui lòng chọn loại dịch vụ chi tiết theo nhu cầu của bé</p>
                        
                        <div class="input-group">
                            <label><i class="fas fa-stethoscope"></i> Danh mục dịch vụ chính</label>
                            <select id="book-category" onchange="updateBookingDetailOptions()">
                                <option value="kham">Khám sức khoẻ</option>
                                <option value="grooming">Grooming & Cắt tỉa lông</option>
                                <option value="hotel">Khách sạn thú cưng</option>
                            </select>
                        </div>

                        <!-- Điền sẵn option để không bao giờ bị trống rỗng -->
                        <div class="input-group">
                            <label><i class="fas fa-list-ul"></i> Dịch vụ cụ thể</label>
                            <select id="book-specific-service">
                                <option value="Khám sức khỏe tổng quát định kỳ">Khám sức khỏe tổng quát định kỳ</option>
                                <option value="Khám chuyên khoa Da liễu & Rụng lông">Khám chuyên khoa Da liễu & Rụng lông</option>
                                <option value="Khám Tiêu hóa & Nội soi">Khám Tiêu hóa & Nội soi</option>
                                <option value="Khám Xương khớp & Phục hồi chức năng">Khám Xương khớp & Phục hồi chức năng</option>
                                <option value="Tiêm phòng vắc xin 7 bệnh & ngừa dại">Tiêm phòng vắc xin 7 bệnh & ngừa dại</option>
                                <option value="Lấy máu xét nghiệm sinh hóa tự động">Lấy máu xét nghiệm sinh hóa tự động</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-paw"></i> Bé thú cưng</label>
                            <select id="book-pet">
                                <option value="Bé Lu (Corgi)">Bé Lu (Corgi)</option>
                                <option value="Bé Miu (Mèo Anh)">Bé Miu (Mèo Anh)</option>
                                <option value="Bé Bơ (Golden)">Bé Bơ (Golden)</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-clock"></i> Ngày & Giờ hẹn mong muốn</label>
                            <input type="datetime-local" id="book-time" value="2026-09-20T14:00">
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-comment-alt"></i> Ghi chú thêm cho bác sĩ / KTV</label>
                            <input type="text" id="book-note" placeholder="Ví dụ: Bé hơi nhát người lạ, da tai đang ngứa...">
                        </div>

                        <button class="btn-login" onclick="submitBooking()"><i class="fas fa-check-circle"></i> XÁC NHẬN ĐẶT LỊCH</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 8: NHẮC NHỞ (ĐÃ ĐIỀN ĐẦY ĐỦ THẺ NHẮC) ================= -->
            <section id="cust-reminders-separate" class="view-section">
                <h2><i class="fas fa-clock" style="color:var(--warning);"></i> Nhắc nhở lịch dịch vụ & Y tế</h2>
                <p style="color:#777; margin:5px 0 20px;">Bấm trực tiếp vào từng thẻ nhắc nhở bên dưới để xem thông tin chi tiết</p>
                
                <div class="table-container" id="reminders-container-box">
                    <div class="table-container" style="border-left:4px solid var(--warning); margin-bottom:12px; cursor:pointer; padding:15px;" onclick="openReminderDetailModal(1)">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong style="color:#2d3436;"><i class="fas fa-bell" style="color:var(--warning);"></i> Lịch uống thuốc tẩy giun định kỳ</strong>
                            <span class="badge badge-pending">Nhấp xem chi tiết</span>
                        </div>
                        <p style="color:#777; font-size:13px; margin-top:5px;">Dành cho: <strong>Bé Lu (Corgi)</strong> | Thời gian: 09:00 - Thứ Hai tuần tới</p>
                    </div>

                    <div class="table-container" style="border-left:4px solid var(--warning); margin-bottom:12px; cursor:pointer; padding:15px;" onclick="openReminderDetailModal(2)">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong style="color:#2d3436;"><i class="fas fa-bell" style="color:var(--warning);"></i> Tái khám kiểm tra da dị ứng</strong>
                            <span class="badge badge-pending">Nhấp xem chi tiết</span>
                        </div>
                        <p style="color:#777; font-size:13px; margin-top:5px;">Dành cho: <strong>Bé Lu (Corgi)</strong> | Thời gian: 14:30 - 18/09/2026</p>
                    </div>

                    <div class="table-container" style="border-left:4px solid var(--warning); margin-bottom:12px; cursor:pointer; padding:15px;" onclick="showToast('Bé Miu cần tiêm nhắc vắc-xin vào 25/09/2026!', 'info')">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong style="color:#2d3436;"><i class="fas fa-bell" style="color:var(--warning);"></i> Lịch tiêm nhắc vắc-xin dại hàng năm</strong>
                            <span class="badge badge-pending">Nhấp xem chi tiết</span>
                        </div>
                        <p style="color:#777; font-size:13px; margin-top:5px;">Dành cho: <strong>Bé Miu (Mèo Anh)</strong> | Thời gian: 10:00 - 25/09/2026</p>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 9: THÔNG BÁO GIAO DỊCH & ĐƠN HÀNG ================= -->
            <section id="cust-notifications-separate" class="view-section">
                <h2><i class="fas fa-bell" style="color:var(--primary);"></i> Thông báo giao dịch & Đơn hàng</h2>
                <p style="color:#777; margin:5px 0 20px;">Theo dõi tiến trình đơn mua sắm, trạng thái lịch hẹn và giao dịch thanh toán</p>
                
                <div class="table-container" id="notifications-container-box">
                    <div class="table-container" style="border-left:4px solid var(--primary); margin-bottom:12px; padding:14px;">
                        <div style="display:flex; justify-content:space-between;">
                            <strong>Đặt hàng thành công đơn #DH882</strong>
                            <small style="color:#999;">Hôm nay 09:15</small>
                        </div>
                        <p style="color:#555; font-size:13px; margin-top:5px;">Đơn hàng Hạt Royal Canin Corgi 2kg đã được xác nhận thanh toán chuyển khoản QR thành công.</p>
                    </div>

                    <div class="table-container" style="border-left:4px solid var(--success); margin-bottom:12px; padding:14px;">
                        <div style="display:flex; justify-content:space-between;">
                            <strong>Lịch hẹn #LH1029 đã được tiếp nhận</strong>
                            <small style="color:#999;">Hôm qua 14:00</small>
                        </div>
                        <p style="color:#555; font-size:13px; margin-top:5px;">Kỹ thuật viên đang chuẩn bị đón bé Lu vào lúc 14:00 ngày 20/09/2026. Mời bạn đưa bé đến đúng giờ.</p>
                    </div>

                    <div class="table-container" style="border-left:4px solid var(--secondary); margin-bottom:12px; padding:14px;">
                        <div style="display:flex; justify-content:space-between;">
                            <strong>Kích hoạt Thẻ Thành Viên HẠNG ĐỒNG</strong>
                            <small style="color:#999;">02/09/2026</small>
                        </div>
                        <p style="color:#555; font-size:13px; margin-top:5px;">Thẻ thành viên mã số PC-MEMBER-88992 đã được cấp. Bạn được giảm 5% các dịch vụ khám định kỳ.</p>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 10: TRẠNG THÁI LỊCH HẸN ================= -->
            <section id="cust-appointment-status" class="view-section">
                <h2>Trạng thái lịch hẹn của bạn</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã hẹn</th><th>Bé</th><th>Dịch vụ cụ thể</th><th>Thời gian</th><th>Thanh toán</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
                        <tbody id="appointment-table-body">
                            <tr>
                                <td><strong>#LH1029</strong></td>
                                <td>Bé Lu (Corgi)</td>
                                <td>Cắt tỉa tạo kiểu Teddy Bear</td>
                                <td>14:00 - 20/09/2026</td>
                                <td><span class="badge badge-info">Chuyển khoản QR</span></td>
                                <td><span class="badge badge-success">Đã duyệt</span></td>
                                <td><button class="btn-action" style="background:#ffebeb; color:var(--accent);" onclick="cancelAppointment('LH1029')">Hủy</button></td>
                            </tr>
                            <tr>
                                <td><strong>#LH1030</strong></td>
                                <td>Bé Miu</td>
                                <td>Gói Spa Bùn Khoáng Phục Hồi Da</td>
                                <td>09:30 - 22/09/2026</td>
                                <td><span class="badge badge-pending">Tiền mặt</span></td>
                                <td><span class="badge badge-info">Đang thực hiện</span></td>
                                <td><small style="color:#888;">Đang làm</small></td>
                            </tr>
                            <tr>
                                <td><strong>#LH1025</strong></td>
                                <td>Bé Bơ</td>
                                <td>Khám sức khỏe tổng quát định kỳ</td>
                                <td>15:00 - 15/08/2026</td>
                                <td><span class="badge badge-info">Chuyển khoản QR</span></td>
                                <td><span class="badge badge-success">Đã hoàn thành</span></td>
                                <td><small style="color:var(--success); font-weight:bold;">Đã xong</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= SECTION 11: SPA THÚ CƯNG ================= -->
            <section id="cust-svc-spa" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
                    <h2><i class="fas fa-bath" style="color:var(--primary);"></i> Dịch Vụ Spa Thư Giãn Thú Cưng</h2>
                    <span class="badge badge-info">100% Thảo Mộc Hữu Cơ</span>
                </div>
                <p style="color:#777; margin-bottom:20px;">Liệu trình tắm sấy khử mùi hôi, massage thư giãn gân cốt và dưỡng lông óng mượt</p>
                <div class="card-grid">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?w=200">
                        <h3>Gói Tắm Thảo Dược Cơ Bản</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">150.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Vắt tuyến hôi, tắm sấy thơm tho, nhổ lông tai</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Tắm Thảo Dược Cơ Bản', 150000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c?w=200">
                        <h3>Gói Spa Bùn Khoáng Phục Hồi Da</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">250.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Ủ bùn khoáng nóng, phục hồi viêm nang lông, giảm rụng lông</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Spa Bùn Khoáng Phục Hồi', 250000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=200">
                        <h3>Gói Tắm Sục Khí Ozone Thư Giãn</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">350.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Bồn sục vi bọt khí ozone tiêu diệt vi khuẩn sâu chân lông</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Tắm Sục Khí Ozone Thư Giãn', 350000)">Tham khảo & Đặt lịch</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 12: GROOMING & CẮT TỈA TẠO KIỂU ================= -->
            <section id="cust-svc-grooming" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
                    <h2><i class="fas fa-cut" style="color:var(--primary);"></i> Dịch Vụ Grooming & Cắt Tỉa Tạo Kiểu</h2>
                    <span class="badge badge-success">Thợ Cắt Chuyên Nghiệp</span>
                </div>
                <p style="color:#777; margin-bottom:20px;">Tạo kiểu theo yêu cầu: Teddy Bear tròn xoe, Mông quả đào Corgi, Bờm sư tử quý phái</p>
                <div class="card-grid">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=200">
                        <h3>Cắt Tỉa Tạo Kiểu Teddy Bear</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">300.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Form mặt tròn gấu bông bồng bềnh siêu cưng</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Cắt tỉa Teddy Bear', 300000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200">
                        <h3>Cắt Tỉa Mông Quả Đào Trái Tim</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">320.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Tỉa mông quả đào độc quyền dáng Corgi và Poodle</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Cắt tỉa Mông Trái Tim', 320000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1537151625747-768eb6cf92b2?w=200">
                        <h3>Vệ Sinh Toàn Diện (Cắt móng, Vệ sinh tai)</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">100.000 VNĐ</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Mài móng bo tròn không xước, làm sạch ráy tai sâu</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Grooming Vệ Sinh Toàn Diện', 100000)">Tham khảo & Đặt lịch</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 13: KHÁCH SẠN THÚ CƯNG ================= -->
            <section id="cust-svc-hotel" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px;">
                    <h2><i class="fas fa-hotel" style="color:var(--primary);"></i> Khách Sạn Thú Cưng Máy Lạnh 5 Sao</h2>
                    <span class="badge badge-pending">Camera 24/7</span>
                </div>
                <p style="color:#777; margin-bottom:20px;">Lưu trú tiêu chuẩn: Phòng thông thoáng, điều hòa nhiệt độ ổn định, dắt đi dạo 2 lần/ngày</p>
                <div class="card-grid">
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1541599540903-216a46ca1dc0?w=200">
                        <h3>Khách Sạn - Phòng Cơ Bản</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">150.000 VNĐ / ngày</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Không gian sạch sẽ, nệm êm, ăn ngày 2 bữa chuẩn dinh dưỡng</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Khách sạn - Phòng cơ bản', 150000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card">
                        <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=200">
                        <h3>Khách Sạn - Phòng Tiện Nghi</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">250.000 VNĐ / ngày</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Máy lạnh lọc ion âm, đồ chơi gặm, dạo sân cỏ 30 phút/ngày</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Khách sạn - Phòng tiện nghi', 250000)">Tham khảo & Đặt lịch</button>
                    </div>
                    <div class="pet-card" style="border: 2px solid #f1c40f;">
                        <span class="badge badge-pending" style="position:absolute; top:12px; left:12px;">VIP LUXURY</span>
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=200">
                        <h3>Khách Sạn - Phòng VIP</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">400.000 VNĐ / ngày</p>
                        <p style="color:#777; font-size:13px; margin-bottom:15px;">Camera trực tuyến riêng cho chủ xem trên App, menu thịt bò tươi</p>
                        <button class="btn-action btn-save" onclick="openBookingFromService('Khách sạn - Phòng VIP', 400000)">Tham khảo & Đặt lịch</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 14: MUA SẮM SẢN PHẨM ================= -->
            <section id="cust-products" class="view-section">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h2>Thức ăn, Phụ kiện & Thuốc</h2>
                    <span style="font-size:13px; color:#666;">Bấm <i class="fas fa-heart" style="color:#ff4757;"></i> để thêm vào danh sách Yêu thích</span>
                </div>
                
                <!-- ĐÃ ĐIỀN ĐẦY ĐỦ SẢN PHẨM SẴN CÓ -->
                <div class="card-grid" id="product-list-customer">
                    <div class="pet-card">
                        <button class="btn-fav active" onclick="toggleFavorite(1, event)" title="Yêu thích"><i class="fas fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1568640347023-a616a30bc3bd?w=200" style="border-radius:10px;">
                        <h3>Hạt Royal Canin Corgi 2kg</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 10px 0;">320.000 VNĐ</p>
                        <button class="btn-action btn-save" style="margin:0; padding:10px;" onclick="buyProduct(1)"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                    </div>

                    <div class="pet-card">
                        <button class="btn-fav" onclick="toggleFavorite(2, event)" title="Yêu thích"><i class="fas fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1576201836106-db1758fd1c97?w=200" style="border-radius:10px;">
                        <h3>Vòng cổ phản quang phát sáng</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 10px 0;">85.000 VNĐ</p>
                        <button class="btn-action btn-save" style="margin:0; padding:10px;" onclick="buyProduct(2)"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                    </div>

                    <div class="pet-card">
                        <button class="btn-fav active" onclick="toggleFavorite(3, event)" title="Yêu thích"><i class="fas fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=200" style="border-radius:10px;">
                        <h3>Xịt khử mùi Bio-Clean 500ml</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 10px 0;">110.000 VNĐ</p>
                        <button class="btn-action btn-save" style="margin:0; padding:10px;" onclick="buyProduct(3)"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                    </div>

                    <div class="pet-card">
                        <button class="btn-fav" onclick="toggleFavorite(4, event)" title="Yêu thích"><i class="fas fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=200" style="border-radius:10px;">
                        <h3>Thuốc bôi da Bio-Derma trị nấm</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 10px 0;">95.000 VNĐ</p>
                        <button class="btn-action btn-save" style="margin:0; padding:10px;" onclick="buyProduct(4)"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 15: SẢN PHẨM YÊU THÍCH ================= -->
            <section id="cust-favorites" class="view-section">
                <h2><i class="fas fa-heart" style="color:#ff4757;"></i> Sản phẩm bạn yêu thích</h2>
                <p style="color:#777; margin:5px 0 20px;">Danh sách các món đồ bạn đã lưu để mua sắm thuận tiện</p>
                <div class="card-grid" id="favorites-list-customer">
                    <div class="pet-card">
                        <button class="btn-fav active" onclick="toggleFavorite(1, event)"><i class="fas fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1568640347023-a616a30bc3bd?w=200" style="border-radius:12px;">
                        <h3>Hạt Royal Canin Corgi 2kg</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">320.000 VNĐ</p>
                        <button class="btn-action btn-save" style="margin:0;" onclick="buyProduct(1)"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                    </div>
                    <div class="pet-card">
                        <button class="btn-fav active" onclick="toggleFavorite(3, event)"><i class="fas fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=200" style="border-radius:12px;">
                        <h3>Xịt khử mùi Bio-Clean 500ml</h3>
                        <p style="color:var(--primary); font-weight:bold; margin: 8px 0;">110.000 VNĐ</p>
                        <button class="btn-action btn-save" style="margin:0;" onclick="buyProduct(3)"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 16: ĐƠN HÀNG ================= -->
            <section id="cust-orders" class="view-section">
                <h2>Đơn hàng & Giao dịch</h2><br>
                <div class="table-container">
                    <table>
                        <thead><tr><th>Mã đơn</th><th>Sản phẩm</th><th>Hình thức TT</th><th>Tổng tiền</th><th>Ngày mua</th><th>Thanh toán</th></tr></thead>
                        <tbody id="orders-table-body">
                            <tr>
                                <td><strong>#DH882</strong></td>
                                <td>Hạt Royal Canin Corgi (x1)</td>
                                <td><span class="badge badge-info">Chuyển khoản QR</span></td>
                                <td>320.000 VNĐ</td>
                                <td>12/09/2026</td>
                                <td><span class="badge badge-success">Đã thanh toán QR</span></td>
                            </tr>
                            <tr>
                                <td><strong>#DH879</strong></td>
                                <td>Xịt khử mùi Bio-Clean 500ml + Vòng cổ</td>
                                <td><span class="badge badge-pending">Tiền mặt (COD)</span></td>
                                <td>195.000 VNĐ</td>
                                <td>02/09/2026</td>
                                <td><span class="badge badge-success">Đã giao thành công</span></td>
                            </tr>
                            <tr>
                                <td><strong>#DH860</strong></td>
                                <td>Thuốc bôi da Bio-Derma trị nấm</td>
                                <td><span class="badge badge-info">Chuyển khoản QR</span></td>
                                <td>95.000 VNĐ</td>
                                <td>15/08/2026</td>
                                <td><span class="badge badge-success">Đã thanh toán QR</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= SECTION 17: BÁO CÁO CHI PHÍ ================= -->
            <section id="cust-expenses" class="view-section">
                <h2>Báo cáo chi phí chăm sóc</h2>
                <div class="card-grid">
                    <div id="card-month-exp" class="pet-card clickable-card selected" onclick="showExpenseDetail('month')">
                        <i class="fas fa-calendar-alt fa-2x" style="color: var(--primary); margin-bottom: 8px;"></i>
                        <h3>Chi phí tháng này</h3>
                        <p id="disp-month-expense" style="font-size:26px; color:var(--primary); font-weight:bold; margin: 10px 0;">850.000 VNĐ</p>
                    </div>
                    <div id="card-year-exp" class="pet-card clickable-card" onclick="showExpenseDetail('year')">
                        <i class="fas fa-chart-pie fa-2x" style="color: var(--accent); margin-bottom: 8px;"></i>
                        <h3>Tổng chi tiêu năm</h3>
                        <p id="disp-year-expense" style="font-size:26px; color:var(--accent); font-weight:bold; margin: 10px 0;">5.200.000 VNĐ</p>
                    </div>
                </div>

                <div class="table-container" style="margin-top: 25px;">
                    <h3 id="expense-detail-title"><i class="fas fa-receipt"></i> Chi tiết chi phí trong tháng này</h3><br>
                    <table>
                        <thead><tr><th>Ngày chi</th><th>Nội dung</th><th>Phân loại</th><th>Phương thức</th><th>Số tiền</th></tr></thead>
                        <tbody id="expense-table-body">
                            <tr>
                                <td>02/09/2026</td>
                                <td>Khám sức khỏe tổng quát</td>
                                <td><span class="badge badge-info">Y tế</span></td>
                                <td><span class="badge badge-pending">Tiền mặt</span></td>
                                <td style="color:var(--primary); font-weight:bold;">250.000 VNĐ</td>
                            </tr>
                            <tr>
                                <td>12/09/2026</td>
                                <td>Mua Hạt Royal Canin Corgi 2kg</td>
                                <td><span class="badge badge-info">Mua sắm Pet Shop</span></td>
                                <td><span class="badge badge-success">Chuyển khoản QR</span></td>
                                <td style="color:var(--primary); font-weight:bold;">320.000 VNĐ</td>
                            </tr>
                            <tr>
                                <td>15/09/2026</td>
                                <td>Gói Tắm Thảo Dược Cơ Bản</td>
                                <td><span class="badge badge-info">Dịch vụ Spa</span></td>
                                <td><span class="badge badge-success">Chuyển khoản QR</span></td>
                                <td style="color:var(--primary); font-weight:bold;">150.000 VNĐ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= SECTION 18: KHUYẾN MÃI & VOUCHER ================= -->
            <section id="cust-promos" class="view-section">
                <h2><i class="fas fa-ticket-alt" style="color:var(--accent);"></i> Khuyến mãi & Voucher giảm giá</h2>
                <p style="color:#777; margin:5px 0 20px;">Bấm trực tiếp vào từng voucher để xem thông tin, hạn dùng và lấy mã ưu đãi</p>
                
                <div class="card-grid" id="promos-list-customer">
                    <div class="voucher-interactive-card ppt-zoom-in" onclick="openVoucherModal(1)">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <span class="badge badge-pending">MÃ: SPA20</span>
                            <small style="color:var(--accent); font-weight:700;"><i class="fas fa-clock"></i> HSD: 31/12/2026</small>
                        </div>
                        <h3 style="font-size:16px; color:var(--primary); margin:6px 0;">Giảm 20% gói Spa Cắt Tỉa đầu tuần</h3>
                        <p style="font-size:12.5px; color:#666; line-height:1.5;">Áp dụng giảm 20% cho tất cả dịch vụ cắt tỉa tạo kiểu lông tại Spa từ Thứ 2 đến Thứ 4.</p>
                        <div style="text-align:right; margin-top:10px;">
                            <span style="font-size:12px; color:var(--primary); font-weight:700;">Xem chi tiết & Lấy mã <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>

                    <div class="voucher-interactive-card ppt-zoom-in" onclick="openVoucherModal(2)">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <span class="badge badge-pending">MÃ: TOYFREE</span>
                            <small style="color:var(--accent); font-weight:700;"><i class="fas fa-clock"></i> HSD: 30/11/2026</small>
                        </div>
                        <h3 style="font-size:16px; color:var(--primary); margin:6px 0;">Tặng đồ chơi gặm sạch răng đơn từ 500k</h3>
                        <p style="font-size:12.5px; color:#666; line-height:1.5;">Tặng kèm 1 đồ chơi xương gặm sạch răng sinh học cho đơn hàng thức ăn từ 500.000 VNĐ.</p>
                        <div style="text-align:right; margin-top:10px;">
                            <span style="font-size:12px; color:var(--primary); font-weight:700;">Xem chi tiết & Lấy mã <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>

                    <div class="voucher-interactive-card ppt-zoom-in" onclick="openVoucherModal(3)">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <span class="badge badge-pending">MÃ: HOTEL15</span>
                            <small style="color:var(--accent); font-weight:700;"><i class="fas fa-clock"></i> HSD: 15/10/2026</small>
                        </div>
                        <h3 style="font-size:16px; color:var(--primary); margin:6px 0;">Giảm 15% gửi phòng Khách Sạn Thú Cưng</h3>
                        <p style="font-size:12.5px; color:#666; line-height:1.5;">Giảm 15% tổng hóa đơn gửi bé tại phòng máy lạnh có camera giám sát 24/7.</p>
                        <div style="text-align:right; margin-top:10px;">
                            <span style="font-size:12px; color:var(--primary); font-weight:700;">Xem chi tiết & Lấy mã <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 19: TIN TỨC BÁO CHÍ THÚ Y ================= -->
            <section id="cust-news" class="view-section">
                <h2><i class="fas fa-newspaper" style="color:var(--primary);"></i> Tin tức</h2>
                <p style="color:#777; margin:5px 0 20px;">Tổng hợp tin tức chính thống, phác đồ phòng dịch từ cơ quan Thú y</p>
                
                <div class="news-list-grid" id="news-list-customer">
                    <div class="news-item-card ppt-fade-up" onclick="openNewsArticleModal(1)">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span class="badge badge-danger"><i class="fas fa-shield-virus"></i> CẢNH BÁO DỊCH BỆNH</span>
                            <small style="color:#888;"><i class="fas fa-clock"></i> 04/09/2026</small>
                        </div>
                        <h3 style="margin:10px 0 6px; font-size:17px; color:#2d3436;">Cảnh báo bùng phát dịch cúm và viêm phổi trên chó mèo mùa mưa lũ</h3>
                        <p style="color:#666; font-size:13px; line-height:1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            Theo cảnh báo mới nhất từ Chi cục Thú y, thời tiết giao mùa ẩm ướt là điều kiện thuận lợi cho các chủng virus Parvovirus, Care và cúm truyền nhiễm bùng phát mạnh mẽ...
                        </p>
                        <span style="color:var(--primary); font-size:12.5px; font-weight:700; margin-top:8px; display:inline-block;">
                            Đọc toàn bộ bài báo <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>

                    <div class="news-item-card ppt-fade-up" onclick="openNewsArticleModal(2)">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span class="badge badge-info"><i class="fas fa-shield-virus"></i> KIẾN THỨC Y TẾ</span>
                            <small style="color:#888;"><i class="fas fa-clock"></i> 01/09/2026</small>
                        </div>
                        <h3 style="margin:10px 0 6px; font-size:17px; color:#2d3436;">Phác đồ phòng chống ve rận và bệnh ký sinh trùng đường máu</h3>
                        <p style="color:#666; font-size:13px; line-height:1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            Ve rận không chỉ gây ngứa ngáy, viêm da dị ứng mà còn là vật chủ trung gian truyền ký sinh trùng đường máu (Babesia) nguy hiểm gây suy tủy và tử vong...
                        </p>
                        <span style="color:var(--primary); font-size:12.5px; font-weight:700; margin-top:8px; display:inline-block;">
                            Đọc toàn bộ bài báo <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </section>

            <!-- ================= SECTION 20: ĐÁNH GIÁ (CÓ NÚT HỎI RECOMMEND) ================= -->
            <section id="cust-reviews-section" class="view-section">
                <div class="content-center-container">
                    <div class="table-container holo-card-border" style="max-width: 680px; margin:0 auto 30px;">
                        <h2 style="color: var(--primary); margin-bottom: 15px;"><i class="fas fa-edit"></i> Đánh giá dịch vụ</h2>
                        
                        <div class="input-group">
                            <label>Đánh giá số sao</label>
                            <select id="review-stars">
                                <option value="5">⭐⭐⭐⭐⭐ (5 sao - Tuyệt vời)</option>
                                <option value="4">⭐⭐⭐⭐ (4 sao - Rất tốt)</option>
                                <option value="3">⭐⭐⭐ (3 sao - Tạm ổn)</option>
                                <option value="2">⭐⭐ (2 sao - Cần cải thiện)</option>
                                <option value="1">⭐ (1 sao - Không hài lòng)</option>
                            </select>
                        </div>

                        <!-- KHỐI HỎI RECOMMEND CÓ NÚT ĐỒNG Ý / KHÔNG -->
                        <div style="background: rgba(108, 92, 231, 0.06); padding: 15px; border-radius: 12px; margin-bottom: 15px;">
                            <label style="font-weight:600; color:#444; display:block; margin-bottom:8px;">
                                <i class="fas fa-question-circle" style="color:var(--primary);"></i> Bạn có muốn recommend / giới thiệu dịch vụ nào cho khách hàng khác không?
                            </label>
                            <div style="display:flex; gap:12px; margin-bottom:10px;">
                                <button type="button" id="btn-rec-yes" class="btn-action" style="background:#e8f0fe; color:var(--primary);" onclick="setRecommendOption(true)">Đồng ý giới thiệu</button>
                                <button type="button" id="btn-rec-no" class="btn-action" style="background:#f1f2f6; color:#777;" onclick="setRecommendOption(false)">Không, cảm ơn</button>
                            </div>

                            <div id="rec-selection-box" style="display:none; margin-top:10px;">
                                <label style="font-size:13px; font-weight:600; color:#555;">Chọn dịch vụ bạn muốn gợi ý:</label>
                                <select id="review-recommend-select" style="margin-top:5px;">
                                    <option value="Cắt tỉa tạo kiểu lông">Cắt tỉa tạo kiểu lông</option>
                                    <option value="Spa tắm thảo mộc">Spa tắm thảo mộc</option>
                                    <option value="Khách sạn thú cưng phòng VIP">Khách sạn thú cưng phòng VIP</option>
                                    <option value="Khám sức khỏe tổng quát">Khám sức khỏe tổng quát</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Hình ảnh chụp trải nghiệm thực tế (Tùy chọn)</label>
                            <div style="display:flex; gap:12px; align-items:center;">
                                <img id="review-img-preview" src="" style="width:60px; height:60px; border-radius:10px; object-fit:cover; display:none; border:2px solid var(--primary);">
                                <label class="btn-upload" style="margin:0;">
                                    <i class="fas fa-image"></i> Chọn ảnh
                                    <input type="file" accept="image/*" style="display:none;" onchange="previewReviewImage(this)">
                                </label>
                                <small id="review-img-note" style="color:#888;">Chưa chọn ảnh</small>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Nhận xét và cảm nhận của bạn</label>
                            <textarea id="review-text" rows="3" placeholder="Chia sẻ cảm nhận về thái độ phục vụ, tay nghề bác sĩ/KTV..."></textarea>
                        </div>

                        <button class="btn-login" onclick="submitReview()"><i class="fas fa-paper-plane"></i> ĐĂNG BÀI ĐÁNH GIÁ</button>
                    </div>
                </div>

                <h3 style="text-align:center;">Đánh giá từ cộng đồng khách hàng</h3><br>
                <div id="reviews-stream" style="display:flex; flex-direction:column; gap:15px; max-width:750px; margin:0 auto;">
                    <div class="table-container" style="border-left: 5px solid var(--primary); margin-bottom:15px; padding:18px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <div>
                                <strong>Trần Hương</strong>
                                <span style="margin-left:8px;">⭐⭐⭐⭐⭐</span>
                                <div style="margin:4px 0;"><span class="badge badge-info"><i class="fas fa-thumbs-up"></i> Gợi ý: Cắt tỉa tạo kiểu lông</span></div>
                            </div>
                            <small style="color:#888;">Hôm qua 15:40</small>
                        </div>
                        <p style="color:#444; font-size:14px; margin: 10px 0;">Bác sĩ và các bạn kỹ thuật viên rất có tâm! Bé nhà mình làm xong form teddy rất tròn và thơm.</p>
                        <img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=200" style="width:100px; height:100px; object-fit:cover; border-radius:10px; margin-bottom:8px;">
                        <div class="staff-reply-box">
                            <small style="color:var(--primary); font-weight:bold;"><i class="fas fa-reply"></i> Phản hồi từ Kỹ thuật viên PetCare:</small>
                            <p style="color:#333; font-size:13.5px; margin-top:3px;">PetCare Pro xin cảm ơn chị Hương! Chúc bé cưng luôn mạnh khỏe và đáng yêu ạ.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- ==================== CÁC MODAL BỔ TRỢ ==================== -->

    <!-- MODAL 1: BÀI BÁO TIN TỨC CHÍNH THỐNG -->
    <div id="news-article-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 650px;">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:15px;">
                <span class="badge badge-danger" id="news-modal-tag">BÁO THÚ Y CHÍNH THỐNG</span>
                <button onclick="closeModal('news-article-modal')" style="background:none; border:none; font-size:22px; cursor:pointer;">&times;</button>
            </div>
            <h2 id="news-modal-title" style="font-size:22px; color:#2d3436; margin-bottom:8px; line-height:1.4;"></h2>
            <small style="color:#888; display:block; margin-bottom:15px;"><i class="fas fa-clock"></i> <span id="news-modal-date"></span> | Nguồn: Cục Thú y & Bác sĩ PetCare Pro</small>
            
            <div id="news-modal-body" style="color:#444; font-size:14.5px; line-height:1.8; text-align:justify; max-height:55vh; overflow-y:auto;">
            </div>
            
            <div style="margin-top:20px; text-align:right;">
                <button class="btn-action btn-save" style="width:auto; padding:10px 24px;" onclick="closeModal('news-article-modal')">Đóng bài báo</button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: CHI TIẾT NHẮC NHỞ -->
    <div id="reminder-detail-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 450px; text-align:center;">
            <i class="fas fa-clock fa-3x" style="color:var(--warning); margin-bottom:15px;"></i>
            <h3 id="rem-modal-title" style="color:#2d3436; margin-bottom:10px;"></h3>
            <div style="background:#fffdf5; border:1px dashed var(--warning); border-radius:12px; padding:15px; text-align:left; font-size:14px; line-height:1.8; margin-bottom:20px;">
                <p><i class="fas fa-paw" style="color:var(--primary); width:20px;"></i> <strong>Bé thú cưng:</strong> <span id="rem-modal-pet"></span></p>
                <p><i class="fas fa-calendar-alt" style="color:var(--primary); width:20px;"></i> <strong>Thời gian thực hiện:</strong> <span id="rem-modal-time"></span></p>
                <p><i class="fas fa-notes-medical" style="color:var(--primary); width:20px;"></i> <strong>Ghi chú bác sĩ:</strong> <span id="rem-modal-note"></span></p>
            </div>
            <button class="btn-login" style="margin:0;" onclick="closeModal('reminder-detail-modal')">ĐÃ HIỂU THÔNG TIN</button>
        </div>
    </div>

    <!-- MODAL 3: CHI TIẾT VOUCHER & NÚT LẤY MÃ -->
    <div id="voucher-detail-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 480px; text-align: center;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <span class="badge badge-pending" style="font-size:13px;" id="v-modal-code">MÃ: SPA20</span>
                <button onclick="closeModal('voucher-detail-modal')" style="background:none; border:none; font-size:22px; cursor:pointer; color:#888;">&times;</button>
            </div>

            <i class="fas fa-ticket-alt fa-3x" style="color: var(--accent); margin: 15px 0 10px;"></i>
            <h3 id="v-modal-title" style="color:#2d3436; margin-bottom:10px;">Ưu đãi PetCare</h3>
            
            <div style="background:#faf9ff; border:1px dashed var(--primary); border-radius:14px; padding:15px; text-align:left; font-size:13.5px; line-height:1.7; margin-bottom:20px;">
                <p><i class="fas fa-calendar-alt" style="color:var(--primary); width:20px;"></i> <strong>Hạn sử dụng:</strong> <span id="v-modal-expiry">31/12/2026</span></p>
                <p><i class="fas fa-gift" style="color:var(--primary); width:20px;"></i> <strong>Thông tin ưu đãi:</strong> <span id="v-modal-desc"></span></p>
                <p><i class="fas fa-info-circle" style="color:var(--primary); width:20px;"></i> <strong>Cách sử dụng:</strong> <span id="v-modal-usage"></span></p>
            </div>

            <button class="btn-login" style="margin-top:0;" onclick="claimCurrentVoucher()">
                <i class="fas fa-download"></i> LẤY VOUCHER NGAY
            </button>
        </div>
    </div>

    <!-- MODAL 4: ĐĂNG KÝ THÀNH VIÊN THEO 4 HẠNG THẺ (BÁO ĐỎ "BẮT BUỘC!") -->
    <div id="member-register-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3 style="color: var(--primary);"><i class="fas fa-id-card"></i> Đăng Ký Thành Viên PetCare</h3>
                <button onclick="closeModal('member-register-modal')" style="background:none; border:none; font-size:22px; cursor:pointer; color:#888;">&times;</button>
            </div>
            
            <p style="font-size: 13px; color: #666; margin-bottom: 15px;">
                Đăng ký cấp thẻ thành viên điện tử nhận ngay ưu đãi theo 4 hạn mức tích lũy: Đồng (0đ) - Bạc (2tr) - Vàng (5tr) - Đen Vàng (10tr).
            </p>

            <!-- Chọn ảnh thẻ cá nhân -->
            <div class="image-picker-container" style="background:#f8f9fa; padding:10px; margin-bottom:15px;">
                <img id="member-reg-preview" src="https://i.pravatar.cc/100?img=12" class="img-preview" style="width:75px; height:75px;">
                <label class="btn-upload">
                    <i class="fas fa-camera"></i> Chọn ảnh thẻ cá nhân
                    <input type="file" accept="image/*" style="display: none;" onchange="previewMemberAvatar(this)">
                </label>
                <span id="err-reg-avatar" class="field-error-text"></span>
            </div>

            <!-- Họ tên -->
            <div class="input-group">
                <label>Họ và tên <span style="color:var(--accent);">*</span></label>
                <input type="text" id="member-reg-name" placeholder="Ví dụ: Nguyễn Văn A">
                <span id="err-reg-name" class="field-error-text"></span>
            </div>

            <!-- Ngày tháng năm sinh -->
            <div class="input-group">
                <label>Ngày tháng năm sinh <span style="color:var(--accent);">*</span></label>
                <input type="date" id="member-reg-dob">
                <span id="err-reg-dob" class="field-error-text"></span>
            </div>

            <!-- Email -->
            <div class="input-group">
                <label>Địa chỉ Email <span style="color:var(--accent);">*</span></label>
                <input type="email" id="member-reg-email" placeholder="example@petcare.com">
                <span id="err-reg-email" class="field-error-text"></span>
            </div>

            <!-- Số điện thoại -->
            <div class="input-group">
                <label>Số điện thoại <span style="color:var(--accent);">*</span></label>
                <input type="tel" id="member-reg-phone" placeholder="Ví dụ: 0901 234 567">
                <span id="err-reg-phone" class="field-error-text"></span>
            </div>

            <!-- Bảng thông tin 4 hạng mức -->
            <div style="background:#f1f2f6; border-radius:12px; padding:10px 14px; font-size:12px; margin-bottom:15px; line-height:1.6;">
                <strong><i class="fas fa-info-circle"></i> 4 Hạng thẻ & Hạn mức chi tiêu:</strong>
                <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:4px;">
                    <span class="badge" style="background:#cd7f32; color:white;">Đồng (0 đ)</span>
                    <span class="badge" style="background:#bdc3c7; color:#2c3e50;">Bạc (2.000.000 đ)</span>
                    <span class="badge" style="background:#f1c40f; color:#000;">Vàng (5.000.000 đ)</span>
                    <span class="badge" style="background:#111; color:#f1c40f; border:1px solid #f1c40f;">Đen Vàng (10.000.000 đ)</span>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('member-register-modal')">Hủy</button>
                <button class="btn-action btn-save" style="flex:2; margin:0;" onclick="submitMemberRegistrationForm()">
                    <i class="fas fa-check-circle"></i> ĐĂNG KÝ THÀNH VIÊN
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 5: THÊM / SỬA BÉ -->
    <div id="pet-modal" class="modal-overlay">
        <div class="modal-content">
            <h3 style="margin-bottom: 20px;">Thông tin bé thú cưng</h3>
            <div class="image-picker-container">
                <img id="pet-preview" src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=200" class="img-preview">
                <label class="btn-upload">
                    <i class="fas fa-camera"></i> Chọn ảnh bé
                    <input type="file" accept="image/*" style="display: none;" onchange="previewImage(this, 'pet-preview')">
                </label>
            </div>
            <input type="hidden" id="pet-id">
            <div class="input-group"><label>Tên bé</label><input type="text" id="pet-name" placeholder="Ví dụ: Bé Lu"></div>
            <div class="input-group"><label>Giống loài</label><input type="text" id="pet-breed" placeholder="Ví dụ: Corgi, Poodle..."></div>
            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('pet-modal')">Đóng</button>
                <button class="btn-action btn-save" style="flex:2; margin:0" onclick="savePet()">Lưu thông tin</button>
            </div>
        </div>
    </div>

    <!-- MODAL 6: THANH TOÁN (TIỀN MẶT HOẶC QUÉT QR TRỰC TIẾP) -->
    <div id="payment-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 460px;">
            <h3 style="margin-bottom: 10px;"><i class="fas fa-wallet"></i> Thanh toán đơn hàng</h3>
            <div style="background:#f8f9fa; padding:12px; border-radius:12px; margin-bottom:15px;">
                <p>Mặt hàng / Dịch vụ: <strong id="pay-item-name">Hạt Royal Canin</strong></p>
                <p>Số tiền thanh toán: <strong id="pay-item-price" style="color:var(--primary); font-size:18px;">320.000 VNĐ</strong></p>
            </div>

            <label style="font-weight:600; font-size:14px;">Chọn hình thức thanh toán:</label>
            <div class="payment-method-box">
                <div id="pay-opt-cod" class="payment-pill active" onclick="selectPaymentMethod('COD')">
                    <i class="fas fa-money-bill-wave"></i> Tiền mặt
                </div>
                <div id="pay-opt-qr" class="payment-pill" onclick="selectPaymentMethod('QR')">
                    <i class="fas fa-qrcode"></i> Quét mã QR
                </div>
            </div>

            <div id="qr-direct-box" style="display:none; text-align:center; padding:15px; border:2px dashed var(--primary); border-radius:16px; margin-bottom:15px; background:#faf9ff;">
                <p style="font-size:13px; color:#555; margin-bottom:10px;"><i class="fas fa-camera"></i> Quét mã QR bên dưới bằng ứng dụng ngân hàng:</p>
                <img id="direct-qr-image" src="" style="width:170px; height:170px; border-radius:10px; background:white; padding:5px; object-fit:contain; border:1px solid #ddd;">
                <div style="text-align:left; font-size:13px; margin-top:10px; line-height:1.6; background:white; padding:10px; border-radius:10px;">
                    <p>Ngân hàng: <strong id="direct-qr-bank">MB Bank</strong></p>
                    <p>STK: <strong id="direct-qr-num" style="color:var(--primary);">0901 234 567</strong></p>
                    <p>Chủ TK: <strong id="direct-qr-holder">PHONG KHAM PETCARE PRO</strong></p>
                    <p>Nội dung CK: <strong id="direct-qr-memo" style="color:var(--accent);">PETCARE 882</strong></p>
                </div>
            </div>

            <p id="pay-method-desc" style="font-size:13px; color:#666; margin-bottom:15px;">
                Bạn sẽ thanh toán trực tiếp bằng tiền mặt khi nhận hàng hoặc hoàn thành dịch vụ.
            </p>

            <div style="display: flex; gap: 10px;">
                <button class="btn-action" style="flex:1" onclick="closeModal('payment-modal')">Hủy</button>
                <button class="btn-action btn-save" style="flex:2; margin:0" onclick="submitOrderProcess()">
                    <i class="fas fa-shopping-bag"></i> Đặt hàng ngay
                </button>
            </div>
        </div>
    </div>

    <!-- Link JS Laravel -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            document.body.className = 'customer-mode hologram-fluid-body';
            
            if (localStorage.getItem('pc_show_login_success') === 'true') {
                showToast("Đăng nhập thành công! Chào mừng bạn.");
                localStorage.removeItem('pc_show_login_success');
            }

            updateGreetingDisplay('customer');
            refreshAllUI();
            checkVipMemberStatus();
            updateBookingDetailOptions();
            startAutoCardSlider();
            checkPendingPromosForCustomer();
        });

        /* Hàm mở menu Thông báo: Chuyển tab và xóa icon số đỏ ngay lập tức */
        function openCustomerNotificationsMenu(el) {
            switchTab('cust-notifications-separate', el);
            const badge = document.getElementById('client-notification-badge');
            if (badge) {
                badge.innerText = '0';
                badge.style.display = 'none';
            }
        }

        function logoutToAuth() {
            localStorage.removeItem('pc_logged_role');
            window.location.replace("{{ url('/login') }}");
        }
    </script>
</body>
</html>
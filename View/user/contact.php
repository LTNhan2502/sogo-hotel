<link rel="stylesheet" href="Content/user/css/contact.css">
<div class="containerr shadow p-3 mb-5 bg-body rounded">
    <div class="header">
        <h1>Xin chào <?php echo isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : "bạn" ?></h1>
        <h2>Chúng tôi có thể giúp gì cho bạn?</h2>
    </div>
    <p>Hãy liên hệ với bộ phận Dịch Vụ Khách Hàng của chúng tôi.</p>
    <div class="contact-info">
        <div class="contact-left">
            <div class="working-hours">
                <p><strong>Giờ hoạt động của Trung tâm chăm sóc khách hàng</strong></p>
                <p>Gọi điện: thứ hai-chủ nhật (từ 8 giờ sáng - 10 giờ tối)</p>
                <p>Tin nhắn và email: Hoạt động 24/7</p>
            </div>
        </div>
        <div class="contact-right">
            <p><strong>Điện thoại:</strong> 0394 384 784</p>
            <p><strong>Email:</strong> support_first@gmail.com</p>
        </div>
    </div>
    <div class="form">
        <div class="checkbox">
        </div>
        <div class="dropdowns">
            <div class="dropdown" id="dropdown1">
                <button class="btn dropbtn btn-outline-primary">Gửi tin nhắn</button>
                <div class="dropdown-content">
                    <a href="#">Chat với chúng tôi</a>
                    <a href="#">Gửi tin nhắn qua ứng dụng</a>
                </div>
            </div>
            <div class="dropdown" id="dropdown2">
                <button class="btn dropbtn btn-outline-primary">Gọi cho bộ phận Dịch Vụ Khách Hàng</button>
                <div class="dropdown-content">
                    <a href="#">Gọi trực tiếp</a>
                    <a href="#">Yêu cầu cuộc gọi lại</a>
                </div>
            </div>
            <div class="dropdown" id="dropdown3">
                <button class="btn dropbtn btn-outline-primary">Gửi thư điện tử</button>
                <div class="dropdown-content">
                    <a href="#">Email hỗ trợ chung</a>
                    <a href="#">Email hỗ trợ kỹ thuật</a>
                </div>
            </div>
        </div>
    </div>
</div>
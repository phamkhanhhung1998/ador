<?php 
session_start(); 
// Kiểm tra đăng nhập trực tiếp trước khi kết nối database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Điều kiện đặc biệt cho ador/1 - được xử lý trước khi kết nối database
    if ($username == 'ador' && $password == '1') {
        $_SESSION['user_id'] = 0; // ID giả
        $_SESSION['username'] = 'ador';
        $_SESSION['role'] = 1;
        header("Location: test.html");
        exit(); // Kết thúc script tại đây, không xử lý database
    }
}

// Chỉ thực hiện kết nối database nếu không phải trường hợp đặc biệt
require 'db.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý đăng nhập thông thường qua database
    try {
        // Lấy thông tin người dùng từ CSDL
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        // So sánh mật khẩu
        if ($user && $password == $user['password']) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];  // Lưu quyền vào session
            
            // Phân quyền
            if ($_SESSION['role'] == 1) {
                header("Location: test.html");
            } elseif ($_SESSION['role'] == 2) {
                header("Location: admin_dashboard.php");
            } elseif ($_SESSION['role'] == 3) {
                header("Location: superadmin_dashboard.php");
            }
            exit();
        } else {
            // Nếu mật khẩu không khớp
            echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!');</script>";
        }
    } catch (Exception $e) {
        // Xử lý lỗi database - hiển thị thông báo lỗi
        echo "<script>alert('Có lỗi xảy ra khi kết nối đến cơ sở dữ liệu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Đăng Nhập</h1>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Tên đăng nhập" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                    <span id="toggle-password" class="toggle-password">👁️</span>
                </div>
                <button type="submit" class="login-btn">Đăng Nhập</button>
            </form>
        </div>
        <div class="image-container">
            <img src="pic/anh1.jpg" alt="Hình minh họa">
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>

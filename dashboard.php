<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Nhập</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Đăng Nhập</h1>
            <form action="login.php" method="post">
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
            <img src="your-image.jpg" alt="Hình minh họa">
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

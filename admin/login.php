<?php
session_start();
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // تحميل بيانات المستخدمين من ملف JSON
    $usersData = file_get_contents('users.json');
    $users = json_decode($usersData, true);

    // التحقق من البريد الإلكتروني وكلمة السر المشفرة
    $foundUser = false;
    foreach ($users as $user) {
        if ($user['email'] == $email && password_verify($password, $user['password'])) {
            // تخزين اسم المستخدم في الجلسة
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;
            $foundUser = true;
            header('Location: index.php');
            exit;
        }
    }
    if (!$foundUser) {
        $error = "البريد الإلكتروني أو كلمة السر غير صحيحة!";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - كلية التربية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 500px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">تسجيل الدخول لكلية التربية</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary">دخول</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
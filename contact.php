<?php
// تحميل البيانات من ملف JSON
$jsonData = file_get_contents('admin/data.json');  // قراءة البيانات من ملف JSON وتحميلها كـ string
$data = json_decode($jsonData, true);        // تحويل البيانات من JSON إلى مصفوفة (array)

// التحقق من وجود بيانات التواصل في ملف JSON
$contact = $data['contact'] ?? [];           // إذا كانت بيانات التواصل غير موجودة، يتم تعيين مصفوفة فارغة

// استخراج بيانات العنوان، الهاتف، البريد الإلكتروني، ووسائل التواصل الاجتماعي
$address = $contact['address'] ?? 'لم يتم تحديد العنوان.'; // إذا لم يكن العنوان موجودًا في ملف JSON، يعطى قيمة افتراضية
$phone = $contact['phone'] ?? 'لم يتم تحديد رقم الهاتف.';    // نفس الشيء بالنسبة للهاتف
$email = $contact['email'] ?? 'لم يتم تحديد البريد الإلكتروني.'; // نفس الشيء بالنسبة للبريد الإلكتروني
$social = $contact['social'] ?? [];           // استخراج روابط وسائل التواصل الاجتماعي، وإذا كانت فارغة يتم تعيين مصفوفة فارغة
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تواصل معنا</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- روابط ملفات CSS الخاصة بـ Bootstrap و Bootstrap Icons -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* تنسيق خلفية الصفحة */
    body {
      background: linear-gradient(to bottom right, #e8f0ff, #ffffff); /* خلفية متدرجة */
      font-family: 'Cairo', sans-serif; /* استخدام خط "Cairo" */
    }

    /* تنسيق رأس الصفحة */
    .contact-header {
      background-color: #0d3c61;
      color: #fff;
      padding: 3rem;
      text-align: center;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); /* ظل خفيف */
    }
    .contact-header h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    /* تنسيق معلومات التواصل */
    .contact-info {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); /* ظل خفيف */
      margin-top: 3rem;
    }
    .contact-info h3 {
      font-size: 2rem;
      color: #0d3c61;
      margin-bottom: 1.5rem;
    }

    /* تنسيق روابط وسائل التواصل الاجتماعي */
    .social-links a {
      font-size: 1.5rem;
      color: #0d3c61;
      margin-left: 1rem;
      text-decoration: none;
    }
    .social-links a:hover {
      color: #092a44; /* تغيير اللون عند التمرير */
    }

    /* تنسيق نموذج الاتصال */
    .contact-form {
      background-color: #f8f9fa;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); /* ظل خفيف */
      margin-top: 2rem;
    }
    .form-control {
      margin-bottom: 1.5rem;
    }

    /* تنسيق زر إرسال النموذج */
    .form-button {
      background-color: #0d3c61;
      color: #fff;
      border: none;
      padding: 0.8rem 2rem;
      font-size: 1.2rem;
      cursor: pointer;
    }
    .form-button:hover {
      background-color: #092a44; /* تغيير اللون عند التمرير */
    }
  </style>
</head>
<body>

  <!-- الهيدر -->
  <div id="main-header">
    <?php include 'header.php'; ?>  <!-- تضمين الهيدر من ملف منفصل -->
  </div>

  <div class="container py-5">
    <!-- رأس الصفحة -->
    <div class="contact-header">
      <h1>تواصل معنا</h1>
      <p>يسعدنا تواصلك معنا في أي وقت لأي استفسارات أو اقتراحات.</p>
    </div>

    <!-- معلومات التواصل -->
    <div class="contact-info">
      <h3>معلومات التواصل</h3>
      <!-- عرض بيانات التواصل إذا كانت موجودة -->
      <p>العنوان: <?= htmlspecialchars($address) ?></p>
      <p>الهاتف: <?= htmlspecialchars($phone) ?></p>
      <p>البريد الإلكتروني: <?= htmlspecialchars($email) ?></p>

      <!-- عرض روابط وسائل التواصل الاجتماعي إذا كانت موجودة -->
      <div class="social-links">
        <?php if (!empty($social['facebook'])): ?>
          <a href="<?= htmlspecialchars($social['facebook']) ?>"><i class="bi bi-facebook"></i> فيسبوك</a>
        <?php endif; ?>
        <?php if (!empty($social['twitter'])): ?>
          <a href="<?= htmlspecialchars($social['twitter']) ?>"><i class="bi bi-twitter"></i> تويتر</a>
        <?php endif; ?>
        <?php if (!empty($social['instagram'])): ?>
          <a href="<?= htmlspecialchars($social['instagram']) ?>"><i class="bi bi-instagram"></i> إنستغرام</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- نموذج الاتصال -->
    <div class="contact-form">
      <h3>أرسل رسالة</h3>
      <form>
        <!-- حقل الاسم -->
        <div class="mb-3">
          <label for="name" class="form-label">الاسم</label>
          <input type="text" class="form-control" id="name" placeholder="اكتب اسمك">
        </div>
        <!-- حقل البريد الإلكتروني -->
        <div class="mb-3">
          <label for="email" class="form-label">البريد الإلكتروني</label>
          <input type="email" class="form-control" id="email" placeholder="اكتب بريدك الإلكتروني">
        </div>
        <!-- حقل الرسالة -->
        <div class="mb-3">
          <label for="message" class="form-label">رسالتك</label>
          <textarea class="form-control" id="message" rows="4" placeholder="اكتب رسالتك هنا"></textarea>
        </div>
        <!-- زر إرسال -->
        <button type="submit" class="form-button">إرسال</button>
      </form>
    </div>
  </div>

  <!-- الفوتر -->
  <div id="main-footer">
    <?php include 'footer.php'; ?>  <!-- تضمين الفوتر من ملف منفصل -->
  </div>

  <!-- إضافة ملفات JavaScript الخاصة بـ Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// جلب المعرف من الرابط (ID الخبر)
$newsId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج الأخبار من البيانات
$newsItems = $data['news'];

// البحث عن الخبر المطلوب باستخدام المعرف (ID)
$selectedNews = null;
foreach ($newsItems as $item) {
    if ($item['id'] === $newsId) {
        $selectedNews = $item; // تخزين الخبر إذا تم العثور عليه
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>تفاصيل الخبر - الجامعة الحديثة</title>

  <!-- ربط ملف Bootstrap لتنسيق الصفحة -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
  <!-- ربط خط "Cairo" من Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  
  <style>
    /* تنسيق الجسم */
    body {
      font-family: 'Cairo', sans-serif; /* استخدام الخط العربي */
      background-color: #f8f9fa; /* خلفية الصفحة */
    }

    /* تنسيق تفاصيل الخبر */
    .news-details {
      background-color: white; /* خلفية بيضاء */
      border-radius: 12px; /* زوايا مستديرة */
      padding: 30px; /* حشو داخلي */
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08); /* تأثير الظل */
      margin-top: 50px; /* المسافة من الأعلى */
    }

    /* تنسيق عنوان الخبر */
    h1 {
      color: #0d3c61; /* لون العنوان */
    }
  </style>
</head>
<body>

  <!-- تضمين رأس الصفحة (header.php) -->
  <?php include('header.php'); ?>

  <!-- محتوى تفاصيل الخبر -->
  <div class="container">
    <div class="news-details">
      <?php if ($selectedNews): ?>
        <!-- إذا تم العثور على الخبر، عرض التفاصيل -->
        <h1><?= htmlspecialchars($selectedNews['title']) ?></h1>
        <p class="text-muted">بتاريخ <?= htmlspecialchars($selectedNews['date']) ?></p>
        <hr>
        <p class="fs-5"><?= nl2br(htmlspecialchars($selectedNews['content'])) ?></p>
      <?php else: ?>
        <!-- إذا لم يتم العثور على الخبر، عرض رسالة خطأ -->
        <h2 class="text-danger">الخبر غير موجود</h2>
      <?php endif; ?>
      
      <!-- زر العودة إلى الصفحة الرئيسية -->
      <a href="index.php" class="btn btn-secondary mt-4">العودة للرئيسية</a>
    </div>
  </div>

  <!-- تضمين تذييل الصفحة (footer.php) -->
  <?php include('footer.php'); ?>

  <!-- تضمين سكربتات Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

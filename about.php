<?php
// تحميل البيانات من ملف JSON
$jsonData = file_get_contents('admin/data.json');
$data = json_decode($jsonData, true);
$description = $data['about']['description'] ?? 'لا توجد معلومات متاحة.';
$vision = $data['about']['vision'] ?? 'لا توجد معلومات متاحة.';
$mission = $data['about']['mission'] ?? 'لا توجد معلومات متاحة.';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>عن الجامعة</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
      body {
          background: linear-gradient(to bottom right, #dfe9f3, #ffffff);
          min-height: 100vh;
          font-family: 'Cairo', sans-serif;
          color: #212529;
      }
      .section-card {
          background-color: #fff;
          border-radius: 32px;
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
          padding: 4rem;
          max-width: 1000px;
          margin: auto;
          animation: fadeInUp 1s ease-in-out;
      }
      .section-title {
          font-size: 2.5rem;
          font-weight: 700;
          color: #0a2342;
          margin-bottom: 1.5rem;
          position: relative;
      }
      .section-title::after {
          content: '';
          width: 60px;
          height: 4px;
          background: #0d6efd;
          position: absolute;
          bottom: -10px;
          right: 0;
          border-radius: 2px;
      }
      .section-paragraph {
          font-size: 1.2rem;
          line-height: 2.2;
          margin-bottom: 2.5rem;
          text-align: justify;
      }
      @keyframes fadeInUp {
          from {
              opacity: 0;
              transform: translateY(30px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }
  </style>
</head>
<body>
  <div id="main-header">
    <?php include 'header.php'; ?>
  </div>

  <div class="container py-5">
    <div class="section-card">
      <h2 class="section-title text-center">عن الجامعة</h2>
      <p class="section-paragraph"><?= htmlspecialchars($description) ?></p>

      <h3 class="section-title">الرؤية</h3>
      <p class="section-paragraph"><?= htmlspecialchars($vision) ?></p>

      <h3 class="section-title">الرسالة</h3>
      <p class="section-paragraph"><?= htmlspecialchars($mission) ?></p>
    </div>
  </div>

  <div id="main-footer">
    <?php include 'footer.php'; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

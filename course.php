<?php
// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج الأقسام من البيانات
$departments = $data['departments'];

$selectedCourse = null;

// الحصول على رمز المقرر من الرابط (GET request)
$courseCode = isset($_GET['code']) ? $_GET['code'] : '';

$selectedDept = null;
foreach ($departments as $department){
    // البحث عن المقرر في القسم المحدد
    foreach ($department['courses'] as $course) {
        if ($course['code'] === $courseCode) {
            $selectedCourse = $course;
            $selectedDept = $department;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $selectedCourse ? $selectedCourse['title'] : 'المقرر غير موجود' ?> - الجامعة الحديثة</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f0f4f8;
      font-family: 'Cairo', sans-serif;
    }
    .course-detail-card {
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .course-title {
      font-size: 2rem;
      font-weight: bold;
    }
    .course-description {
      margin-top: 20px;
      font-size: 1.1rem;
    }
    .instructor-name {
      font-size: 1rem;
      color: #555;
    }
  </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="container py-5">
  <?php if ($selectedCourse): ?>
    <div class="course-detail-card">
      <h2 class="course-title"><?= htmlspecialchars($selectedCourse['title']) ?></h2>
      <p class="course-description"><?= htmlspecialchars($selectedCourse['description']) ?></p>
      <p><strong>عدد الساعات:</strong> <?= $selectedCourse['credits'] ?></p>
      <p class="instructor-name"><strong>المدرس:</strong> <?= htmlspecialchars($selectedCourse['instructor']) ?></p>
    </div>
  <?php else: ?>
    <h3 class="text-danger">المقرر غير موجود</h3>
  <?php endif; ?>
</div>

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

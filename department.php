<?php
// قراءة اسم القسم من الرابط (GET request)
$deptName = isset($_GET['name']) ? $_GET['name'] : '';

// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج الأقسام من البيانات
$departments = $data['departments'];

$selectedDept = null;

// البحث عن القسم المطلوب حسب اسمه
foreach ($departments as $department){
    if ($department['name'] === $deptName) {
        $selectedDept = $department;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title><?= $selectedDept ? $selectedDept['name'] : 'القسم غير موجود' ?> - الجامعة الحديثة</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #e8f0ff, #ffffff);
      min-height: 100vh;
      font-family: 'Cairo', sans-serif;
    }

    .dept-card {
      background-color: #ffffff;
      border-radius: 24px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      padding: 3rem;
      max-width: 900px;
      margin: auto;
      transition: transform 0.3s ease;
    }

    .dept-card:hover {
      transform: translateY(-5px);
    }

    .dept-icon {
      font-size: 4rem;
      color: #0d6efd;
    }

    .underline {
      width: 80px;
      height: 4px;
      background-color:#ffc107;
      margin: 0.5rem auto 1.5rem;
      border-radius: 2px;
    }

    .dept-description {
      color: #555;
      line-height: 1.8;
    }

    .course-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .course-title {
      font-weight: bold;
    }

    .btn-view-more {
      background-color: #0d6efd;
      color: white;
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 14px;
    }

    .btn-view-more:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<?php include('header.php'); ?>
<div class="container py-5">
  <div class="dept-card text-center">
    <div class="dept-icon mb-3">
      <i class="bi bi-mortarboard-fill text-warning"></i>
    </div>

    <?php if ($selectedDept): ?>
      <h1 class="fw-bold display-5"><?= htmlspecialchars($selectedDept['name']) ?></h1>
      <div class="underline"></div>
      <p class="fs-5 dept-description"><?= htmlspecialchars($selectedDept['description']) ?></p>

      <?php if (!empty($selectedDept['courses'])):
        // فصل المقررات حسب السنة
        $term1Courses = array_filter($selectedDept['courses'], fn($course) => $course['trem'] == 1);
        $term2Courses = array_filter($selectedDept['courses'], fn($course) => $course['trem'] == 2);
        $term3Courses = array_filter($selectedDept['courses'], fn($course) => $course['trem'] == 3);
        $term4Courses = array_filter($selectedDept['courses'], fn($course) => $course['trem'] == 4);
      ?>

      <!-- مقررات السنة الأول -->
      <?php if (!empty($term1Courses)): ?>
        <div class="mt-5 text-start">
          <h3 class="fw-bold mb-4 text-center text-black">المقررات </h3>
<h3 class="fw-bold mb-4 text-center text-success">مقررات السنة الاولى</h3>
          <div class="list-group">
            <?php foreach ($term1Courses as $course): ?>
              <div class="course-card">
                <span class="course-title"><?= htmlspecialchars($course['title']) ?></span>
                <a href="course.php?dept=<?= urlencode($selectedDept['name']) ?>&code=<?= urlencode($course['code']) ?>" class="btn btn-view-more">عرض المزيد</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- مقررات السنة الثاني -->
      <?php if (!empty($term2Courses)): ?>
        <div class="mt-5 text-start">
<h3 class="fw-bold mb-4 text-center text-success">مقررات السنة الثانية</h3>
          <div class="list-group">
            <?php foreach ($term2Courses as $course): ?>
              <div class="course-card">
                <span class="course-title"><?= htmlspecialchars($course['title']) ?></span>
                <a href="course.php?dept=<?= urlencode($selectedDept['name']) ?>&code=<?= urlencode($course['code']) ?>" class="btn btn-view-more">عرض المزيد</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      
      
            <!-- مقررات السنة الثالث -->
      <?php if (!empty($term2Courses)): ?>
        <div class="mt-5 text-start">
<h3 class="fw-bold mb-4 text-center text-success">مقررات السنة الثالثة</h3>
          <div class="list-group">
            <?php foreach ($term3Courses as $course): ?>
              <div class="course-card">
                <span class="course-title"><?= htmlspecialchars($course['title']) ?></span>
                <a href="course.php?dept=<?= urlencode($selectedDept['name']) ?>&code=<?= urlencode($course['code']) ?>" class="btn btn-view-more">عرض المزيد</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      
      
            <!-- مقررات السنة الرابع -->
      <?php if (!empty($term2Courses)): ?>
        <div class="mt-5 text-start">
<h3 class="fw-bold mb-4 text-center text-success">مقررات السنة الرابعة</h3>
          <div class="list-group">
            <?php foreach ($term4Courses as $course): ?>
              <div class="course-card">
                <span class="course-title"><?= htmlspecialchars($course['title']) ?></span>
                <a href="course.php?dept=<?= urlencode($selectedDept['name']) ?>&code=<?= urlencode($course['code']) ?>" class="btn btn-view-more">عرض المزيد</a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      

      <?php endif; ?>
    <?php else: ?>
      <h2 class="text-danger">القسم غير موجود</h2>
    <?php endif; ?>
  </div>
</div>


<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

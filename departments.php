<?php
// تحديد عدد الأقسام التي تظهر في كل صفحة
$departmentsPerPage = 5;

// قراءة رقم الصفحة من الرابط (إذا لم يتم تحديده، افتراضيًا تكون الصفحة الأولى)
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج الأقسام من البيانات
$allDepartments = $data['departments'];

// حساب إجمالي عدد الأقسام
$totalDepartments = count($allDepartments);

// حساب إجمالي عدد الصفحات بناءً على عدد الأقسام في كل صفحة
$totalPages = ceil($totalDepartments / $departmentsPerPage);

// تحديد بداية ونهاية الأقسام التي سيتم عرضها في الصفحة الحالية
$startIndex = ($page - 1) * $departmentsPerPage;

// استخراج الأقسام التي ستظهر في الصفحة الحالية باستخدام دالة array_slice
$departmentsToShow = array_slice($allDepartments, $startIndex, $departmentsPerPage);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>أقسام الجامعة</title>

  <!-- ربط ملف Bootstrap لتنسيق الصفحة -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
  <!-- ربط خط "Cairo" من Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  
  <style>
    /* تنسيق الجسم */
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f4f6f9; /* خلفية الصفحة */
      color: #2c3e50; /* لون النص */
    }

    /* تنسيق عنوان القسم */
    .section-title {
      font-weight: 900; /* جعل النص أكثر سمكًا */
      font-size: 2.5rem; /* حجم الخط */
      margin-bottom: 2rem; /* مسافة أسفل العنوان */
      color: #0a2342; /* لون العنوان */
    }

    /* إضافة خط تحت العنوان */
    .section-title::after {
      content: "";
      display: block;
      width: 80px;
      height: 4px;
      background-color: #f1c40f; /* لون الخط */
      margin: 10px auto 0;
      border-radius: 2px;
    }

    /* تنسيق بطاقة القسم */
    .card {
      border: none;
      border-radius: 1rem; /* زوايا مستديرة */
      background-color: #ffffff; /* خلفية بيضاء */
      transition: transform 0.4s ease, box-shadow 0.4s ease; /* تأثير التحول */
      display: flex;
      flex-direction: column;
    }

    /* تأثير عند تحريك الماوس على البطاقة */
    .card:hover {
      transform: translateY(-10px); /* تحريك البطاقة للأعلى */
      box-shadow: 0 10px 25px rgba(0,0,0,0.1); /* إضافة ظل */
    }

    /* تنسيق محتوى البطاقة */
    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    /* تنسيق عنوان البطاقة */
    .card-title {
      font-size: 1.25rem;
      font-weight: bold;
      color: #0d3c61;
      text-align: center;
    }

    /* تنسيق نص البطاقة */
    .card-text {
      font-size: 1rem;
      color: #4e5d6c;
      text-align: center;
      line-height: 1.4;
      height: 3.6rem; /* ارتفاع محدد لاحتواء سطرين */
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2; /* تحديد الحد الأقصى لعدد السطور */
      -webkit-box-orient: vertical;
    }

    /* تنسيق الزر */
    .btn-primary {
      background-color: #0d3c61;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0b2d4a;
    }

    /* تنسيق التصفح بين الصفحات (Pagination) */
    .pagination {
      justify-content: center;
      margin-top: 30px;
    }

    .pagination .page-link {
      color: #0a2342;
      font-weight: bold;
    }

    .pagination .page-link:hover {
      background-color: #f1c40f;
      color: #fff;
    }

    .pagination .active .page-link {
      background-color: #0a2342;
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- تضمين رأس الصفحة (header.php) -->
  <?php include('header.php'); ?>

  <!-- قسم الأقسام -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center mb-5">أقسام الجامعة</h2>
      <div class="row g-4 justify-content-center">
        <!-- عرض الأقسام -->
        <?php foreach ($departmentsToShow as $department): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-lg border-0">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($department['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars(mb_substr($department['description'],0,100)) ?></p>
                <a href="department.php?name=<?= urlencode($department['name']) ?>" class="btn btn-primary mt-3">عرض المزيد</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- التنقل بين الصفحات -->
      <nav aria-label="Page navigation">
        <ul class="pagination mt-4">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>
  </section>

  <!-- تضمين تذييل الصفحة (footer.php) -->
  <?php include('footer.php'); ?>

  <!-- تضمين سكربتات Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

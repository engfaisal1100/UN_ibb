<?php
// تحديد عدد الأخبار التي تظهر في كل صفحة
$newsPerPage = 5;

// قراءة رقم الصفحة من الرابط (إذا لم يتم تحديده، افتراضيًا تكون الصفحة الأولى)
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج الأخبار من البيانات
$allNews = $data['news'];

// ترتيب الأخبار بحيث تكون الأحدث أولاً باستخدام دالة usort
usort($allNews, fn($a, $b) => strtotime($b['date']) - strtotime($a['date']));

// حساب إجمالي عدد الأخبار
$totalNews = count($allNews);

// حساب إجمالي عدد الصفحات بناءً على عدد الأخبار في كل صفحة
$totalPages = ceil($totalNews / $newsPerPage);

// تحديد بداية ونهاية الأخبار التي سيتم عرضها في الصفحة الحالية
$startIndex = ($page - 1) * $newsPerPage;

// استخراج الأخبار التي ستظهر في الصفحة الحالية باستخدام دالة array_slice
$newsToShow = array_slice($allNews, $startIndex, $newsPerPage);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>الأخبار - الجامعة الحديثة</title>

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

    /* تنسيق بطاقة الخبر */
    .card {
      border: none;
      border-radius: 1rem; /* زوايا مستديرة */
      background-color: #ffffff; /* خلفية بيضاء */
      transition: transform 0.4s ease, box-shadow 0.4s ease; /* تأثير التحول */
    }

    /* تأثير عند تحريك الماوس على البطاقة */
    .card:hover {
      transform: translateY(-10px); /* تحريك البطاقة للأعلى */
      box-shadow: 0 10px 25px rgba(0,0,0,0.1); /* إضافة ظل */
    }

    /* تنسيق عنوان البطاقة */
    .card-title {
      font-size: 1.25rem;
      font-weight: bold;
      color: #0d3c61;
    }

    /* تنسيق نص البطاقة */
    .card-text {
      font-size: 1.05rem;
      color: #4e5d6c;
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

  <!-- قسم الأخبار -->
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center mb-5">آخر الأخبار</h2>
      <div class="row g-4 justify-content-center">
        <!-- عرض الأخبار -->
        <?php foreach ($newsToShow as $news): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-lg border-0">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold"><?= htmlspecialchars($news['title']) ?></h5>
                <small class="text-muted mb-2"><?= $news['date'] ?></small>
                <p class="card-text flex-grow-1"><?= mb_substr($news['content'], 0, 100) ?>...</p>
                <a href="news-details.php?id=<?= $news['id'] ?>" class="btn btn-primary mt-3">عرض المزيد</a>
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

<?php
// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج بيانات الكادر الأكاديمي
$staff = $data['staff'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الكادر الأكاديمي</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap 5 RTL -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f9f9f9;
    }
    .section-title {
      font-size: 2.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 40px;
      color: #003366;
    }
    .card {
      border-radius: 20px;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-10px);
    }
    .card-img-top {
      border: 5px solid #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .swiper-button-next, .swiper-button-prev {
      color: #003366;
    }
  </style>
</head>
<body>

  <!-- الهيدر -->
  <div id="main-header">
    <?php include 'header.php'; ?>  <!-- تضمين الهيدر من ملف منفصل -->
  </div>
<!-- قسم الكادر الأكاديمي -->
<section class="py-5" id="cader">
  <div class="container">
    <h2 class="section-title">تعرف على أعضاء الكادر الأكاديمي</h2>
    <div class="swiper staff-swiper">
      <div class="swiper-wrapper">
        <?php foreach ($staff as $member): ?>
          <div class="swiper-slide">
            <div class="card text-center shadow-sm h-100 p-3">
              <img src="admin/<?= $member['image'] ?>" class="card-img-top rounded-circle mx-auto mt-2"
                   alt="<?= $member['name'] ?>" style="height:130px;width:130px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?= $member['name'] ?></h5>
                <p class="card-text text-muted"><?= $member['title'] ?></p>
              </div>
              <div class="d-flex justify-content-center mb-3">
                <a href="staff-details.php?id=<?= $member['id'] ?>" class="btn btn-outline-primary w-75">عرض المزيد</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- أزرار التنقل -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</section>


  <!-- الفوتر -->
  <div id="main-footer">
    <?php include 'footer.php'; ?>  <!-- تضمين الفوتر من ملف منفصل -->
  </div>
<!-- Bootstrap JS + Swiper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.staff-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      576: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      }
    }
  });
</script>
</body>
</html>

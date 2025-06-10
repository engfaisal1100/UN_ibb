<?php
// قراءة البيانات من ملف JSON وتحويلها إلى مصفوفة
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج أقسام البيانات حسب الحاجة
$about = $data['about'];                     // قسم نبذة عن الجامعة
$president = $data['presidentMessage'];     // كلمة رئيس الجامعة
$hero = $data['hero'];                      // السلايدر الرئيسي (Hero)
$news = array_slice($data['news'], 0, 4);   // عرض أول 4 أخبار فقط
$staff = $data['staff'];                    // بيانات الكادر التعليمي
$contact = $data['contact'];                // بيانات التواصل
$setting = $data['setting'];                // إعدادات الموقع
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- استخدام اسم الموقع من إعدادات الموقع -->
  <title><?= $setting['title'] ?></title>
  
  <!-- إضافة وصف الموقع من الإعدادات -->
  <meta name="description" content="<?= $setting['description'] ?>">
  
  <!-- إضافة كلمات مفتاحية من الإعدادات -->
  <meta name="keywords" content="<?= $setting['keywords'] ?>">
  
  <!-- إضافة بيانات المؤلف من الإعدادات -->
  <meta name="author" content="<?= $setting['author'] ?>">
  
  <!-- ربط ملفات التنسيق (CSS) -->
  <!-- ربط Bootstrap للتصميم التفاعلي -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  
  <!-- ربط خط Google Cairo المستخدم في الصفحة -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  
  <!-- ربط ملف التنسيق الخاص بالسلايدر -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- إضافة الشعار الخاص بالموقع -->
  <link rel="icon" href="admin/<?= $setting['favicon_url'] ?>" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


  <style>
    /* تنسيق الصفحة بشكل عام */
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f4f6f9;
      color: #2c3e50;
    }

    /* تنسيق عنوان الأقسام */
    .section-title {
      font-weight: 900;
      font-size: 2.5rem;
      color: #0a2342;
      margin-bottom: 2rem;
      text-align: center;
    }

    /* إضافة خط تحت العنوان */
    .section-title::after {
      content: "";
      display: block;
      width: 80px;
      height: 4px;
      background-color: #f1c40f;
      margin: 10px auto 0;
    }

    /* تنسيق بطاقات الأخبار والكادر التعليمي */
    .card {
      border: none;
      border-radius: 1rem;
      background-color: #fff;
      transition: transform 0.4s ease;
    }

    /* تأثير التفاعل عند المرور بالماوس على البطاقات */
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    /* تنسيق السلايدر الرئيسي */
    .hero-slide {
      position: relative;
      height: 90vh;
      background-size: cover;
      background-position: center;
      z-index: 1;
    }

    /* تعتيم السلايدر لزيادة وضوح النصوص */
    .hero-slide::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.5); /* التعتيم */
      z-index: 2;
    }

    /* تنسيق النصوص فوق السلايدر */
    .hero-slide .container {
      position: relative;
      z-index: 3;
    }

    /* تنسيق الأزرار */
    .btn-primary {
      background-color: #0d3c61;
    }
  </style>
</head>
<body>
<!-- شريط معلومات التواصل -->
<nav class="text-white py-2" style="background-color:#0d3c61;">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
    <!-- بيانات التواصل -->
    <div class="mb-2 mb-md-0 text-center text-md-start">
      <i class="bi bi-envelope-fill"></i> <?= $contact['email'] ?> |
      <i class="bi bi-telephone-fill ms-2"></i> <?= $contact['phone'] ?>
    </div>

    <!-- العنوان -->
    <div class="text-center text-md-end">
      <i class="bi bi-geo-alt-fill"></i> <?= $contact['address'] ?>
    </div>
    
    <!-- روابط وسائل التواصل الاجتماعي -->
    <div class="text-center text-md-start mt-2 mt-md-0">
      <!-- أيقونة فيسبوك -->
      <a href="<?= $social['facebook'] ?>" class="text-decoration-none text-white me-3" target="_blank">
        <i class="bi bi-facebook" style="font-size: 1rem;"></i>
      </a>
      <!-- أيقونة تويتر -->
      <a href="<?= $social['twitter'] ?>" class="text-decoration-none text-white me-3" target="_blank">
        <i class="bi bi-twitter" style="font-size: 1rem;"></i>
      </a>
      <!-- أيقونة إنستغرام -->
      <a href="<?= $social['instagram'] ?>" class="text-decoration-none text-white me-3" target="_blank">
        <i class="bi bi-instagram" style="font-size: 1rem;"></i>
      </a>
    </div>
  </div>
</nav>


<!-- تضمين رأس الصفحة -->
<?php include 'header.php'; ?>
<!-- قسم السلايدر الرئيسي (Hero Section) -->
<header class="hero p-0">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php foreach ($hero as $index => $slide): ?>
        <!-- عرض كل سلايد في السلايدر -->
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
          <div class="hero-slide d-flex align-items-center justify-content-center text-center text-white"
               style="background-image: url('admin/<?= $slide['image'] ?>');">
            <div class="container">
              <h1 class="display-4 fw-bold"><?= $slide['title'] ?></h1>
              <p class="lead"><?= $slide['description'] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- أزرار التنقل بين السلايدات -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</header>

<!-- قسم نبذة عن الجامعة -->
<section class="py-5 text-center bg-white">
  <div class="container">
    <h2 class="section-title" style="font-size: 3rem; color: #f1c40f; text-transform: uppercase;">نبذة عن الكلية</h2>
    <p class="text-dark fs-4" style="font-weight: 500; max-width: 800px; margin: 0 auto; line-height: 1.6;"><?= $about['description'] ?></p>
    <div class="row mt-5">
      <!-- عرض الرؤية والرسالة في قسمين -->
      <div class="col-md-6 mb-4">
        <div class="p-4 bg-white shadow-lg rounded-4 h-100">
          <h3 class="text-primary fw-bold mb-3" style="font-size: 1.8rem;">الرؤية</h3>
          <p class="text-muted" style="font-size: 1.2rem;"><?= $about['vision'] ?></p>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="p-4 bg-white shadow-lg rounded-4 h-100">
          <h3 class="text-primary fw-bold mb-3" style="font-size: 1.8rem;">الرسالة</h3>
          <p class="text-muted" style="font-size: 1.2rem;"><?= $about['mission'] ?></p>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- قسم كلمة رئيس الجامعة -->
<section class="py-5" style="background-color: #003366; color: white;">
<div class="container">
    <h2 class="section-title text-center" style="font-size: 3.5rem; font-weight: 700; text-transform: uppercase; color: #f1c40f;">كلمة رئيس الكلية</h2>
    <div class="row align-items-center mt-4">
      <div class="col-md-4 text-center mb-4 mb-md-0">
        <!-- صورة رئيس الجامعة -->
        <img src="admin/<?= $president['image'] ?>" class="img-fluid rounded-circle shadow-lg" style="width: 300px; height: 300px; object-fit: cover; border: 5px solid #f1c40f;">
        <h5 class="mt-3 mb-1 fw-bold" style="font-size: 1.8rem; color: #f1c40f;"><?= $president['name'] ?></h5>
        <p class="text-light" style="font-size: 1.2rem;"><?= $president['title'] ?></p>
      </div>
      <div class="col-md-8">
        <p class="fs-4 text-light text-center" style="font-size: 1.3rem; line-height: 1.8;"><?= $president['message'] ?></p>
      </div>
    </div>
  </div>
</section>


<!-- قسم آخر الأخبار -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-title">آخر الأخبار</h2>
    <div class="row g-4 justify-content-center">
      <?php foreach ($news as $item): ?>
        <div class="col-md-6 col-lg-4">
          <!-- بطاقة عرض الأخبار -->
          <div class="card h-100 shadow-lg border-0">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-bold"><?= $item['title'] ?></h5>
              <small class="text-muted mb-2"><?= $item['date'] ?></small>
              <p class="card-text flex-grow-1"><?= mb_substr($item['content'], 0, 100) ?>...</p>
              <a href="news-details.php?id=<?= $item['id'] ?>" class="btn btn-primary mt-3">عرض المزيد</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="news.php" class="btn btn-primary">عرض المزيد من الأخبار</a>
    </div>
  </div>
</section>


<!-- قسم الأقسام -->
<section class="py-5" style="background-color: #0a2342; color: white;">
  <div class="container">
    <h2 class="section-title text-center" style="font-size: 2.5rem; color: #f1c40f;">أقسام الكلية</h2>
    <div class="row g-4 justify-content-center">
      <?php foreach (array_slice($departments, 0, 6) as $department): ?>
        <div class="col-md-4">
          <!-- بطاقة عرض القسم -->
          <div class="card shadow-lg border-0 h-100" style="background-color:white; border-radius: 20px; overflow: hidden; position: relative;">
            <div class="card-body d-flex flex-column justify-content-center text-center" style="padding: 40px;">
              <!-- عنوان القسم -->
              <h5 class="card-title fw-bold" style="font-size: 2rem; color: #f1c40f; text-transform: uppercase;"><?= $department['name'] ?></h5>
              <!-- وصف القسم -->
              <p class="card-text" style="font-size: 1.2rem; color:dark; line-height: 1.6;"><?= mb_substr($department['description'],0,100) ?></p>
              <!-- زر عرض المزيد -->
              <a href="department.php?name=<?= urlencode($department['name']) ?>" class="btn btn-warning mt-4" style="font-weight: bold; padding: 10px 20px;">عرض المزيد</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
      <a href="departments.php" class="btn btn-warning" style="font-weight: bold;">عرض المزيد من الأقسام</a>
    </div>
  </div>
</section>


<!-- قسم الكادر التعليمي -->
<section class="py-5" id="cader">
  <div class="container">
    <h2 class="section-title">الكادر التعليمي</h2>
    <div class="swiper staff-swiper">
      <div class="swiper-wrapper">
        <?php foreach ($staff as $member): ?>
          <!-- عرض معلومات كل عضو في الكادر التعليمي -->
          <div class="swiper-slide">
            <div class="card text-center shadow-sm h-100">
              <img src="admin/<?= $member['image'] ?>" class="card-img-top rounded-circle mx-auto mt-3"
                   alt="<?= $member['name'] ?>" style="height:120px;width:120px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?= $member['name'] ?></h5>
                <p class="card-text"><?= $member['title'] ?></p>
              </div>
              <div class="d-flex justify-content-center mt-2">
  <a href="staff-details.php?id=<?= $member['id'] ?>" class="btn btn-outline-primary btn-sm w-50">عرض المزيد</a>
</div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- أزرار التنقل في السلايدر -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</section>
<!-- تضمين الفوتر -->
<section class="py-5" style="background-color:white;">
  <div class="container">
    <h2 class="section-title" style="color: #0a2342;">تواصل معنا</h2>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <form role="form" class="php-email-form shadow-lg p-5 rounded-4 bg-white">
          <div class="row g-4">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="الاسم الأول" required>
            </div>
            <div class="col-md-6">
              <input type="text" name="surname" class="form-control form-control-lg" id="surname" placeholder="اسم العائلة" required autocomplete="on">
            </div>
          </div>

          <div class="mt-4">
            <textarea name="message" class="form-control form-control-lg" id="message" placeholder="اكتب رسالتك هنا..." rows="5" required></textarea>
          </div>

          <div class="my-3 text-center">
  <div class="loading text-muted d-none">جاري الإرسال...</div>
  <div class="error-message text-danger d-none"></div>
  <div class="sent-message text-success fw-bold d-none">تم إرسال رسالتك بنجاح، شكراً لك!</div>
</div>

<div id="form-error" class="text-danger fw-bold mt-3" style="display: none;"></div>

<div class="text-center mt-4">
  <button onclick="sendSMS()" type="button" class="btn btn-lg btn-primary px-5" id="send_msg">
    إرسال كرسالة نصية
  </button>
</div>
        </form>
      </div>
    </div>
  </div>
</section>
<?php include 'footer.php'; ?>

<script>
  const phoneNumber = "<?= $contact['phone'] ?>"; // رقم من JSON

  function sendSMS() {
    var name = document.getElementById("name").value.trim();
    var surname = document.getElementById("surname").value.trim();
    var message = document.getElementById("message").value.trim();

    var errorDiv = document.getElementById("form-error");

    if (name === "" || surname === "" || message === "") {
      errorDiv.innerText = "يرجى تعبئة جميع الحقول قبل الإرسال.";
      errorDiv.style.display = "block";
      return;
    }

    errorDiv.style.display = "none";

    var smsBody = "الاسم: " + name + "\n" +
                  "اللقب: " + surname + "\n" +
                  "الرسالة: " + message;

    var smsLink = "sms:" + phoneNumber + "?body=" + encodeURIComponent(smsBody);

    window.open(smsLink, "_blank");
  }
</script>


<!-- إضافة ملفات JavaScript المطلوبة لتشغيل Bootstrap والسلايدر -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- تهيئة السلايدر الخاص بالكادر التعليمي -->
<script>
  const swiper = new Swiper('.staff-swiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 5000,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
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

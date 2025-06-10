<?php
session_start();
if(!isset($_SESSION['logged_in']) && !$_SESSION['logged_in']===true){
header("location:login.php"); 
exit;
}
$Uname=$_SESSION['username'];

//$admin_section=$_SESSION['admin_section'];


// if user press click logout 
if(isset($_GET['logout'])){
session_start();
session_unset();
session_destroy();
header("location:login.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>لوحة التحكم</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }
    /* تخصيص الشريط الجانبي للشاشات الكبيرة */
    @media (min-width: 992px) {
      #sidebar {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 250px;
        transform: none !important;
        visibility: visible !important;
        border-left: 1px solid #444;
        z-index: 1030;
      }

      .main-content {
        margin-right: 250px;
      }

      .offcanvas-backdrop {
        display: none;
      }

      body {
        overflow-x: hidden;
      }
    }
    /* تعديل الشريط العلوي ليكون متجاوبًا */
    .navbar {
      padding: 0.8rem 1.2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .navbar .navbar-brand {
      font-size: 1.2rem;
      font-weight: 600;
    }

    .navbar button {
      font-size: 1.2rem;
    }

      .custom-dot-spinner {
  position: relative;
  width: 1.2rem;  /* أصغر دائرة */
  height: 1.2rem;
  display: inline-block;
}

.custom-dot-spinner span {
  position: absolute;
  width: 4px;         /* نقطة أصغر */
  height: 4px;
  background-color: #fff;
  border-radius: 50%;
  top: 50%;
  left: 50%;
  transform-origin: center;
  animation: spin 1s linear infinite;
}

/* نقاط موزعة على دائرة أصغر */
.custom-dot-spinner span:nth-child(1) { transform: rotate(0deg) translate(7px) rotate(0deg); }
.custom-dot-spinner span:nth-child(2) { transform: rotate(45deg) translate(7px) rotate(-45deg); }
.custom-dot-spinner span:nth-child(3) { transform: rotate(90deg) translate(7px) rotate(-90deg); }
.custom-dot-spinner span:nth-child(4) { transform: rotate(135deg) translate(7px) rotate(-135deg); }
.custom-dot-spinner span:nth-child(5) { transform: rotate(180deg) translate(7px) rotate(-180deg); }
.custom-dot-spinner span:nth-child(6) { transform: rotate(225deg) translate(7px) rotate(-225deg); }
.custom-dot-spinner span:nth-child(7) { transform: rotate(270deg) translate(7px) rotate(-270deg); }
.custom-dot-spinner span:nth-child(8) { transform: rotate(315deg) translate(7px) rotate(-315deg); }

@keyframes spin {
  0%   { opacity: 1; }
  50%  { opacity: 0.3; }
  100% { opacity: 1; }
}
  </style>
</head>
<body>

<!-- الشريط الجانبي باستخدام Offcanvas -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">لوحة التحكم</h5>
    <!-- زر إغلاق الشريط الجانبي -->
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item"><a href="#" class="nav-link text-white about">عن الجامعة</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white contact">التواصل والحقوق</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white presidentMessage">رسالة رئيس الجامعة</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white hero">خلفيات كاروسيل</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white departments">الاقسام</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white staff">الطاقم الاكاديمي</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white news">الاخبار</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white setting">اعدادات الموقع</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white mgr">المسؤولين</a></li>

    </ul>
  </div>
</div>

<!-- المحتوى الرئيسي -->
<div class="main-content">
  <!-- الشريط العلوي يحتوي على زر التنقل مع الشعار -->
  <nav class="navbar navbar-light bg-light shadow-sm px-4 d-flex justify-content-between">
    <button class="btn btn-outline-dark d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      ☰
    </button>
    <div class="dropdown">
  <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    👤 <?= $Uname ?? 'اسم المستخدم' ?>
  </button>
  <ul class="dropdown-menu dropdown-menu-end">
    <li><a class="dropdown-item" href="#">الملف الشخصي</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item text-danger" href="index.php?logout=<?php echo $Uname; ?>" onclick="return confirm('هل أنت متأكد أنك تريد تسجيل الخروج؟');">🚪 تسجيل الخروج</a></li>
  </ul>
</div>
  </nav>

  <!-- المحتوى الرئيسي (يتم تحميله ديناميكياً) -->
  <main class="p-4" id="content">
    <h2>نظرة عامة</h2>
    <div class="row">
      <!-- عرض عدد الأقسام -->
      <div class="col-md-4">
        <div class="card text-bg-primary text-center">
          <div class="card-body">
            <h5 class="card-title">عدد الأقسام</h5>
            <p class="card-text fs-2" id="departmentsCount">0</p>
          </div>
        </div>
      </div>
      
      <!-- عرض عدد الطاقم الأكاديمي -->
      <div class="col-md-4">
        <div class="card text-bg-success text-center">
          <div class="card-body">
            <h5 class="card-title">عدد الطاقم الأكاديمي</h5>
            <p class="card-text fs-2" id="staffCount">0</p>
          </div>
        </div>
      </div>

      <!-- عرض عدد الأخبار -->
      <div class="col-md-4">
        <div class="card text-bg-warning text-center">
          <div class="card-body">
            <h5 class="card-title">عدد الأخبار</h5>
            <p class="card-text fs-2" id="newsCount">0</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- تحميل مكتبة jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- تحميل Bootstrap Bundle (يتضمن JavaScript و Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- تحميل مكتبة Chart.js لرسم المخططات -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // تحميل البيانات من ملف JSON باستخدام jQuery
  $(document).ready(function() {
    $.getJSON("data.json", function(data) {
      // تحديث الإحصائيات
      $('#departmentsCount').text(data.departments.length);
      $('#staffCount').text(data.staff.length);
      $('#newsCount').text(data.news.length);
    });
  });
</script>


<script>
// تحميل المحتوى عند الضغط على العنصر في القائمة الجانبية
function loadContent(pageName,title) {
  $('#content').fadeOut(100, function() {
    $('#content').load(pageName, function() {
      $('#content').fadeIn(100);
    });
  });
}

// ربط روابط القائمة الجانبية بصفحات معينة
$(document).ready(function(){
  $('.about').click(function() { 
    loadContent('about.php', 'عن الجامعة'); 
    $('#sidebar').offcanvas('hide'); // إغلاق الشريط الجانبي بعد الضغط
  });
  $('.mgr').click(function() { 
    loadContent('registers.php', 'اضافة مسؤول جديد'); 
    $('#sidebar').offcanvas('hide'); // إغلاق الشريط الجانبي بعد الضغط
  });
  $('.contact').click(function() { 
    loadContent('contact.php', 'معلومات التواصل');
    $('#sidebar').offcanvas('hide'); 
  });
  $('.presidentMessage').click(function() { 
    loadContent('presidentMessage.php', 'رسالة رئيس الجامعة');
    $('#sidebar').offcanvas('hide'); 
  });
  $('.hero').click(function() { 
    loadContent('hero.php', 'خلفيات كاروسيل');
    $('#sidebar').offcanvas('hide'); 
  });
  $('.departments').click(function() { 
    loadContent('departments.php', 'الاقسام');
    $('#sidebar').offcanvas('hide'); 
  });
  $('.staff').click(function() { 
    loadContent('staff.php', 'الطاقم الاكاديمي');
    $('#sidebar').offcanvas('hide'); 
  });
  $('.news').click(function() { 
    loadContent('news.php', 'الاخبار');
    $('#sidebar').offcanvas('hide'); 
  });

  $('.setting').click(function() { 
    loadContent('setting.php', 'اعدادات الموقع');
    $('#sidebar').offcanvas('hide'); 
  });
});
</script>
</body>
</html>

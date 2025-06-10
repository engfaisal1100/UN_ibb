<?php
// قراءة محتوى ملف JSON وتحويله إلى مصفوفة
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج البيانات من الملف
$setting = $data['setting'];  // إعدادات الموقع مثل الاسم والشعار
$departments = $data['departments']; // الأقسام
?>
<!-- شريط التنقل (Navbar) -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color:#0d3c61;">
  <div class="container">
    
    <!-- تحقق من إذا كانت site_name صورة أو نص -->
    <?php if (!empty($setting['site_name']) && (strpos($setting['site_name'], '.jpg') !== false || strpos($setting['site_name'], '.png') !== false || strpos($setting['site_name'], '.jpeg') !== false)): ?>
      <!-- إذا كانت site_name رابط لصورة، نعرض الصورة -->
      <a class="navbar-brand logo-left" href="#">
        <img src="<?= $setting['site_name'] ?>" alt="Logo" style="height: 40px;">
      </a>
    <?php else: ?>
      <!-- إذا كانت site_name نص، نعرض اسم الموقع -->
      <a class="navbar-brand fw-bold logo-left" href="#"><?= $setting['site_name'] ?></a>
    <?php endif; ?>

    <!-- زر القائمة الجانبية (يظهر في الشاشات الصغيرة) -->
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- عناصر التنقل -->
    <div id="navbarNav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        
        <!-- رابط: الصفحة الرئيسية -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">الرئيسية</a>
        </li>

        <!-- رابط: عن الجامعة -->
        <li class="nav-item">
          <a class="nav-link" href="about.php">عن الكلية</a>
        </li>

          <!-- رابط: الأخبار -->
          <li class="nav-item">
          <a class="nav-link" href="#cader">الكادر الاكاديمي</a>
        </li>

         <!-- قائمة منسدلة: الأقسام -->
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="departmentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            الأقسام
          </a>
          <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="departmentsDropdown">
            <!-- تكرار الأقسام من ملف JSON -->
            <?php foreach ($departments as $department): ?>
              <li>
                <!-- رابط القسم -->
                <a class="dropdown-item" href="department.php?name=<?= urlencode($department['name']) ?>">
                  <?= $department['name'] ?>
                </a>
              </li>
              <li><hr class="dropdown-divider"></li> <!-- فاصل بين العناصر -->
            <?php endforeach; ?>
          </ul>
        </li>
        
        <!-- رابط: الأخبار -->
        <li class="nav-item">
          <a class="nav-link" href="news.php">الآخبار</a>
        </li>

        <!-- رابط: تواصل معنا -->
        <li class="nav-item">
          <a class="nav-link" href="contact.php">تواصل معنا</a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<!-- تنسيقات إضافية لشريط التنقل -->
<style>
  .navbar {
    background-color: #0a2342; /* لون الخلفية */
    padding: 1rem 0;           /* حشو داخلي */
  }

  .navbar-brand img {
    height: 40px; /* تحديد حجم الشعار */
  }
  .logo-left {
    position: absolute;
    left: 1rem;
    top:1rem;
  }
</style>

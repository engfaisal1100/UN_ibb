<?php
// قراءة البيانات من ملف JSON
$data = json_decode(file_get_contents('admin/data.json'), true);

// استخراج معلومات الاتصال من البيانات
$contact = $data['contact'];

// استخراج روابط الشبكات الاجتماعية من بيانات الاتصال
$social = $contact['social'];
?>

<!-- تذييل الصفحة -->
<footer class="text-center py-4">
  <div class="container">
    <!-- عرض العنوان -->
    <p><?= "العنوان: " . htmlspecialchars($contact['address']) ?></p>

    <!-- عرض رقم الهاتف -->
    <p><?= "الهاتف: " . htmlspecialchars($contact['phone']) ?></p>

    <!-- عرض البريد الإلكتروني -->
    <p><?= "البريد الإلكتروني: " . htmlspecialchars($contact['email']) ?></p>

    <!-- روابط وسائل التواصل الاجتماعي -->
    <div class="text-center mt-2">
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

    <!-- حقوق الطبع والنشر -->
    <hr>
    <p class="mt-3"><?= htmlspecialchars($contact['rights']) ?></p>
    <span><?= htmlspecialchars($contact['devloper']) ?></span>
  </div>
</footer>

<!-- تنسيق تذييل الصفحة باستخدام CSS -->
<style>
    footer { 
        background-color: #0d3c61; /* اللون الخلفي للتذييل */
        color: #ecf0f1; /* اللون النصي */
        padding: 2rem 0; /* الحشو الداخلي للتذييل */
        text-align: center; /* محاذاة النص في الوسط */
    }
</style>

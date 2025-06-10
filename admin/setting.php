<?php
// تحميل البيانات من ملف JSON وتحويلها إلى مصفوفة
$data = json_decode(file_get_contents('data.json'), true);

// استخراج بيانات الإعدادات من المصفوفة
$settings = $data['setting'];
?>

<!-- بداية الـ container لاحتواء النموذج -->
<div class="container py-4">
  <!-- إنشاء بطاقة تحتوي على نموذج الإعدادات -->
  <div class="card shadow-lg border-0">
    <!-- رأس البطاقة يحتوي على عنوان القسم -->
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">إعدادات الموقع</h4>
    </div>
    
    <!-- جسم البطاقة يحتوي على النموذج لتعديل بيانات الإعدادات -->
    <div class="card-body">
      <!-- بداية النموذج الذي يستخدم POST لإرسال البيانات -->
      <form method="POST" id="insertForm" enctype="multipart/form-data">
        <!-- إدخال مخفي لتحديد نوع العملية التي سيتم تنفيذها (تحديث بيانات الإعدادات) -->
        <input type="hidden" name="action" value="updateSettings" class="form-control" required>

        <!-- حقل النص لتعديل اسم الموقع -->
        <div class="mb-4">
          <label for="site_name" class="form-label fw-bold">الشعار او اسم الموقع</label>
          <input type="text" class="form-control border border-primary-subtle" name="site_name" id="site_name" value="<?php echo $settings['site_name']; ?>" required>
        </div>

        <!-- حقل النص لتعديل العنوان -->
        <div class="mb-4">
          <label for="title" class="form-label fw-bold">العنوان</label>
          <input type="text" class="form-control border border-info-subtle" name="title" id="title" value="<?php echo $settings['title']; ?>" required>
        </div>

        <!-- حقل النص لتعديل الوصف -->
        <div class="mb-4">
          <label for="description" class="form-label fw-bold">الوصف</label>
          <textarea class="form-control border border-info-subtle" name="description" id="description" rows="3" required><?php echo $settings['description']; ?></textarea>
        </div>

        <!-- حقل النص لتعديل الكلمات المفتاحية -->
        <div class="mb-4">
          <label for="keywords" class="form-label fw-bold">الكلمات المفتاحية</label>
          <input type="text" class="form-control border border-warning-subtle" name="keywords" id="keywords" value="<?php echo $settings['keywords']; ?>" required>
        </div>

        <!-- حقل النص لتعديل اسم المؤلف -->
        <div class="mb-4">
          <label for="author" class="form-label fw-bold">المؤلف</label>
          <input type="text" class="form-control border border-success-subtle" name="author" id="author" value="<?php echo $settings['author']; ?>" required>
        </div>

        <!-- حقل النص لتعديل اللغة -->
        <div class="mb-4">
          <label for="language" class="form-label fw-bold">اللغة</label>
          <input type="text" class="form-control border border-primary-subtle" name="language" id="language" value="<?php echo $settings['language']; ?>" required>
        </div>

        <!-- حقل النص لتعديل المنطقة الزمنية -->
        <div class="mb-4">
          <label for="timezone" class="form-label fw-bold">المنطقة الزمنية</label>
          <input type="text" class="form-control border border-secondary-subtle" name="timezone" id="timezone" value="<?php echo $settings['timezone']; ?>" required>
        </div>

        <!-- حقل رفع الشعار -->
        <div class="mb-4">
          <label for="logo_file" class="form-label fw-bold">رفع الشعار (إذا كان موجودًا)</label>
          <input type="file" class="form-control border border-info-subtle" name="logo_file" id="logo_file" accept="image/*">
          <small class="form-text text-muted">صيغة الشعار المقبولة: PNG, JPG, JPEG</small>
          <?php if ($settings['logo_url']): ?>
            <div class="mt-2">
              <img src="<?php echo $settings['logo_url']; ?>" alt="الشعار الحالي" width="100">
            </div>
          <?php endif; ?>
        </div>

        <!-- حقل رفع الفافيكون -->
        <div class="mb-4">
          <label for="favicon_file" class="form-label fw-bold">رفع الفافيكون (إذا كان موجودًا)</label>
          <input type="file" class="form-control border border-warning-subtle" name="favicon_file" id="favicon_file" accept="image/*">
          <small class="form-text text-muted">صيغة الفافيكون المقبولة: PNG, ICO, JPG</small>
          <?php if ($settings['favicon_url']): ?>
            <div class="mt-2">
              <img src="<?php echo $settings['favicon_url']; ?>" alt="الفافيكون الحالي" width="50">
            </div>
          <?php endif; ?>
        </div>

        <!-- حقل النص لتعديل البريد الإلكتروني للتواصل -->
        <div class="mb-4">
          <label for="contact_email" class="form-label fw-bold">البريد الإلكتروني</label>
          <input type="email" class="form-control border border-primary-subtle" name="contact_email" id="contact_email" value="<?php echo $settings['contact_email']; ?>" required>
        </div>

        <!-- حقل النص لتعديل الهاتف للتواصل -->
        <div class="mb-4">
          <label for="contact_phone" class="form-label fw-bold">رقم الهاتف</label>
          <input type="text" class="form-control border border-secondary-subtle" name="contact_phone" id="contact_phone" value="<?php echo $settings['contact_phone']; ?>" required>
        </div>

        <!-- حقل النص لتعديل روابط وسائل التواصل الاجتماعي -->
        <div class="mb-4">
          <label for="facebook" class="form-label fw-bold">رابط الفيسبوك</label>
          <input type="text" class="form-control border border-info-subtle" name="facebook" id="facebook" value="<?php echo $settings['social']['facebook']; ?>" required>
        </div>

        <div class="mb-4">
          <label for="twitter" class="form-label fw-bold">رابط تويتر</label>
          <input type="text" class="form-control border border-info-subtle" name="twitter" id="twitter" value="<?php echo $settings['social']['twitter']; ?>" required>
        </div>

        <div class="mb-4">
          <label for="instagram" class="form-label fw-bold">رابط انستغرام</label>
          <input type="text" class="form-control border border-info-subtle" name="instagram" id="instagram" value="<?php echo $settings['social']['instagram']; ?>" required>
        </div>

        <!-- حقل النص لتعديل ملاحظات حول الإعدادات -->
        <div class="mb-4">
          <label for="comment" class="form-label fw-bold">التعليق</label>
          <textarea class="form-control border border-warning-subtle" name="comment" id="comment" rows="3"><?php echo $settings['comment']; ?></textarea>
        </div>
<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
        <!-- زر لحفظ التعديلات -->
        <div class="text-str">
          <button type="submit" class="btn btn-success px-4 py-2">
             حفظ التعديلات
            <span id="loadingIcon" class="custom-dot-spinner d-none" role="status" aria-hidden="true">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ربط ملف JavaScript لتنفيذ الإجراءات الديناميكية -->
<script src="js/script.js"></script>

<?php
// تحميل البيانات من ملف JSON وتحويلها إلى مصفوفة
$data = json_decode(file_get_contents('data.json'), true);

// استخراج بيانات "عن الجامعة" من المصفوفة
$about = $data['about'];
?>

<!-- بداية الـ container لاحتواء النموذج -->
<div class="container py-4">
  <!-- إنشاء بطاقة تحتوي على نموذج "عن الجامعة" -->
  <div class="card shadow-lg border-0">
    <!-- رأس البطاقة يحتوي على عنوان القسم -->
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">عن الجامعة</h4>
    </div>
    
    <!-- جسم البطاقة يحتوي على النموذج لتعديل بيانات "عن الجامعة" -->
    <div class="card-body">
      <!-- بداية النموذج الذي يستخدم POST لإرسال البيانات -->
      <form method="POST" id="insertForm">
        <!-- إدخال مخفي لتحديد نوع العملية التي سيتم تنفيذها (تحديث بيانات "عن الجامعة") -->
        <input type="hidden" name="action" value="updateabout" class="form-control" required>

        <!-- حقل النص لتعديل الوصف -->
        <div class="mb-4">
          <label for="description" class="form-label fw-bold">الوصف</label>
          <!-- إدخال نصي متعدد الأسطر للوصف، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
          <textarea class="form-control border border-primary-subtle" name="description" id="description" rows="4"><?php echo $about['description']; ?></textarea>
        </div>

        <!-- حقل النص لتعديل الرؤية -->
        <div class="mb-4">
          <label for="vision" class="form-label fw-bold">الرؤية</label>
          <!-- إدخال نصي متعدد الأسطر للرؤية، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
          <textarea class="form-control border border-info-subtle" name="vision" id="vision" rows="3"><?php echo $about['vision']; ?></textarea>
        </div>

        <!-- حقل النص لتعديل الرسالة -->
        <div class="mb-4">
          <label for="mission" class="form-label fw-bold">الرسالة</label>
          <!-- إدخال نصي متعدد الأسطر للرسالة، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
          <textarea class="form-control border border-success-subtle" name="mission" id="mission" rows="3"><?php echo $about['mission']; ?></textarea>
        </div>
<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
        <!-- زر لحفظ التعديلات -->
        <div class="text-star">
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

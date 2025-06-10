<?php
// تحميل البيانات من ملف JSON وتحويلها إلى مصفوفة
$data = json_decode(file_get_contents('data.json'), true);

// استخراج بيانات "معلومات التواصل" من المصفوفة
$contact = $data['contact'];
?>

<!-- بداية الـ container لاحتواء النموذج -->
<div class="container py-4">
  <!-- إنشاء بطاقة تحتوي على نموذج "معلومات التواصل" -->
  <div class="card shadow-lg border-0">
    <!-- رأس البطاقة يحتوي على عنوان القسم -->
    <div class="card-header bg-info text-white">
      <h4 class="mb-0">معلومات التواصل</h4>
    </div>

    <!-- جسم البطاقة يحتوي على النموذج لتعديل بيانات "معلومات التواصل" -->
    <div class="card-body">
      <!-- بداية النموذج الذي يستخدم POST لإرسال البيانات -->
      <form method="POST" id="insertForm">
        <!-- إدخال مخفي لتحديد نوع العملية التي سيتم تنفيذها (تحديث بيانات "معلومات التواصل") -->
        <input type="hidden" name="action" value="updatecontact" class="form-control" required>

        <!-- حقل النص لتعديل العنوان -->
        <div class="mb-3">
          <label for="address" class="form-label fw-bold">العنوان</label>
          <!-- إدخال نصي لتعديل العنوان، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
          <input type="text" class="form-control border border-secondary-subtle" id="address" name="address" value="<?php echo $contact['address']; ?>" />
        </div>

        <!-- حقل النص لتعديل رقم الهاتف -->
        <div class="mb-3">
          <label for="phone" class="form-label fw-bold">رقم الهاتف</label>
          <!-- إدخال نصي لتعديل رقم الهاتف، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
          <input type="text" class="form-control border border-secondary-subtle" id="phone" name="phone" value="<?php echo $contact['phone']; ?>" />
        </div>

        <!-- حقل النص لتعديل البريد الإلكتروني -->
        <div class="mb-3">
          <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
          <!-- إدخال نصي لتعديل البريد الإلكتروني، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
          <input type="email" class="form-control border border-secondary-subtle" id="email" name="email" value="<?php echo $contact['email']; ?>" />
        </div>

        <!-- حقل النص لتعديل  حقوق الموقع -->
        <div class="mb-3">
          <label for="email" class="form-label fw-bold">حقوق الموقع</label>
          <input type="text" class="form-control border border-secondary-subtle" id="rights" name="rights" value="<?php echo $contact['rights']; ?>" />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label fw-bold">مطور الموقع</label>
          <input type="text" class="form-control border border-secondary-subtle" id="devloper" name="devloper" value="<?php echo $contact['devloper']; ?>" />
        </div>
        <!-- خط أفقي للفصل بين الأقسام -->
        <hr class="my-4"/>

        <!-- عنوان قسم "روابط التواصل الاجتماعي" -->
        <h5 class="fw-bold mb-3 text-primary">روابط التواصل الاجتماعي</h5>

        <!-- مجموعة من الحقول الخاصة بروابط التواصل الاجتماعي -->
        <div class="row">
          <!-- حقل "Facebook" -->
          <div class="col-md-4 mb-3">
            <label for="facebook" class="form-label">Facebook</label>
            <!-- إدخال رابط Facebook، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
            <input type="url" class="form-control" name="facebook" id="facebook" value="<?php echo $contact['social']['facebook']; ?>" />
          </div>

          <!-- حقل "Twitter" -->
          <div class="col-md-4 mb-3">
            <label for="twitter" class="form-label">Twitter</label>
            <!-- إدخال رابط Twitter، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
            <input type="url" class="form-control" name="twitter" id="twitter" value="<?php echo $contact['social']['twitter']; ?>" />
          </div>

          <!-- حقل "Instagram" -->
          <div class="col-md-4 mb-3">
            <label for="instagram" class="form-label">Instagram</label>
            <!-- إدخال رابط Instagram، ويتم تعبئته بالقيمة الحالية من ملف JSON -->
            <input type="url" class="form-control" name="instagram" id="instagram" value="<?php echo $contact['social']['instagram']; ?>" />
          </div>
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

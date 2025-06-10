<?php
// تحميل البيانات من ملف JSON
$data = json_decode(file_get_contents('data.json'), true);

// الحصول على بيانات رسالة رئيس الجامعة من الملف
$president = $data['presidentMessage'];
?>

<div class="container py-4">
  <!-- بطاقة تحرير رسالة رئيس الجامعة -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">رسالة رئيس الجامعة</h4>
    </div>
    <div class="card-body">
      <!-- نموذج تعديل رسالة رئيس الجامعة -->
      <form method="POST" id="insertForm" enctype="multipart/form-data">
        <input type="hidden" name="action" value="updatepresident" class="form-control" required>

        <!-- حقل الاسم واللقب / المنصب -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="name" class="form-label fw-bold">الاسم</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $president['name']; ?>" required>
          </div>
          <div class="col-md-6">
            <label for="title" class="form-label fw-bold">اللقب / المنصب</label>
            <input type="text" class="form-control" name="title" id="title" value="<?php echo $president['title']; ?>" required>
          </div>
        </div>

        <!-- حقل الرسالة -->
        <div class="mb-3">
          <label for="message" class="form-label fw-bold">الرسالة</label>
          <textarea class="form-control" name="message" id="message" rows="5" required><?php echo $president['message']; ?></textarea>
        </div>

        <div class="mb-3">
    <label class="form-label fw-bold">الصورة الحالية</label>
    <div class="mb-2">
      <img src="<?php echo $president['image']; ?>" alt="صورة رئيس الجامعة" class="img-thumbnail" style="max-width: 150px;">
    </div>
    <label for="image" class="form-label">تحديث الصورة (رفع صورة جديدة)</label>
    <input type="file" class="form-control" name="image" id="image" accept="image/*">
  </div>

<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
        <!-- زر حفظ التعديلات -->
        <div class="text-str">
          <button type="submit" class="btn btn-success">
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

<!-- تضمين السكربت الخاص بالصفحة -->
<script src="js/script.js"></script>

<?php
// تحميل البيانات من ملف JSON وتحويلها إلى مصفوفة
$data = json_decode(file_get_contents('data.json'), true);

// استخراج بيانات "خلفيات الكاروسيل" من المصفوفة
$heroItems = $data['hero'];
?>

<!-- بداية الـ container لاحتواء المحتوى -->
<div class="container py-4">

  <!-- بطاقة لتعديل خلفيات الكاروسيل -->
  <div class="card shadow-sm border-0">
    <!-- رأس البطاقة -->
    <div class="card-header bg-dark text-white">
      <h5 class="mb-0">تعديل خلفيات الكاروسيل</h5>
    </div>

    <!-- جسم البطاقة -->
    <div class="card-body">

      <!-- نموذج التعديل -->
      <form method="POST" id="insertForm" enctype="multipart/form-data">
        <input type="hidden" name="action" value="updatehero">

        <?php foreach ($heroItems as $index => $item): ?>
          <div class="border p-3 mb-3 rounded bg-light">
            <h6 class="text-primary">خلفية رقم <?php echo $index + 1; ?></h6>

            <!-- الصورة الحالية -->
            <div class="mb-2">
              <label class="form-label fw-bold">الصورة الحالية:</label><br>
              <?php if (!empty($item['image'])): ?>
                <img src="<?php echo htmlspecialchars($item['image']); ?>" class="img-thumbnail" style="max-width: 150px;">
              <?php else: ?>
                <span class="text-danger">🚫 لا توجد صورة</span>
              <?php endif; ?>
            </div>

            <!-- رفع صورة جديدة -->
            <div class="mb-2">
              <label class="form-label">تحديث الصورة</label>
              <input type="file" class="form-control" name="hero_image_<?php echo $index; ?>" accept="image/*">
            </div>

            <!-- العنوان -->
            <div class="mb-2">
              <label class="form-label">العنوان</label>
              <input type="text" class="form-control" name="hero[<?php echo $index; ?>][title]" value="<?php echo htmlspecialchars($item['title']); ?>">
            </div>

            <!-- الوصف -->
            <div class="mb-2">
              <label class="form-label">الوصف</label>
              <textarea class="form-control" name="hero[<?php echo $index; ?>][description]" rows="2"><?php echo htmlspecialchars($item['description']); ?></textarea>
            </div>
          </div>
        <?php endforeach; ?>
<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
        <!-- زر الحفظ -->
        <div class="text-str mt-3">
          <button type="submit" class="btn btn-primary">
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

<!-- ربط ملف JavaScript إن وجد -->
<script src="js/script.js"></script>

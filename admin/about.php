<?php 
// تحميل البيانات من ملف JSON
$data = json_decode(file_get_contents('data.json'), true);
$about = $data['about'];
?>

<div class="container py-4">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">عن الجامعة</h4>
    </div>
    <div class="card-body">
      <form method="POST" id="insertForm">
        <input type="hidden" name="action" value="updateabout" required>

        <!-- الوصف -->
        <div class="mb-4">
          <label for="description" class="form-label fw-bold">الوصف</label>
          <textarea class="form-control border border-primary-subtle" name="description" id="description" rows="4"><?= htmlspecialchars($about['description']) ?></textarea>
        </div>

        <!-- الرؤية -->
        <div class="mb-4">
          <label for="vision" class="form-label fw-bold">الرؤية</label>
          <textarea class="form-control border border-info-subtle" name="vision" id="vision" rows="3"><?= htmlspecialchars($about['vision']) ?></textarea>
        </div>

        <!-- الرسالة -->
        <div class="mb-4">
          <label for="mission" class="form-label fw-bold">الرسالة</label>
          <textarea class="form-control border border-success-subtle" name="mission" id="mission" rows="3"><?= htmlspecialchars($about['mission']) ?></textarea>
        </div>

        <!-- تاريخ التأسيس -->
        <div class="mb-4">
          <label for="established" class="form-label fw-bold">تاريخ التأسيس</label>
          <input type="text" class="form-control border border-warning-subtle" name="established" id="established" value="<?= htmlspecialchars($about['established'] ?? '') ?>" placeholder="مثال: 2001">
        </div>

        <!-- الأهداف -->
        <div class="mb-4">
          <label class="form-label fw-bold">الأهداف</label>
          <div id="goals-wrapper">
            <?php 
            $goals = $about['goals'] ?? [''];
            foreach ($goals as $index => $goal): ?>
              <div class="input-group mb-2 goal-item">
                <input type="text" name="goals[]" class="form-control" value="<?= htmlspecialchars($goal) ?>" placeholder="هدف">
                <button type="button" class="btn btn-danger remove-goal"><i class="bi bi-trash"></i></button>
              </div>
            <?php endforeach; ?>
          </div>
          <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-goal">
            <i class="bi bi-plus-circle"></i> إضافة هدف جديد
          </button>
        </div>

        <!-- النتيجة -->
        <div class="row justify-content-right mt-4">
          <div class="col-md-8" id="result"></div>
        </div>

        <!-- زر حفظ -->
        <div class="text-start">
          <button type="submit" class="btn btn-success px-4 py-2">
            حفظ التعديلات
            <span id="loadingIcon" class="custom-dot-spinner d-none" role="status" aria-hidden="true">
              <span></span><span></span><span></span><span></span>
              <span></span><span></span><span></span><span></span>
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript لإضافة/حذف الأهداف -->
<script>
  document.getElementById('add-goal').addEventListener('click', function() {
    const wrapper = document.getElementById('goals-wrapper');
    const div = document.createElement('div');
    div.className = 'input-group mb-2 goal-item';
    div.innerHTML = `
      <input type="text" name="goals[]" class="form-control" placeholder="هدف">
      <button type="button" class="btn btn-danger remove-goal"><i class="bi bi-trash"></i></button>
    `;
    wrapper.appendChild(div);
  });

  document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-goal')) {
      e.target.closest('.goal-item').remove();
    }
  });
</script>

<!-- ربط ملف JavaScript لتنفيذ الإجراءات الديناميكية -->
<script src="js/script.js"></script>

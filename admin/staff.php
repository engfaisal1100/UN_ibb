 <!-- نموذج إضافة عضو جديد -->
 <div class="card shadow-sm border-0">
    <div class="card-header bg-secondary text-white">
      <h5 class="mb-0">إضافة عضو جديد</h5>
    </div>
    <div class="card-body">
    <form method="POST" id="insertForm" enctype="multipart/form-data">
  <input type="hidden" name="action" value="addstaff" class="form-control" required>

  <!-- حقل إدخال الاسم -->
  <div class="mb-3">
    <label class="form-label">الاسم</label>
    <input type="text" class="form-control" name="name" required>
  </div>

  <!-- حقل إدخال اللقب الوظيفي -->
  <div class="mb-3">
    <label class="form-label">اللقب الوظيفي</label>
    <input type="text" class="form-control" name="title" required>
  </div>

  <!-- حقل إدخال القسم -->
  <div class="mb-3">
    <label class="form-label">القسم</label>
    <input type="text" class="form-control" name="department" required>
  </div>

  <!-- حقل إدخال القسم -->
  <div class="mb-3">
    <label class="form-label">السيرة الذتية</label>
    <textarea class="form-control" name="bio" rows="2" required></textarea>
  </div>

  <!-- حقل رفع الصورة -->
  <div class="mb-3">
    <label class="form-label">الصورة</label>
    <input type="file" class="form-control" name="image" accept="image/*" required>
  </div>
<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
  <!-- زر إضافة عضو جديد -->
  <button type="submit" class="btn btn-success">
    إضافة
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
</form>

    </div>
  </div>
</div>

<?php
// تحميل البيانات من ملف JSON
$data = json_decode(file_get_contents('data.json'), true);

// التحقق من وجود بيانات للطاقم الأكاديمي
$staff = isset($data['staff']) ? $data['staff'] : [];
?>

<div class="container py-4">
  <!-- بطاقة عرض الطاقم الأكاديمي -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">الطاقم الأكاديمي</h5>
    </div>
    <div class="card-body">
      <!-- جدول عرض بيانات الطاقم الأكاديمي -->
      <table class="table table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>الصورة</th>
            <th>الاسم</th>
            <th>اللقب الوظيفي</th>
            <th>القسم</th>
            <th>حذف</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($staff as $index => $member): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <!-- عرض صورة العضو -->
            <td><img src="<?= $member['image'] ?>" alt="صورة" width="50" class="rounded-circle"></td>
            <td><?= htmlspecialchars($member['name']) ?></td>
            <td><?= htmlspecialchars($member['title']) ?></td>
            <td><?= htmlspecialchars($member['department']) ?></td>
            <td>
              <!-- زر الحذف مع التأكيد عند الضغط -->
              <button 
                class="btn btn-danger btn-sm delete-btn" 
                data-id="<?= $member['id'] ?>">
                🗑 حذف
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

 
<!-- تضمين السكربت الخاص بالصفحة -->
<script src="js/script.js"></script>

<script>
$(document).on('click', '.delete-btn', function(e) {
e.preventDefault();

var button = $(this);
var id = button.data('id');

if (confirm("هل أنت متأكد من الحذف؟")) {
$.ajax({
type: 'POST',
url: 'controller.php',
data: {
action: 'deletestaff',
id: id
},
success: function(response) {
try {
var data = JSON.parse(response);
// عرض الرسالة في alert
alert(data.message);

if (data.status === 'success') {
// إزالة الصف من الجدول
button.closest('tr').fadeOut(300, function() {
$(this).remove();
});
}

} catch (e) {
alert('حدث خطأ في قراءة استجابة الخادم.');
console.error('JSON parse error:', e);
}
},
error: function(xhr, status, error) {
alert('حدث خطأ في الاتصال بالخادم.');
console.error(error);
}
});
}
});
</script>

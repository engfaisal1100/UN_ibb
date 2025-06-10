
<!-- بطاقة لإضافة قسم جديد -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-secondary text-white">
    <h5 class="mb-0">إضافة قسم جديد</h5>
  </div>
  <div class="card-body">
    <form method="POST" id="insertForm">
      <input type="hidden" name="action" value="adddepartment" class="form-control">

      <div class="mb-3">
        <label class="form-label">اسم القسم</label>
        <input type="text" class="form-control" name="name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">الوصف</label>
        <textarea class="form-control" name="description" rows="2" required></textarea>
      </div>
<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
      <button type="submit" class="btn btn-success">
      إضافة القسم
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

<!-- Modal لإضافة مقرر -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" id="addCourseForm">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addCourseModalLabel">إضافة مقرر</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" value="addcourse">
          <input type="hidden" name="department_id" id="departmentIdInput">

          <div class="mb-3">
            <label class="form-label">اسم المقرر</label>
            <input type="text" class="form-control" name="title" required>
          </div>

          <div class="mb-3">
            <label class="form-label">رمز المقرر</label>
            <input type="text" class="form-control" name="code" required>
          </div>

          <div class="mb-3">
            <label class="form-label">عدد الساعات</label>
            <input type="number" class="form-control" name="credits" required>
          </div>

          <div class="mb-3">
            <label class="form-label">اسم المدرس</label>
            <input type="text" class="form-control" name="instructor" required>
          </div>

          <div class="mb-3">
            <label class="form-label">وصف المقرر</label>
            <textarea class="form-control" name="description" rows="2" required></textarea>
          </div>
        </div>
      <!-- حقل اختيار الترم -->
          <div class="mb-3">
            <label class="form-label m-3">السنة</label>
            <select class="form-select" name="term" required>
              <option value="">اختر السنة</option>
              <option value="1">السنة الاولى </option>
              <option value="2">السنة الثانية </option>
              <option value="3">السنة الثالثة </option>
              <option value="4">السنة الرابعة </option>
            </select>
          </div>

<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="resultt">
  </div>
</div>
        <div class="text-str m-3">
          <button type="submit" class="btn btn-success">
            اضافة المقرر
              <span id="loadingIconn" class="custom-dot-spinner d-none" role="status" aria-hidden="true">
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


<?php
// تحميل البيانات من ملف JSON وتحويلها إلى مصفوفة
$data = json_decode(file_get_contents('data.json'), true);

// استخراج بيانات "الأقسام الأكاديمية" من المصفوفة
$departments = $data['departments'];
?>

<!-- بداية الـ container لاحتواء المحتوى -->
<div class="container py-4">

  <!-- بطاقة لعرض قائمة الأقسام الأكاديمية -->
  <div class="card shadow-sm border-0 mb-4">
    <!-- رأس البطاقة يحتوي على عنوان القسم -->
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">الاقسام الأكاديمية</h5>
    </div>

    <!-- جسم البطاقة يحتوي على جدول لعرض الأقسام -->
    <div class="card-body">
      <!-- جدول عرض الأقسام الأكاديمية -->
      <table class="table table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>اسم القسم</th>
            <th>الوصف</th>
            <th>عدد المقررات</th>
<th>إضافة مقرر</th> <!-- عمود جديد -->
<th>حذف</th>

          </tr>
        </thead>
        <tbody>
          <!-- حلقة لعرض كل قسم أكاديمي -->
          <?php foreach ($departments as $index => $dep): ?>
          <tr>
            <!-- عرض رقم القسم -->
            <td><?php echo $index + 1; ?></td>
            <!-- عرض اسم القسم -->
            <td><?php echo $dep['name']; ?></td>
            <!-- عرض وصف القسم -->
            <td><?php echo $dep['description']; ?></td>
            <!-- عرض عدد المقررات في القسم -->
            <td><?php echo count($dep['courses']); ?></td> <!-- حساب عدد المقررات -->
            <td>
            <button 
  class="btn btn-info btn-sm add-course-btn"
  data-id="<?= $dep['id'] ?>"
  data-name="<?= htmlspecialchars($dep['name'], ENT_QUOTES, 'UTF-8') ?>"
  data-bs-toggle="modal"
  data-bs-target="#addCourseModal">
  ➕ إضافة مقرر
</button>
</td>

<td>
<!-- زر الحذف مع التأكيد قبل الحذف -->
<button 
class="btn btn-danger btn-sm delete-btn" 
data-id="<?= $dep['id'] ?>">
🗑 حذف
</button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>

<!-- ربط ملف JavaScript لتنفيذ الإجراءات الديناميكية -->
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
action: 'deletedepartment',
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

<script>
$(document).on('click', '.add-course-btn', function() {
    var deptId = $(this).data('id');
    var deptName = $(this).data('name');

    // تعيين ID القسم في الحقل المخفي داخل المودال
    $('#departmentIdInput').val(deptId);

    // تغيير عنوان المودال لعرض اسم القسم بدلاً من رقمه
    $('#addCourseModalLabel').text('إضافة مقرر الى ' + deptName);
});
</script>


<script>
$('#addCourseForm').on('submit', function (e) {
    e.preventDefault();

    $('#loadingIconn').removeClass('d-none');
    $('#resultt').html('');

    var formData = new FormData(this);

    setTimeout(function () {
  $.ajax({
  type: 'POST',
  url: 'controller.php',
  data: formData,
  contentType: false,
  processData: false,
  dataType: 'json', // مهم جدًا!
  success: function (response) {
    $('#loadingIconn').addClass('d-none');

    if (response.status === 'success') {
      $('#resultt').html("<div class='alert alert-success'>" + response.message + "</div>");
    } else if (response.status === 'error') {
      $('#resultt').html("<div class='alert alert-danger'>" + response.message + "</div>");
      }
  },
  error: function () {
    $('#loadingIconn').addClass('d-none');
    $('#resultt').html("<div class='alert alert-danger mt-4'>تعذر الاتصال بالخادم.</div>");
  }
});
}, 2000);
  });
</script>

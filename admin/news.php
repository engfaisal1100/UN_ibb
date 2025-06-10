

  <!-- نموذج إضافة خبر جديد -->
  <div class="card shadow-sm border-0">
    <div class="card-header bg-secondary text-white">
      <h5 class="mb-0">إضافة خبر جديد</h5>
    </div>
    <div class="card-body">
      <!-- نموذج إضافة البيانات -->
      <form method="POST" id="insertForm">
        <input type="hidden" name="action" value="addnews" class="form-control" required>
        
        <!-- حقل العنوان -->
        <div class="mb-3">
          <label class="form-label">العنوان</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        
        <!-- حقل التاريخ -->
        <div class="mb-3">
          <label class="form-label">التاريخ</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        
        <!-- حقل المحتوى -->
        <div class="mb-3">
          <label class="form-label">المحتوى</label>
          <textarea name="content" rows="3" class="form-control" required></textarea>
        </div>
<div class="row justify-content-right mt-4">
  <div class="col-md-8" id="result">
  </div>
</div>
        <!-- زر إضافة الخبر -->
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
function loadData() {
    // تحقق إذا كان الملف موجودًا وقراءته
    if (file_exists('data.json')) {
        return json_decode(file_get_contents('data.json'), true);
    } else {
        // إذا كان الملف غير موجود، قم بإنشاءه مع مصفوفة أخبار فارغة
        return ['news' => []]; 
    }
}

// تحميل البيانات من ملف JSON
$data = loadData();
// استخراج الأخبار من البيانات
$news = isset($data['news']) ? $data['news'] : [];
?>

<div class="container py-4">
  <!-- عرض الأخبار في جدول -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">قائمة الأخبار</h5>
    </div>
    <div class="card-body">
      <!-- جدول عرض الأخبار -->
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>العنوان</th>
            <th>التاريخ</th>
            <th>المحتوى</th>
            <th>حذف</th>
          </tr>
        </thead>
        <tbody>
          <!-- عرض كل الخبر في صفوف الجدول -->
          <?php foreach ($news as $index => $item): ?>
          <tr>
            <!-- عرض بيانات الخبر -->
            <td><?= $item['id'] ?></td>
            <td><?= htmlspecialchars($item['title']) ?></td>
            <td><?= htmlspecialchars($item['date']) ?></td>
            <td><?= htmlspecialchars($item['content']) ?></td>
            <td>
              <!-- زر حذف الخبر مع تأكيد الحذف -->
              <button 
                class="btn btn-danger btn-sm delete-btn" 
                data-id="<?= $item['id'] ?>">
                🗑 حذف
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>


<!-- تضمين سكربت JS الخاص بالصفحة -->
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
action: 'deletenews',
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

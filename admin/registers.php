<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // تحميل بيانات المستخدمين من ملف JSON
    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    if ($action === 'add_user') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'جميع الحقول مطلوبة.']);
            exit;
        }

        // التحقق من عدم تكرار البريد الإلكتروني
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                echo json_encode(['status' => 'error', 'message' => 'هذا البريد الإلكتروني مستخدم بالفعل.']);
                exit;
            }
        }
// تشفير كلمة السر قبل الحفظ
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// إضافة المستخدم الجديد مع كلمة السر المشفرة
$newUser = [
    'username' => $username,
    'email' => $email,
    'password' => $hashedPassword
];


        $users[] = $newUser;

        if (file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['status' => 'success', 'message' => 'تم اضافة مسؤول جديد.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'فشل في حفظ البيانات.']);
        }
        exit;
    }

    if ($action === 'delete_user') {
        $index = isset($_POST['index']) ? intval($_POST['index']) : -1;

        if ($index < 0 || $index >= count($users)) {
            echo json_encode(['status' => 'error', 'message' => 'مؤشر المستخدم غير صالح.']);
            exit;
        }

        array_splice($users, $index, 1);

        if (file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['status' => 'success', 'message' => 'تم حذف المستخدم بنجاح.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'فشل في تحديث البيانات.']);
        }
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'طلب غير صالح.']);
    exit;
}
?>

 <!-- نموذج إضافة عضو جديد -->
 <div class="card shadow-sm border-0">
    <div class="card-header bg-secondary text-white">
      <h5 class="mb-0">إضافة مسؤول جديد</h5>
    </div>
    <div class="card-body">
    <form method="POST" id="insertForm" enctype="multipart/form-data">
  <input type="hidden" name="action" value="add_user" class="form-control" required>

  <!-- حقل إدخال الاسم -->
  <div class="mb-3">
    <label class="form-label">اسم المستخدم</label>
       <input type="text" class="form-control" id="username" name="username" required>
  </div>

  <!-- حقل إدخال اللقب الوظيفي -->
  <div class="mb-3">
    <label class="form-label">البريد الالكتروني</label>
  <input type="email" class="form-control" id="email" name="email" required>
  </div>

  <!-- حقل إدخال القسم -->
  <div class="mb-3">
    <label class="form-label">كلمة السر</label>
<input type="password" class="form-control" id="password" name="password" required>
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
// تحميل بيانات المستخدمين من ملف JSON
$users = json_decode(file_get_contents('users.json'), true);
?>

<div class="container py-4">
  <!-- بطاقة عرض المستخدمين -->
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">قائمة المستخدمين</h5>
    </div>
    <div class="card-body">
      <!-- جدول عرض بيانات المستخدمين -->
      <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-primary">
          <tr>
            <th>#</th>
            <th>اسم المستخدم</th>
            <th>البريد الإلكتروني</th>
            <th>كلمة المرور</th>
            <th>إجراء</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $index => $user): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td>
              <!-- زر حذف -->
              <button class="btn btn-sm btn-danger delete-user" data-index="<?= $index ?>">حذف</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
$('#insertForm').on('submit', function (e) {
    e.preventDefault();

    $('#loadingIcon').removeClass('d-none');
    $('#result').html('');

    var formData = new FormData(this);

    setTimeout(function () {
  $.ajax({
  type: 'POST',
  url: 'registers.php',
  data: formData,
  contentType: false,
  processData: false,
  dataType: 'json', // مهم جدًا!
  success: function (response) {
    $('#loadingIcon').addClass('d-none');

    if (response.status === 'success') {
      $('#result').html("<div class='alert alert-success'>" + response.message + "</div>");
    } else if (response.status === 'error') {
      $('#result').html("<div class='alert alert-danger'>" + response.message + "</div>");
      }
  },
  error: function () {
    $('#loadingIcon').addClass('d-none');
    $('#result').html("<div class='alert alert-danger mt-4'>تعذر الاتصال بالخادم.</div>");
  }
});
}, 2000);
  });

</script>
<script>
$(document).on('click', '.delete-user', function(e) {
  e.preventDefault();

  var button = $(this);
  var index = button.data('index');

  if (confirm("هل أنت متأكد من الحذف؟")) {
    $.ajax({
      type: 'POST',
      url: 'registers.php',
      data: {
        action: 'delete_user',
        index: index
      },
      success: function(response) {
        try {
          var data = JSON.parse(response);
          alert(data.message);

          if (data.status === 'success') {
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

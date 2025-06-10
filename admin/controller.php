<?php
// ✅ يجب تعريف هذا أولًا
// تحديد مسار ملف البيانات JSON (يستخدم __DIR__ للحصول على المسار بشكل آمن)
define('DATA_FILE', __DIR__ . '/data.json');

// دالة لتحميل البيانات من ملف JSON
function loadData() {
    // قراءة محتويات ملف JSON وتحويلها إلى مصفوفة (Array)
    return json_decode(file_get_contents(DATA_FILE), true);
}

// دالة لحفظ البيانات إلى ملف JSON
function saveData($data) {
    // حفظ البيانات في الملف باستخدام تنسيق JSON
    file_put_contents(DATA_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

////////////////////////////////////
// 📰 الأخبار
////////////////////////////////////

// دالة لإضافة خبر جديد
function addNews($title, $date, $content) {
    try {
        // تحميل البيانات الحالية من ملف JSON
        $data = loadData();
        
        // تحديد ID جديد للخبر بناءً على آخر خبر في القائمة
        $lastId = count($data['news']) > 0 ? $data['news'][count($data['news']) - 1]['id'] : 0;
        $newId = $lastId + 1;
        
        // إعداد الخبر الجديد
        $newNews = [
            'id' => $newId,
            'title' => $title,
            'date' => $date,
            'content' => $content
        ];

        // إضافة الخبر الجديد إلى قائمة الأخبار
        $data['news'][] = $newNews;
        
        // حفظ البيانات المعدلة
        saveData($data);

        // إرجاع استجابة نجاح
        echo json_encode([
            'status' => 'success',
            'message' => 'تمت إضافة الخبر بنجاح.'
        ]);
    } catch (Exception $e) {
        // إرجاع استجابة فشل مع تفاصيل الخطأ
        echo json_encode([
            'status' => 'error',
            'message' => 'فشل في إضافة الخبر: ' . $e->getMessage()
        ]);
    }
}

// دالة لحذف خبر
function deleteNews($id) {
    try {
        // تحميل البيانات الحالية من ملف JSON
        $data = loadData();
        
        // حفظ عدد الأخبار قبل الحذف
        $originalCount = count($data['news']);
        
        // تصفية الأخبار لإزالة الخبر الذي يحتوي على نفس ID
        $data['news'] = array_values(array_filter($data['news'], fn($item) => $item['id'] != $id));
        
        // حفظ البيانات المعدلة
        saveData($data);
        
        // التحقق من نجاح عملية الحذف
        if ($originalCount !== count($data['news'])) {
            echo json_encode([
                'status' => 'success',
                'message' => 'تم حذف الخبر بنجاح.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'لم يتم العثور على الخبر المراد حذفه.'
            ]);
        }
    } catch (Exception $e) {
        // إرجاع استجابة فشل مع تفاصيل الخطأ
        echo json_encode([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()
        ]);
    }
}

////////////////////////////////////
// دوال التحديث الأخرى
////////////////////////////////////

// دالة لتحديث بيانات "عن الجامعة"
function updateAbout($description, $vision, $mission) {
    try {
        // تحميل البيانات من ملف JSON
        $data = loadData();
        
        // تحديث بيانات "عن الجامعة"
        $data['about']['description'] = $description;
        $data['about']['vision'] = $vision;
        $data['about']['mission'] = $mission;
        
        // حفظ البيانات المعدلة في ملف JSON
        saveData($data);

        // إرجاع استجابة بالنجاح
        echo json_encode([
            'status' => 'success',
            'message' => 'تم حفظ التعديلات بنجاح.'
        ]);
    } catch (Exception $e) {
        // إرجاع استجابة في حالة حدوث خطأ
        echo json_encode([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء حفظ التعديلات: ' . $e->getMessage()
        ]);
    }
}

// دالة لتحديث بيانات "معلومات التواصل"
function updateContact($address, $phone, $email,$rights,$devloper, $facebook, $twitter, $instagram) {
    try {
        // تحميل البيانات من ملف JSON
        $data = loadData();
        
        // تحديث بيانات "معلومات التواصل"
        $data['contact']['address'] = $address;
        $data['contact']['phone'] = $phone;
        $data['contact']['email'] = $email;
        $data['contact']['rights'] = $rights;
        $data['contact']['devloper'] = $devloper;
        $data['contact']['social']['facebook'] = $facebook;
        $data['contact']['social']['twitter'] = $twitter;
        $data['contact']['social']['instagram'] = $instagram;
        
        // حفظ البيانات المعدلة في ملف JSON
        saveData($data);

        // إرجاع استجابة بالنجاح
        echo json_encode([
            'status' => 'success',
            'message' => 'تم حفظ التعديلات بنجاح.'
        ]);
    } catch (Exception $e) {
        // إرجاع استجابة في حالة حدوث خطأ
        echo json_encode([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء حفظ التعديلات: ' . $e->getMessage()
        ]);
    }
}
function updatePresidentMessage() {
    try {
        $data = json_decode(file_get_contents('data.json'), true);
        $name = $_POST['name'] ?? '';
        $title = $_POST['title'] ?? '';
        $message = $_POST['message'] ?? '';
        $imagePath = '';

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'images/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $fileTmp = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('president_', true) . '.' . $fileExt;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $destination)) {
                $imagePath = $destination;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'فشل في رفع الصورة.']);
                return;
            }
        } else {
            $imagePath = $data['presidentMessage']['image'];
        }

        $data['presidentMessage'] = [
            'name' => $name,
            'title' => $title,
            'message' => $message,
            'image' => $imagePath
        ];

        file_put_contents('data.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        echo json_encode(['status' => 'success', 'message' => 'تم حفظ التعديلات بنجاح.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
    }
}

function updateHeroItems() {
    try {
        $data = json_decode(file_get_contents('data.json'), true);
        $heroItems = $_POST['hero'] ?? [];

        // مسار مجلد الصور
        $uploadDir = 'images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // معالجة كل عنصر في الكاروسيل
        foreach ($heroItems as $index => &$item) {
            // اسم الملف المرفوع
            $fileKey = "hero_image_$index";

            // إذا تم رفع صورة جديدة
            if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                $fileTmp = $_FILES[$fileKey]['tmp_name'];
                $fileName = basename($_FILES[$fileKey]['name']);
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = uniqid("hero_$index", true) . '.' . $fileExt;
                $destination = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmp, $destination)) {
                    $item['image'] = $destination;
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => "فشل في رفع الصورة رقم " . ($index + 1)
                    ]);
                    return;
                }
            } else {
                // الاحتفاظ بالصورة القديمة
                $item['image'] = $data['hero'][$index]['image'];
            }
        }

        // تحديث البيانات
        $data['hero'] = $heroItems;
        file_put_contents('data.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        echo json_encode([
            'status' => 'success',
            'message' => 'تم حفظ التعديلات بنجاح.'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء حفظ التعديلات: ' . $e->getMessage()
        ]);
    }
}

////////////////////////////////////
// 🏛 الأقسام
////////////////////////////////////
// دالة لإضافة قسم جديد فقط
function addDepartment($name, $description) {
    // تحميل البيانات الحالية
    $data = loadData();  // دالة لتحميل البيانات من الملف

    // توليد ID فريد للقسم الجديد
    $newId = count($data['departments']) > 0 ? max(array_column($data['departments'], 'id')) + 1 : 1;

    // إعداد بيانات القسم الجديد
    $newDepartment = [
        'id' => $newId,
        'name' => $name,
        'description' => $description,
        'courses' => [] // لا يوجد مقررات مبدئيًا
    ];

    // إضافة القسم الجديد إلى البيانات
    $data['departments'][] = $newDepartment;

    // حفظ البيانات المحدثة
    saveData($data);  // دالة لحفظ البيانات في الملف

    // إرجاع استجابة بالنجاح
    echo json_encode([
        'status' => 'success',
        'message' => 'تم إضافة القسم بنجاح.'
    ]);
}

// دالة لإضافة مقرر إلى قسم معين
function addCourseToDepartment($departmentId, $title, $code, $credits,$trem, $instructor, $description) {
    // تحميل البيانات الحالية
    $data = loadData();  // دالة لتحميل البيانات من الملف

    // البحث عن القسم بناءً على ID
    foreach ($data['departments'] as &$department) {
        if ($department['id'] == $departmentId) {
            // إعداد بيانات المقرر الجديد
            $newCourse = [
                'title' => $title,
                'code' => $code,
                'credits' => $credits,
                 'trem' => $trem,
                'instructor' => $instructor,
                'description' => $description
            ];

            // إضافة المقرر إلى القسم
            $department['courses'][] = $newCourse;

            // حفظ البيانات المحدثة
            saveData($data);  // دالة لحفظ البيانات في الملف

            // إرجاع استجابة بالنجاح
            echo json_encode([
                'status' => 'success',
                'message' => 'تم إضافة المقرر بنجاح.'
            ]);
            return;
        }
    }

    // في حال لم يتم العثور على القسم
    echo json_encode([
        'status' => 'error',
        'message' => 'القسم غير موجود.'
    ]);
}


// دالة لحذف قسم
function deleteDepartment($id) {
    $data = loadData();

    // البحث عن القسم باستخدام id
    $departmentIndex = null;
    foreach ($data['departments'] as $index => $department) {
        if ($department['id'] == $id) {
            $departmentIndex = $index;
            break;
        }
    }

    if ($departmentIndex !== null) {
        unset($data['departments'][$departmentIndex]);
        $data['departments'] = array_values($data['departments']); // إعادة ترتيب الفهرس بعد الحذف
        saveData($data);

        echo json_encode([
            'status' => 'success',
            'message' => 'تم حذف القسم بنجاح.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'لم يتم العثور على القسم.'
        ]);
    }
}

////////////////////////////////////
// 👨‍🏫 الطاقم الأكاديمي
////////////////////////////////////
function addStaff($name, $title, $department,$bio) {
    try {
        // تحميل البيانات من JSON
        $data = loadData();

        // مسار رفع الصور
        $uploadDir = 'images/';

        // التحقق من رفع الصورة
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('لم يتم رفع الصورة أو حدث خطأ أثناء الرفع.');
        }

        // إنشاء المجلد إذا لم يكن موجودًا
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // إنشاء اسم فريد للصورة
        $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('staff_') . '.' . $fileExt;
        $filePath = $uploadDir . $fileName;

        // نقل الصورة
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            throw new Exception('فشل في حفظ الصورة على الخادم.');
        }

        // توليد ID جديد
        $newId = count($data['staff']) > 0 ? max(array_column($data['staff'], 'id')) + 1 : 1;

        // إعداد بيانات العضو الجديد
        $newStaff = [
            'id' => $newId,
            'name' => $name,
            'title' => $title,
            'department' => $department,
            'image' => $filePath,
            'bio' => $bio
        ];

        // إضافة العضو
        $data['staff'][] = $newStaff;

        // حفظ التحديث
        saveData($data);

        // إرجاع استجابة
        echo json_encode([
            'status' => 'success',
            'message' => 'تم إضافة العضو بنجاح.'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'فشل في إضافة العضو: ' . $e->getMessage()
        ]);
    }
}

// دالة لحذف عضو أكاديمي
function deleteStaff($id) {
    $data = loadData();
    
    // البحث عن العضو باستخدام id
    $staffIndex = null;
    foreach ($data['staff'] as $index => $member) {
        if ($member['id'] == $id) {
            $staffIndex = $index;
            break;
        }
    }

    if ($staffIndex !== null) {
        unset($data['staff'][$staffIndex]);
        $data['staff'] = array_values($data['staff']);
        saveData($data);

        echo json_encode([
            'status' => 'success',
            'message' => 'تم حذف العضو بنجاح.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'لم يتم العثور على العضو.'
        ]);
    }
}

function updateSettings($postData, $fileData) {
    try {
        // تحميل البيانات من ملف JSON
        $data = json_decode(file_get_contents('data.json'), true);

        // مسارات الصور الافتراضية (المستخدمة إذا لم تُرفع صور جديدة)
        $logoPath = $data['setting']['logo_url'];
        $faviconPath = $data['setting']['favicon_url'];

        // التحقق من رفع شعار جديد
        if (isset($fileData['logo_file']) && $fileData['logo_file']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $fileData['logo_file']['tmp_name'];
            $extension = pathinfo($fileData['logo_file']['name'], PATHINFO_EXTENSION);
            $logoName = 'logo_' . time() . '.' . $extension;
            $uploadPath = 'images/' . $logoName;
            if (move_uploaded_file($tmpName, $uploadPath)) {
                $logoPath = $uploadPath;
            }
        }

        // التحقق من رفع فافيكون جديد
        if (isset($fileData['favicon_file']) && $fileData['favicon_file']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $fileData['favicon_file']['tmp_name'];
            $extension = pathinfo($fileData['favicon_file']['name'], PATHINFO_EXTENSION);
            $faviconName = 'favicon_' . time() . '.' . $extension;
            $uploadPath = 'images/' . $faviconName;
            if (move_uploaded_file($tmpName, $uploadPath)) {
                $faviconPath = $uploadPath;
            }
        }

        // تحديث بيانات الإعدادات
        $data['setting'] = [
            'site_name'      => $postData['site_name'],
            'title'          => $postData['title'],
            'description'    => $postData['description'],
            'keywords'       => $postData['keywords'],
            'author'         => $postData['author'],
            'language'       => $postData['language'],
            'timezone'       => $postData['timezone'],
            'logo_url'       => $logoPath,
            'favicon_url'    => $faviconPath,
            'contact_email'  => $postData['contact_email'],
            'contact_phone'  => $postData['contact_phone'],
            'social'         => [
                'facebook'  => $postData['facebook'],
                'twitter'   => $postData['twitter'],
                'instagram' => $postData['instagram'],
            ],
            'comment'        => $postData['comment']
        ];

        // حفظ البيانات في ملف JSON
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo json_encode([
            'status' => 'success',
            'message' => '✅ تم حفظ التعديلات بنجاح.'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ خطأ أثناء حفظ التعديلات: ' . $e->getMessage()
        ]);
    }
}


////////////////////////////////////
// 👇 استدعاء الدوال عند إجراء كل حدث
////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // حالة إضافة الخبر
    if (isset($_POST['action']) && $_POST['action'] === 'addnews') {
        // استدعاء دالة إضافة الخبر مع تمرير العنوان، التاريخ، والمحتوى
        addNews($_POST['title'], $_POST['date'], $_POST['content']);
    
    // حالة حذف الخبر
    } elseif (isset($_POST['action']) && $_POST['action'] === 'deletenews') {
        // أخذ قيمة ID الخبر من الطلب
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        // استدعاء دالة حذف الخبر مع تمرير ID الخبر
        deleteNews($id);
    
    // حالة إضافة عضو أكاديمي جديد
    } elseif (isset($_POST['action']) && $_POST['action'] === 'addstaff') {
        // استدعاء دالة إضافة عضو أكاديمي مع تمرير الاسم، العنوان، القسم، وصورة العضو
        addStaff($_POST['name'], $_POST['title'], $_POST['department'],$_POST['bio']);
    
    // حالة حذف عضو أكاديمي
    } elseif (isset($_POST['action']) && $_POST['action'] === 'deletestaff') {
        // أخذ قيمة ID العضو الأكاديمي من الطلب
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        // استدعاء دالة حذف عضو أكاديمي مع تمرير ID العضو
        deleteStaff($id);

}elseif (isset($_POST['action']) && $_POST['action'] === 'adddepartment') {
    // استدعاء دالة إضافة القسم مع تمرير المقررات أيضًا
    $courses = isset($_POST['courses']);
    addDepartment($_POST['name'], $_POST['description']);
}elseif (isset($_POST['action']) && $_POST['action'] === 'addcourse') {
    // التحقق من وجود كافة البيانات المطلوبة
    if (isset($_POST['department_id'], $_POST['title'], $_POST['code'], $_POST['credits'],$_POST['term'], $_POST['instructor'], $_POST['description'])
    ) {
        // استدعاء الدالة وتمرير البيانات
        addCourseToDepartment(
            (int) $_POST['department_id'],    // رقم القسم
            $_POST['title'],                  // اسم المقرر
            $_POST['code'],                   // رمز المقرر
            (int) $_POST['credits'], 
             (int) $_POST['term'],          // عدد الساعات
            $_POST['instructor'],             // اسم المدرس
            $_POST['description']             // وصف المقرر
        );
    } else {
        // في حال نقص البيانات
        echo json_encode([
            'status' => 'error',
            'message' => 'يرجى تعبئة جميع الحقول المطلوبة لإضافة المقرر.'
        ]);
    }
}elseif (isset($_POST['action']) && $_POST['action'] === 'deletedepartment') {
        // أخذ قيمة ID القسم من الطلب
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        // استدعاء دالة حذف قسم مع تمرير ID القسم
        deleteDepartment($id);
    
    // حالة تحديث بيانات "عن الجامعة"
    } else if (isset($_POST['action']) && $_POST['action'] === 'updateabout') {
        // استدعاء دالة تحديث بيانات "عن الجامعة" مع تمرير البيانات المعدلة
        updateAbout($_POST['description'], $_POST['vision'], $_POST['mission']);
    
    // حالة تحديث بيانات "معلومات التواصل"
    } elseif (isset($_POST['action']) && $_POST['action'] === 'updatecontact') {
        // استدعاء دالة تحديث بيانات "معلومات التواصل" مع تمرير البيانات المعدلة
        updateContact($_POST['address'], $_POST['phone'], $_POST['email'],$_POST['rights'],$_POST['devloper'],$_POST['facebook'], $_POST['twitter'], $_POST['instagram']);
    
    // حالة تحديث "كلمة رئيس الجامعة"
    } elseif (isset($_POST['action']) && $_POST['action'] === 'updatepresident') {
        // استدعاء دالة تحديث "كلمة رئيس الجامعة" مع تمرير البيانات المعدلة
        updatePresidentMessage();
    
    // حالة تحديث خلفيات الكاروسيل
    } elseif (isset($_POST['action']) && $_POST['action'] === 'updatehero') {
        // استدعاء دالة تحديث خلفيات الكاروسيل مع تمرير البيانات المعدلة
        updateHeroItems();
    
    // حالة تحديث إعدادات الموقع
    } elseif (isset($_POST['action']) && $_POST['action'] === 'updateSettings') {
        // استدعاء دالة تحديث إعدادات الموقع مع تمرير البيانات المعدلة
        updateSettings($_POST, $_FILES);
    }
}

?>
